<?php
include_once 'config/Database.php';
$db = new Database();
if(isset($_POST['nis'])){
  $nis = $_POST['nis'];
  $result = $db->login("anggota", "nis = '$nis'");
  if($result > 0){
    echo '<div style="color:red;">&#10005</div>';
  }
  else if($result == 0 && $nis != ""){
    echo '<div style="color:green;">&#10003;</div>';
  }
  else{
    echo "&#160;&#160;&#160;";
  }
}
if(isset($_POST['isbn'])){
  $isbn = $_POST['isbn'];
  $result = $db->login("buku", "isbn = '$isbn'");
  if($result > 0){
    echo '<div style="color:red;">&#10005</div>';
  }
  else if($result == 0 && $isbn != ""){
    echo '<div style="color:green;">&#10003;</div>';
  }
  else{
    echo "&#160;&#160;&#160;";
  }
}

if(isset($_POST['nisp'])){
  $nisp = $_POST['nisp'];
  $result = $db->cek("anggota", "nis = '$nisp'");
  if($result > 0){
    $result = $db->read("anggota", "nis = '$nisp'");
    echo $result[0]['nama'];
  }
}

if(isset($_POST['isbnp'])){
  $isbnp = $_POST['isbnp'];
  $result = $db->cek("buku", "isbn = '$isbnp'");
  if($result > 0){
    $result = $db->read("buku", "isbn = '$isbnp'");
    echo $result[0]['judul'];
  }
}

 ?>
