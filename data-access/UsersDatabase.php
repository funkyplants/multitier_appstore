<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

// Use "require_once" to load the files needed for the class

require_once __DIR__ . "/Database.php";
require_once __DIR__ . "/../models/UsersModel.php";

class UsersDatabase extends Database
{
    private $table_name = "users";

    // Get one app by using the inherited function getOneRowByIdFromTable
    public function getOne($user_id)
    {
        $result = $this->getOneRowByIdFromTable($this->table_name, 'user_id', $user_id);

        $user = $result->fetch_object("UsersModel");

        return $user;
    }


    // Get all customers by using the inherited function getAllRowsFromTable
    public function getAll()
    {
        $result = $this->getAllRowsFromTable($this->table_name);

        $users = [];

        while($app = $result->fetch_object("UsersModel")){
            $users[] = $user;
        }

        return $users;
    }

    // Create one by creating a query and using the inherited $this->conn 
    public function insert(UsersModel $user){
        $query = "INSERT INTO users (first_name, last_name) VALUES (?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("ss", $user->first_name, $user->last_name);

        $success = $stmt->execute();

        return $success;
    }
}
