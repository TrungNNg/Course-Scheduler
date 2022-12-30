<?php
require("connect-mysql-inputs-and-outputs.php");

 if(isset($_POST["Import"])){
    
    $filename=$_FILES["file"]["tmp_name"];    
     if($_FILES["file"]["size"] > 0)
     {
        $file = fopen($filename, "r");
          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
           {
            //INSERT INTO `scheduler` (`SCID`, `CID`, `SEID`, `section`, `lecture_per_week`, `lecture_duration`, `lecture_start_time`, `lecture_end_time`, `lecture_days`, `lecture_FID`, `lecture_ROID`, `lab_start_time`, `lab_end_time`, `lab_days`, `lab_FID`, `lab_ROID`, `locked`) VALUES (NULL, '14', '2', '1', '1', '1', 'd', 'w', 'w', '1', '4', 'w', 'w', NULL, '1', '1', '1');
             $sql = "INSERT INTO `scheduler` (`SCID`, `CID`, `SEID`, `section`, `lecture_per_week`, `lecture_duration`, `lecture_start_time`, `lecture_end_time`, `lecture_days`, `lecture_FID`, `lecture_ROID`, `lab_start_time`, `lab_end_time`, `lab_days`, `lab_FID`, `lab_ROID`, `locked`) 
                   values (Null,'".$getData[1]."','".$getData[2]."'
                   ,'".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."'
                   ,'".$getData[7]."','".$getData[8]."','".$getData[9]."','".$getData[10]."'
                   ,'".$getData[11]."','".$getData[12]."','".$getData[14]."','".$getData[14]."'
                   ,'".$getData[15]."','".$getData[16]."')";
echo($sql);
/*
                   $result = mysqli_query($dbconn, $sql);
        if(!isset($result))
        {
          echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"batchfiles.php\"
              </script>";    
        }
        else {
            echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"batchfiles.php\"
          </script>";
        }
       */
           }
           fclose($file);  
     }
  }   
  function get_all_records(){
    require("connect-mysql-inputs-and-outputs.php");
    $Sql = "SELECT * FROM scheduler";
    $result = mysqli_query($dbconn, $Sql);  
    if (mysqli_num_rows($result) > 0) {
     echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
             <thead><tr><th>SCID</th>
                          <th>CID</th>
                          <th>SEID</th>
                          <th>section</th>
                          <th>lecture_per_week</th>
                          <th>lecture_duration</th>
                          <th>lecture_start_time</th>
                          <th>lecture_end_time</th>
                          <th>lecture_days</th>
                          <th>lecture_FID</th>
                          <th>lecture_ROID</th>
                          <th>lab_per_week</th>
                          <th>lab_duration</th>
                          <th>lab_start_time</th>
                          <th>lab_end_time</th>
                          <th>lab_days</th>
                          <th>lab_FID</th>
                          <th>lab_ROID</th>
                          <th>locked</th>
                        </tr></thead><tbody>";
     while($row = mysqli_fetch_assoc($result)) {
         echo "<tr><td>" . $row['SCID']."</td>
                   <td>" . $row['CID']."</td>
                   <td>" . $row['SEID']."</td>
                   <td>" . $row['section']."</td>
                   <td>" . $row['lecture_per_week']."</td>
                   <td>" . $row['lecture_duration']."</td>
                   <td>" . $row['lecture_start_time']."</td>
                   <td>" . $row['lecture_end_time']."</td>
                   <td>" . $row['lecture_days']."</td>
                   <td>" . $row['lecture_FID']."</td>
                   <td>" . $row['lecture_ROID']."</td>
                   <td>" . $row['lab_per_week']."</td>
                   <td>" . $row['lab_duration']."</td>
                   <td>" . $row['lab_start_time']."</td>
                   <td>" . $row['lab_end_time']."</td>
                   <td>" . $row['lab_days']."</td>
                   <td>" . $row['lab_FID']."</td>
                   <td>" . $row['lab_ROID']."</td>
                   <td>" . $row['locked']."</td>
                   </tr>";        
     }
     echo "</tbody></table></div>";
     
} else {
     echo "you have no records";
}
}
if(isset($_POST["Export"])){
    header('Content-Type: text/csv; charset=utf-8');  
    header('Content-Disposition: attachment; filename=data.csv');  
    $output = fopen("php://output", "w");  
    fputcsv($output, array('SCID','CID','SEID','section','lecture_per_week','lecture_duration'
    ,'lecture_start_time','lecture_end_time','lecture_days','lecture_FID','lecture_ROID', 
    'lab_start_time','lab_end_time','lab_days','lab_FID','lab_ROID','locked'));  
    $query = "SELECT * from scheduler ORDER BY SCID ASC";  
    $result = mysqli_query($dbconn, $query);  
    while($row = mysqli_fetch_assoc($result))  
    {  
         fputcsv($output, $row);  
    }  
    fclose($output);  
}  
 ?>