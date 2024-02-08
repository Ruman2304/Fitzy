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
    <title>Fitzy | Forgot Password</title>
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
    
    include("connect.php");
    if($_SESSION['is_sent']){
        $row = array();
        $user_id = "";
        $email = "";
        $username = "";
        $name = "";
        $role = "";
        $otp = "";
        if(isset($_SESSION['row']) && isset($_SESSION['otp'])) {
            $row = $_SESSION['row'];
            $user_id = $row[0];
            $email = $row[1];
            $username = $_SESSION['username'] = $row[2];
            $role = $row[4];
            $otp = $_SESSION['otp'];
        }

        switch ($role) {
            case "trainer": $table = "trainer";
                break;
            case "dietician": $table = "dietician";
                break;
            case "contributor": $table = "customer";
                break;
            default: $table = "customer";
        }

        $sql = "SELECT Name from `".$table."` WHERE User_Id='".$user_id."'";
        $query =  mysqli_query($conn,$sql);
        $row = mysqli_fetch_row($query);
        if(isset($row[0])){
            $name = $row[0];
        };

        if($email!="" && $name!="" && $otp!="" && $username!="")
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
                
                $mail->Body    = '<table width="500px" align="center" border="0" style="background-color: #FFFFFF;"><tr><th style="font-size: 28px; padding: 30px; text-align: center;">Reset your password?</th></tr><tr><td style="font-size: 18px; padding: 10px; text-align: justify;">If you requested a password reset for @'.$username.', use the confirmation code below to complete the process. If you did not make this request, ignore this email.</td></tr><tr><td style="font-size: 18px; padding: 10px; text-align: justify;">Please enter this verification code to reset your password on Fitzy:</td></tr><tr><td style="font-size: 26px; padding: 10px; font-weight: bold; text-align: center;">Your code is: '.$otp.'</td></tr><tr><td style="font-size: 18px; padding: 10px;">Thanks,<br>Fitzy</td></tr></table>';
                $mail->addReplyTo("help.fitzy@gmail.com");
                $mail->send();
                $_SESSION['is_sent'] = false;
                echo '<script>swal("OTP Sent!", "Please Enter 6-Digit OTP sent to your email", "success");</script>';
            } catch (Exception $e) {
                echo '<script>swal("Email could not be sent!", "Mailer Error: {$mail->ErrorInfo}", "error");</script>';
            }
            // mail sending
        }
    }

    if (isset($_POST['verify_code']))
    {
        // print_r($_POST);
        $otp = "";
        if(isset($_SESSION['otp'])){
            $otp = $_SESSION['otp'];
        }
        $code = $_POST['code'];
        if($otp == $code){
            unset($_SESSION['row']);
            unset($_SESSION['otp']);
            echo '<script>if (swal("OTP Verified!", "Reset your password now", "success")) {setTimeout(function () { window.location.href="reset_password.php"; }, 3000); }</script>';
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
                    <h3><i class="fa fa-lock fa-4x"></i></h3>
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