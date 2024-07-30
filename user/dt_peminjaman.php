<?php
require_once "core/init.php";
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-topic-listing.css" rel="stylesheet">
</head>

<body id="top">

    <main>
        <nav class="navbar navbar-expand-lg">
            <?php include 'nav.php'; ?>
        </nav>
        <header class="site-header d-flex flex-column justify-content-center align-items-center">
            <div class="container">
                <div class="row align-items-center">
                    <h2 class="text-white">
                        Data Peminjaman Barang
                    </h2>
                </div>
            </div>
        </header>

        <div class="container mt-5">
            <table class="table table-borderless table-hover">
                <thead style="background-color: #57a1aa; color: white;">
                    <tr>
                        <th>#</th>
                        <th>Kode barang</th>
                        <th>Nama barang</th>
                        <th>Jumlah Pinjam</th>
                        <th>Tanggal Dipinjam</th>
                        <th>Tanggal Dikembalikan</th>
                        <th>Dateline</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $user = $_SESSION['username'];
                    $query = "SELECT id_user FROM tbl_user WHERE username = '$user'";
                    $user_id = mysqli_query($connect, $query);
                    $user_id = mysqli_fetch_array($user_id)['id_user'];

                    $query_pinjam = "SELECT * FROM tbl_pinjam WHERE user_id = $user_id";
                    $pinjam = mysqli_query($connect, $query_pinjam);
                    $no = 1;

                    while ($pnj = mysqli_fetch_array($pinjam)) {
                        $start_date = $pnj['tgl_pinjam'];
                        $end_date = $pnj['tgl_kembali'];

                        $date1 = new DateTime($start_date);
                        $date2 = new DateTime($end_date);

                        $diff = $date1->diff($date2);

                        echo "
    <tr>
        <td>$no</td>
        <td>{$pnj['kode_barang']}</td>
        <td>{$pnj['nama_barang']}</td>
        <td>{$pnj['jumlah_pinjam']}</td>
        <td>{$pnj['tgl_pinjam']}</td>
        <td>{$pnj['tgl_kembali']}</td>
        <td>{$diff->days} hari</td>
    </tr>";

                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>


    </main>
    <footer class="site-footer section-padding">
        <?php include "footer.php"; ?>
    </footer>

    <!-- JAVASCRIPT FILES -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/click-scroll.js"></script>
    <script src="js/custom.js"></script>
    <!--  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://kit.fontawesome.com/c2dd979a9d.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>