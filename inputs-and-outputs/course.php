<?php
    include("connect-mysql-inputs-and-outputs.php");
    $longName = htmlspecialchars($_POST["long_name"]);
    $shortName = htmlspecialchars($_POST["short_name"]);
    $credit = htmlspecialchars($_POST["credit"]);
    $isLab = htmlspecialchars($_POST["is_lab"]);
    $isGrad = htmlspecialchars($_POST["is_grad"]);
    $DEID = htmlspecialchars($_POST["DEID"]);
    $query = "INSERT INTO course (CID, short_name, long_name, credit, is_lab, is_grad, DEID)
    VALUES (NULL,'".$shortName."', '".$longName."', '".$credit."', '".$isLab."', '".$isGrad."', '".$DEID."')";
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