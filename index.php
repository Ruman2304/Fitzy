<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gym Template">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fitzy | Home</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="./favicon.png">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/barfiller.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php
    session_start();
    include "connect.php";
    include "header.php";

    $c_id = '';
    if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
        $role = $_SESSION['role'];
    }else{
        $role = '';
    }
    if (isset($_SESSION['userid'])) {
        $u_id = $_SESSION['userid'];
        if ($role == 'customer' || $role == 'contributor'){
            $sql = "SELECT `Customer_Id` FROM `customer` WHERE User_Id = '$u_id'";
            $query = mysqli_query($conn, $sql);
            $row = mysqli_fetch_row($query);
            $c_id = $row['0'];
        
            $sql1 = "SELECT * FROM `membership` WHERE Customer_Id = '$c_id'";
            $query1 = mysqli_query($conn, $sql1);
            if(mysqli_num_rows($query1)>0){
                $row = mysqli_fetch_array($query1);
                $end_date = $row['End_Date'];
            
                if ($query1) {
                    if (strtotime(date('Y-m-d')) >= strtotime($end_date)) {
                        $sql2 = "UPDATE `membership` SET `Status`='0' WHERE Customer_Id = '$c_id' && `Status` = 1";
                        $query2 = mysqli_query($conn, $sql2);
                        $sql3 = "UPDATE `user_master` SET `Role`='customer' WHERE `User_Id`='$u_id'";
                        $query3 = mysqli_query($conn, $sql3);
                        $_SESSION['role'] = 'customer';
                    }
                }
            }
        }
    }

    ?>

    <form action="checkout.php">
        <!-- Hero Section Begin -->
        <section class="hero-section">
            <div class="hs-slider owl-carousel">

        <?php
            $sql = "SELECT * FROM `contributor_articles` ORDER BY Comment DESC LIMIT 5";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                if(mysqli_num_rows($query)>0) {
                    while ($row = mysqli_fetch_row($query)) {
                        $Article_Id = $row[0];
                        $Contributor_Id = $row[1];
                        $Img_Title = $row[2];
                        $Title = $row[3];
                        $Date_Created = $row[9];
                        $Date_Created = DateTime::createFromFormat("Y-m-d", $Date_Created)->format("M, d, Y");
                        $cmnt = $row[18];
                        $query1 = mysqli_query($conn, "SELECT * FROM `fitzy_database`.`contributor` WHERE `Contributor_Id` = '$Contributor_Id'");
                        if($query1) {
                            $result1 = mysqli_fetch_array($query1);
                            $Author_Name = $result1['Author_Name'];
                        }
                ?>
                <div class="hs-item set-bg" data-setbg="<?php if(!empty($Img_Title)){ echo "data:image/jpg;charset=utf8;base64,".base64_encode($Img_Title);} else { echo "img/hero/hero-2.jpg";} ?>">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 p-0 m-auto">
                            <div class="bh-text">
                                <h3><a href="<?='blog-details.php?article='.$Article_Id;?>"><?php echo $Title; ?></a></h3>
                                <ul>
                                    <li>by <?php echo $Author_Name; ?></li>
                                    <li><?php echo $Date_Created; ?></li>
                                    <li>
                                        <?php echo sprintf("%02d", $cmnt); ?>
                                        Comment
                                    </li>
                                </ul><br>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                }
            }
        ?>                
            </div>
        </section>
        <!-- Hero Section End -->
        
        <!-- ChoseUs Section Begin -->
        <section class="choseus-section spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <span>Why chose us?</span>
                            <h2>PUSH YOUR LIMITS FORWARD</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="cs-item">
                            <span class="flaticon-005-clipboard"></span>
                            <h4>Interesting Blogs</h4>
                            <p>We have great blogs about health, dietfood, exercise, etc which will help you more to maintain your health.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="cs-item">
                            <span class="flaticon-033-juice"></span>
                            <h4>Healthy Nutrition Plan</h4>
                            <p>Our Dieticians will make diet plans as per your body and plan you have selected so you will get accurate diet plans.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="cs-item">
                            <span class="flaticon-002-dumbell"></span>
                            <h4>Training Plan</h4>
                            <p>We got professional Trainer from diiferent gyms to make accurate exercise schedules for you as per your body.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="cs-item">
                            <span class="flaticon-014-heart-beat"></span>
                            <h4>Unique To Your Needs</h4>
                            <p>Get more benefits for your health by choosing accurate diet and exercises according to calories you need.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ChoseUs Section End -->

        <?php
        if ($role != 'trainer' && $role != 'dietician'){
            $sql1 = "SELECT * FROM `membership` WHERE Customer_Id='$c_id' && Status=1";
            $query1 = mysqli_query($conn, $sql1);
            
            if (!mysqli_num_rows($query1) > 0) {
                ?>
        <section class="pricing-section spad" style="padding-bottom: 0;">
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
                <?php
            }
        }
        ?>

        <!-- Team Section Begin -->
        <section class="team-section spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <span>Our Team</span>
                            <h2>TRAIN WITH EXPERTS</h2>
                        </div>
                        <!-- <a href="#" class="primary-btn btn-normal appoinment-btn">appointment</a> -->
                    </div>
                </div>
                <div class="row">
                    <div class="ts-slider owl-carousel">
                        <?php
                        $sql = "SELECT * FROM `trainer`";
                        $query = mysqli_query($conn, $sql);
                        if ($query) {
                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_row($query)) {
                                    $Trainer_Id = $row[0];
                                    $Name = $row[2];
                                    $Photo = $row[13];
                        ?>
                                    <div class="col-lg-4">
                                        <div class="ts-item set-bg" data-setbg="<?php if (!empty($Photo)) { echo "data:image/jpg;charset=utf8;base64," . base64_encode($Photo); } else { echo "img/team/team-1.jpg"; } ?>">
                                            <div class="ts_text">
                                                <h4><?php echo $Name ?></h4>
                                                <span>Gym Trainer</span>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- Team Section End -->

        <!-- Get In Touch Section Begin -->
        <div class="gettouch-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="gt-text">
                            <i class="fa fa-map-marker"></i>
                            <p>GOVERMENT POLYTECHNIC AHMEDABAD<br /> </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="gt-text">
                            <i class="fa fa-mobile"></i>
                            <ul>
                                <li>+91 93166 06360</li>
                                <li>+91 79906 57193</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="gt-text email">
                            <i class="fa fa-envelope"></i>
                            <p>help.fitzy@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Get In Touch Section End -->

        <?php
        include "footer.php";

        ?>
    </form>

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/jquery.barfiller.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="notification.js"></script>
    
</body>

</html>