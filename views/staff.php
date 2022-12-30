<?php
    include("connect-mysql-inputs-and-outputs.php");
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $DEID = htmlspecialchars($_POST["DEID"]);
    $password = htmlspecialchars($_POST["password"]);
    $role = htmlspecialchars($_POST["role"]);
    $query = "INSERT INTO faculty (FID,DEID, name, email, password, role)
    VALUES (NULL, '".$DEID."', '".$name."', '".$email."', '".$password."', '".$role."')";
if($dbconn->query($query)){
        echo "info was added";
}else{
        echo "info can't be added";
    }
    function inputs($x) {
        if($x==null){
            return false;
        }else{
            return true;
        }
    }
    
    $dbconn->close();
?>