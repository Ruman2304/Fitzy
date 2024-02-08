<?php
    include("connect.php");
    if(isset($_GET['url']) && isset($_GET['article']))
    {
        $url = $_GET['url'];
        $article_id = $_GET['article'];
        $sql = "UPDATE `contributor_articles` SET `Mail`=`Mail` + 1 WHERE `Article_Id` = '$article_id'";
        $query =  mysqli_query($conn, $sql);
        header('Location: mailto:?body=Check out this site '.$url);
    }
	else {
        header('Location: javascript:history.back(1)');
	}
?>