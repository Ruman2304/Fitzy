<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Blogs">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fitzy | Diet</title>

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
    <link rel="shortcut icon" type="image/png" href="./favicon.png">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>
        .btn {
            background-color: #f36100;
        }
        .services-section .container .card {
            margin-bottom: 20px;
        }
        .container-fluid .odd {
            padding: 40px;
            background: #f1f1f1;
        }
        .container-fluid .even {
            padding: 40px;
            background: #151515;
        }
        .container-fluid .row .cont {
            background: #fff;
            padding: 20px;
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
    include("connect.php");
?>
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/food-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Diet Page</h2>
                        <div class="bt-option">
                            <a href="./index.php">Home</a>
                            <span>Diet</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <section class="services-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <center>
                        <div class="card text-center" style="width: 18rem;">
                            <img class="card-img-top" src="./img/images/boy3.jpg" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Vegetarian Diet</h5>
                                <p class="card-text text-left">The vegetarian diet involves abstaining from eating meat, fish and poultry.</p>
                                <a href="./dietfood.php?category=1" class="btn btn-primary">Show Dietfoods</a>
                            </div>
                        </div>
                    </center>
                </div>
                <div class="col-lg-4">
                    <center>
                        <div class="card text-center" style="width: 18rem;">
                            <img class="card-img-top" src="./img/images/girl.jpg" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Veg-Nonveg Diet</h5>
                                <p class="card-text text-left">The best ways to eat meat are to cook it in the healthiest possible methods.</p>
                                <a href="./dietfood.php?category=3" class="btn btn-primary">Show Dietfoods</a>
                            </div>
                        </div>
                    </center>
                </div>
                <div class="col-lg-4">
                    <center>
                        <div class="card text-center" style="width: 18rem;">
                            <img class="card-img-top" src="./img/images/boy1.jpg" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Non-vegetarian Diet</h5>
                                <p class="card-text text-left">Meats contain saturated fats which can thicken the blood and clog blood vessels.</p>
                                <a href="./dietfood.php?category=2" class="btn btn-primary">Show Dietfoods</a>
                            </div>
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </section>

    <div class="container-fluid">
        <div class="row odd">
            <div class="col-12 col-md-8 cont">
                <div class="container">
                    <p class="h1 text-dark font-weight-bold">The Diet</p>
                    <p class="h1 text-dark font-weight-bold">Why You Need Diet?</p>
                    <p class="h3 text-dark font-weight-bold">Weight Loss or Maintenance</p>
                    <p class="h5 text-justify text-dark">Use fruit, vegetables, lean protein and whole grains to replace high-fat, high-calorie foods. Staying within your required calorie range is vital for achieving and maintaining a healthy weight. The fiber in whole grains, fruits and vegetables help fill you up faster and keep you full longer than foods that are loaded with sugar. The longer you are satiated, the less likely you are to exceed your ideal calorie range.</p>
                </div>
            </div>
            <div class="col-6 col-md-4 cont" style="background-color: #f1f1f1;">
                <div class="container">
                    <img src="./img/images/Food5.jpg">
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row even">
            <div class="col-6 col-md-4 cont" style="background-color: #151515;">
                <div class="container">
                    <img src="./img/images/FOOD2.jpg">
                </div>
            </div>
            <div class="col-12 col-md-8 cont">
                <div class="container">
                    <p class="h1 text-dark font-weight-bold">Healthy Body</p>
                    <p class="h3 text-danger font-weight-bold">Blood Sugar Control</p>
                    <p class="h5 text-justify text-dark">Sugary foods, such as white bread, fruit juice, soda and ice cream, cause a spike in blood sugar. While your body can handle occasional influxes of glucose, over time this can lead to insulin resistance, which can go on to become type 2 diabetes. Complex carbohydrates, such as whole grain bread, oatmeal and brown rice, cause a slow release of sugar into the bloodstream, which helps regulate blood sugar.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row odd">
            <div class="col-12 col-md-8 cont">
                <div class="container">
                    <p class="h1 text-success font-weight-bold">Decreased Risk of Heart Disease</p>
                    <p class="h5 text-justify text-dark">Regularly consuming high-fat foods can increase your cholesterol and triglyceride levels, which can cause plaque to buildup in your arteries. Over time, this can lead to heart attack, stroke or heart disease. Eating a moderate amount of healthful fats such as those found in olive oil, avocados, fish, nuts and seeds helps protect your heart.</p>
                </div>
            </div>
            <div class="col-6 col-md-4 cont" style="background-color: #f1f1f1;">
                <div class="container">
                    <img src="./img/images/food1.jfif">
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row even">
            <div class="col-6 col-md-4 cont" style="background-color: #151515;">
                <div class="container">
                    <img src="./img/images/food6.jpg">
                </div>
            </div>
            <div class="col-12 col-md-8 cont">
                <div class="container">
                <p class="h1 text-dark font-weight-bold">Support for Brain Health</p>
                    <p class="h5 text-justify text-dark">A healthful diet is just as good for your brain as the rest of your body. Unhealthy foods are linked to a range of neurological problems. Certain nutrient deficiencies increasing the risk of depression. Other nutrients, like potassium, actually involved in brain cell function. A varied, healthful diet keeps your brain functioning properly, and it can promote good mental health as well.</p>
                </div>
            </div>
        </div>
    </div>

    <?php
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