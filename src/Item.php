<?php

class Item{
    private $id;
    private $name;
    private $price;
    private $description;
    private $status;
    
    //CONSTRUCT
    
    public function __construct(){
        $this->id = "-1";
        $this->name = "";
        $this->price = 0;
        $this->description = "";
        $this->status = 1;
    }
    
    //GETTERS
    
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getPrice() {
        return $this->price;
    }

    function getDescription() {
        return $this->description;
    }

    function getStatus() {
        return $this->status;
    }
    
    //SETTERS
    
    function setName($name) {
        $this->name = $name;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setStatus($status) {
        $this->status = $status;
    }
    
    //DATABASE FUNCTIONS
    
    public function saveToDB(mysqli $conn){
        if($this->id == -1){
            $sql = "INSERT INTO Item(name, price, description, status)
            VALUES ('{$this->name}', '{$this->price}', '{$this->description}', {$this->status})";
                    
            if($conn->query($sql)) {
                $this->id = $conn->insert_id;
                return true;
            }
            else{
                return false;
            }
        }
        else{
            $sql = "UPDATE Item SET 
                name ='{$this->name}', 
                price = '{$this->price}', 
                description = {$this->description},
                status = '{$this->status}'
                WHERE id = {$this->id}";
                
            if($conn->query($sql)){
                return true;
            }
            else{
                return false;
            }
        }
    }
    
    public function loadFromDB(mysqli $conn,$id){
        $sql = "SELECT * FROM Item WHERE id = $id";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $rowItem = $result->fetch_assoc();
            $this->id = $rowItem['id'];
            $this->name= $rowItem['name'];
            $this->price = $rowItem['price'];
            $this->description = $rowItem['description'];
            $this->status = $rowItem['status'];
            return $this;
           
        }
        return null;
    }
    
  





    
}
