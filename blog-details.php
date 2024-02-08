<!DOCTYPE html>
<?php
session_start();
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $url1 = "https://";
} else {
    $url1 = "http://";
}
$url1 .= $_SERVER['HTTP_HOST'];
$url1 .= $_SERVER['REQUEST_URI'];


if (isset($_GET['article'])) {
    $article_id = $_GET['article'];
?>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Gym Template">
        <meta name="keywords" content="Gym, unica, creative, html">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Fitzy | Blog Post</title>

        <!-- Google Font -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

        <!-- Css Styles -->
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="css/flaticon.css" type="text/css">
        <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
        <link rel="stylesheet" href="css/barfiller.css" type="text/css">
        <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
        <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <link rel="shortcut icon" type="image/png" href="./favicon.png">

    </head>

    <body>
        <!-- Page Preloder -->
        <div id="preloder">
            <div class="loader"></div>
        </div>
        <?php
    if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
        include("header.php");
        include("connect.php");
        // $article_id = '1';
        $user_id = $_SESSION['userid'];
        $sql = "SELECT * FROM `contributor_articles` WHERE Article_Id = '$article_id'";
        $query = mysqli_query($conn, $sql);

        if ($query) {
            $result = mysqli_fetch_array($query);

            $Article_Id = $result['Article_Id'];
            $Contributor_Id = $result['Contributor_Id'];
            $Img_Title = $result['Img_Title'];
            $Title = $result['Title'];
            $Content1 = $result['Content1'];
            $Img1 = $result['Img1'];
            $Img2 = $result['Img2'];
            $Sentence = $result['Sentence'];
            $Content2 = $result['Content2'];
            $Date_Created = $result['Date_Created'];
            $Date_Created = DateTime::createFromFormat("Y-m-d", $Date_Created)->format("M, d, Y");
            $Keywords = explode(",", $result['Keywords']);
            $FaceBook = $result['FaceBook'];
            $Twitter1 = $result['Twitter'];
            $Mail = $result['Mail'];
            $cmnt = $result['Comment'];

            $query1 = mysqli_query($conn, "SELECT * FROM `fitzy_database`.`contributor` WHERE `Contributor_Id` = '$Contributor_Id'");
            if ($query1) {
                $result1 = mysqli_fetch_array($query1);
                $Author_Name = $result1['Author_Name'];
                $About_Author = $result1['About_Author'];
                $F_Book = $result1['Facebook'];
                $Twitter = $result1['Twitter'];
                $Github = $result1['Github'];
                $Instagram = $result1['Instagram'];
                $Youtube = $result1['Youtube'];
                $Photo = $result1['Photo'];
            }
        }
        if (isset($_POST['submit'])) {
            $query = mysqli_query($conn, "SELECT * FROM `fitzy_database`.`comment` WHERE `Article_Id`='$article_id' && `User_Id`='$user_id'");
            if (mysqli_num_rows($query) != 1) {

                $role = $_SESSION['role'];

                switch ($role) {
                    case "trainer":
                        $table = "trainer";
                        break;
                    case "dietician":
                        $table = "dietician";
                        break;
                    case "contributor":
                        $table = "customer";
                        break;
                    case "admin":
                        $table = "admin";
                        break;
                    default:
                        $table = "customer";
                }

                $sql1 = "SELECT `Photo` FROM $table WHERE `User_Id` = '$user_id'";
                $query1 = mysqli_query($conn, $sql1);
                if ($query1) {
                    $result1 = mysqli_fetch_array($query1);
                    $photo1 = addslashes($result1[0]);
                } else {
                    $photo1 = addslashes(file_get_contents('img/l_icons/user.jpg'));
                }

                if ($_POST['name'] != "") {
                    $name = $_POST['name'];
                } else {
                    $name = 'Aayush Makwana';
                }
                if ($_POST['email'] != "") {
                    $email = $_POST['email'];
                } else {
                    $email = 'abc@gmail.com';
                }
                $website = $_POST['website'];
                $comment = $_POST['comment'];

                $sql2 = "INSERT INTO `comment`(`Comment_Id`, `Article_Id`, `User_Id`, `Name`, `Likes`, `Email_Id`, `Website`, `Message`, `Photo`, `Count`) VALUES (NULL,'$article_id','$user_id','$name', '0','$email','$website','$comment','$photo1','0')";
                // echo $sql2;
                $query2 = mysqli_query($conn, $sql2);

                $sql3 = "UPDATE `contributor_articles` SET `Comment` = `Comment` + 1 WHERE Article_Id = '$article_id'";
                // echo $sql3;
                $query3 = mysqli_query($conn, $sql3);

                if ($query2 && $query3) {
                    echo "<b><script>swal('', 'You have commented this post', 'success');</script></b>";
                } else {
                    echo "<b><script>swal('Something Went Wrong!', 'Please Try Again Leter', 'error');</script></b>";
                }
            } else {
                echo "<b><script>swal('', 'You have already commented this post', 'error');</script></b>";
            }
        }
        ?>
        <!-- Blog Details Hero Section Begin -->

        <section class="blog-details-hero set-bg" data-setbg="<?php if (!empty($Img_Title)) {echo "data:image/jpg;charset=utf8;base64," . base64_encode($Img_Title);} else {echo "img/blog/details/hero.jpg";} ?>">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 p-0 m-auto">
                        <div class="bh-text">
                            <h3><?php echo $Title; ?></h3>
                            <ul>
                                <li>by <?php echo $Author_Name; ?></li>
                                <li><?php echo $Date_Created; ?></li>
                                <li>
                                    <?php echo sprintf("%02d", $cmnt); ?>
                                    Comment
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Blog Details Hero Section End -->

        <!-- Blog Details Section Begin -->
        <section class="blog-details-section spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 p-0 m-auto">
                        <div class="blog-details-text">
                            <div class="blog-details-title">
                                <p>
                                    <?php echo nl2br($Content1); ?>
                                </p>
                            </div>
                            <div class="blog-details-pic">
                                <div class="blog-details-pic-item">
                                    <img src="<?php if (!empty($Img1)) {echo "data:image/jpg;charset=utf8;base64," . base64_encode($Img1);} else {echo "img/blog/details/details-1.jpg";} ?>" alt="">
                                </div>
                                <div class="blog-details-pic-item">
                                    <img src="<?php if (!empty($Img2)) {echo "data:image/jpg;charset=utf8;base64," . base64_encode($Img2);} else {echo "img/blog/details/details-2.jpg";} ?>" alt="">
                                </div>
                            </div>
                            <div class="blog-details-quote">
                                <div class="quote-icon">
                                    <img src="img/blog/details/quote-left.png" alt="">
                                </div>
                                <h5><?php echo $Sentence; ?></h5>
                            </div>
                            <div class="blog-details-desc">
                                <p>
                                    <?php echo nl2br($Content2); ?>
                                </p>
                            </div>
                            <div class="blog-details-tag-share">
                                <div class="tags">
                                    <?php foreach ($Keywords as $value) { ?> <a href="<?php echo "blog.php?tag=".$value;?>"><?php echo $value; ?></a><?php } ?>
                                </div>
                                <div class="share">
                                    <span>Share </span>
                                    <a href="facebook.php?url=<?php echo "https://www.facebook.com/sharer/sharer.php?u=" . $url1; ?>&article=<?php echo $article_id; ?>" target="_blank"><i class="fa fa-facebook"></i> <?php echo sprintf("%02d", $FaceBook) ?></a>
                                    <a href="twitter.php?url=<?php echo "https://twitter.com/intent/tweet?url=" . $url1; ?>&article=<?php echo $article_id; ?>" target="_blank"><i class="fa fa-twitter"></i> <?php echo sprintf("%02d", $Twitter1); ?></a>
                                    <a href="mail.php?url=<?php echo $url1; ?>&article=<?php echo $article_id; ?>" target="_blank"><i class="fa fa-envelope"></i> <?php echo sprintf("%02d", $Mail) ?></a>
                                </div>
                            </div>
                            <div class="blog-details-author">
                                <div class="ba-pic">
                                    <img src="<?php if (!empty($Photo)) {echo "data:image/jpg;charset=utf8;base64," . base64_encode($Photo);} else {echo "img/blog/details/details-1.jpg";} ?>" alt="">
                                </div>
                                <div class="ba-text">
                                    <h5><?php echo $Author_Name; ?></h5>
                                    <p><?php echo nl2br($About_Author); ?></p>
                                    <div class="bp-social">
                                        <a href="<?php echo "https://www.facebook.com/".$F_Book; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                                        <a href="<?php echo "https://twitter.com/".$Twitter; ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                                        <a href="<?php echo "https://github.com/".$Github; ?>" target="_blank"><i class="fa fa-github"></i></a>
                                        <a href="<?php echo "https://www.instagram.com/".$Instagram; ?>" target="_blank"><i class="fa fa-instagram"></i></a>
                                        <a href="<?php echo "https://www.youtube.com/".$Youtube; ?>" target="_blank"><i class="fa fa-youtube-play"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="comment-option">
                                        <h5 class="co-title">Comment</h5>
                                        <div class="comment-cont" style="background-color: #141414;">
                                            <?php
                                            $query1 = mysqli_query($conn, "SELECT * FROM `fitzy_database`.`comment` WHERE Article_Id = '$article_id '");
                                            if ($query1) {
                                                while ($row = mysqli_fetch_row($query1)) {
                                                    $count = explode(",", $row[9]);
                                            ?>
                                                    <div class="co-item">
                                                        <div class="co-widget">
                                                            <?php
                                                            if (in_array($user_id, $count)) {
                                                            ?><a href="unlike.php?comment=<?php echo $row[0]; ?>&article=<?php echo $article_id; ?>&user=<?php echo $user_id; ?>"><i class="fa fa-heart"></i><?php } else { ?><a href="like.php?comment=<?php echo $row[0]; ?>&article=<?php echo $article_id; ?>&user=<?php echo $user_id; ?>"><i class="fa fa-heart-o"></i><?php } ?>
                                                            <?php echo sprintf("%02d", $row[4]) ?></a>
                                                        </div>
                                                        <div class="co-pic">
                                                            <img src="<?php if (!empty($row[8])) {echo "data:image/jpg;charset=utf8;base64," . base64_encode($row[8]);} else {echo "img/l_icons/user.jpg";} ?>" alt="<?php echo $row[3] ?>">
                                                            <h5><?php echo $row[3] ?></h5>
                                                        </div>
                                                        <div class="co-text">
                                                            <p><?php echo $row[7] ?></p>
                                                        </div>
                                                    </div>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="leave-comment">
                                        <h5>Leave a comment</h5>
                                        <form method="POST">
                                            <input type="text" name="name" placeholder="Name" maxlength="25">
                                            <input type="email" name="email" maxlength="100" placeholder="Email">
                                            <input type="url" name="website" placeholder="Website">
                                            <textarea placeholder="Comment" name="comment" maxlength="95" required></textarea>
                                            <button type="submit" name="submit">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Blog Details Section End -->

        <?php
        include("footer.php");
        ?>

        <!-- Js Plugins -->
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.magnific-popup.min.js"></script>
        <script src="js/masonry.pkgd.min.js"></script>
        <script src="js/jquery.barfiller.js"></script>
        <script src="js/jquery.slicknav.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/main.js"></script>

    </body>

    </html>
<?php
    } else {
        header('Location: login.php');
    }
} else {
    header('Location: index.php');
}

?>