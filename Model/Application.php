<?php

class Application {

  private $dbParams = array(
    "servername" => 'localhost',
    'username' => 'root',
    'password' => 'Babesoft89',
    'dbname' => 'library'
  );

  private $connection;
  private $connectionLive = false;

  protected $table = '';
  protected $fields = array();

  protected $id = 0;

  public function __construct() {
    $this->connectDb();
    include_once('Utils/Messages.php');
    $this->msg = new Messages();
  }

  private function connectDb(){
    $this->connection = new mysqli($this->dbParams['servername'], $this->dbParams['username'],$this->dbParams['password'], $this->dbParams['dbname']);
    if($this->connection->connect_error) {
      die("Connection failed: " . $this->connection->connect_error);
    }
    $this->connectionLive = true;
  }

  protected function isDbConnectionLive() {
    return $this->connectionLive;
  }

  protected function getResultList($sql) {
    $resultList = array();
    $result = $this->connection->query($sql);
    if($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $resultList[] = $row;
      }
    }else {
      $this->writeLog("nem talált értéket a lekérdezés", $sql);
    }
    return $resultList;
  }

  protected function getSingleResult($sql)  {
    $resultList = $this->getResultList($sql);

    if (!$resultList) {
      $this->writeLog("nem talált értéket a lekérdezés", $sql);
      return array();
    } else {
      return $resultList[0];
    }
  }

  public function writeLog($string, $sql = null) {
    $logStr = $string;

    if ($sql !== null) {
      $logStr .= "-- SQL QUERY: ".$sql;
    }

    $log = fopen("log/log.txt", "a");
    fwrite($log, $logStr);
    fclose($log);
  }

  protected function isValidId($id) {
    if(is_int($id) && $id > 0) {
      return true;
    } else {
      return false;
    }
  }

  protected function deleteRekordById($table, $id) {
    //$result = $this->connection->query("delete from $table where id = $id");
    $result = $this->connection->query("update $table set active = 0 where id = $id");
    return $result;
  }

  protected function validation($data) {
    return true;
  }

  protected function create($data) {
    $sql = "INSERT INTO {$this->table} ";

    $insert = array();
    $insertData = array();
    foreach ($this->fields as $field) {
      if($field != 'id') {
        $insert[] = $field;
        $insertData[] = "'".$data[$field]."'";
      }
    }
    $sql .= '( '.implode(', ', $insert).' ) VALUES ('.implode(', ',$insertData).')';    
    return $this->execute($sql);
  }

  protected function getLastInsertedId() {
    $sql = "select id from {$this->table} order by id desc limit 1";
    $res = $this->getSingleResult($sql);
    return intval($res['id']);
  }

  protected function execute($sql) {
    $res = $this->connection->query($sql);
    return $res;
  }


  protected function modify($data) {
    $sql = 'UPDATE '.$this->table.' SET ';
    $update = array();
    foreach ($this->fields as $field) {
      if($field != 'id') {
        $update[] = $field . " = '".$data[$field]."'";
      }
    }
    $sql .= implode(', ', $update);
    $sql .= ' WHERE id = '.$data['id'];
    return $this->execute($sql);
  }

  public function exist($key, $table) {
    $sql = "select id from $table where id = $key";
    $result = $this->connection->query($sql);
    foreach ($result as $value) {
      return true;
    }
    return false;
  }

}
?>
