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
    $status = 'success';
        echo '<script>alert("info was added")</script>';
        header("Location: forms.php?status=success");
        exit();
        
    }else{
    $status = 'error';
        echo '<script>alert("info was not added")</script>';
        header("Location: forms.php?status=error");
        exit();
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