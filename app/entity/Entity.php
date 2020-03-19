<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 13.12.2019
 * Time: 11:03
 */
namespace app\entity;

abstract class Entity
{
    protected $connection;
    protected $protocol_and_host;

    public function __construct($environment)
    {
        //Подключаемся к базе данных
        $servername =$environment['DB_SERVER_NAME'] ;
        $port = $environment['DB_PORT'];
        $username = $environment['DB_USER_NAME'];
        $password = $environment['DB_PASSWORD'];
        $db_name = $environment['DB_NAME'];

        // Создаем соединение
        $conn = new \mysqli($servername, $username, $password,$db_name,$port);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $this->connection = $conn;

        //Таблица contacts
        $sql = "CREATE TABLE IF NOT EXISTS contacts (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                phone VARCHAR(150) NOT NULL,
                name VARCHAR(150) NOT NULL
                ) ENGINE=InnoDB COLLATE=utf8_unicode_ci";
        if ($conn->query($sql) === TRUE) {

        } else {
            echo "Error creating table contacts:  " . $conn->error;
        }

        //Таблица users
        $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(150) NOT NULL,
                password VARCHAR(150) NOT NULL,
                login VARCHAR(150) NOT NULL,
                UNIQUE KEY unique_email (email)
                ) ENGINE=InnoDB COLLATE=utf8_unicode_ci";
        if ($conn->query($sql) === TRUE) {

        } else {
            echo "Error creating table users:  " . $conn->error;
        }

        //связь многие ко многим с таблицами contacts и users
        $sql = "CREATE TABLE IF NOT EXISTS contact_user (
                user_id INT(6) UNSIGNED,
                contact_id INT(6) UNSIGNED,
                PRIMARY KEY (user_id, contact_id),
                CONSTRAINT `FK__user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
                CONSTRAINT `FK_contact` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`)
                ) ENGINE=InnoDB COLLATE=utf8_unicode_ci";
        if ($conn->query($sql) === TRUE) {

        } else {
            echo "Error creating table contact_user:  " . $conn->error;
        }

        $this->protocol_and_host = $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://'.$_SERVER['SERVER_NAME'];

    }
    protected function check_auth()
    {
        $authorization = getallheaders()['Authorization'];
        $time_expired='';
        $quantity='';
        $sql = "select count(*) as quantity, time_expired_token from users where token_access='$authorization'";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $time_expired = $row['time_expired_token'];
                $quantity=$row['quantity'];
            }
        }
        $now = new \DateTime("NOW");
        $now->modify("-1 hour");
        $new_time =  $now->format('Y-m-d H:i:s');

        if($quantity>0 && strtotime($new_time)<strtotime($time_expired)){
            return true;
        } else {
           return false;
        }
    }
    public function __destruct()
    {
        $this->connection->close();
        // TODO: Implement __destruct() method.
    }

}