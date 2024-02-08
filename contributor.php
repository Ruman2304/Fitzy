<?php
    include("connect.php");
    session_start();
    if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
        $role = $_SESSION['role'];
        $user_id = $_SESSION['userid'];
        if ($role == 'customer') {
            $sql = "SELECT * FROM `customer` WHERE `User_Id`='$user_id'";
            $query = mysqli_query($conn, $sql);
            if($query) {
                $row = mysqli_fetch_array($query);
                $customer_id = $row['Customer_Id'];
                $author_name = $row['Name'];
                $photo = addslashes($row['Photo']);

                $sql1 = "SELECT * FROM `membership` WHERE `Customer_Id`='$customer_id' && Status='1'";
                $query1 = mysqli_query($conn, $sql1);
                if ($query1) {
                    if(mysqli_num_rows($query1) > 0) {
                        $sql2 = "UPDATE `user_master` SET `Role`='contributor' WHERE `User_Id`='$user_id'";
                        $query2 = mysqli_query($conn, $sql2);
                        
                        $sql3 = "SELECT * FROM `contributor` WHERE User_Id='$user_id'";
                        $query3 = mysqli_query($conn, $sql3);
                        if(!mysqli_num_rows($query3) > 0) {
                            $sql4 = "INSERT INTO `contributor`(`Contributor_Id`, `Author_Name`, `About_Author`, `Photo`, `Facebook`, `Twitter`, `Github`, `Instagram`, `Youtube`, `User_Id`, `Customer_Id`) VALUES ('','$author_name','','$photo','','','','','','$user_id','$customer_id')";
                            $query4 = mysqli_query($conn, $sql4);
                        } else {
                            $query4 = true;
                        }
                        if($query2 && $query4){
                            $_SESSION['role'] = 'contributor';
                            header("Location: ./index.php");
                        }
                    }
                }
            }
        } else {
            header("Location: ./index.php");
        }
    } else {
        header("Location: ./login.php");
    }
?>