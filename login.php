<form action="proses.php" method="post">
  <div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <div class="input-group">
          <input type="text" name="username" class="form-control" placeholder="Username">
        </div>
      </li>
      &nbsp;
      <li class="nav-item">
        <div class="input-group">
          <input type="password" name="password" class="form-control" placeholder="Password">
        </div>
      </li>
      &nbsp;
      <li class="nav-item">
        <input type="hidden" name="proses" value="login">
        <input type="submit" class="btn btn-secondary" name="login" value="Login">
      </li>
    </ul>
  </div>
</form>
