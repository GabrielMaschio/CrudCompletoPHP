<?php

class Model {
    protected $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "loja_unifunec");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function closeConnection() {
        $this->conn->close();
    }
}

