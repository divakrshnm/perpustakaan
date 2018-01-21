<?php
$title = "Pengembalian";
include 'header.php';
include 'config/Database.php';
$db = new Database();
if(isset($_SESSION['valid'])){
  echo $_SESSION['valid'];
  unset($_SESSION['valid']);
}
if(isset($_POST['cari_peminjaman'])){
  $nis = $_POST['nis'];
  $isbn = $_POST['isbn'];
  $cek = $db->cek("data_peminjaman", "data_peminjaman.isbn = '$isbn' AND data_peminjaman.nis  = '$nis' AND status = 'Belum Kembali'", "INNER JOIN buku ON data_peminjaman.isbn = buku.isbn INNER JOIN anggota ON data_peminjaman.nis = anggota.nis");
  if($cek > 0){
    $result = $db->read("data_peminjaman", "data_peminjaman.isbn = '$isbn' AND data_peminjaman.nis  = '$nis' AND status = 'Belum Kembali'", "INNER JOIN buku ON data_peminjaman.isbn = buku.isbn INNER JOIN anggota ON data_peminjaman.nis = anggota.nis");
  }
  else{
    echo '<script type="text/javascript">alert("NIS atau ISBN yang anda masukan tidak ada di data peminjaman.");</script>';
  }

}
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
    <i class="fa fa-plus"></i> Tambah Pengembalian</div>
    <div class="card-body">
      <form action="pengembalian.php" method="post" enctype="multipart/form-data" id="needs-validation" novalidate>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-5">
              <label for="">NIS</label>
              <input class="form-control" type="text" name="nis" value="<?php if(isset($result[0]['nis'])){echo $result[0]['nis'];} ?>" placeholder="NIS" required>
              <div class="invalid-feedback">
                NIS belum diisi.
              </div>
            </div>
            <div class="col-md-5">
              <label for="">ISBN</label>
              <input class="form-control" type="text" name="isbn" value="<?php if(isset($result[0]['isbn'])){echo $result[0]['isbn'];} ?>" placeholder="ISBN" required>
              <div class="invalid-feedback">
                ISBN belum diisi.
              </div>
            </div>
            <div class="col-md-2">
              <label for="">&nbsp;</label>
              <input type="hidden" name="proses" value="cari_peminjaman">
              <input class="btn btn-primary btn-block" type="submit" name="cari_peminjaman" value="Cari">
            </div>
          </div>
        </div>
      </form>
      <form action="proses.php" method="post" enctype="multipart/form-data" id="needs-validation" novalidate>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-6">
              <label for="">Buku Dipinjam</label>
              <input class="form-control" type="text" name="nis" value="<?php if(isset($result[0]['judul'])){echo $result[0]['judul'];} ?>" required readonly>
              <input type="hidden" name="isbn" value="<?php if(isset($result[0]['isbn'])){echo $result[0]['isbn'];} ?>">
              <div class="invalid-feedback">
                Buku belum diisi.
              </div>
            </div>
            <div class="col-md-6">
              <label for="">Nama Peminjam</label>
              <input class="form-control" type="text" name="nis" value="<?php if(isset($result[0]['nama'])){echo $result[0]['nama'];} ?>" required readonly>
              <input type="hidden" name="nis" value="<?php if(isset($result[0]['nis'])){echo $result[0]['nis'];} ?>">
              <div class="invalid-feedback">
                Nama belum diisi.
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-6">
              <label>Tanggal Peminjaman</label>
              <input type="text" class="form-control" value="<?php if(isset($result[0]['tanggal_peminjaman'])){$newDate = date("d F Y", strtotime($result[0]['tanggal_peminjaman'])); echo $newDate;} ?>" readonly>
            </div>
            <div class="col-md-6">
              <label>Tanggal Pengembalian</label>
              <input type="text" class="form-control" id="date" readonly>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-12">
              <label for="">Keterangan</label>
              <textarea class="form-control" name="keterangan" rows="8" cols="80" placeholder="Keterangan"></textarea>
              <div class="invalid-feedback">
                Keterangan belum diisi.
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-2">
              <input type="hidden" name="no_peminjaman" value="<?php if(isset($result[0]['no_peminjaman'])){echo $result[0]['no_peminjaman'];} ?>">
              <input type="hidden" name="nis" value="<?php if(isset($result[0]['nis'])){echo $result[0]['nis'];} ?>">
              <input type="hidden" name="isbn" value="<?php if(isset($result[0]['isbn'])){echo $result[0]['isbn'];} ?>">
              <input type="hidden" name="proses" value="tambah_pengembalian">
              <input class="btn btn-primary btn-block" type="submit" name="tambah_pengembalian" value="Tambah">
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
    <i class="fa fa-table"></i> Data Pengembalian</div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No. Pengembalian</th>
              <th>NIS</th>
              <th>ISBN</th>
              <th>Tanggal Peminjaman</th>
              <th>Tanggal Pengembalian</th>
              <th>Status</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $result = $db->read("data_peminjaman");
            foreach($result as $data){
              ?>
              <tr>
                <td><?php echo $data['no_peminjaman']; ?></td>
                <td><?php echo $data['nis']; ?></td>
                <td><?php echo $data['isbn']; ?></td>
                <td><?php $newDate = date("d F Y", strtotime($data['tanggal_peminjaman'])); echo $newDate; ?></td>
                <td><?php $newDate = date("d F Y", strtotime($data['tanggal_pengembalian'])); echo $newDate; ?></td>
                <td><?php if($data['status'] == "Kembali"){echo "<b style='color:green;'>".$data['status']."</b>";}else{echo "<b style='color:red;'>".$data['status']."</b>";} ?></td>
                <td><?php echo $data['keterangan']; ?></td>
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
