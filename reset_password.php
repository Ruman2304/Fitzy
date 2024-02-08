<?php
    session_start();
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
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="shortcut icon" type="image/png" href="./favicon.png">

    <style>
        body {
            background-color: #2C272E;
        }
        .container {
            margin-top: 70px;
        }
        .bg-alert {
            margin-left: 10%;
            position: absolute;
        }
        .alert {
            border-radius: 50px;
            padding: 10px 50px;
            /* position: absolute; */
            margin-top: 50px;
            display: inline-block;
        }
        .alert-danger {
            border: 1px solid #ffb3b3;
            background-color: #ffd0cc;
            color: #990000;
        }
        .alert-success {
            border: 1px solid #99ff99;
            background-color: #ccffcc;
            color: #009900;
        }
    </style>
</head>
<body>
    <?php
        include("connect.php");        
        if (isset($_POST['reset_pass']))
        {
            // print_r($_POST);
            $new_pass = hash("sha512", $_POST['new_pass']);
            $c_pass = hash("sha512", $_POST['c_pass']);

            if($new_pass != $c_pass) {
                echo '<b><script>swal("Password Does Not Match!", "Confirm Password Must Be Same As New Password", "error");</script></b>';
            } else {
                $username = "";
                if(isset($_SESSION['username'])) {
                    $username = $_SESSION['username'];
                }
                $sql = "SELECT `Password` FROM `user_master` WHERE Username='$username'";
                $query =  mysqli_query($conn, $sql);
                $row = mysqli_fetch_row($query);
                
                $password = "";
                if(isset($row[0])) {
                    $password = $row[0];
                };
    
                if($password == $new_pass) {
                    echo '<script>swal("Password not updated!", "Password is same as current password", "error");</script>';
                }
                else {
                    $sql = "UPDATE `user_master` SET `Password`='$new_pass' WHERE Username='$username'";
                    $query =  mysqli_query($conn, $sql);
                    if(mysqli_affected_rows($conn) == 1) {
                        session_unset();
                        session_destroy();
                        echo '<script>if (swal("Password updated!", "Your password reset successfully", "success")) {setTimeout(function () { window.location.href="login.php"; }, 3000); }</script>';
                    }
                    else {
                        echo '<script>swal("Password not updated!", "Please try again leter", "error");</script>';
                    }
                }
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
                    <h2 class="text-center">Reset Password!</h2>
                    <p>Enter a new password for your account.</p>
                    <div class="panel-body">
        
                        <form id="register-form" role="form" autocomplete="off" class="form" method="post">
        
                        <div class="form-group">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-check color-blue"></i></span>
                            <input id="new_pass" name="new_pass" placeholder="New Password" class="form-control" type="password" required minlength="8">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-check color-blue"></i></span>
                            <input id="c_pass" name="c_pass" placeholder="Confirm Password" class="form-control" type="password" required minlength="8">
                            </div>
                        </div>
                        <div class="form-group">
                            <input name="reset_pass" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
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