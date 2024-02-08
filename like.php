<?php
    include("connect.php");
    if(isset($_GET['comment']) && isset($_GET['article']) && isset($_GET['user']))
    {
        $comment = $_GET['comment'];
        $article_id = $_GET['article'];
        $user_id = $_GET['user'];

        $query = mysqli_query($conn, "SELECT * FROM `fitzy_database`.`comment` WHERE `Comment_Id`='$comment'");
        if($query)
        {
            $row = mysqli_fetch_row($query);
            $str = $row[9].",".$user_id;
            $sql = "UPDATE `comment` SET `Count`='$str', `Likes` = `Likes` + 1 WHERE `Comment_Id`='$comment'";
            $query =  mysqli_query($conn, $sql);
        }
        header('Location: blog-details.php?article='.$article_id);
    }
	else {
        header('Location: javascript:history.back(1)');
	}
?>