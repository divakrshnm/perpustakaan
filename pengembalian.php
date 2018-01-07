<?php
$title = "Pengembalian";
include 'header.php';
include 'config/Database.php';
$db = new Database();
if(isset($_POST['cari_peminjaman'])){
  $npm = $_POST['npm'];
  $isbn = $_POST['isbn'];
  $result = $db->read("data_peminjaman", "data_peminjaman.isbn = '$isbn' AND data_peminjaman.npm  = '$npm'", "INNER JOIN buku ON data_peminjaman.isbn = buku.isbn INNER JOIN anggota ON data_peminjaman.npm = anggota.npm");
}
?>
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-plus"></i> Tambah Peminjaman</div>
    <div class="card-body">
      <form action="pengembalian.php" method="post" enctype="multipart/form-data" id="needs-validation" novalidate>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-5">
              <label for="">NPM</label>
              <input class="form-control" type="text" name="npm" value="" placeholder="NPM" required id="npmp">
              <div class="invalid-feedback">
                NPM belum diisi.
              </div>
            </div>
            <div class="col-md-5">
              <label for="">ISBN</label>
              <input class="form-control" type="text" name="isbn" value="" placeholder="ISBN" required id="isbnp">
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
              <input class="form-control" type="text" name="npm" value="<?php if(isset($result[0]['judul'])){echo $result[0]['judul'];} ?>" required readonly>
              <input type="hidden" name="isbn" value="<?php if(isset($result[0]['isbn'])){echo $result[0]['isbn'];} ?>">
              <div class="invalid-feedback">
                Buku belum diisi.
              </div>
            </div>
            <div class="col-md-6">
              <label for="">Nama Peminjam</label>
              <input class="form-control" type="text" name="npm" value="<?php if(isset($result[0]['nama'])){echo $result[0]['nama'];} ?>" required readonly>
              <input type="hidden" name="npm" value="<?php if(isset($result[0]['npm'])){echo $result[0]['npm'];} ?>">
              <div class="invalid-feedback">
                Nama belum diisi.
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-6">
              <label>Tanggal Pengembalian</label>
              <input type="text" class="form-control" id="date" readonly>
            </div>
            <div class="col-md-6">
              <label>Jam Pengembalian</label>
              <input type="text" class="form-control" id="time" readonly>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-12">
              <label for="">Denda</label>
              <?php
              if(isset($result[0]['tanggal'])){
                $date1=  new DateTime($result[0]['tanggal']);
                $date2= new DateTime();
                $difference = $date1->diff($date2);
                $date =  $difference->days;
                if($date > 7){
                  $denda = ($date - 7)*2000;
                }else{
                  $denda = 0;
                }
              }
               ?>
              <input class="form-control" type="text" name="denda" value="<?php if(isset($denda)){echo $denda;} ?>" required readonly>
              <div class="invalid-feedback">
                Buku belum diisi.
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-2">
              <input type="hidden" name="no_peminjaman" value="<?php if(isset($result[0]['no_peminjaman'])){echo $result[0]['no_peminjaman'];} ?>">
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
</div>
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-table"></i> Data Buku</div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No. Pengembalian</th>
              <th>NPM</th>
              <th>ISBN</th>
              <th>Tanggal</th>
              <th>Jam</th>
              <th>Jumlah</th>
              <th>Denda</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $result = $db->read("data_pengembalian");
            foreach($result as $data){
              ?>
              <tr>
                <td><?php echo $data['no_pengembalian']; ?></td>
                <td><?php echo $data['npm']; ?></td>
                <td><?php echo $data['isbn']; ?></td>
                <td><?php echo $data['tanggal']; ?></td>
                <td><?php echo $data['jam']; ?></td>
                <td><?php echo $data['jumlah']; ?></td>
                <td><?php echo $data['denda']; ?></td>
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
