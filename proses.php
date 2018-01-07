<?php
include_once 'config/Database.php';
$db = new Database();
@$proses = $_POST['proses'];
date_default_timezone_set('Asia/Jakarta');
switch ($proses) {
  ////LOGIN////
  case 'login':
  $username = $_POST['username'];
  $password = $_POST['password'];

  $result = $db->login("petugas", "username = '$username' AND password = '$password'");

  if($result > 0){
    $result = $db->read("petugas", "username = '$username' AND password = '$password'");
    session_start();
    $_SESSION['fullname'] = $result[0]['fullname'];
    $_SESSION['status'] = "login";
    header("location:dashboard.php");
  }
  else{
    include 'index.php';
  }
  break;
  ////TAMBAH ANGGOTA////
  case 'tambah_anggota':
  $npm = $_POST['npm'];
  $nama = ucwords($_POST['nama']);
  $kelas = strtoupper($_POST['kelas']);
  $jurusan = $_POST['jurusan'];
  $jenis_kelamin = $_POST['jenis_kelamin'];

  $data = array(
    "npm" => $npm,
    "nama" => $nama,
    "kelas" => $kelas,
    "jurusan" => $jurusan,
    "jenis_kelamin" => $jenis_kelamin
  );
  $db->create("anggota", $data);
  session_start();
  $_SESSION['pesan'] = "$nama berhasil ditambahkan.";
  header("location:anggota.php");
  break;
  ////EDIT ANGGOTA////
  case 'edit_anggota':
  $npm = $_POST['npm'];
  $nama = ucwords($_POST['nama']);
  $kelas = strtoupper($_POST['kelas']);
  $jurusan = $_POST['jurusan'];
  $jenis_kelamin = $_POST['jenis_kelamin'];
  $data = array(
    "nama" => $nama,
    "kelas" => $kelas,
    "jurusan" => $jurusan,
    "jenis_kelamin" => $jenis_kelamin
  );
  $db->update("anggota", $data, "npm = '$npm'");
  session_start();
  $_SESSION['pesan'] = "$nama berhasil diedit.";
  header("location:anggota.php");
  break;
  ////TAMBAH BUKU////
  case 'tambah_buku':
  $isbn = $_POST['isbn'];
  $judul = ucwords($_POST['judul']);
  $pengarang = ucwords($_POST['pengarang']);
  $tahun_terbit = $_POST['tahun_terbit'];
  $penerbit = ucwords($_POST['penerbit']);
  $jumlah = $_POST['jumlah'];
  $lokasi = $_POST['lokasi'];
  $sinopsis = $_POST['sinopsis'];
  $gambar = addslashes(file_get_contents($_FILES['gambar']['tmp_name']));
  $jenis_gambar = $_FILES['gambar']['type'];
  $ukuran_gambar = $_FILES['gambar']['size'];
  $ukuran = 1000000;
  if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif" || $jenis_gambar=="image/x-png"){
    if($ukuran_gambar <= $ukuran){
      $data = array(
        "isbn" => $isbn,
        "judul" => $judul,
        "pengarang" => $pengarang,
        "tahun_terbit" => $tahun_terbit,
        "penerbit" => $penerbit,
        "jumlah" => $jumlah,
        "lokasi" => $lokasi,
        "sinopsis" => $sinopsis,
        "gambar" => $gambar
      );
      $db->create("buku", $data);
      header("location:buku.php");
    }else {
      echo "Ukuran Gambar Lebih dari 1 Mb";
      include 'buku.php';
    }
  }
  else{
    echo "Jenis gambar yang anda kirim salah. Harus .jpg .gif .png";
    include 'buku.php';
  }
  break;
  ////EDIT BUKU////
  case 'edit_buku':
  $isbn = $_POST['isbn'];
  $judul = ucwords($_POST['judul']);
  $pengarang = ucwords($_POST['pengarang']);
  $tahun_terbit = $_POST['tahun_terbit'];
  $penerbit = ucwords($_POST['penerbit']);
  $jumlah = $_POST['jumlah'];
  $lokasi = $_POST['lokasi'];
  $sinopsis = $_POST['sinopsis'];
  if(file_exists($_FILES['gambar'])){
    $gambar = addslashes(file_get_contents($_FILES['gambar']['tmp_name']));
    $jenis_gambar = $_FILES['gambar']['type'];
    $ukuran_gambar = $_FILES['gambar']['size'];
    $ukuran = 1000000;
    if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif" || $jenis_gambar=="image/x-png"){
      if($ukuran_gambar <= $ukuran){
        $data = array(
          "judul" => $judul,
          "pengarang" => $pengarang,
          "tahun_terbit" => $tahun_terbit,
          "penerbit" => $penerbit,
          "jumlah" => $jumlah,
          "lokasi" => $lokasi,
          "sinopsis" => $sinopsis,
          "gambar" => $gambar
        );
        $db->update("buku", $data, "isbn = '$isbn'");
        header("location:buku.php");
      }else {
        echo "Ukuran Gambar Lebih dari 500 kb";
      }
    }
    else{
      echo "Jenis gambar yang anda kirim salah. Harus .jpg .gif .png";
    }
  }else{
    $data = array(
      "judul" => $judul,
      "pengarang" => $pengarang,
      "tahun_terbit" => $tahun_terbit,
      "penerbit" => $penerbit,
      "jumlah" => $jumlah,
      "lokasi" => $lokasi,
      "sinopsis" => $sinopsis
    );
    $db->update("buku", $data, "isbn = '$isbn'");
    header("location:buku.php");
  }
  break;
  ////TAMBAH PETUGAS////
  case 'tambah_petugas':
  $username = $_POST['username'];
  $password = $_POST['password'];
  $fullname = $_POST['fullname'];
  $data = array(
    "username" => $username,
    "password" => $password,
    "fullname" => $fullname
  );
  $db->create("petugas", $data);
  header("location:petugas.php");
  break;

  case 'edit_petugas':
  $username = $_POST['username'];
  $password = $_POST['password'];
  $fullname = $_POST['fullname'];
  $data = array(
    "password" => $password,
    "fullname" => $fullname
  );
  $db->update("petugas", $data, "username = '$username'");
  header("location:petugas.php");
  break;
  ////TAMBAH KUNJUNGAN////
  case 'tambah_kunjugan':
  $nama = ucwords($_POST['nama']);
  $kelas = strtoupper($_POST['kelas']);
  $jurusan = $_POST['jurusan'];
  $jenis_kelamin = $_POST['jenis_kelamin'];
  $tanggal = date('Y-m-d');
  $jam = date('H:i:s');
  $keperluan = $_POST['keperluan'];
  $data = array(
    "nama_pengunjung" => $nama,
    "kelas" => $kelas,
    "jurusan" => $jurusan,
    "jenis_kelamin" => $jenis_kelamin,
    "tanggal" => $tanggal,
    "jam" => $jam,
    "keperluan" => $keperluan
  );
  $db->create("data_kunjungan", $data);
  header("location:index.php");
  break;
  ////TAMBAH PEMINJAMAN////
  case 'tambah_peminjaman':
  $npm = $_POST['npm'];
  $isbn = $_POST['isbn'];
  $tanggal = date('Y-m-d');
  $jam = date('H:i:s');
  $data = array(
    "npm" => $npm,
    "isbn" => $isbn,
    "tanggal" => $tanggal,
    "jam" => $jam
  );
  $db->create("data_peminjaman", $data);
  header("location:peminjaman.php");
  break;
  ////TAMBAH PENGEMBALIAN////
  case 'tambah_pengembalian':
  $npm = $_POST['npm'];
  $isbn = $_POST['isbn'];
  $denda = $_POST['denda'];
  $no_peminjaman = $_POST['no_peminjaman'];
  $tanggal = date('Y-m-d');
  $jam = date('H:i:s');
  $data = array(
    "npm" => $npm,
    "isbn" => $isbn,
    "tanggal" => $tanggal,
    "jam" => $jam
  );
  $db->create("data_pengembalian", $data);
  header("location:pengembalian.php");
  break;
}

?>
