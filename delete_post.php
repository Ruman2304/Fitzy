<?php
    include("connect.php");
    session_start();
    if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
        $role = $_SESSION['role'];
        $user_id = $_SESSION['userid'];
        if ($role == 'contributor') {
            if (isset($_GET['article'])) {
                $article_id = $_GET['article'];
                $sql = "SELECT * FROM `contributor` WHERE `User_Id` = '$user_id'";
                $query = mysqli_query($conn, $sql);
                $result = mysqli_fetch_array($query);
                $Contributor_Id = $result['Contributor_Id'];

                $sql1 = "DELETE FROM `contributor_articles` WHERE `Contributor_Id` = '$Contributor_Id' && `Article_Id` = '$article_id'";
                $query1 = mysqli_query($conn, $sql1);
                if ($query1) {
                    header("Location: my_posts.php?action=post_deleted");
                } else {
                    echo "Error in deleting data: " . mysqli_error($conn);
                }
            } else {
                echo '<script type="text/javascript"> window.location.href = "./index.php"; </script>';
            }
        } else {
            echo '<b><script>if (swal("Error!", "You don\'t have permission to access this page!", "error")) {setTimeout(function () { window.location.href="./index.php"; }, 3000); }</script></b>';
        }
    } else {
        echo '<script type="text/javascript"> window.location.href = "./login.php"; </script>';
    }
?>