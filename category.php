<?php

use \PDO as PDO;

global $db_host, $db_user, $db_pass, $db_name;
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'dbo_event Management';

class CATEGORY {

    public $db;

    public function connect() {
        global $db_host, $db_user, $db_pass, $db_name;
        $dsn = "mysql:host=" . $db_host . ";dbname=" . $db_name;
        return $this->db = new PDO($dsn, $db_user, $db_pass);
    }

    public function add($category_name, $category_description, $categoryimage, $status) {
        $sql = "INSERT INTO `category`(`categoryname`, `categoryimage`,`categorydescription`,`status`) VALUES ('" . $category_name . "','" . $categoryimage . "','" . $category_description . "','" . $status . "')";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
    }

    public function select($category_name, $category_description, $categoryimage, $status) {
        $test = $this->connect()->prepare("SELECT * FROM `category` where category_id = '" . $_GET['category_id'] . "'");
        $test->execute();
        $userRow = $test->fetch(PDO::FETCH_ASSOC);
        if ($userRow->rowCount() == 1) {

            $categoryname = $userRow["category_name"];
            $categorydescription = $userRow["category_description"];
            $categoryimage = $userRow["categoryimage"];
            $status = $userRow["status"];
            return true;
        } else {
            return false;
        }
    }

    function cat_check_duplicate($category_name) {
        $sql1 = $this->connect()->prepare("SELECT `category_id` FROM `category` WHERE `categoryname` = '" . $category_name . "'");
        $sql1->execute();
        $row = $sql1->fetch(PDO::FETCH_ASSOC);
        if ($row > 0) {
            return true;
        } else {
            return false;
        }
    }

}