<?php

use \PDO as PDO;

global $db_host, $db_user, $db_pass, $db_name;
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'dbo_event_management';

class EVENT {

    public $db;

    public function connect() {
        global $db_host, $db_user, $db_pass, $db_name;
        $dsn = "mysql:host=" . $db_host . ";dbname=" . $db_name;
        return $this->db = new PDO($dsn, $db_user, $db_pass);
    }

    public function register($user_name, $user_mail, $user_pass, $user_profile) {
        $user_pass = Password_hash($user_pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO `users`(`user_name`, `user_mail`, `user_pass`,`user_profile`) VALUES ('" . $user_name . "','" . $user_mail . "','" . $user_pass . "','" . $user_profile . "')";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
    }

    public function dologin($Username, $Password) {
        $stmt = $this->connect()->prepare("SELECT * FROM `users` WHERE `user_name` = '$Username'");
        $stmt->execute();
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) {
            $_SESSION['is_admin'] = $userRow['is_admin'];
            $_SESSION['user_id'] = $userRow['user_id'];
            $_SESSION['user_name'] = $userRow['user_name'];
            $_SESSION['user_profile'] = $userRow['user_profile'];
            return true;
        } else {
            return false;
        }
    }

    public function is_loggedin() {
        if (isset($_SESSION['user_id'])) {
            return true;
        }
    }

    public function redirect($url) {
        header("Location:$url");
    }

    public function dologout() {
        session_destroy();
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        return true;
    }

    public function add($title, $description, $Venue, $event_start_date, $event_end_date, $ticketamount, $event_status, $Capacity, $booking_start_date, $booking_end_date, $category_name, $Address, $status) {

        $sql = "INSERT INTO `event`(`Title`,`Description`,`Venue`,`Event_start_date`,`Event_end_date`,`Eventstatus`,`Ticketamount`,`Capacity`,`Booking_start_date`,`Booking_end_date`,`category_id`,`Address`,`Status`) VALUES ('" . $title . "','" . $description . "','" . $Venue . "','" . $event_start_date . "','" . $event_end_date . "','" . $event_status . "','" . $ticketamount . "','" . $Capacity . "','" . $booking_start_date . "','" . $booking_end_date . "','" . $category_name . "','" . $Address . "','" . $status . "')";
        $sql1 = $this->connect()->prepare($sql);
        $sql1->execute();
        $lastId = $this->db->lastInsertId();
        return $lastId;
    }
    public function deleteInfo($id){
    $delete = $pdo->prepare("DELETE FROM table WHERE id = ?");
    $delete-> bindValue(":id", $id, PDO::PARAM_STR);
    $delete-> execute();
    }
}

?>