</div>
<!-- /.container-fluid-->
<!-- /.content-wrapper-->
<footer class="sticky-footer">
  <div class="container">
    <div class="text-center">
      <small>Copyright &copy; ePerpustakaan <?php echo date('Y') ?></small>
    </div>
  </div>
</footer>
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fa fa-angle-up"></i>
</a>
<!-- Logout Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ePerpustakaan</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Pilih "Logout" apabila anda ingin keluar dari sini.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="logout.php">Logout</a>
      </div>
    </div>
  </div>
</div>
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="assets/vendor/datatables/jquery.dataTables.js"></script>
<script src="assets/vendor/datatables/dataTables.bootstrap4.js"></script>
<script src="assets/js/sb-admin-datatables.min.js"></script>
<script src="assets/js/sb-admin.min.js"></script>
<script src="assets/js/jquery.form-validator.js"></script>
</div>
</body>
</html>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
(function() {
  'use strict';

  window.addEventListener('load', function() {
    var form = document.getElementById('needs-validation');
    form.addEventListener('submit', function(event) {
      if (form.checkValidity() == false) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  }, false);
})();
</script>
<script>
$(document).ready(function(){
  $('#nis').keyup(function(){
    var nis = $(this).val();
    $.ajax({
      type	: 'POST',
      url 	: 'cek.php',
      data 	: 'nis='+nis,
      success	: function(data){
        $('#pesan').html(data);
      }
    })
  });
});
</script>
<script>
$(document).ready(function(){
  $('#isbn').keyup(function(){
    var isbn = $(this).val();
    $.ajax({
      type	: 'POST',
      url 	: 'cek.php',
      data 	: 'isbn='+isbn,
      success	: function(data){
        $('#pesan').html(data);
      }
    })
  });
});
</script>
<script>
$(document).ready(function(){
  $('#nisp').blur(function(){
    var nisp = $(this).val();
    $.ajax({
      type	: 'POST',
      url 	: 'cek.php',
      data 	: 'nisp='+nisp,
      success	: function(data){
        $("#namap").val(data);
      }
    })
  });
  $('#isbnp').blur(function(){
    var isbnp = $(this).val();
    $.ajax({
      type	: 'POST',
      url 	: 'cek.php',
      data 	: 'isbnp='+isbnp,
      success	: function(data){
        $("#judulp").val(data);
      }
    })
  });
});
</script>
<script type="text/javascript">
function updateClock() {
  var now = new Date(),
      months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
      date = [now.getDate(),
              months[now.getMonth()],
              now.getFullYear()].join(' ');
              document.getElementById("date").value = date;
  setTimeout(updateClock, 1000);
}
updateClock();
</script>
