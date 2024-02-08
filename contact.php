<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Contact Us">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fitzy | Contact</title>

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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="shortcut icon" type="image/png" href="./favicon.png">


    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <?php
    include("connect.php");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    session_start();
    if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $user_id = $_SESSION['userid'];

    if (isset($_POST['sbt_btn'])) {

        $name = $_REQUEST['name'];
        $email = $_REQUEST['email'];
        if (isset($_REQUEST['number'])) {
            $number = $_REQUEST['number'];
        } else {
            $number = "";
        }
        $subject = $_REQUEST['subject'];
        $message = $_REQUEST['message'];

        $sql = "INSERT INTO `contact_us`(`Id`, `User_Id`, `Email_Id`, `Name`, `Contact_No`, `Message`) VALUES ('','$user_id','$email','$name','$number','$message')";
        $query = mysqli_query($conn, $sql);

        require 'vendor/autoload.php';

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'help.fitzy@gmail.com';
        $mail->Password   = 'Fitzy@12345';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->addAddress("help.fitzy@gmail.com", "Fitzy Support");
        $mail->addReplyTo($email);

        $mail->isHTML(true);
        $mail->Body    = "<table width='500px' align='center' border='0' style='background-color: #FFFFFF;'><tr><th style='font-size: 28px; padding: 30px; text-align: center;'>Fitzy Contact</th></tr><tr><td style='font-size: 18px; padding: 10px; text-align: justify;'>Name: $name </td></tr><tr><td style='font-size: 18px; padding: 10px; text-align: justify;'>Email: $email</td></tr><tr><td style='font-size: 18px; padding: 10px;'>Number: $number </td></tr><tr><td style='font-size: 18px; padding: 10px;'>Message: $message </td></tr></table>";
        $mail->Subject = $subject;
        if (!$mail->send() && !$query) {
            echo '<b><script>swal("Error!", "Invalid Email Address", "error");</script><b>';
        } else {
            echo '<b><script>swal("Thank You For Contacting Us!", "Will Reach Back to You Shortly", "success")</script></b>';
        }
    }
    ?>
</head>

<body>
    <!-- Page Preloder -->

    <?php
    include("header.php");
    ?>
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Contact Us</h2>
                        <div class="bt-option">
                            <a href="./index.php">Home</a>
                            <a href="#">Other</a>
                            <span>Contact us</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Contact Section Begin -->
    <section class="contact-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title contact-title">
                        <span>Contact Us</span>
                        <h2>GET IN TOUCH</h2>
                    </div>
                    <div class="contact-widget">
                        <div class="cw-text">
                            <i class="fa fa-map-marker"></i>
                            <p>Government Polytechnic, <br /> Ahmedabad</p>
                        </div>
                        <div class="cw-text">
                            <i class="fa fa-mobile"></i>
                            <ul>
                                <li>+91 93166 06360</li>
                                <li>+91 79906 57193</li>
                            </ul>
                        </div>
                        <div class="cw-text email">
                            <i class="fa fa-envelope"></i>
                            <p>help.fitzy@gmail.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="leave-comment">
                        <form method="POST">
                            <input type="text" class="field" name="name" placeholder="Your Name" required>
                            <input type="email" class="field" name="email" placeholder="Your Email" required>
                            <input type="tel" class="field" name="number" pattern="[0-9]{10}" placeholder="Phone">
                            <input type="text" class="field" name="subject" placeholder="Subject" required>
                            <textarea placeholder="Message" name="message" class="field" required></textarea>
                            <button class="btn" name="sbt_btn">Send</button>
                        </form>
                    </div>
                </div>
            </div>
    </section>
    <!-- Contact Section End -->


    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/jquery.barfiller.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>

    <?php
    include("footer.php");
    } else {
        header("Location: ./login.php");
    }
    ?>
</body>

</html>