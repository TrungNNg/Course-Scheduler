<?php
    include("connect-mysql-inputs-and-outputs.php");
    $longName = htmlspecialchars($_POST["long_name"]);
    $shortName = htmlspecialchars($_POST["short_name"]);
    $query = "INSERT INTO building (BUID, short_name, long_name)
    VALUES (NULL, '".$longName."', '".$shortName."')";
if($dbconn->query($query)){
    echo "info was added";
}else{
    echo "info was not added";
}
?>