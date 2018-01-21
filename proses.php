<?php
include_once 'config/Database.php';
$db = new Database();
@$proses = $_POST['proses'];
date_default_timezone_set('Asia/Jakarta');
switch ($proses) {
  ////TAMBAH ANGGOTA////
  case 'tambah_anggota':
  $nis = $_POST['nis'];
  $nama = ucwords($_POST['nama']);
  $kelas = strtoupper($_POST['kelas']);
  $jenis_kelamin = $_POST['jenis_kelamin'];
  $result = $db->login("anggota", "nis = '$nis'");
  if($result > 0){
    session_start();
    $_SESSION['valid'] = '<script type="text/javascript">alert("NIS yang anda masukan sudah ada.");</script>';
    header("Location:anggota.php");
  }else{
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
  }
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

  $result = $db->login("buku", "isbn = '$isbn'");
  if($result > 0){
    session_start();
    $_SESSION['valid'] = '<script type="text/javascript">alert("ISBN yang anda masukan sudah ada.");</script>';
    header("Location:buku.php");
  }else{
    if(file_exists($_FILES['gambar']['tmp_name'])){
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
          session_start();
          $_SESSION['valid'] = '<script type="text/javascript">alert("Ukuran Gambar Lebih dari 1 Mb.");</script>';
          header("Location:buku.php");
        }
      }
      else{
        session_start();
        $_SESSION['valid'] = '<script type="text/javascript">alert("Jenis gambar yang anda kirim salah. Harus .jpg .gif .png.");</script>';
        header("Location:buku.php");
      }
    }else{
      $data = array(
        "isbn" => $isbn,
        "judul" => $judul,
        "pengarang" => $pengarang,
        "tahun_terbit" => $tahun_terbit,
        "penerbit" => $penerbit,
        "jumlah" => $jumlah,
        "lokasi" => $lokasi,
        "tanggal_masuk" => $tanggal_masuk
      );
      $db->create("buku", $data);
      session_start();
      $_SESSION['pesan'] = "$judul berhasil ditambahkan.";
      header("location:buku.php");
    }

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
  if(file_exists($_FILES['gambar']['tmp_name'])){
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
        session_start();
        $_SESSION['valid'] = '<script type="text/javascript">alert("Ukuran Gambar Lebih dari 1 Mb.");</script>';
        header("Location:buku.php");
      }
    }
    else{
      session_start();
      $_SESSION['valid'] = '<script type="text/javascript">alert("Jenis gambar yang anda kirim salah. Harus .jpg .gif .png.");</script>';
      header("Location:buku.php");
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
  $fullname = ucwords($_POST['fullname']);
  $data = array(
    "username" => $username,
    "password" => $password,
    "fullname" => $fullname
  );
  $db->create("petugas", $data);
  session_start();
  $_SESSION['pesan'] = "$fullname berhasil ditambahkan.";
  header("location:petugas.php");
  break;

  case 'edit_petugas':
  $username = $_POST['username'];
  $password = $_POST['password'];
  $fullname = ucwords($_POST['fullname']);
  $data = array(
    "password" => $password,
    "fullname" => $fullname
  );
  $db->update("petugas", $data, "username = '$username'");
  session_start();
  $_SESSION['pesan'] = "$fullname berhasil diedit.";
  header("location:petugas.php");
  break;
  ////TAMBAH KUNJUNGAN////
  case 'tambah_kunjugan':
  if(!empty($_POST['nis2'])){
    $nis = $_POST['nis2'];
    $tanggal = date('Y-m-d');
    $keperluan = $_POST['keperluan'];
    $data = array(
      "nis" => $nis,
      "tanggal" => $tanggal,
      "keperluan" => $keperluan
    );
    $db->create("data_kunjungan", $data);
    header("location:index.php");
  }
  else{
    session_start();
    $_SESSION['valid'] = '<script type="text/javascript">alert("Data kunjungan belum lengkap.");</script>';
    header("Location:index.php");
  }
  break;
  ////TAMBAH PEMINJAMAN////
  case 'tambah_peminjaman':
  if(isset($_POST['nis']) && isset($_POST['isbn'])){
    $nis = $_POST['nis'];
    $isbn = $_POST['isbn'];
    $cek_buku = $db->cek("buku", "isbn = '$isbn'");
    $cek_nis = $db->cek("anggota", "nis = '$nis'");
    if($cek_buku > 0 && $cek_nis > 0){
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
    }
    else{
      session_start();
      $_SESSION['valid'] = '<script type="text/javascript">alert("NIS atau ISBN yang anda masukan tidak terdaftar.");</script>';
      header("Location:peminjaman.php");
    }
  }

  break;
  ////TAMBAH PENGEMBALIAN////
  case 'tambah_pengembalian':
  if(!empty($_POST['nis']) && !empty($_POST['isbn'])){
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
  }
  else{
    session_start();
    $_SESSION['valid'] = '<script type="text/javascript">alert("Anda belum memasukan NIS atau ISBN.");</script>';
    header("Location:pengembalian.php");
  }

  break;
}

?>
