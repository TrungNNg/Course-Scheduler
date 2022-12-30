<?php
class DB
{

  private $host = "localhost";
  private $db_name = "2022-scheduler";
  private $username = "root";
  private $password = "";
  public $conn;

  function __construct()
  {
    $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
    if ($this->conn->connect_error) {
      die("Connection failed: " . $this->conn->connect_error);
    }
  }
  function query($sql)
  {

    return mysqli_query($this->conn, $sql);
  }
  function getCourseInfo($SCID)
  {
    $sql = 'select * from scheduler where SCID = ' . $SCID;
    $result = $this->query($sql)->fetch_assoc();
    $info['section'] = $result['section'];
    $sql = 'select * from course where CID = ' . $result['CID'];
    $result = $this->query($sql)->fetch_assoc();
    $info['short_name'] = $result['short_name'];
    return $info;
  }
  function getLabInfo($LID){
    $sql = 'select SCID from lab where LID = ' . $LID;
    $result = $this->query($sql)->fetch_assoc();
    $sql = 'select * from scheduler where SCID = ' . $result['SCID'];
    $result = $this->query($sql)->fetch_assoc();
    $info['section'] = $result['section'];
    $sql = 'select * from course where CID = ' . $result['CID'];
    $result = $this->query($sql)->fetch_assoc();
    $info['short_name'] = $result['short_name'];
    return $info;
  }
}
