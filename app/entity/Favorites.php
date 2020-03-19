<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 13.12.2019
 * Time: 14:13
 */

namespace app\entity;

require_once __DIR__."/Entity.php";

class Favorites extends Entity
{
    /**
     * @return array
     */
    public function getAllFavorites()
    {
        $response=[];
        $conn = $this->connection;
        $email = $_SESSION['email'];
        $sql = "SELECT *
                FROM contacts WHERE EXISTS (SELECT * FROM contact_user WHERE contact_user.contact_id = contacts.id and contact_user.user_id = (
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
}
