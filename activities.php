<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gym Template">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fitzy | Activities</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/barfiller.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <style>
        .crop-text-1 {
            -webkit-line-clamp: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
        }

        #exercise,
        #meditation {
            background-repeat: no-repeat;
            background-size: cover;
            background-position: top center;
            border-radius: 20px;
        }
    </style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php
    session_start();
    if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
        include("header.php");
    ?>

        <!-- Breadcrumb Section Begin -->
        <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb-bg.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="breadcrumb-text">
                            <h2>Activities</h2>
                            <div class="bt-option">
                                <a href="./index.php">Home</a>
                                <span>Activities</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Section End -->

        <!-- Services Section Begin -->
        <section class="services-section spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <span>What we do?</span>
                            <h2>PUSH YOUR LIMITS FORWARD</h2>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <?php

                    $sql = "SELECT * FROM `exercise_master`";
                    $query = mysqli_query($conn, $sql);
                    if ($query) {
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_array($query)) {
                                $Exercise_Id = $row['Exercise_Id'];
                                $Photo = $row['Photo'];
                                $Exercise_Name = $row['Exercise_Name'];
                                $Link = $row['Link'];
                    ?>
                                <div class="col-lg-3">
                                    <center>
                                        <div id="exercise" class="ss-text bs-text set-bg" data-setbg="<?php if (!empty($Photo)) {
                                                                                                            echo "data:image/jpg;charset=utf8;base64," . base64_encode($Photo);
                                                                                                        } else {
                                                                                                            echo "./img/services/services-1.jpg";
                                                                                                        } ?>">
                                            <h4 class="crop-text-1 text-dark" style="text-shadow: 2px 1px #f36100;"><?php echo $Exercise_Name; ?></h4>
                                            <a href="<?php echo $Link; ?>" class="play-btn video-popup"><i class="fa fa-caret-right"></i></a>
                                        </div>
                                    </center>
                                </div>
                    <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </section>
        <!-- Services Section End -->

        <!-- Services Section Begin -->
        <?php
        $u_id = $_SESSION['userid'];
        if ($role == 'customer' || $role == 'contributor'){
        $sql = "SELECT `Customer_Id` FROM `customer` WHERE User_Id = '$u_id'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_row($query);
        $c_id = $row['0'];
        
        $sql1 = "SELECT * FROM `membership` WHERE Customer_Id='$c_id' && Status=1";
        $query1 = mysqli_query($conn, $sql1);
        if (mysqli_num_rows($query1) > 0) {
        ?>
            <section class="services-section spad" style="padding-top: 0;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title">
                                <span>Finding Best Yogas?</span>
                                <h2>Inhale the future, exhale the past</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <?php

                        $sql = "SELECT * FROM `meditation_master`";
                        $query = mysqli_query($conn, $sql);
                        if ($query) {
                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_array($query)) {
                                    $Meditation_Id = $row['Meditation_Id'];
                                    $Photo = $row['Photo'];
                                    $Meditation_Name = $row['Meditation_Name'];
                                    $Link = $row['Link'];
                        ?>
                                    <div class="col-lg-3">
                                        <center>
                                            <div id="meditation" class="ss-text bs-text set-bg" data-setbg="<?php if (!empty($Photo)) { echo "data:image/jpg;charset=utf8;base64," . base64_encode($Photo); } else { echo "./img/services/services-1.jpg"; } ?>">
                                                <h4 class="crop-text-1 text-dark" style="text-shadow: 2px 1px #f36100;"><?php echo $Meditation_Name; ?></h4>
                                                <a href="<?php echo $Link; ?>" class="play-btn video-popup"><i class="fa fa-caret-right"></i></a>
                                            </div>
                                        </center>
                                    </div>
                        <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </section>
        <?php
        } else {
        ?>

            <!-- Banner Section End -->
            <section class="pricing-section spad">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title">
                                <span>Our Plan</span>
                                <h2>Choose your pricing plan</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">

                        <?php
                        $Description = "";
                        $sql = "SELECT * FROM `packages`";
                        $query = mysqli_query($conn, $sql);

                        if ($query) {
                            if (mysqli_num_rows($query) > 0) {

                                while ($row = mysqli_fetch_row($query)) {
                                    $Package_Id = $row[0];
                                    $Package_Name = $row[1];
                                    $Duration = $row[2];
                                    $Description = $row[3];
                                    $Amount = $row[4];
                                    $Photo = $row[5];

                                    $_SESSION['Description'] = $Description;
                        ?>
                                    <div class="col-lg-4 col-md-8">
                                        <div class="ps-item">
                                            <h3><?= $Package_Name ?></h3>
                                            <div class="pi-price">
                                                <h2>₹<?= $Amount ?></h2>
                                            </div>
                                            <ul>
                                                <?php
                                                $Keywords = explode(",", $Description);
                                                if (is_array($Keywords)) {
                                                    foreach ($Keywords as $key => $val) {
                                                        $Keywords[$key] = trim($val);
                                                    }
                                                }
                                                foreach ($Keywords as $key => $val) {
                                                ?><li><?php echo $val; ?></li><?php
                                                                            }
                                                                                ?>
                                            </ul>
                                            <a href="<?php echo "order-review.php?name=" . $Package_Name . "&planid=" . $Package_Id ?>" class="primary-btn pricing-btn buy_now_btn" id="">Subscribe Now</a>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        }
                        ?>

                    </div>
                </div>
            </section>

            <!-- Pricing Section End -->
    <?php
        }
    }
        include("footer.php");
    } else {
        header("Location: ./login.php");
    }
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