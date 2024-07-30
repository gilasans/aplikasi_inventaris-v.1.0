<?php
require_once "core/init.php";


$_SESSION["username"];

if (!isset($_SESSION['user'])) {
    $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
    header("location:../login.php");
    exit;
}


$id = $_GET["id"];


$barang = mysqli_query($connect, "SELECT * FROM tbl_barang");
$user = mysqli_query($connect, "SELECT * FROM tbl_user");

if (isset($_POST['simpan'])) {
    $user = $_POST['user'];
    $nama = $_POST['nama'];
    $kode = $_POST['kode'];
    $tgl_pinjam = $_POST['pinjam'];
    $tgl_kembali = $_POST['kembali'];
    $jumlah = $_POST['jumlah'];

    $barng = mysqli_query($connect, "SELECT * FROM tbl_barang WHERE kode_barang='$kode'");
    $brg = mysqli_fetch_assoc($barng);
    $br = $brg['jumlah_brg'];
    $sisa = $br - $jumlah;

    /// Cek apakah tanggal pinjam lebih besar dari tanggal kembali
    if ($tgl_pinjam > $tgl_kembali) {
        $_SESSION['tanggal'] = 'dsda';

        header('location:404_error.php');
    } else {

        // Cek apakah jumlah yang ingin dipinjam melebihi jumlah barang yang tersedia
        if ($jumlah > $br) {
            $_SESSION['lebih'] = 'dsda';

            header('location:404_error.php');
        } else {

            // Simpan data peminjaman
            $sql = "INSERT INTO tbl_pinjam (user_id,tgl_pinjam,kode_barang,nama_barang,jumlah_pinjam,tgl_kembali) VALUES ('$user','$tgl_pinjam','$kode','$nama','$jumlah','$tgl_kembali')";
            $result = mysqli_query($connect, $sql);
            if ($result) {

                // Update jumlah barang
                $query = "UPDATE tbl_barang set jumlah_brg='$sisa' WHERE kode_barang='$kode'";
                $result = mysqli_query($connect, $query);
                if ($result) {
                    $_SESSION["pinjam"] = "fchch";

                    header("location:index.php");
                } else {
                    die(mysqli_error($connect));
                }
            } else {
                die(mysqli_error($connect));
            }
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>APIP - aplikasi inventaris PeTIK</title>
    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-topic-listing.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body class="topics-listing-page" id="top">

    <main>
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg">
            <?php include 'nav.php'; ?>
        </nav>
        <header class="site-header d-flex flex-column justify-content-center align-items-center">
            <div class="container">
                <div class="row align-items-center">
                    <?php
                    foreach ($barang as $brg) {
                        if ($brg["id_barang"] == $id) {
                    ?>
                            <div class="col-lg-5 col-12">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Homepage</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            <?= $brg["nama_barang"] ?>
                                        </li>
                                    </ol>
                                </nav>
                                <h2 class="text-white">
                                    <?= $brg["nama_barang"] ?>
                                </h2>
                            </div>
                    <?php
                        }
                    } ?>
                </div>
            </div>
        </header>
        <section class="section-padding section-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <h3 class="mb-4 pb-2"></h3>
                    </div>
                    <div class="col-lg-6 col-12" data-aos="zoom-in-right">

                        <form action="#" method="POST" role="form">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-floating">
                                        <select name="user" type="text" class="form-control" id="user">
                                            <?php
                                            foreach ($user as $us) {
                                            ?>
                                                <option value="<?= $us['id_user'] ?>" <?= ($us['username'] == $_SESSION['username']) ? 'selected' : '' ?>>
                                                    <?= $us['username'] ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="floatingInput">Nama Peminjam</label>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-floating">
                                            <?php foreach ($barang as $brg) {
                                                if ($brg["id_barang"] == $id) { ?>
                                                    <input value="<?= $brg['nama_barang'] ?>" type="text" name="nama" id="email" class="form-control" placeholder="Name" required>
                                            <?php }
                                            } ?>
                                        <label for="floatingInput">Nama barang</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-floating">
                                            <?php foreach ($barang as $brg) {
                                                if ($brg["id_barang"] == $id) { ?>
                                                    <input value="<?= $brg['kode_barang'] ?>"type="text" name="kode" id="email" class="form-control" placeholder="Name" required>
                                            <?php }
                                            } ?>
                                        <label for="floatingInput">Kode barang</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-floating">
                                        <input type="number" name="jumlah" id="email" class="form-control" placeholder="Name" required>
                                        <label for="floatingInput">Jumlah pinjam</label>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-floating">
                                        <input type="date" name="pinjam" id="name" placeholder="Name" class="form-control" placeholder="Name" required="">
                                        <label for="floatingInput">Tanggal pinjam</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-floating">
                                        <input type="date" name="kembali" id="name" placeholder="pengambalian" class="form-control" placeholder="Name" required="">
                                        <label for="floatingInput">Tanggal pengambalian</label>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-success" name="simpan" style="width:100%;">Pinjam</button>
                                </div>

                            </div>
                        </form>

                    </div>
                    <div class="col-lg-5 col-12 mx-auto mt-5 mt-lg-0" data-aos="zoom-in-left">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.0552689660644!2d106.77489547499177!3d-6.386869293603587!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69e92c0df5da9d%3A0x8499222ee6779470!2sPeTIK%20(Pesantren%20Teknologi%20Informasi%20dan%20Komunikasi)%20Program%20Kuliah%20IT%20Gratis%20Binaan%20YBM%20PLN!5e0!3m2!1sid!2sid!4v1704070558680!5m2!1sid!2sid" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                        <h4 class="mb-3">Depok office</h4>

                        <small>Jl. Mandor Basar No.54, Rangkapan Jaya, Kec. Pancoran Mas, Kota Depok, Jawa Barat
                            16434
                        </small>
                        <hr>
                        <p class="d-flex align-items-center mb-1">
                            <span class="me-2">Phone</span>
                            <a href="#" class="site-footer-link">
                                (021)-77886691
                            </a>
                        </p>
                        <p class="d-flex align-items-center">
                            <span class="me-2">Email</span>
                            <a href="#" class="site-footer-link">
                                lkppetik@gmail.com
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="site-footer section-padding">
        <?php include "footer.php"; ?>
    </footer>
    <!-- JAVASCRIPT FILES -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/custom.js"></script>
    <script src="https://kit.fontawesome.com/c2dd979a9d.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>