<?php
require_once "core/init.php"; 

$_SESSION["username"];

if (!isset($_SESSION['user'])) {
    $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
    header("location:../login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
   <?php include("../amin/includes/head.php") ?>
   <body class="inner_page error_404">
      <div class="full_container">
         <div class="container">
            <div class="center verticle_center full_height">
               <div class="error_page">
                  <div class="center">
                     <div class="error_icon">
                        <img class="img-responsive" src="images/layout_img/error.png" alt="#">
                     </div>
                  </div>
                  <br>
                  <h3>PAGE NOT FOUND !</h3>
                  <P>YOU SEEM TO BE TRYING TO FIND HIS WAY HOME</P>
                  <div class="center"><a class="main_bt" href="index.php">Go To Home Page</a></div>
               </div>
            </div>
         </div>
      </div>
      <!-- jQuery -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <!-- wow animation -->
      <script src="js/animate.js"></script>
      <!-- select country -->
      <script src="js/bootstrap-select.js"></script>
      <!-- nice scrollbar -->
      <script src="js/perfect-scrollbar.min.js"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <!-- custom js -->
      <script src="js/custom.js"></script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   </body>
</html>
<?php
if (isset($_SESSION['tanggal'])) {
    ?>
    <script>
        swal("Warning", "Tanggal pinjam harus lebih kecil dari tanggal kembali!", "error");
    </script>
    <?php
}elseif (isset($_SESSION['lebih'])) {
   ?>
   <script>
       swal("Warning", "Jumlah yang ingin dipinjam melebihi jumlah barang yang tersedia!", "error");
   </script>
   <?php
}


unset($_SESSION["tanggal"] , $_SESSION["lebih"]);
?>