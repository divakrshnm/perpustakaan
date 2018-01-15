<?php
$title = "Kunjungan";
  include 'header.php';
  include 'config/Database.php';
  $db = new Database();
  $result = $db->read("data_kunjungan", null, "INNER JOIN anggota ON data_kunjungan.nis = anggota.nis");
?>
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-table"></i> Data Kunjungan</div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No. Kunjungan</th>
              <th>Nama Pengunjung</th>
              <th>Kelas</th>
              <th>Jenis Kelamin</th>
              <th>Keperluan</th>
              <th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach($result as $data){
              ?>
              <tr>
                <td><?php echo $data['no_kunjungan']; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['kelas']; ?></td>
                <td><?php echo $data['jenis_kelamin']; ?></td>
                <td><?php echo $data['keperluan']; ?></td>
                <td><?php $newDate = date("d F Y", strtotime($data['tanggal'])); echo $newDate; ?></td>
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
