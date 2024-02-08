<?php
    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitzy | Signup</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="shortcut icon" type="image/png" href="./favicon.png">

    <style>
        body {
            background-color: #2C272E;
        }
        .container {
            margin-top: 70px;
            /* background-color: #ff0000; */
        }
    </style>
</head>
<body>
    <?php

    if($_SESSION['is_sent']){
        include("connect.php");
        $otp = "";
        $name = "";
        $email = "";
        if(isset($_SESSION['email']) && isset($_SESSION['otp'])) {
            $email = $_SESSION['email'];
            $name = $_SESSION['name'];
            $otp = $_SESSION['otp'];
        }
        if($email!="" && $name!="" && $otp!="")
        {
            // mail sending
            require 'vendor/autoload.php';
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'help.fitzy@gmail.com';
                $mail->Password = 'Fitzy@12345';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('help.fitzy@gmail.com', 'Fitzy Support');
                $mail->addAddress($email, $name);

                $mail->isHTML(true);
                $mail->Subject = $otp.' is your Fitzy verification code';
                
                $mail->Body    = '<table width="500px" align="center" border="0" style="background-color: #FFFFFF;"><tr><th style="font-size: 28px; padding: 30px; text-align: center;">Confirm your email address</th></tr><tr><td style="font-size: 18px; padding: 10px; text-align: justify;">There\'s one quick step you need to complete before creating your Fitzy account. Let\'s make sure this is the right email address for you — please confirm this is the right address to use for your new account.</td></tr><tr><td style="font-size: 18px; padding: 10px; text-align: justify;">Please enter this verification code to get started on Fitzy:</td></tr><tr><td style="font-size: 26px; padding: 10px; font-weight: bold; text-align: center;">Your code is: '.$otp.'</td></tr><tr><td style="font-size: 18px; padding: 10px;">Thanks,<br>Fitzy</td></tr></table>';
                $mail->addReplyTo("help.fitzy@gmail.com");
                $mail->send();
                $_SESSION['is_sent'] = false;
                echo '<script>swal("OTP Sent!", "Please Enter 6-Digit OTP sent to your email", "success");</script>';
            } catch (Exception $e) {
                echo '<script>swal("Email could not be sent!", "Please Enter Valid Email Address", "error");</script>';
            }
            // mail sending
        }
    }
    if (isset($_POST['verify_code']))
    {
        // print_r($_POST);
        include("connect.php");
        $otp = "";
        $sql ="";
        $sql1 = "";
        if(isset($_SESSION['otp']) && isset($_SESSION['sql']) && isset($_SESSION['sql1'])){
            $otp = $_SESSION['otp'];
            $sql = $_SESSION['sql'];
            $sql1 = $_SESSION['sql1'];
        }
        $code = $_POST['code'];
        if($otp == $code){
            $query = mysqli_query($conn, $sql);
            $query1 = mysqli_query($conn, $sql1);
            if($query && $query1) {
                unset($_SESSION['name']);
                unset($_SESSION['email']);
                unset($_SESSION['otp']);
                unset($_SESSION['sql']);
                unset($_SESSION['sql1']);
                echo '<b><script>if (swal("Account Created!", "Redirecting Now..", "success")) {setTimeout(function () { window.location.href="login.php"; }, 3000); }</script></b>';
            } else {
                echo '<b><script>swal("Account not created!", "Please Try Again Later", "error");</script></b>';
            }
        }
        else{
            echo '<script>swal("OTP is Incorrect!", "Please Enter Valid 6-Digit Code", "error");</script>';
        }
    }
    
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">
                    <h3><i class="fa fa-comments fa-4x"></i></h3>
                    <h2 class="text-center">Verify Your Code</h2>
                    <p>Enter the OTP sent to your mail.</p>
                    <div class="panel-body">
                        <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-check color-blue"></i></span>
                                    <input id="code" name="code" placeholder="Enter 6 Digit Code" class="form-control" type="text" pattern="[0-9]{6}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <input name="verify_code" class="btn btn-lg btn-primary btn-block" value="Verify Code" type="submit">
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>