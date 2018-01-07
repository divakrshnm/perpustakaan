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
  session_start();
  if(isset($_SESSION['status']) && $_SESSION['status'] == "login"){
    header("location:dashboard.php");
  }
  else{
    ?>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">ePerpustakaan</a>
        <?php include 'login.php'; ?>
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
              <h3>Mastin</h3>
              <p>Manggis kini ada ekstraknya.</p>
            </div>
          </div>
          <!-- Slide Two - Set the background image for this slide in the line below -->
          <div class="carousel-item" style="background-image: url('images/2.jpg')">
            <div class="carousel-caption d-none d-md-block">
              <h3>Mastin</h3>
              <p>Manggis kini ada ekstraknya.</p>
            </div>
          </div>
          <!-- Slide Three - Set the background image for this slide in the line below -->
          <div class="carousel-item" style="background-image: url('images/3.jpg')">
            <div class="carousel-caption d-none d-md-block">
              <h3>Mastin</h3>
              <p>Manggis kini ada ekstraknya.</p>
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
            include 'config/Database.php';
            $db = new Database();
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
            $query = "SELECT * FROM buku order by isbn DESC LIMIT $mulai, $batas";
            $result = mysqli_query($koneksi, $query);
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
            ?>
          </div>
          <?php
          $halaman_query = "SELECT * FROM buku ORDER BY isbn DESC";
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
            <h5 class="card-header">Search</h5>
            <div class="card-body">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                  <button class="btn btn-secondary" type="button">Go!</button>
                </span>
              </div>
            </div>
          </div>
          <!-- Side Widget -->
          <div class="card mb-4">
            <h5 class="card-header">Kunjungan Hari Ini</h5>
            <div class="card-body">
              <form action="proses.php" method="post" id="needs-validation" novalidate>
                <div class="control-group form-group">
                  <div class="controls">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required placeholder="Nama">
                    <div class="invalid-feedback">
                      Nama belum diisi.
                    </div>
                  </div>
                </div>
                <div class="control-group form-group">
                  <div class="controls">
                    <label>Kelas</label>
                    <input type="text" name="kelas" class="form-control" required placeholder="Kelas">
                    <div class="invalid-feedback">
                      Kelas belum diisi.
                    </div>
                  </div>
                </div>
                <div class="control-group form-group">
                  <div class="controls">
                    <label>Jurusan</label>
                    <select class="form-control" name="jurusan" required>
                      <option value="" selected disabled>Pilih Jurusan</option>
                      <option value="Teknik Informatika">Teknik Informatika</option>
                      <option value="Logistik Bisnis">Logistik Bisnis</option>
                      <option value="Akuntansi">Akuntansi</option>
                      <option value="Manajemen Bisnis">Manajemen Bisnis</option>
                      <option value="Manajemen Informatika">Manajemen Informatika</option>
                    </select>
                    <div class="invalid-feedback">
                      Nama belum diisi.
                    </div>
                  </div>
                </div>
                <div class="control-group form-group">
                  <div class="controls">
                    <label>Jenis Kelamin</label>
                    <div class="radio">
                      &nbsp;&nbsp;&nbsp;&nbsp;
                      <label class="radio-inline">
                        <input type="radio" name="jenis_kelamin" value="Laki-Laki" required> Laki-Laki
                      </label>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <label class="radio-inline">
                        <input type="radio" name="jenis_kelamin" value="Perempuan" required> Perempuan
                      </label>
                    </div>
                    <div class="invalid-feedback">
                      Jenis kelamin belum diisi.
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
                    <label>Jam</label>
                    <input type="text" class="form-control" id="time" readonly>
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
                    <th style="width:30%">Nama</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th style="width:20%">Keperluan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  $tanggal = date('Y-m-d');
                  $kunjungan = $db->read("data_kunjungan", "tanggal = '$tanggal'");
                  foreach($kunjungan as $data){
                    ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $data['nama_pengunjung']; ?></td>
                      <td><?php echo $data['kelas']; ?></td>
                      <td><?php echo $data['jurusan']; ?></td>
                      <td><?php echo $data['jenis_kelamin']; ?></td>
                      <td><?php echo $data['tanggal']; ?></td>
                      <td><?php echo $data['jam']; ?></td>
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
    <script>
    (function() {
      'use strict';      
      window.addEventListener('load', function() {
        var form = document.getElementById('needs-validation');
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      }, false);
    })();
    </script>
    <script type="text/javascript">
    function updateClock() {
      var now = new Date(),
      months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
      time = now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds(),
      date = [now.getDate(),
        months[now.getMonth()],
        now.getFullYear()].join(' ');
        document.getElementById("time").value = time;
        document.getElementById("date").value = date;
        setTimeout(updateClock, 1000);
      }
      updateClock();
      </script>
    <?php       } ?>
  </body>
  </html>
