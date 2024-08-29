<?php
//this file help to get a connection from database
class Connection {
    public $conn;
    public function __construct() {
    $json = file_get_contents($_SERVER['DOCUMENT_ROOT']."/../data-base-config/config.json");
    $json_data = json_decode($json, true);
    $db_server = $json_data['servername'];
    $db_username = $json_data['username'];
    $db_password = $json_data['password'];
    $db_database = $json_data['database'];
    $this->conn = new mysqli($db_server, $db_username, $db_password, $db_database);
    }
    public function returnConn() {
        return $this->conn;
    }
    public function __destruct() {
        $this->conn->close();
    }
}


