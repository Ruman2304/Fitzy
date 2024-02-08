<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Blogs">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fitzy | Blog</title>

    <!-- Google Font -->
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
		function del_item(newurl)
		{
			if (confirm("Are you sure you want to delete this Post?"))
			{
				document.location = newurl;
			}
		}
	</script>
    
    <style>
        .crop-text-2 {
            -webkit-line-clamp: 2;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
        }

        .crop-text-3 {
            -webkit-line-clamp: 3;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
        }

        .blog-pagination .active_page{
            background: #f36100;
        }

        .latest-item .li-pic img{
            max-width: 105px;
            height: 70px;
        }
    </style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

<?php
    session_start();
    if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
        $role = $_SESSION['role'];
        if ($role == 'contributor') {
    include("header.php");
    include("connect.php");

    $limit = 5;
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }
    else{
        $page = 1;
    }
    $offset = ($page - 1) * $limit;
?>
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Your Posts</h2>
                        <div class="bt-option">
                            <a href="./index.php">Home</a>
                            <!-- <a href="#">Pages</a> -->
                            <span>Blog</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Begin -->
    <section class="blog-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 p-0 blog-t">
                <?php
                    $user_id = $_SESSION['userid'];
                    $sql = "SELECT * FROM `contributor` WHERE `User_Id` = '$user_id'";
                    $query = mysqli_query($conn, $sql);
                    $result = mysqli_fetch_array($query);
            
                    $Contributor_Id = $result['Contributor_Id'];

                    $sql = "SELECT * FROM `contributor_articles` WHERE `Contributor_Id` = '$Contributor_Id' ORDER BY Comment DESC LIMIT {$offset}, {$limit}";
                    $query = mysqli_query($conn, $sql);
                    if ($query) {
                        if(mysqli_num_rows($query)>0) {
                            while ($row = mysqli_fetch_row($query)) {
                                $Article_Id = $row[0];
                                $Contributor_Id = $row[1];
                                $Img_Title = $row[2];
                                $Title = $row[3];
                                $Content1 = $row[4];
                                $Date_Created = $row[9];
                                $Date_Created = DateTime::createFromFormat("Y-m-d", $Date_Created)->format("M, d, Y");
                                $cmnt = $row[18];
                                $query1 = mysqli_query($conn, "SELECT * FROM `fitzy_database`.`contributor` WHERE `Contributor_Id` = '$Contributor_Id'");
                                if($query1) {
                                    $result1 = mysqli_fetch_array($query1);
                                    $Author_Name = $result1['Author_Name'];
                                }
                        ?>
                        <div class="blog-item">
                            <div class="bi-pic">
                                <img src="<?php if(!empty($Img_Title)){ echo "data:image/jpg;charset=utf8;base64,".base64_encode($Img_Title);} else { echo "img/blog/blog-1.jpg";} ?>" alt="">
                            </div>
                            <div class="bi-text">
                                <div class="bi-widget">
                                    <a href="<?php echo "update_post.php?article=".$Article_Id; ?>"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:del_item('<?php echo "delete_post.php?article=".$Article_Id;?>');"><i class="fa fa-trash-o"></i></a>
                                </div>
                                <h5><a href="<?php echo "update_post.php?article=".$Article_Id;?>"><?php echo $Title;?></a></h5>
                                <ul>
                                    <li>by <?php echo $Author_Name;?></li>
                                    <li><?php echo $Date_Created;?></li>
                                    <li>
                                    <?php echo sprintf("%02d",$cmnt);?>
                                        Comment
                                    </li>
                                </ul>
                                <p class="crop-text-3"><?php echo nl2br($Content1);?></p>
                            </div>
                        </div>
                        <?php
                            }
                        }
                    }
                    
                    $sql2 = "SELECT * FROM `contributor_articles` WHERE `Contributor_Id` = '$Contributor_Id'";
                    $query2 = mysqli_query($conn, $sql2);
                    if (mysqli_num_rows($query2) > 0) {
                        
                        $total_records = mysqli_num_rows($query2);
                        $total_page = ceil($total_records / $limit);

                        echo '<div class="blog-pagination">';
                        if($page > 1){
                            echo '<a href="my_posts.php?page=' .($page - 1). '">Prev</a>';
                        }
                        for ($i = 1; $i <= $total_page; $i++){
                            if($i == $page){
                                $active = "active_page";
                            }
                            else{
                                $active = "";
                            }
                            ?><a class="<?php echo $active;?>" href="<?php echo 'my_posts.php?page='.$i;?>"><?php echo $i;?></a><?php
                        }
                        if($total_page > $page){
                            echo '<a href="my_posts.php?page=' .($page + 1). '">Next</a>';
                        }
                        echo '</div>';
                    }
                ?>

                </div>
                <div class="col-lg-4 col-md-8 p-0">
                    <div class="sidebar-option">
                        <div class="so-categories">
                            <h5 class="title">Categories</h5>
                            <ul>
                            <?php
                                $sql = "SELECT COUNT(Category), Category FROM `contributor_articles` GROUP BY Category ORDER BY COUNT(Category) DESC";
                                $query = mysqli_query($conn, $sql);
                                if ($query) {
                                    if(mysqli_num_rows($query)>0) {
                                        while ($row = mysqli_fetch_row($query)) {
                                            if($row[1] == "Yoga") {
                                                $Yoga = (int) $row[0];
                                            } elseif($row[1] == "Running") {
                                                $Running = (int) $row[0];
                                            } elseif($row[1] == "Weightloss") {
                                                $Weightloss = (int) $row[0];
                                            } elseif($row[1] == "Cardio") {
                                                $Cardio = (int) $row[0];
                                            } elseif($row[1] == "Body buiding") {
                                                $Bodybuiding = (int) $row[0];
                                            } elseif($row[1] == "Nutrition") {
                                                $Nutrition = (int) $row[0];
                                            } else {
                                                $Other = (int) $row[0];
                                            }
                                        }
                                    }
                                }
                            ?>
                                <li>
                                    <a href="blog.php?category=yoga">Yoga <span><?php if(isset($Yoga)){ echo $Yoga;} else { echo 0;}?></span></a>
                                </li>
                                <li>
                                    <a href="blog.php?category=running">Running <span><?php if(isset($Running)){ echo $Running;} else { echo 0;}?></span></a>
                                </li>
                                <li>
                                    <a href="blog.php?category=weightloss">Weightloss <span><?php if(isset($Weightloss)){ echo $Weightloss;} else { echo 0;}?></span></a>
                                </li>
                                <li>
                                    <a href="blog.php?category=cardio">Cardio <span><?php if(isset($Cardio)){ echo $Cardio;} else { echo 0;}?></span></a>
                                </li>
                                <li>
                                    <a href="blog.php?category=bodybuilding">Body buiding <span><?php if(isset($Bodybuiding)){ echo $Bodybuiding;} else { echo 0;}?></span></a>
                                </li>
                                <li>
                                    <a href="blog.php?category=nutrition">Nutrition <span><?php if(isset($Nutrition)){ echo $Nutrition;} else { echo 0;}?></span></a>
                                </li>
                                <li>
                                    <a href="blog.php?category=other">Other <span><?php if(isset($Other)){ echo $Other;} else { echo 0;}?></span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="so-latest">
                            <h5 class="title">Feature posts</h5>
                            <?php
                                $sql = "SELECT * FROM `contributor_articles` ORDER BY Comment DESC LIMIT 6";
                                $query = mysqli_query($conn, $sql);
                                if($query) {
                                    if(mysqli_num_rows($query)>0) {
                                        while ($row = mysqli_fetch_row($query)) {
                                            $Article_Id = $row[0];
                                            $Img_Title = $row[2];
                                            $Title = $row[3];
                                            $Date_Created = $row[9];
                                            $Date_Created = DateTime::createFromFormat("Y-m-d", $Date_Created)->format("M, d, Y");
                                            $cmnt = $row[18];
                            ?>
                            <div class="latest-item">
                                <div class="li-pic">
                                    <img src="<?php if(!empty($Img_Title)){ echo "data:image/jpg;charset=utf8;base64,".base64_encode($Img_Title);} else { echo "img/letest-blog/latest-2.jpg";} ?>" alt="">
                                </div>
                                <div class="li-text">
                                    <h6><a href="<?php echo "blog-details.php?article=".$Article_Id;?>"><?php echo $Title?></a></h6>
                                    <span class="li-time"><?php echo $Date_Created?></span>
                                </div>
                            </div>
                            <?php
                                        }
                                    }
                                }
                            ?>
        
                        <div class="so-tags">
                            <h5 class="title">Popular tags</h5>
                            <div class="tags-cont" style="background-color: #141414;">                                
                        <?php
                        $Keywords = "";
                        $sql = "SELECT * FROM `contributor_articles` ORDER BY Comment DESC";
                        $query = mysqli_query($conn, $sql);
                        if ($query) {
                            if(mysqli_num_rows($query)>0) {
                                while ($row = mysqli_fetch_row($query)) {
                                    $Keywords .= ",".$row[12];
                                }
                                $Keywords = explode(",",$Keywords);
                                if (is_array($Keywords)) {
                                    foreach ($Keywords as $key => $val) {
                                        $Keywords[$key] = trim($val);
                                    }
                                }
                                $Keywords = array_unique($Keywords); 
                                $Keywords = array_filter($Keywords);
                                if (is_array($Keywords)) {
                                    foreach ($Keywords as $key => $val) {
                                        ?><a href="<?php echo "blog.php?tag=".$val;?>"><?php echo $val;?></a><?php
                                    }
                                }
                            }
                        }
                        ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

    <?php
    include("footer.php");
        } else {
            echo '<b><script>if (swal("Error!", "You don\'t have permission to access this page!", "error")) {setTimeout(function () { window.location.href="./index.php"; }, 3000); }</script></b>';
        }
    } else {
        header("Location: ./login.php");
    }
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