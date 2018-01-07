<?php
$title = "Buku";
include 'header.php';
include_once 'config/Database.php';
$db = new Database();
$result = $db->read("buku");
?>
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-plus"></i> <?php if(isset($_GET['isbn'])){echo "Edit";}else{echo "Tambah";} ?> Buku</div>
    <div class="card-body">
      <form action="proses.php" method="post" enctype="multipart/form-data" id="needs-validation" novalidate>
        <?php
        if(isset($_GET['isbn'])){
          $isbn = $_GET['isbn'];
          $data = $db->read("buku", "isbn = '$isbn'");

          ?>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="">ISBN</label>
                <input class="form-control" type="text" name="isbn" value="<?php echo $data[0]['isbn']; ?>" readonly>
              </div>
              <div class="col-md-6">
                <label for="">Judul</label>
                <input class="form-control" type="text" name="judul" value="<?php echo $data[0]['judul']; ?>" placeholder="Judul" required>
                <div class="invalid-feedback">
                  Judul belum diisi.
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="">Pengarang</label>
                <input class="form-control" type="text" name="pengarang" value="<?php echo $data[0]['pengarang']; ?>" placeholder="Pengarang" required>
                <div class="invalid-feedback">
                  Pengarang belum diisi.
                </div>
              </div>
              <div class="col-md-6">
                <label for="">Tahun Terbit</label>
                <input class="form-control" type="text" name="tahun_terbit" value="<?php echo $data[0]['tahun_terbit']; ?>" placeholder="Tahun Terbit" required>
                <div class="invalid-feedback">
                  Tahun terbit belum diisi.
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="">Penerbit</label>
                <input class="form-control" type="text" name="penerbit" value="<?php echo $data[0]['penerbit']; ?>" placeholder="Penerbit" required>
                <div class="invalid-feedback">
                  Penerbit belum diisi.
                </div>
              </div>
              <div class="col-md-6">
                <label for="">Jumlah</label>
                <input class="form-control" type="text" name="jumlah" value="<?php echo $data[0]['jumlah']; ?>" placeholder="Jumlah" required>
                <div class="invalid-feedback">
                  Jumlah belum diisi.
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="">Lokasi</label>
                <input class="form-control" type="text" name="lokasi" value="<?php echo $data[0]['lokasi']; ?>" placeholder="Lokasi" required>
                <div class="invalid-feedback">
                  Lokasi belum diisi.
                </div>
              </div>
              <div class="col-md-6">
                <label for="">Gambar</label><br>
                <input type="file" name="gambar" value="" onchange="bacaGambar(this);">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="">Sinopsis</label>
                <textarea class="form-control" name="sinopsis" rows="8" cols="80"  placeholder="Ketik sinopsis tentang buku disini." required><?php echo $data[0]['sinopsis']; ?></textarea>
                <div class="invalid-feedback">
                  Sinopsis belum diisi.
                </div>
              </div>
              <div class="col-md-6">
                <?php echo '<img id="gambar" src="data:image/jpeg;base64,'.base64_encode( $data[0]['gambar'] ).'" style="width:200px; height:auto;">'; ?>
                <input type="hidden" name="proses" value="edit_buku">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-2">
                <input class="btn btn-primary btn-block" type="submit" name="edit_buku" value="Edit">
              </div>
              <div class="col-md-2">
                <a class="btn btn-secondary btn-block" href="buku.php">Batal</a>
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
                <label for="">ISBN</label>
                <input class="form-control" type="text" name="isbn" value="" maxlength="13" placeholder="ISBN" required>
                <div class="invalid-feedback">
                  ISBN belum diisi.
                </div>
              </div>
              <div class="col-md-6">
                <label for="">Judul</label>
                <input class="form-control" type="text" name="judul" value="" placeholder="Judul" required>
                <div class="invalid-feedback">
                  Judul belum diisi.
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="">Pengarang</label>
                <input class="form-control" type="text" name="pengarang" value="" placeholder="Pengarang" required>
                <div class="invalid-feedback">
                  Pengarang belum diisi.
                </div>
              </div>
              <div class="col-md-6">
                <label for="">Tahun Terbit</label>
                <input class="form-control" type="text" name="tahun_terbit" value="" placeholder="Tahun Terbit" required>
                <div class="invalid-feedback">
                  Tahun terbit belum diisi.
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="">Penerbit</label>
                <input class="form-control" type="text" name="penerbit" value="" placeholder="Penerbit" required>
                <div class="invalid-feedback">
                  Penerbit belum diisi.
                </div>
              </div>
              <div class="col-md-6">
                <label for="">Jumlah</label>
                <input class="form-control" type="text" name="jumlah" value="" placeholder="Jumlah" required>
                <div class="invalid-feedback">
                  Jumlah belum diisi.
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="">Lokasi</label>
                <input class="form-control" type="text" name="lokasi" value="" placeholder="Lokasi" required>
                <div class="invalid-feedback">
                  Lokasi belum diisi.
                </div>
              </div>
              <div class="col-md-6">
                <label for="">Gambar</label><br>
                <input type="file" name="gambar" value="" onchange="bacaGambar(this);" required>
              </div>
              <div class="invalid-feedback">
                Gambar belum diisi.
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="">Sinopsis</label>
                <textarea class="form-control" name="sinopsis" rows="8" cols="80" placeholder="Ketik sinopsis tentang buku disini." required></textarea>
                <div class="invalid-feedback">
                  Sinopsis belum diisi.
                </div>
              </div>
              <div class="col-md-6">
                <img id="gambar" src="#" alt="">
                <input type="hidden" name="proses" value="tambah_buku">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-2">
                <input class="btn btn-primary btn-block" type="submit" name="tambah_buku" value="Tambah">
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
                <th>ISBN</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Tahun Terbit</th>
                <th>Penerbit</th>
                <th>Jumlah</th>
                <th>Lokasi</th>
                <th width="53px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($result as $data){
                ?>
                <tr>
                  <td><?php echo $data['isbn']; ?></td>
                  <td><?php echo $data['judul']; ?></td>
                  <td><?php echo $data['pengarang']; ?></td>
                  <td><?php echo $data['tahun_terbit']; ?></td>
                  <td><?php echo $data['penerbit']; ?></td>
                  <td><?php echo $data['jumlah']; ?></td>
                  <td><?php echo $data['lokasi']; ?></td>
                  <td>
                    <a href="buku.php?isbn=<?php echo $data['isbn'];?>"><i class="fa fa-pencil-square-o fa-2x"></i></a>&nbsp;&nbsp;
                    <a href="hapus.php?isbn=<?php echo $data['isbn'];?>"><i class="fa fa-trash fa-2x"></i></a>
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
    <script type="text/javascript">
    function bacaGambar(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#gambar')
          .attr('src', e.target.result)
          .css({"width": "200px", "height": "auto"});
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
    </script>
