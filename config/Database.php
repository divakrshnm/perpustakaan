<?php
class Database{
  public $conn;
  public $host = "localhost";
  public $user = "root";
  public $pass = "";
  public $db   = "perpustakaan";

  public function __construct(){
    $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
    if(!$this->conn){
      die($this->conn->error);
    }
  }

  public function login($table, $where){
    $sql = "SELECT * FROM $table WHERE $where";
    $query = $this->conn->query($sql);
    return $query->num_rows;
  }

  public function cek($table, $where=null, $join=null){
    $sql = "SELECT * FROM $table";
    if($where != null){
      if($join != null){
        $sql .= " $join WHERE $where";
      }
      else{
        $sql .= " WHERE $where";
      }
    }
    $query = $this->conn->query($sql);
    return $query->num_rows;
  }

  public function read($table, $where=null, $join=null){
    $sql = "SELECT * FROM $table";
    if($where != null){
      if($join != null){
        $sql .= " $join WHERE $where";
      }
      else{
        $sql .= " WHERE $where";
      }
    }else{
      $sql .= " $join";
    }
    $query = $this->conn->query($sql);
    return $query->fetch_all(MYSQLI_BOTH);
  }

  public function create($table, $data){
      $sql = "INSERT INTO $table";
      $kolom = null;
      $nilai = null;
      foreach($data as $field => $value){
        $kolom .= ", ".$field;
        $nilai .= ", '".$value."'";
      }
      $sql .=" (".substr($kolom, 2).")";
      $sql .=" VALUES(".substr($nilai, 2).")";
      // echo($sql);
      $query = $this->conn->prepare($sql);
      $query->execute();
    }

    public function update($table, $data, $where){
        $sql = "UPDATE $table SET ";
        $set = null;
        foreach($data as $kolom => $nilai){
          $set .=", ".$kolom." = '".$nilai."'";
        }
        $sql .= substr($set, 2)." WHERE $where";
        //echo $sql;
        $query = $this->conn->prepare($sql);
        $query->execute();
      }
      public function delete($table, $where){
        $sql = "DELETE FROM $table WHERE $where";
        $this->conn->query($sql);
      }
}
 ?>
