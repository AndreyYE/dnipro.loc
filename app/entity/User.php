<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 13.12.2019
 * Time: 14:13
 */

namespace app\entity;

require_once __DIR__."/Entity.php";

class User extends Entity
{
    /**
     * @return string
     * @throws \Exception
     */
    public function create()
    {
        $stmt = $this->connection->prepare("INSERT INTO users (login,email,password) VALUES (?,?,?)");

        $login = $_POST['login'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt->bind_param("sss", $login,$email, $password);

        if(!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;

        return json_encode([
            'verificated_user'=>
                [
                    'email' => $email,
                    'password' => $password
                ]
             ]);

    }

    /**
     * @return bool|string
     */
    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $conn = $this->connection;
        $sql = "SELECT *
                FROM users
                WHERE email = '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $checkPassword = false;
            $pass = '';
            while($row = $result->fetch_assoc()) {
                if (password_verify($password, $row['password'])) {
                    $pass = $row['password'];
                    $checkPassword = true;
                }
            }
            if($checkPassword){
                $_SESSION["email"] = $email;
                $_SESSION["password"] = $pass;
                return json_encode([
                    'verificated_user'=>
                        [
                            'email' => $email,
                            'password' => $password
                        ]
                ]);
            }else{
                return false;
            }
        }
    }

    /**
     * Get email
     * @param string $email
     */
    public function check_email_already_exists($email)
    {
        $conn = $this->connection;
        $sql = "SELECT *
                FROM users
                WHERE email = '$email'";
        $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                return true;
            }
            return false;
    }

    /**
     * @return bool|null
     */
    public function checkAuth()
    {
        $email = '';
        $password = '';
        if(isset($_SESSION['email']) and isset($_SESSION['password'])){
            $email = $_SESSION['email'];
            $password = $_SESSION['password'];
        }
        $conn = $this->connection;
        $sql = "SELECT *
                FROM users
                WHERE email = '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $id = null;
            while($row = $result->fetch_assoc()) {

                if($row['password'] == $password){
                    $id = $row['id'];
                }
            }
            if($id){
                return $id;
            }else{
                return false;
            }
        }
        return false;
    }

    /**
     * redirect
     */
    public function redirect_to_login()
    {
        header("Location: ".$this->protocol_and_host."/login");
        exit();
    }
    /**
     * redirect
     */
    public function redirect_to_main()
    {
        header("Location: ".$this->protocol_and_host."/contacts");
        exit();
    }
    public function add_favorites()
    {
        return $_SESSION['email'];
    }
}
