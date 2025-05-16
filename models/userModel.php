<?php

require_once __DIR__ . '/../config/database.php';

class User{
    private $conn;

    public function __construct(){
        $database = new database();
        $this->conn = $database->getConnection();
    }

    public function getUserRole($id){
        $stmt = $this->conn->prepare("SELECT role FROM user WHERE id= ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $user = $result->fetch_assoc();
            return $user['role'];
        }

        return null;
    }

    public function checkAdminAccess(){
        if(empty($_SESSION["id"])){
            header("Location: components/login.php");
            exit();
        }

        $role = $this->getUserRole($_SESSION["id"]);
        if($role !== 'admin'){
            header("Location: index.php");
            exit();
        }
    }
}

?>