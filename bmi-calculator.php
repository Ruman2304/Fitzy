<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gym Template">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fitzy | BMI Calculator</title>

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
        /* Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
            input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php
    include "connect.php";
    include("header.php");
    ?>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>BMI calculator</h2>
                        <div class="bt-option">
                            <a href="./index.php">Home</a>
                            <a href="">Other</a>
                            <span>BMI calculator</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- BMI Calculator Section Begin -->
    <section class="bmi-calculator-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title chart-title">
                        <span>check your body</span>
                        <h2>BMI CALCULATOR CHART</h2>
                    </div>
                    <div class="chart-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Bmi</th>
                                    <th>WEIGHT STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="point">Below 18.5</td>
                                    <td>Underweight</td>
                                </tr>
                                <tr>
                                    <td class="point">18.5 - 24.9</td>
                                    <td>Healthy</td>
                                </tr>
                                <tr>
                                    <td class="point">25.0 - 29.9</td>
                                    <td>Overweight</td>
                                </tr>
                                <tr>
                                    <td class="point">30.0 - and Above</td>
                                    <td>Obese</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="section-title chart-calculate-title">
                        <span>check your body</span>
                        <h2>CALCULATE YOUR BMI</h2>
                    </div>
                    <div class="chart-calculate-form">
                        <form method="POST">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="number" min="2" max="120" name="age" placeholder="Age" required>
                                </div>
                                <div class="col-sm-12">
                                    <input type="number" min="30" max="250" name="height" placeholder="Height / cm" required>
                                </div>
                                <div class="col-sm-12">
                                    <input type="number" min="7" max="350" name="weight" placeholder="Weight / kg" required>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" name="calculate">Calculate</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- BMI Calculator Section End -->

    <?php
        if (isset($_POST['calculate'])) {
            $age = $_POST['age'];
            $height = $_POST['height'];
            $weight = $_POST['weight'];

            $bmi = $weight / (($height/100) * ($height/100));
            $bmi = round($bmi, 2);

            if($bmi<18.5) {
                $result = 'Underweight';
                echo '<b><script>swal("BMI: '.$bmi.' --> '.$result.'", "", "error");</script></b>';
            }
            elseif($bmi>=18.5 && $bmi<=24.99) {
                $result = 'Healthy';
                echo '<b><script>swal("BMI: '.$bmi.' --> '.$result.'", "", "success");</script></b>';
            }
            elseif($bmi>=25 && $bmi<=29.99) {
                $result = 'Overweight';
                echo '<b><script>swal("BMI: '.$bmi.' --> '.$result.'", "", "error");</script></b>';
            }
            elseif($bmi>=30 && $bmi<=34.99) {
                $result = 'Obese';
                echo '<b><script>swal("BMI: '.$bmi.' --> '.$result.'", "", "error");</script></b>';
            }
            elseif($bmi>=35) {
                $result = 'Extremely obese';
                echo '<b><script>swal("BMI: '.$bmi.' -->  '.$result.'", "", "error");</script></b>';
            }
        }
    ?>

    <?php
    include("footer.php");
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