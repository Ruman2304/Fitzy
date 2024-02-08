<!DOCTYPE html>
<html lang="en">

<?php
$error = $_SERVER["REDIRECT_STATUS"];

$error_title = "";
$error_message = "";
if($error == 404){
    $error_title = "Opps! This page Could Not Be Found!";
    $error_message = "Sorry but the page you are looking for does not exist, have been removed or name changed.";
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="404 not Found">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fitzy | 404</title>
    <link rel="shortcut icon" type="image/png" href="./favicon.png">

</head>

<body>

    <!-- 404 Section Begin -->
    <section class="section-404">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-404">
                        <h1>404</h1>
                        <h3><?=$error_title?></h3>
                        <p><?=$error_message?></p>
                        <a href="./index.php"><i class="fa fa-home"></i> Go back home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- 404 Section End -->

    <?php
    include("index.php");
    ?>

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/jquery.barfiller.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>