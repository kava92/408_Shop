<?php
require_once 'src/User.php';
require_once 'config.php';


if(isset($_SESSION['loggedUserId'])){
    header("Location: index.php");
}


if($_SERVER['REQUEST_METHOD'] =='POST'){
    $email = strlen(trim($_POST['email']))>0 ? trim($_POST['email']) : null;
    $password = strlen(trim($_POST['password']))>0 ? trim($_POST['password']) : null;
    $retypedPassword = strlen(trim($_POST['retypedPassword']))>0 ? trim($_POST['retypedPassword']) : null;
    $name = strlen(trim($_POST['name']))>0 ? trim($_POST['name']) : null;
    $surname = strlen(trim($_POST['surname']))>0 ? trim($_POST['surname']) : null;
    
    $user = User::getUserByEmail($conn, $email);
    
    if($email && $password && $retypedPassword && $name && $surname && $password==$retypedPassword && !$user){
        
        $newUser =  new User();
        $newUser->setEmail($email);
        $newUser->setPassword($password, $retypedPassword);
        $newUser->setName($name);
        $newUser->setSurname($surname);
        if($newUser->saveToDB($conn)){
            echo 'Reqistration successfull<br>';
            header("Location: login.php");
        }
        else{
            echo "Error during the registration<br>";
        }
    }
    else{
        if(!$email){
            echo 'Incorrect emai<br>';
        }
        if(!$password){
            echo 'Incorrrect password<br>';
        }
        if(!$retypedPassword || $password != $retypedPassword){
            echo 'Incorrect retyped password<br>';
        }
        if(!$name){
            echo 'Incorrect name<br>';
        }
        if(!$surname){
            echo 'Incorrect surname<br>';
        }
        if($user) {
            echo 'User email exists<br>';
        }
    }
}


?>


<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <form method="POST">
            <fieldset>
                <label>
                    Email:
                    <input type="text" name="email">
                </label>
                <br>
                <label>
                    Password:
                    <input type="password" name="password">
                </label>
                <br>
                <label>
                    Retype password:
                    <input type="password" name="retypedPassword">
                </label>
                <br>
                <label>
                    Name:
                    <input type="text" name="name">
                </label>
                <br>
                <label>
                    Surname:
                    <input type="text" name="surname">
                </label>
                <br>
                <input type="submit" value="Register">
            </fieldset>
        </form>
    </body>
</html>

