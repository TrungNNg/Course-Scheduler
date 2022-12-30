<?php
    include("connect-mysql-inputs-and-outputs.php");
    $nameOfClass = htmlspecialchars($_POST["CID"]);//menu from data
    $SE = htmlspecialchars($_POST["SEID"]);//menu from data
    $section = htmlspecialchars($_POST["section"]);//inputs
    $lpw = htmlspecialchars($_POST["lecture_per_week"]);//inputs
    $ld = htmlspecialchars($_POST["lecture_duration"]);//inputs
    $lst = htmlspecialchars($_POST["lecture_start_time"]);//inputs
    $let = htmlspecialchars($_POST["lecture_end_time"]);//inputs
    $ldy = htmlspecialchars($_POST["lecture_days"]);//inputs
    $staff = htmlspecialchars($_POST["lecture_FID"]);//menu from data
    $room=htmlspecialchars($_POST["lecture_ROID"]);//menu from data
    $last = htmlspecialchars($_POST["lab_start_time"]);//inputs
    $laet = htmlspecialchars($_POST["lab_end_time"]);//inputs
    $lady = htmlspecialchars($_POST["lab_days"]);//inputs
    $lastaff = htmlspecialchars($_POST["lab_FID"]);//menu from data
    $laroom=htmlspecialchars($_POST["lab_ROID"]);//menu from data
    $islocked=htmlspecialchars($_POST["locked"]);//inputs
    $query = "INSERT INTO `scheduler` (`SCID`, `CID`, `SEID`, `section`, `lecture_per_week`,
     `lecture_duration`, `lecture_start_time`, `lecture_end_time`, `lecture_days`, `lecture_FID`,
      `lecture_ROID`, `lab_start_time`, `lab_end_time`, `lab_days`, `lab_FID`, `lab_ROID`, `locked`)
      values (Null,'".$nameOfClass."','".$SE."'
                   ,'".$section."','".$lpw."','".$ld."','".$lst."'
                   ,'".$let."','".$ldy."','".$staff."','".$room."','".$last."'
                   ,'".$laet."','".$lady."','".$lastaff."','".$laroom."'
                   ,'".$laroom."','".$islocked."')";
                   if($dbconn->query($query))
                   {
                       echo "info was added";
                   }else
               {
                   echo"info was not added"."<br>";
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
