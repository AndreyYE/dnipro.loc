<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 13.12.2019
 * Time: 14:13
 */

namespace app\entity;

require_once __DIR__."/Entity.php";

class Contacts extends Entity
{
    /**
     * @return array
     */
    public function index()
    {
        $response=[];
        $conn = $this->connection;
        $email = $_SESSION['email'];
        $sql = "SELECT *
                FROM contacts WHERE NOT EXISTS (SELECT * FROM contact_user WHERE contact_user.contact_id = contacts.id and contact_user.user_id = (
                SELECT users.id FROM users WHERE email = '$email'
                ))
         ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($response, $row);
            }
            return $response;
        } else {
            return ['errors'=>'Нет ни одного контакта'];
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function add_contact_to_user()
    {
        $conn = $this->connection;
        $email = $_SESSION['email'];
        $user_id = '';
        $contact_id = $_POST['id'];
        $sql = "SELECT id
                FROM users WHERE email='$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $user_id = $row['id'];
            }
            $this->add_record_table_contact_user($user_id, $contact_id);
        } else {
            return ['errors'=>'Нет ни одного контакта'];
        }
        echo $_SESSION['email'];
    }

    /**
     * @param $user_id
     * @param $contact_id
     * @throws \Exception
     */
    private function add_record_table_contact_user($user_id, $contact_id)
    {
        $stmt = $this->connection->prepare("INSERT INTO contact_user (user_id,contact_id) VALUES (?,?)");

        $user = (int)$user_id;
        $contact = (int)$contact_id;
        $stmt->bind_param("dd", $user, $contact);

        if(!$stmt->execute()) {
            throw new \Exception($stmt->error);
        }
    }
}
