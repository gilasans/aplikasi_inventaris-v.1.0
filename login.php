<?php
require_once "core/init.php";

// kalau udah login
if (isset($_SESSION['user'])) {
  // header("location:user/index.php");
  redirect_login($nama);
  exit;
}


// validasi login
if (isset($_POST['submit'])) {
  $nama = $_POST['username'];
  $pw = $_POST['password'];


  if (!empty(trim($nama)) && !empty(trim($pw))) {

    if (cek_nama($nama) != 0) {
      if (cek_data($nama, $pw)) {
        $_SESSION["insert"] = "fchch";
        $_SESSION["username"] = $nama;
        redirect_login($nama);
      } else {
        $_SESSION["error"] = "fchch";

        header('location:eror.php');
      }
    } else {
      $_SESSION["dont"] = "fchch";

      header('location:eror.php');

    }
  } else {
    $_SESSION["no"] = "fchch";

    header('location:eror.php');
  }

}


// validasi regis
if (isset($_POST['submit1'])) {
  $nama = $_POST['username1'];
  $email = $_POST['email'];
  $pw = $_POST['password1'];

  if (cek_nama($nama) == 0) {

    if (!empty(trim($nama)) && !empty(trim($email)) && !empty(trim($pw))) {
      if (register_user($nama, $email, $pw)) {
        $_SESSION["insert"] = "fchch";

        redirect_login($nama);
      } else {
        $_SESSION["gagal"] = "fchch";

        header('location:eror.php');
      }
    } else {
      $_SESSION["kosong"] = "fchch";

      header('location:eror.php');
    }
  } else {
    $_SESSION["sudah ada"] = "fchch";

    header('location:eror.php');
  }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login And Regist</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
  <div class="wrapper">
    <span class="bg-animate"></span>
    <span class="bg-animate2"></span>

    <div class="form-box login">
      <h2 class="animation" style="--i: 0 --j:21;">Login</h2>
      <form action="#" method="post">
        <div class="input-box animation" style="--i: 1 --j:22;">
          <input name="username" type="text" autocomplete="off" />
          <label>Username</label>
          <i class="bx bxs-user"></i>
        </div>

        <div class="input-box animation" style="--i: 2 --j:23;">
          <input name="password" type="password" autocomplete="off" />
          <label>Password</label>
          <i class="bx bxs-lock-alt"></i>
        </div>
        <button name="submit" type="submit" class="btn animation" style="--i: 3 --j:24;">
          Login
        </button>
        <div class="logreg-link animation" style="--i: 4 --j:25;">
          <p>
            Don`t have an account?
            <a href="#" class="register-link">Sign Up</a>
          </p>
        </div>
      </form>
    </div>
    <div class="info-text login">
      <h2 class="animation" style="--1: 0 --j:20;">Welcome Back</h2>
      <p class="animation" style="--1: 1 --j:21;">APIP</p>
      <p class="animation" style="--1: 1 --j:21;">(aplikasi inventaris PeTIK)</p>
    </div>

    <div class="form-box register">
      <h2 class="animation" style="--i: 17 --j:0;">Sign Up</h2>
      <form action="#" method="post">
        <div class="input-box animation" style="--i: 18 --j:1;">
          <input name="username1" type="text" />
          <label>Username</label>
          <i class="bx bxs-user"></i>
        </div>
        <div class="input-box animation" style="--i: 19 --j:2;">
          <input name="email" type="text" />
          <label>Email</label>
          <i class="bx bxs-envelope"></i>
        </div>

        <div class="input-box animation" style="--i: 20 --j:3;">
          <input name="password1" type="password" />
          <label>Password</label>
          <i class="bx bxs-lock-alt"></i>
        </div>
        <button name="submit1" type="submit" class="btn animation" style="--i: 21 --j:4;">
          Sign Up
        </button>
        <div class="logreg-link animation" style="--i: 22 --j:5;">
          <p>
            Already have an account?
            <a href="#" class="login-link">Login</a>
          </p>
        </div>
      </form>
    </div>
    <div class="info-text register">
      <h2 class="animation" style="--i: 17 --j:0;">Welcome To</h2>
      <p class="animation" style="--1: 1 --j:21;">APIP</p>
      <p class="animation" style="--1: 1 --j:21;">(aplikasi inventaris PeTIK)</p>
    </div>
  </div>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="script.js"></script>
</body>

</html>