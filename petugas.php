<?php
$title = "Petugas";
  include 'header.php';
  include 'config/Database.php';
  $db = new Database();
  $result = $db->read("petugas");
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
    <i class="fa fa-plus"></i> <?php if(isset($_GET['username'])){echo "Edit";}else{echo "Tambah";} ?> Petugas</div>
    <div class="card-body">
      <form action="proses.php" method="post" enctype="multipart/form-data" id="needs-validation" novalidate>
        <?php
        if(isset($_GET['username'])){
          $username = $_GET['username'];
          $data = $db->read("petugas", "username = '$username'");

          ?>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="">Username</label>
                <input class="form-control" type="text" name="username" value="<?php echo $data[0]['username']; ?>" placeholder="Username" required>
                <div class="invalid-feedback">
                  Username belum diisi.
                </div>
              </div>
              <div class="col-md-6">
                <label for="">Password</label>
                <input class="form-control" type="password" name="password" value="<?php echo $data[0]['password']; ?>" placeholder="Password" required>
                <div class="invalid-feedback">
                  Password belum diisi.
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-12">
                <label for="">Fullname</label>
                <input class="form-control" type="text" name="fullname" value="<?php echo $data[0]['fullname']; ?>" placeholder="Fullname" required>
                <input type="hidden" name="proses" value="edit_petugas">
                <div class="invalid-feedback">
                  Fullname belum diisi.
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-2">
                <input class="btn btn-primary btn-block" type="submit" name="edit_petugas" value="Edit">
              </div>
              <div class="col-md-2">
                <a class="btn btn-secondary btn-block" href="petugas.php">Batal</a>
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
                <label for="">Username</label>
                <input class="form-control" type="text" name="username" value="" placeholder="Username" required>
                <div class="invalid-feedback">
                  Username belum diisi.
                </div>
              </div>
              <div class="col-md-6">
                <label for="">Password</label>
                <input class="form-control" type="password" name="password" value="" placeholder="Password" required>
                <div class="invalid-feedback">
                  Password belum diisi.
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-12">
                <label for="">Fullname</label>
                <input class="form-control" type="text" name="fullname" value="" placeholder="Fullname" required>
                <input type="hidden" name="proses" value="tambah_petugas">
                <div class="invalid-feedback">
                  Fullname belum diisi.
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-2">
                <input class="btn btn-primary btn-block" type="submit" name="tambah_petugas" value="Tambah">
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
    <i class="fa fa-table"></i> Data Buku</div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Username</th>
              <th>Password</th>
              <th>Fullname</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach($result as $data){
              ?>
              <tr>
                <td><?php echo $data['username']; ?></td>
                <td><?php $pass = strlen($data['password']); for($i = 0; $i<$pass; $i++){echo "&#10033";} ?></td>
                <td><?php echo $data['fullname']; ?></td>
                <td>
                  <a href="petugas.php?username=<?php echo $data['username'];?>"><i class="fa fa-pencil-square-o fa-2x"></i></a>&nbsp;&nbsp;
                  <a href="hapus.php?username=<?php echo $data['username'];?>"><i class="fa fa-trash fa-2x"></i></a>
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
