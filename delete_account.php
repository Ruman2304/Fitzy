<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    include("connect.php");
    $role = $_SESSION['role'];
    $user_id = $_SESSION['userid'];

    $query = mysqli_query($conn, "UPDATE `user_master` SET `Active`='0' WHERE `User_Id` = '$user_id'");

    if($role == 'customer' || $role == 'contributor'){
        $sql1 = "SELECT * FROM `customer` WHERE `User_Id` = '$user_id'";
        $query1 = mysqli_query($conn, $sql1);
        if (mysqli_num_rows($query1) > 0) {
            $result1 = mysqli_fetch_array($query1);
            $c_id = $result1['Customer_Id'];
            $sql2 = "SELECT * FROM `membership` WHERE Customer_Id='$c_id' && Status=1";
            $query2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($query2) > 0) {
                $query3 = mysqli_query($conn, "DELETE FROM `membership` WHERE Customer_Id='$c_id'");
            }
        }
    } else {
        $query1 = true;
    }
    if ($query && $query1) {
        session_unset();
        session_destroy();
        header("Location: index.php?action=account_deleted");
    } else {
        echo "Error in deleting data: " . mysqli_error($conn);
    }
    
} else {
    echo '<script type="text/javascript"> window.location.href = "./login.php"; </script>';
}
?>