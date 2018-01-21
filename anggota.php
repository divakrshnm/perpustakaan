<?php
$title = "Anggota";
include 'header.php';
include_once 'config/Database.php';
$db = new Database();
$result = $db->read("anggota");
if(isset($_SESSION['valid'])){
  echo $_SESSION['valid'];
  unset($_SESSION['valid']);
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
    <i class="fa fa-user-plus"></i> <?php if(isset($_GET['nis'])){echo "Edit";}else{echo "Tambah";} ?> Anggota</div>
    <div class="card-body">
      <form action="proses.php" method="post" id="needs-validation" novalidate>
        <?php
        if(isset($_GET['nis'])){
          $nis = $_GET['nis'];
          $data = $db->read("anggota", "nis = '$nis'");
          ?>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="">NIS</label>
                <input class="form-control" type="number" name="nis" value="<?php echo $data[0]['nis']; ?>" readonly>
              </div>
              <div class="col-md-6">
                <label for="">Kelas</label>
                <input class="form-control" type="text" name="kelas" maxlength="10" placeholder="Kelas" required value="<?php echo $data[0]['kelas']; ?>">
                <div class="invalid-feedback">
                  Kelas belum diisi.
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="">Nama Lengkap</label>
                <input class="form-control" type="text" name="nama" maxlength="100" placeholder="Nama Lengkap" required value="<?php echo $data[0]['nama']; ?>">
                <div class="invalid-feedback">
                  Nama lengkap belum diisi.
                </div>
              </div>
              <div class="col-md-6">
                <label class="">Jenis Kelamin :</label>
                <div class="radio">
                  &nbsp;&nbsp;
                  <label class="radio-inline">
                    <input type="radio" name="jenis_kelamin" value="Laki-Laki" <?php if($data[0]['jenis_kelamin'] == "Laki-Laki"){echo "checked";} ?>> Laki-Laki
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label class="radio-inline">
                    <input type="radio" name="jenis_kelamin" value="Perempuan" <?php if($data[0]['jenis_kelamin'] == "Perempuan"){echo "checked";} ?>> Perempuan
                  </label>
                </div>
                <div class="invalid-feedback">
                  Jenis Kelamin belum diisi.
                </div>
                <input type="hidden" name="proses" value="edit_anggota">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">

            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-2">
                <input class="btn btn-primary btn-block" type="submit" name="edit_anggota" value="Edit">
              </div>
              <div class="col-md-2">
                <a class="btn btn-primary btn-block" href="anggota.php">Batal</a>
              </div>
              <div class="col-md-8">
              </div>
            </div>
          </div>
          <?php
        }
        else{
          ?>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="">NIS</label>
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                  <div class="input-group-addon"><span id="pesan">&#160;&#160;&#160;</span></div>
                  <input class="form-control" type="number" name="nis" maxlength="11" placeholder="NIS" required id="nis">
                </div>
                <div class="invalid-feedback">
                  NIS belum diisi.
                </div>
              </div>
              <div class="col-md-6">
                <label for="">Kelas</label>
                <input class="form-control" type="text" name="kelas" value="" maxlength="10" placeholder="Kelas" required>
                <div class="invalid-feedback">
                  Kelas belum diisi.
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="">Nama Lengkap</label>
                <input class="form-control" type="text" name="nama" maxlength="100" placeholder="Nama Lengkap" required>
                <div class="invalid-feedback">
                  Nama lengkap belum diisi.
                </div>
              </div>
              <div class="col-md-6">
                <label class="control-label">Jenis Kelamin :</label>
                <div class="radio">
                  &nbsp;&nbsp;
                  <label class="radio-inline">
                    <input type="radio" name="jenis_kelamin" value="Laki-Laki" required> Laki-Laki
                  </label>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label class="radio-inline">
                    <input type="radio" name="jenis_kelamin" value="Perempuan" required> Perempuan
                  </label>
                </div>
                <div class="invalid-feedback">
                  Jenis Kelamin belum diisi.
                </div>
                <input type="hidden" name="proses" value="tambah_anggota">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-2">
                <input class="btn btn-primary btn-block" type="submit" name="tambah_anggota" value="Tambah">
              </div>
              <div class="col-md-2">
                <input class="btn btn-secondary btn-block" type="reset" name="batal" value="Batal">
              </div>
              <div class="col-md-8">
              </div>
            </div>
          </div>
          <?php
        }
        ?>
      </form>
    </div>
  </div>
  <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Data Anggota</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>NIS</th>
                  <th>Nama</th>
                  <th>Kelas</th>
                  <th>Jenis Kelamin</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach($result as $data){
                  ?>
                <tr>
                  <td><?php echo $data['nis']; ?></td>
                  <td><?php echo $data['nama']; ?></td>
                  <td><?php echo $data['kelas']; ?></td>
                  <td><?php echo $data['jenis_kelamin']; ?></td>
                  <td>
                    <a href="anggota.php?nis=<?php echo $data['nis'];?>"><i class="fa fa-pencil-square-o fa-2x"></i></a>&nbsp;&nbsp;
                    <a href="hapus.php?nis=<?php echo $data['nis'];?>"><i class="fa fa-trash fa-2x"></i></a>
                  </td>
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
