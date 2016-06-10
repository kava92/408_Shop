<?php

class Admin{
    
    public static function getAdminByEmail(mysqli $conn, $email){
        $sql = "SELECT * FROM Admin WHERE email = '$email'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            return $result->fetch_assoc();
        }else{
            return false;
        }
    }
     public static function login(mysqli $conn, $email, $password) {
        $sql = "SELECT * FROM Admin WHERE email = '$email' ";
        $result = $conn->query($sql);
        if($result->num_rows == 1 ) {
            $rowUser = $result->fetch_assoc();
            if (password_verify($password, $rowUser['password'])){
                return $rowUser['id'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    private $id;
    private $email;
    private $password;
    
    
    
    public function __construct() {
        $this->id = -1;
        $this->email = '';
        $this->password = '';
           
    }
    
    public function getId(){
        return $this->id;
    }
    
   
    public function setEmail($email){
        $this->email = is_string($email) ? trim($email) : $this->email;
    }
    
    public function getEmail (){
        return $this->email;
    }
    
    public function setPassword($password, $retypePassword){
        if($password != $retypePassword) {
            return false;
        }
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        return true;
    }
    
    public function saveToDB(mysqli $conn){
        if ($this->id == -1){
            $sql="INSERT INTO Admin  (email, password) Values ('{$this->email}', '{$this->password}')";
            if($conn->query($sql)){
                $this->id = $conn->insert_id;// wartosc ostatniego id do bazy danych
                return true;
            }else{
                echo $conn->error;
                return false;
            }
        }else {
            $sql = "UPDATE Admin SET email = '{$this->email}', password='{$this->password}' WHERE id = '{$this->id}'";
        }
        if($conn->query($sql)){
            return true;
        }else{
            return false;
        }
        
    }
    public function loadFromDB(mysqli $conn, $id) {
        $sql = "SELECT * FROM Admin WHERE id=$id";
        $result = $conn->query($sql);
        if($result->num_rows == 1) {
            $rowUser = $result->fetch_assoc();
            $this->id = $rowUser['id'];
            $this->email = $rowUser['email'];
            $this->password = $rowUser['password'];
           
            return $this;
        }
        else {
            return null;
        }
    }
}
