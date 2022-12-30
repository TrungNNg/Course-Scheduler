<?php
//$path = '/includes';
//set_include_path(get_include_path() . PATH_SEPARATOR . $path);
$server = "localhost";
$dbusername = "se_f22_g05";
$password = "rdt8ve";
$db = "se_f22_g05_db";
$debug = "true";

$dbconn = mysqli_connect($server, $dbusername, $password, $db);

if ($dbconn->connect_error) {
    die('Could not connect: ' . $dbconn->connect_error);
}elseif($debug == "true"){
}

//You can use the command below to set the default database to another db.
//mysqli_select_db($dbconn, "webiii");

?>