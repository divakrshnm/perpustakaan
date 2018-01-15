<?php
include_once 'config/Database.php';
$db = new Database();
@$proses = $_POST['proses'];
date_default_timezone_set('Asia/Jakarta');
switch ($proses) {
  ////LOGIN////
  case 'login':
  $username =  mysqli_real_escape_string($db->conn, trim($_POST['username']));
  $password =  mysqli_real_escape_string($db->conn, trim($_POST['password']));

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
  $nis = $_POST['nis'];
  $nama = ucwords($_POST['nama']);
  $kelas = strtoupper($_POST['kelas']);
  $jenis_kelamin = $_POST['jenis_kelamin'];

  $data = array(
    "nis" => $nis,
    "nama" => $nama,
    "kelas" => $kelas,
    "jenis_kelamin" => $jenis_kelamin
  );
  $db->create("anggota", $data);
  session_start();
  $_SESSION['pesan'] = "$nama berhasil ditambahkan.";
  header("location:anggota.php");
  break;
  ////EDIT ANGGOTA////
  case 'edit_anggota':
  $nis = $_POST['nis'];
  $nama = ucwords($_POST['nama']);
  $kelas = strtoupper($_POST['kelas']);
  $jenis_kelamin = $_POST['jenis_kelamin'];
  $data = array(
    "nama" => $nama,
    "kelas" => $kelas,
    "jenis_kelamin" => $jenis_kelamin
  );
  $db->update("anggota", $data, "nis = '$nis'");
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
  $tanggal_masuk = date("Y-m-d", strtotime($_POST['tanggal_masuk']));
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
        "tanggal_masuk" => $tanggal_masuk,
        "gambar" => $gambar
      );
      $db->create("buku", $data);
      session_start();
      $_SESSION['pesan'] = "$judul berhasil ditambahkan.";
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
  $tanggal_masuk = date("Y-m-d", strtotime($_POST['tanggal_masuk']));
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
          "tanggal_masuk" => $tanggal_masuk,
          "gambar" => $gambar
        );
        $db->update("buku", $data, "isbn = '$isbn'");
        session_start();
        $_SESSION['pesan'] = "$judul berhasil diedit.";
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
      "tanggal_masuk" => $tanggal_masuk,
    );
    $db->update("buku", $data, "isbn = '$isbn'");
    session_start();
    $_SESSION['pesan'] = "$judul berhasil diedit.";
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
  $nis = $_POST['nis'];
  $tanggal = date('Y-m-d');
  $keperluan = $_POST['keperluan'];
  $data = array(
    "nis" => $nis,
    "tanggal" => $tanggal,
    "keperluan" => $keperluan
  );
  $db->create("data_kunjungan", $data);
  header("location:index.php");
  break;
  ////TAMBAH PEMINJAMAN////
  case 'tambah_peminjaman':
  $nis = $_POST['nis'];
  $isbn = $_POST['isbn'];
  $tanggal = date('Y-m-d');
  $data = array(
    "nis" => $nis,
    "isbn" => $isbn,
    "tanggal_peminjaman" => $tanggal
  );
  $db->create("data_peminjaman", $data);
  session_start();
  $_SESSION['pesan'] = "Data peminjaman berhasil ditambahkan.";
  header("location:peminjaman.php");
  break;
  ////TAMBAH PENGEMBALIAN////
  case 'tambah_pengembalian':
  $nis = $_POST['nis'];
  $isbn = $_POST['isbn'];
  $no_peminjaman = $_POST['no_peminjaman'];
  $tanggal = date('Y-m-d');
  if(isset($_POST['keterangan'])){
    $keterangan = $_POST['keterangan'];
  }
  else{
      $keterangan = "-";
  }
  $keterangan = $_POST['keterangan'];
  $data = array(
    "tanggal_pengembalian" => $tanggal,
    "keterangan" => $keterangan,
    "status" => "Kembali"
  );
  $db->update("data_peminjaman", $data, "nis = '$nis' AND isbn = '$isbn' AND no_peminjaman = '$no_peminjaman'");
  session_start();
  $_SESSION['pesan'] = "Data pengembalian berhasil ditambahkan.";
  header("location:pengembalian.php");
  break;
}

?>
