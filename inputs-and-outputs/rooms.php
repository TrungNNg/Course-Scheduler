<?php
    include("connect-mysql-inputs-and-outputs.php");
    $roomNum = htmlspecialchars($_POST["room_num"]);
    $shortName = htmlspecialchars($_POST["short_name"]);
    $BUID = htmlspecialchars($_POST["BUID"]);
    $seats = htmlspecialchars($_POST["seats"]);
    $query = "INSERT INTO rooms (ROID, BUID, short_name, room_num, seats)
    VALUES (NULL, '".$BUID."', '".$shortName."', '".$roomNum."', '".$seats."')";
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