<?php
    include("connect-mysql-inputs-and-outputs.php");
    $longName = htmlspecialchars($_POST["long_name"]);
    $shortName = htmlspecialchars($_POST["short_name"]);
    $query = "INSERT INTO building (BUID, short_name, long_name)
    VALUES (NULL, '".$longName."', '".$shortName."')";
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
?>