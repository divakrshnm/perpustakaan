<?php
$title = "Peminjaman";
include 'header.php';
include 'config/Database.php';
$db = new Database();
$result = $db->read("data_peminjaman", null, "INNER JOIN anggota ON data_peminjaman.nis = anggota.nis  INNER JOIN buku ON data_peminjaman.isbn = buku.isbn");
if(isset($_SESSION['pesan'])){
  ?>
  <div class="alert alert-success alert-dismissable">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Sukses!</strong> <?php echo $_SESSION['pesan']; unset($_SESSION['pesan']); ?>
  </div>
  <?php
}
?>
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-plus"></i> Tambah Peminjaman</div>
    <div class="card-body">
      <form action="proses.php" method="post" enctype="multipart/form-data" id="needs-validation" novalidate>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-6">
              <label for="">NIS</label>
              <input class="form-control" type="text" name="nis" value="" placeholder="NIS" required id="nisp">
              <div class="invalid-feedback">
                NIS belum diisi.
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
      <i class="fa fa-table"></i> Data Peminjaman</div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No. Peminjaman</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>ISBN</th>
                <th>Judul</th>
                <th>Tanggal Peminjaman</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($result as $data){
                ?>
                <tr>
                  <td><?php echo $data['no_peminjaman']; ?></td>
                  <td><?php echo $data['nis']; ?></td>
                  <td><?php echo $data['nama']; ?></td>
                  <td><?php echo $data['isbn']; ?></td>
                  <td><?php echo $data['judul']; ?></td>
                  <td><?php $newDate = date("d F Y", strtotime($data['tanggal_peminjaman'])); echo $newDate; ?></td>
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
