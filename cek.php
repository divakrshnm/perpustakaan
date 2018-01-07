<?php
include_once 'config/Database.php';
$db = new Database();
if(isset($_POST['npm'])){
  $npm = $_POST['npm'];
  $result = $db->login("anggota", "npm = '$npm'");
  if($result > 0){
    echo '<div style="color:red;">&#10005</div>';
  }
  else if($result == 0 && $npm != ""){
    echo '<div style="color:green;">&#10003;</div>';
  }
  else{
    echo "&#160;&#160;&#160;";
  }
}

if(isset($_POST['npmp'])){
  $npmp = $_POST['npmp'];
  $result = $db->cek("anggota", "npm = '$npmp'");
  if($result > 0){
    $result = $db->read("anggota", "npm = '$npmp'");
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
