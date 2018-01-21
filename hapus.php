<?php
include 'config/Database.php';
$db = new Database();
if(isset($_GET['nis'])){
  $nis = $_GET['nis'];
  $db->delete("anggota", "nis = '$nis'");
  session_start();
  $_SESSION['pesan'] = "Data berhasil dihapus.";
  header("location:anggota.php");
}
else if(isset($_GET['isbn'])){
  $isbn = $_GET['isbn'];
  $db->delete("buku", "isbn = '$isbn'");
  session_start();
  $_SESSION['pesan'] = "Data berhasil dihapus.";
  header("location:buku.php");
}
else if(isset($_GET['username'])){
  $username = $_GET['username'];
  $db->delete("petugas", "username = '$username'");
  session_start();
  $_SESSION['pesan'] = "Data berhasil dihapus.";
  header("location:petugas.php");
}
 ?>
