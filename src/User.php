<?php

class User{
    
    public static function getUserById(mysqli $conn, $id){
        $sql = "SELECT * FROM User WHERE id = $id";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            return $result->fetch_assoc();
        }else{
            return false;
        }
    }
    
    public static function getUserByEmail(mysqli $conn,$email){
        $sql = "SELECT * FROM User WHERE email = '$email'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            return $row;
            
        }
        else{
            return false;
        }
    }
    
    public static function login(mysqli $conn, $email, $password){
        $sql = "SELECT * FROM User WHERE email = '$email' ";
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
    private $name;
    private $surname;
    private $email;
    private $password;
    
    
    
    public function __construct() {
        $this->id = -1;
        $this->name = 0;
        $this->surname =0;
        $this->email = '';
        $this->password = '';
        
        
    }
    
    public function getId(){
        return $this->id;
    }
    
    
    public function setName($name){
        $this->name = is_string($name) ? trim($name) : $this->name;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function setSurname($surname){
        $this->surname = is_string($surname) ? trim($surname) : $this->surname;
    }
    
    public function getSurname(){
        return $this->nsurname;
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
            $sql="INSERT INTO User (name, surname, email, password) Values ('{$this->name}', '{$this->surname}', '{$this->email}', '{$this->password}')";
            if($conn->query($sql)){
                $this->id = $conn->insert_id;// wartosc ostatniego id do bazy danych
                return true;
            }else{
                echo $conn->error;
                return false;
            }
        }else {
            $sql = "UPDATE User SET  name = '{$this->name}', surname =  '{$this->surname}', email = '{$this->email}', password='{$this->password}' WHERE id = '{$this->id}'";
        }
        if($conn->query($sql)){
            return true;
        }else{
            return false;
        }
        
    }
    public function loadFromDB(mysqli $conn, $id) {
        $sql = "SELECT * FROM User WHERE id=$id";
        $result = $conn->query($sql);
        if($result->num_rows == 1) {
            $rowUser = $result->fetch_assoc();
            $this->id = $rowUser['id'];
            $this->name = $rowUser['name'];
            $this->surname = $rowUser['surname'];
            $this->email = $rowUser['email'];
            $this->password = $rowUser['password'];
           
            return $this;
        }
        else {
            return null;
        }
    }
}
