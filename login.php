<?php
session_start();
require_once 'src/User.php';
require_once 'config.php';
require_once 'src/Admin.php';
//login do skonczenia
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email =  strlen(trim($_POST['login'])) ? trim($_POST['login']) : null;
        $password =  strlen(trim($_POST['password'])) ? trim($_POST['password']) : null;
        $admin = Admin::getAdminByEmail($conn, $email);
        
        if(!$admin == false && $password){
            if($loggedUserId = Admin::login($conn, $email, $password)){
               $_SESSION['loggedUserId'] = $loggedUserId;
               header("Location: panel_admin.php");
           }
           else{
               echo' Incorrect email or password<br>';
           }
        }
        
        
        if($email && $password){
           if($loggedUserId = User::login($conn, $email, $password)){
               $_SESSION['loggedUserId'] = $loggedUserId;
               header("Location: index.php");
           }
           else{
               echo' Incorrect email or password<br>';
           }
        }
    }



?>
<html>
    <body>
        <form method="POST">
            <fieldset>
                    Email:
                    <label>
                        <input type="text" name="login">
                    </label>
                    <br>
                    Password:
                    <label>
                        <input type="text" name="password">
                    </label>
                    <br>
                    <label>
                        <input type="submit" value="Login" name="submit">
                    </label>
            </fieldset>
        </form>
    </body>
</html

