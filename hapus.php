<?php
include 'config/Database.php';
$db = new Database();
if(isset($_GET['npm'])){
  $npm = $_GET['npm'];
  $db->delete("anggota", "npm = '$npm'");
  header("location:anggota.php");
}
else if(isset($_GET['isbn'])){
  $isbn = $_GET['isbn'];
  $db->delete("buku", "isbn = '$isbn'");
  header("location:buku.php");
}
 ?>
