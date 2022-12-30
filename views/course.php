<?php
    include("connect-mysql-inputs-and-outputs.php");
    $longName = htmlspecialchars($_POST["long_name"]);
    $shortName = htmlspecialchars($_POST["short_name"]);
    $credit = htmlspecialchars($_POST["credit"]);
    $isLab = htmlspecialchars($_POST["is_lab"]);
    $isGrad = htmlspecialchars($_POST["is_grad"]);
    $DEID = htmlspecialchars($_POST["DEID"]);
    $isGrad = '0';
    $DEID = '1';

    $query = "INSERT INTO course VALUES (NULL, '".$shortName."', '".$longName."', '".$credit."', '".$isLab."', '".$isGrad."', '', '".$DEID."')";

    if($dbconn->query($query)){
        echo '<script>alert("info was added")</script>';
        header("Location: forms.php?status=success");
        exit();
        
    }else{
        echo '<script>alert("info was not added")</script>';
        header("Location: forms.php?status=error");
        exit();
    }

?>
