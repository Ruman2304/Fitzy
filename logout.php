<?php
session_start();
include("connect.php");
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {

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

    $user_id = $_SESSION['userid'];
    $sql = "INSERT INTO `user_activity`(`User_Activity_Id`, `User_Id`, `Activity_Name`, `IP_Address`, `Activity_Date`, `Activity_Time`) VALUES ('','$user_id','logged out','$user_ip_address','$date','$time')";
    $query =  mysqli_query($conn, $sql);
}

session_unset();
session_destroy();
echo "<script>
    setTimeout(function () {
        window.location.href= 'index.php?action=logout';
    }, 100);
    </script>";