<?php
$title = "Peminjaman";
include 'header.php';
include 'config/Database.php';
$db = new Database();
$result = $db->read("data_peminjaman");
?>
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-plus"></i> Tambah Peminjaman</div>
    <div class="card-body">
      <form action="proses.php" method="post" enctype="multipart/form-data" id="needs-validation" novalidate>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-6">
              <label for="">NPM</label>
              <input class="form-control" type="text" name="npm" value="" placeholder="NPM" required id="npmp">
              <div class="invalid-feedback">
                NPM belum diisi.
              </div>
            </div>
            <div class="col-md-6">
              <label for="">ISBN</label>
              <input class="form-control" type="text" name="isbn" value="" placeholder="ISBN" required id="isbnp">
              <div class="invalid-feedback">
                ISBN belum diisi.
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-6">
              <label for="">Nama</label>
              <input class="form-control" type="text" placeholder="Nama" readonly id="namap" required>
              <div class="invalid-feedback">
                Anggota belum terdaftar.
              </div>
            </div>
            <div class="col-md-6">
              <label for="">Judul Buku</label>
              <input class="form-control" type="text" placeholder="Judul Buku" readonly id="judulp" required>
              <div class="invalid-feedback">
                Buku blm terdaftar.
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-6">
              <label>Tanggal</label>
              <input type="text" class="form-control" id="date" readonly>
            </div>
            <div class="col-md-6">
              <label>Jam</label>
              <input type="text" class="form-control" id="time" readonly>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-2">
              <input type="hidden" name="proses" value="tambah_peminjaman">
              <input class="btn btn-primary btn-block" type="submit" name="tambah_peminjaman" value="Tambah">
            </div>
            <div class="col-md-2">
              <input class="btn btn-secondary btn-block" type="reset" name="batal" value="Batal">
            </div>
            <div class="col-md-8">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table"></i> Data Buku</div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No. Peminjaman</th>
                <th>NPM</th>
                <th>ISBN</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($result as $data){
                ?>
                <tr>
                  <td><?php echo $data['no_peminjaman']; ?></td>
                  <td><?php echo $data['npm']; ?></td>
                  <td><?php echo $data['isbn']; ?></td>
                  <td><?php echo $data['tanggal']; ?></td>
                  <td><?php echo $data['jam']; ?></td>
                  <td><?php echo $data['jumlah']; ?></td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php
    include 'footer.php';
    ?>
