<?php

namespace App;

use App\Database;

class Users
{
    private $conn;
    private $tablename = "users";

    public $id;
    public $firstname;
    public $lastname;
    public $email;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function read()
    {
        $query = "SELECT id, first_name, last_name, email FROM " . $this->tablename;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->tablename . "(first_name, last_name, email) VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));

        $values = array($this->firstname, $this->lastname, $this->email);

        if ($stmt->execute($values)) {
            return true;
        }
        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->tablename . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $values = array($this->id);

        if ($stmt->execute($values)) {
            return true;
        }

        return false;
    }
}
