<?php
    include("connect-mysql-inputs-and-outputs.php");
    $roomNum = htmlspecialchars($_POST["room_num"]);
    $shortName = htmlspecialchars($_POST["short_name"]);
    $BUID = htmlspecialchars($_POST["BUID"]);
    $seats = htmlspecialchars($_POST["seats"]);
    $query = "INSERT INTO rooms (ROID, BUID, short_name, room_num, seats)
    VALUES (NULL, '".$BUID."', '".$shortName."', '".$roomNum."', '".$seats."')";
if($dbconn->query($query)){
    echo "info was added";
}else{
    echo "info was not added";
}
?>