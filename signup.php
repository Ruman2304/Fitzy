<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Fitzy | Signup</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/s_main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="shortcut icon" type="image/png" href="./favicon.png">

</head>

<?php
include "connect.php";
if (isset($_POST['btn_submit'])) {
    $datetime = date("Y-m-d H:i:s");
    $date = date("Y-m-d");
    $time = date("H:i:s");

    $email = $_POST['email'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $_SESSION['user_name_master'] = $username;
    $password = hash("sha512", $_POST['pass']);
    $c_password = hash("sha512", $_POST['c_pass']);
    $gender = $_POST['gender'];
    $b_date = $_POST['b_date'];

    $diff = date_diff(date_create($b_date), date_create($date));
    $age = $diff->format('%y');

    if (isset($_POST['telephone'])) {
        $telephone = $_POST['telephone'];
    } else {
        $telephone = '';
    }

    if ($password != $c_password) {
        echo '<b><script>swal("Password Does Not Match!", "Confirm Password Must Be Same As New Password", "error");</script></b>';
    } else {

        $query = mysqli_query($conn, "SELECT * from `user_master` WHERE (Username='$username' || Email_Id='$email') && Active='1'");
        $result = mysqli_num_rows($query);

        if ($result > 0) {
            echo "<b><script>swal('Account not created!', 'Username Already Exists!', 'error');</script></b>";
        } else {

            $query = mysqli_query($conn, "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'fitzy_database' AND TABLE_NAME = 'user_master'");
            if (mysqli_num_rows($query) == 1) {
                $row = mysqli_fetch_row($query);
                $User_Id = $row[0];
            }

            $query = mysqli_query($conn, "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'fitzy_database' AND TABLE_NAME = 'customer'");
            if (mysqli_num_rows($query) == 1) {
                $row = mysqli_fetch_row($query);
                $Customer_Id = $row[0];
            }

            $filename = $_FILES['photo']['name'];
            $filetmp = $_FILES['photo']['tmp_name'];
            $filesize = $_FILES["photo"]["size"];
            $fileext = explode('.', $filename);
            $filecheck = strtolower(end($fileext));
            $extention = array('png', 'jpg', 'jpeg');

            if (empty($filename)) {
                $photo = '';
                $sql = "INSERT INTO `user_master`(`User_Id`, `Email_Id`, `Username`, `Password`, `Role`, `Active`, `Approve_Datetime`, `Admin_Remark`, `Date_Joined`, `Time_Joined`) VALUES ('$User_Id','$email','$username','$password','customer', '1','$datetime','','$date','$time');";

                $sql1 = "INSERT INTO `customer`(`Customer_Id`, `User_Id`, `Name`, `Gender`, `Birth_Date`, `Age`, `Contact_No`, `Height`, `Weight`, `Physicaly_Handicap`, `Disease_Check`, `Disease_Name`, `Pincode`, `Local_Place`, `City`, `State`, `Country`, `Photo`) VALUES ('$Customer_Id','$User_Id','$name','$gender','$b_date','$age','$telephone','0','0','0','0','',NULL,NULL,NULL,NULL,NULL,'$photo');";

                $_SESSION["otp"] = mt_rand(100000, 999999);
                $_SESSION["name"] = $name;
                $_SESSION["email"] = $email;
                $_SESSION['sql'] = $sql;
                $_SESSION['sql1'] = $sql1;
                $_SESSION["is_sent"] = true;
                header("Location: s_verify.php");
            } elseif ($filesize > '2097152') {
                echo '<b><script>swal("Account not created!", "Size of photo must be less then 2 MB!", "error");</script></b>';
            } elseif (in_array($filecheck, $extention)) {
                $photo = addslashes(file_get_contents($filetmp));
                $sql = "INSERT INTO `user_master`(`User_Id`, `Email_Id`, `Username`, `Password`, `Role`, `Active`, `Approve_Datetime`, `Admin_Remark`, `Date_Joined`, `Time_Joined`) VALUES ('$User_Id','$email','$username','$password','customer', '1','$datetime','','$date','$time');";

                $sql1 = "INSERT INTO `customer`(`Customer_Id`, `User_Id`, `Name`, `Gender`, `Birth_Date`, `Age`, `Contact_No`, `Height`, `Weight`, `Physicaly_Handicap`, `Disease_Check`, `Disease_Name`, `Pincode`, `Local_Place`, `City`, `State`, `Country`, `Photo`) VALUES ('$Customer_Id','$User_Id','$name','$gender','$b_date','$age','$telephone','0','0','0','0','',NULL,NULL,NULL,NULL,NULL,'$photo');";

                $_SESSION["otp"] = mt_rand(100000, 999999);
                $_SESSION["name"] = $name;
                $_SESSION["email"] = $email;
                $_SESSION['sql'] = $sql;
                $_SESSION['sql1'] = $sql1;
                $_SESSION["is_sent"] = true;
                header("Location: s_verify.php");
            } else {
                echo '<b><script>swal("Account not created!", "Please upload image file with jpg, png, jpeg only!", "error");</script></b>';
            }
        }
    }
}
?>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic">
                    <img src="img/fitness-vector.png" alt="IMG">
                </div>
                <form class="login100-form validate-form" method="POST" enctype="multipart/form-data">
                    <span class="login100-form-title">
                        Register Here
                    </span>
                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="email" placeholder="Email" autofocus>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Name is required: John Sena">
                        <input class="input100" type="text" name="name" placeholder="Name">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user-secret aria-hidden=" true></i>
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Valid username is required: johnsnows288">
                        <input class="input100" type="text" name="username" placeholder="Username">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="pass" placeholder="New Password" minlength="8">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Confirm Password is required">
                        <input class="input100" type="password" name="c_pass" placeholder="Confirm Password" minlength="8">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="wrap-input100" id="gender">
                        <span>Gender:</span>&nbsp;
                        <input type="radio" name="gender" id="male" value="male" required>&nbsp;<label for="male" required>Male</label>
                        <input type="radio" name="gender" value="female" id="female">&nbsp;<label for="female">Female</label>
                        <input type="radio" name="gender" value="other" id="other">&nbsp;<label for="other">Other</label>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Valid Birth Date is required: 12-13-2000">
                        <input class="input100" type="date" name="b_date">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-birthday-cake" aria-hidden="true "></i>
                        </span>
                    </div>
                    <div class="wrap-input100">
                        <input class="input100" type="text" name="telephone" pattern="[0-9]{10}" placeholder="Phone Number">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-phone-square" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="wrap-input100">
                        <label for="file" class="up1">
                            <i class="fa fa-cloud-upload" id="upload" style="font-size: 18px; text-align: center;"></i>&nbsp;&nbsp;&nbsp;
                            Upload Your Photo</label>
                        <input type="file" name="photo" id="file" accept="image/png, image/gif, image/jpeg">
                    </div>
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" name="btn_submit">
                            Register
                        </button>
                    </div>

                    <div class="text-center p-t-136">
                        <span class="txt2">
                            Already Have an Account?
                        </span>
                        <a class="txt2" id="fc1" href="login.php">
                            Login Here
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $('#file').change(function() {
            var file = $('#file')[0].files[0].name;
            $(this).prev('label').text(file);
        });
    </script>
    <script src=script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/tilt/tilt.jquery.min.js"></script>
    <script src="js/l_main.js"></script>
</body>

</html>