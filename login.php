<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Fitzy | Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/l_main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="shortcut icon" type="image/png" href="./favicon.png">

</head>

<body>
    <?php
    include("connect.php");

    if (isset($_POST['btn_submit'])) {
        // print_r($_POST);
        $email = $_POST['email'];
        $password = hash("sha512", $_POST['pass']);
        $role = $_POST['role'];
        $sql = "SELECT * FROM `user_master` WHERE Email_Id='$email' && Password='$password' && Role='$role' && Active='1'";
        $query =  mysqli_query($conn, $sql);
        if ($query) {
            $result = mysqli_fetch_array($query);
            if (isset($result['User_Id'])) {
                $user_id = $result['User_Id'];
            } else {
                $user_id = "";
            }
        }
        if (mysqli_num_rows($query) == 1) {

            if (isset($_POST["remember"])) {
                setcookie('email', $_POST['email'], time() + 60 * 60 * 24 * 365, '/');
                setcookie('password', $_POST['pass'], time() + 60 * 60 * 24 * 365, '/');
                setcookie('role', $_POST['role'], time() + 60 * 60 * 24 * 365, '/');
            } else {
                setcookie('email', '', time() - 50, '/');
                setcookie('password', '', time() - 50, '/');
                setcookie('role', '', time() - 50, '/');
            }
            session_unset();
            session_destroy();
            session_start();

            $date = date("Y-m-d");
            $time = date("H:i:s");

            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $user_ip_address = $_SERVER['HTTP_CLIENT_IP'];
            }
            elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $user_ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            elseif(!empty($_SERVER['HTTP_X_FORWARDED'])) {
                $user_ip_address = $_SERVER['HTTP_X_FORWARDED'];
            }
            elseif(!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
                $user_ip_address = $_SERVER['HTTP_FORWARDED_FOR'];
            }
            elseif(!empty($_SERVER['HTTP_FORWARDED'])) {
                $user_ip_address = $_SERVER['HTTP_FORWARDED'];
            }
            elseif(!empty($_SERVER['REMOTE_ADDR'])) {
                $user_ip_address = $_SERVER['REMOTE_ADDR'];
            }
            else {
                $user_ip_address = 'UNKNOWN';
            }

            $sql = "INSERT INTO `user_activity`(`User_Activity_Id`, `User_Id`, `Activity_Name`, `IP_Address`, `Activity_Date`, `Activity_Time`) VALUES ('','$user_id','logged in','$user_ip_address','$date','$time')";
            $query =  mysqli_query($conn, $sql);

            $_SESSION['userid'] = $user_id;
            $_SESSION['role'] = $role;
            $_SESSION["email"] = $email;
            $_SESSION["password"] = $password;
            echo '<script>if (swal("Login Successful!", "You have Logged in successfully to Fitzy", "success")) {setTimeout(function () { window.location.href="index.php"; }, 2000); }</script>';
        } else {
            echo '<script>if (swal("Details are Incorrect!", "Username and Password are Incorrect for ' . $role . '", "error")) {setTimeout(function () { window.location.href="javascript:history.back(1)"; }, 2000); }</script>';
        }
    }
    ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic">
                    <img src="img/Fitness.png" alt="IMG">
                </div>

                <form class="login100-form validate-form" method="POST">
                    <span class="login100-form-title">
                        Login to Fitzy
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="email" value="<?php if (isset($_COOKIE['email'])) { echo $_COOKIE['email']; } ?>" placeholder="Email Address">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="pass" value="<?php if (isset($_COOKIE['password'])) { echo $_COOKIE['password']; } ?>" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true" style="font-size: 20px;"></i>
                        </span>
                    </div>

                    <?php
                        if (isset($_COOKIE['role'])) {
                            $rr = $_COOKIE['role'];
                        } else {
                            $rr = "";
                        }
                    ?>

                    <div class="wrap-input100">
                        <select name="role" id="role" class="input100 validate-input" required>
                            <option value="" selected>Choose Your Role</option>
                            <option value="customer" <?php if ($rr == 'customer') { echo "selected='selected'"; } ?>>Customer</option>
                            <option value="trainer" <?php if ($rr == 'trainer') { echo "selected='selected'"; } ?>>Trainer</option>
                            <option value="dietician" <?php if ($rr == 'dietician') { echo "selected='selected'"; } ?>>Dietician</option>
                            <option value="contributor" <?php if ($rr == 'contributor') { echo "selected='selected'"; } ?>>Contributor</option>
                        </select>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-users" aria-hidden="true" style="font-size: 20px;"></i>
                        </span>
                    </div>

                    <div class="remember">
                        <label class="container-rem">
                            <input type="checkbox" name="remember">
                            <span class="checkmark"></span>
                            Remember Me
                        </label>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" name="btn_submit">
                            Login
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <span class="txt1">
                            Forgot
                        </span>
                        <a class="txt2" id="f_pass" href="forgot_password.php">
                            Username / Password?
                        </a>
                    </div>

                    <div class="text-center p-t-136">
                        <span class="txt2">
                            Don't have an Account?
                        </span>
                        <a class="txt2" id="fc1" href="signup.php">
                            Create One
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/tilt/tilt.jquery.min.js"></script>
    <script src="js/l_main.js"></script>
</body>

</html>