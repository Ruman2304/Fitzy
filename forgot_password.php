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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
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
    if (isset($_POST['send_code'])) {
        // print_r($_POST);
        $username = $_POST['username'];
        $query =  mysqli_query($conn, "SELECT * from `user_master` WHERE Username='$username'");
        if (mysqli_num_rows($query) == 1) {
            $_SESSION["row"] = mysqli_fetch_row($query);
            $_SESSION["otp"] = mt_rand(100000, 999999);
            $_SESSION["is_sent"] = true;
            header("Location: l_verify.php");
        }
        else {
            echo '<script>swal("Username Incorrect!", "Please Enter Valid Username", "error");</script>';
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
                            <h2 class="text-center">Forgot Password?</h2>
                            <p>Enter your Username to reset the password.</p>
                            <div class="panel-body">

                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                            <input id="username" name="username" placeholder="Username" class="form-control" type="text" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="send_code" class="btn btn-lg btn-primary btn-block" value="Send Code" type="submit">
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