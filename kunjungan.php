<?php
$title = "Kunjungan";
  include 'header.php';
  include 'config/Database.php';
  $db = new Database();
  $result = $db->read("data_kunjungan");
?>
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-table"></i> Data Buku</div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No. Kunjugan</th>
              <th>Nama Pengunjung</th>
              <th>Kelas</th>
              <th>Jurusan</th>
              <th>Jenis Kelamin</th>
              <th>Keperluan</th>
              <th>Tanggal</th>
              <th>Jam</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach($result as $data){
              ?>
              <tr>
                <td><?php echo $data['no_kunjungan']; ?></td>
                <td><?php echo $data['nama_pengunjung']; ?></td>
                <td><?php echo $data['kelas']; ?></td>
                <td><?php echo $data['jurusan']; ?></td>
                <td><?php echo $data['jenis_kelamin']; ?></td>
                <td><?php echo $data['keperluan']; ?></td>
                <td><?php echo $data['tanggal']; ?></td>
                <td><?php echo $data['jam']; ?></td>
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
