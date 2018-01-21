<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>ePerpustakaan</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="assets/css/modern-business.css" rel="stylesheet">
  <link href="assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
</head>
<body>
  <?php
  include_once 'config/Database.php';
  $db = new Database();
  date_default_timezone_set('Asia/Jakarta');
  session_start();
  if(isset($_SESSION['valid'])){
    echo $_SESSION['valid'];
    unset($_SESSION['valid']);
  }
  if(isset($_SESSION['status']) && $_SESSION['status'] == "login"){
    header("location:dashboard.php");
  }
  else{
    ?>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">ePerpustakaan</a>
        <?php
        include 'login.php';
        if(isset($_POST['username']) AND isset($_POST['password'])){
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
            echo '<script type="text/javascript">alert("Username atau password salah.");</script>';
          }
        }
        ?>
      </div>
    </nav>
    <header>
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
          <!-- Slide One - Set the background image for this slide in the line below -->
          <div class="carousel-item active" style="background-image: url('images/1.jpg')">
            <div class="carousel-caption d-none d-md-block">
              <h3>Magic Painting Book</h3>
            </div>
          </div>
          <!-- Slide Two - Set the background image for this slide in the line below -->
          <div class="carousel-item" style="background-image: url('images/2.jpg')">
            <div class="carousel-caption d-none d-md-block">
              <h3>Many Books</h3>
            </div>
          </div>
          <!-- Slide Three - Set the background image for this slide in the line below -->
          <div class="carousel-item" style="background-image: url('images/3.jpg')">
            <div class="carousel-caption d-none d-md-block">
              <h3>The Great Ghost Hunt</h3>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </header>
    <!-- Page Content -->
    <div class="container">
      <h1 class="my-4">Selamat Datang di ePerpustakaan</h1>
      <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
          <div class="row">
            <?php
            $buku = $db->read("buku");
            $koneksi = new mysqli("localhost", "root", "", "perpustakaan");
            $batas = 6;
            $halaman = '';
            if(isset($_GET['halaman'])){
              $halaman = $_GET['halaman'];
            }
            else{
              $halaman = 1;
            }
            $mulai = ($halaman-1)*$batas;
            if(isset($_POST['cari_buku'])){
              $judul = $_POST['judul'];
              $query = "SELECT * FROM buku WHERE judul LIKE '%$judul%' ORDER BY isbn DESC LIMIT $mulai, $batas";
            }else{
              $query = "SELECT * FROM buku order by isbn DESC LIMIT $mulai, $batas";
            }

            $result = mysqli_query($koneksi, $query);
            $exist = mysqli_num_rows($result);
            if($exist > 0){
              while($data = mysqli_fetch_array($result)){
                ?>
                <div class="col-lg-4 mb-4">
                  <div class="card h-100 text-center">
                    <?php echo '<img class="card-img-top" src="data:image/jpeg;base64,'.base64_encode( $data['gambar'] ).'" style="width:100%; height:306px; object-fit: cover;">'; ?>
                    <div class="card-body">
                      <h5 class="card-title"><?php echo $data['judul']; ?></h5>
                      <h6 class="card-subtitle mb-2 text-muted"><?php echo $data['pengarang']; ?></h6>
                      <div class="card-text">
                        Lokasi Buku : <?php  echo $data['lokasi']; ?>
                      </div>
                    </div>
                    <div class="card-footer">
                      <?php
                      if($data['jumlah']>0){
                        echo '<h6 style="color:green;">Buku Tersedia</h6>';
                      }
                      else{
                        echo '<h6 style="color:red;">Buku Telah Dipinjam</h6>';
                      }
                      ?>
                    </div>
                  </div>
                </div>
                <?php
              }
            }else{
              echo '<div class="col-lg-12"><h4 style="height:60px;">Maaf, buku yang anda cari tidak ditemukan.</h4></div>';
            }

            ?>
          </div>
          <?php
          if(isset($_POST['cari_buku'])){
            $halaman_query = "SELECT * FROM buku WHERE judul LIKE '%$judul%' ORDER BY isbn DESC";
          }else{
            $halaman_query = "SELECT * FROM buku ORDER BY isbn DESC";
          }
          //$halaman_query = "SELECT * FROM buku ORDER BY isbn DESC";
          $hasil = mysqli_query($koneksi, $halaman_query);
          $total_data = mysqli_num_rows($hasil);
          $total_halaman = ceil($total_data/$batas);
          $akhir_halaman = $total_halaman;
          ?>
          <ul class="pagination justify-content-center mb-4">
            <?php
            if($halaman == 1)
            {
              if($total_data <= 6){
                ?>
                <li class="page-item disabled">
                  <a class="page-link" href="#">&#8249; Selanjutnya</a>
                </li>
                <li class="page-item disabled">
                  <a class="page-link" href="#">Sebelumnya &#8250;</a>
                </li>
                <?php
              }
              else{
                ?>
                <li class="page-item disabled">
                  <a class="page-link" href="#">&#8249; Selanjutnya</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="index.php?halaman=<?php $halaman += 1; echo $halaman; ?>">Sebelumnya &#8250;</a>
                </li>
                <?php
              }
            }else if($halaman >= 1){
              if($halaman == $akhir_halaman)
              {
                ?>
                <li class="page-item">
                  <a class="page-link" href="index.php?halaman=<?php $halaman -= 1; echo $halaman; ?>">&#8249; Selanjutnya</a>
                </li>
                <li class="page-item disabled">
                  <a class="page-link" href="#">Sebelumnya &#8250;</a>
                </li>
                <?php
              }else {
                ?>
                <li class="page-item">
                  <a class="page-link" href="index.php?halaman=<?php $halaman += 1; echo $halaman; ?>">&#8249; Selanjutnya</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="index.php?halaman=<?php $halaman -= 1; echo $halaman; ?>">Sebelumnya &#8250;</a>
                </li>
                <?php
              }
            }
            ?>
          </ul>
        </div>
        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">
          <!-- Search Widget -->
          <div class="card mb-4">
            <h5 class="card-header">Cari Buku</h5>
            <div class="card-body">
              <form action="index.php" method="post">
                <div class="input-group">
                  <input type="text" class="form-control" name="judul" placeholder="Judul" required>
                  <span class="input-group-btn">
                    <input type="submit" class="btn btn-primary" value="Cari" name="cari_buku">
                  </span>
                </div>
              </form>
            </div>
          </div>
          <!-- Side Widget -->
          <div class="card mb-4">
            <h5 class="card-header">Kunjungan Hari Ini</h5>
            <div class="card-body">

              <div class="control-group form-group">

                <?php
                if(isset($_POST['cari_nis'])){
                  $nis = $_POST['nis'];
                  $cek = $db->cek("anggota", "nis = '$nis'");
                  if($cek > 0){
                    $data = $db->read("anggota", "nis = '$nis'");
                  }
                  else{
                    echo '<script type="text/javascript">alert("NIS yang anda masukan tidak terdaftar.");</script>';
                  }
                }
                ?>
                <form action="index.php" method="post">
                  <div class="controls">
                    <label>NIS</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="nis"  placeholder="Cari NIS" value="<?php if(isset($data[0]['nis'])){echo $data[0]['nis'];} ?>" required>
                      <span class="input-group-btn">
                        <input type="submit" class="btn btn-primary" value="Cari" name="cari_nis">
                      </span>
                    </div>
                  </div>
                </div>
              </form>
              <form action="proses.php" method="post" id="needs-validation2" novalidate>
                <div class="control-group form-group">
                  <div class="controls">
                    <label>Nama</label>
                    <input type="hidden" name="nis2" value="<?php if(isset($data[0]['nis'])){echo $data[0]['nis'];} ?>" required>
                    <input type="text" name="nama" class="form-control" required placeholder="Nama" value="<?php  if(isset($data[0]['nama'])){echo $data[0]['nama'];} ?>" readonly>
                    <div class="invalid-feedback">
                      Nama belum diisi.
                    </div>
                  </div>
                </div>
                <div class="control-group form-group">
                  <div class="controls">
                    <label>Kelas</label>
                    <input type="text" name="kelas" class="form-control" required placeholder="Kelas" value="<?php  if(isset($data[0]['kelas'])){echo $data[0]['kelas'];}else{echo "";} ?>" readonly>
                    <div class="invalid-feedback">
                      Kelas belum diisi.
                    </div>
                  </div>
                </div>
                <div class="control-group form-group">
                  <div class="controls">
                    <label>Tanggal</label>
                    <input type="text" class="form-control" id="date" readonly>
                  </div>
                </div>
                <div class="control-group form-group">
                  <div class="controls">
                    <label>Keperluan</label>
                    <textarea rows="10" cols="80" class="form-control" name="keperluan" placeholder="Keperluan" maxlength="999" style="resize:none" required></textarea>
                    <div class="invalid-feedback">
                      Keperluan belum diisi.
                    </div>
                  </div>
                </div>
                <input type="hidden" name="proses" value="tambah_kunjugan">
                <input type="submit" class="btn btn-primary" value="Tambah" name="tambah_kunjugan">
              </form>
            </div>
          </div>
        </div>
        <div class="card md-12">
          <h5 class="card-header">Data Kunjungan Hari Ini</h5>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th style="width:20%">Nama</th>
                    <th>Kelas</th>
                    <th style="width:15%">Jenis Kelamin</th>
                    <th style="width:15%">Tanggal</th>
                    <th style="width:15%">Keperluan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  $tanggal = date('Y-m-d');
                  $kunjungan = $db->read("data_kunjungan", "tanggal = '$tanggal'", "INNER JOIN anggota ON data_kunjungan.nis = anggota.nis");
                  foreach($kunjungan as $data){
                    ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $data['nama']; ?></td>
                      <td><?php echo $data['kelas']; ?></td>
                      <td><?php echo $data['jenis_kelamin']; ?></td>
                      <td><?php $newDate = date("d F Y", strtotime($data['tanggal'])); echo $newDate; ?></td>
                      <td><?php echo $data['keperluan']; ?></td>
                    </tr>
                    <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br>
    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; ePerpustakaan <?php echo date('Y') ?></p>
      </div>
      <!-- /.container -->
    </footer>
    <!-- Bootstrap core JavaScript -->

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/datatables/jquery.dataTables.js"></script>
    <script src="assets/vendor/datatables/dataTables.bootstrap4.js"></script>
    <script src="assets/js/sb-admin-datatables.min.js"></script>
    <script type="text/javascript">

    (function() {
      'use strict';
      window.addEventListener('load', function() {
        var form = document.getElementById('needs-validation2');
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      }, false);
    })();

    function updateClock() {
      var now = new Date(),
      months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
      date = [now.getDate(),
        months[now.getMonth()],
        now.getFullYear()].join(' ');
        document.getElementById("date").value = date;
        setTimeout(updateClock, 1000);
      }
      updateClock();
      </script>

    <?php       } ?>
  </body>
  </html>
