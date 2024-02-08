<?php
include "connect.php";
if (!isset($_SESSION)) {
    session_start();
}
$url = $_SERVER['REQUEST_URI'];
$url = explode('/', $url);
$url = end($url);
$url = substr($url, 0, strpos($url, "."));
if ($url == '') {
    $ind = "active";
} elseif ($url == 'index') {
    $ind = "active";
} elseif ($url == 'activities') {
    $act = "active";
} elseif ($url == 'diet') {
    $dt = "active";
} elseif ($url == 'dietfood') {
    $dt = "active";
} elseif ($url == 'blog') {
    $bg = "active";
} elseif ($url == 'blog-details') {
    $bg = "active";
} elseif ($url == 'add_blog') {
    $bg = "active";
} elseif ($url == 'my_posts') {
    $bg = "active";
} elseif ($url == 'update_post') {
    $bg = "active";
} elseif ($url == 'dashboard') {
    $dash = "active";
} else {
    $ot = "active";
}
?>

<!-- Offcanvas Menu Section Begin -->

<div class="offcanvas-menu-overlay"></div>
<div class="offcanvas-menu-wrapper">
    <div class="canvas-close">
        <i class="fa fa-close"></i>
    </div>
    <div class="canvas-search search-switch">
        <i class="fa fa-search"></i>
    </div>
    <nav class="canvas-menu mobile-menu">
        <ul>
            <li><a href="">Account</a>
                <ul class="dropdown">
                    <?php
                    if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
                        $role = $_SESSION['role'];
                    ?>
                        <li><a href="./user_profile.php">My Profile</a></li>
                        <?php
                        if ($role == 'customer' || $role == 'contributor') {
                        $user_id = $_SESSION['userid'];
                        $sql = "SELECT Customer_Id FROM `customer` WHERE `User_Id`='$user_id'";
                        $query = mysqli_query($conn, $sql);
                        if($query) {
                            $row = mysqli_fetch_array($query);
                            $customer_id = $row['Customer_Id'];

                            $sql1 = "SELECT * FROM `membership` WHERE `Customer_Id`='$customer_id' && Status='1'";
                            $query1 = mysqli_query($conn, $sql1);
                            if ($query1) {
                                if(mysqli_num_rows($query1) > 0) {
                                    ?><li><a href="./diet_routine.php">My Routine</a></li><?php
                                    if ($role == 'customer'){
                                        ?><li><a href="./contributor.php">Became Author</a></li><?php
                                    }
                                }
                            }
                        }
                        ?>
                        
                        <?php
                        if ($role == 'contributor') {
                            ?><li><a href="./my_posts.php">My Posts</a></li><?php
                        ?><li><a href="./add_blog.php">Add Post</a></li><?php } }?>
                        <li><a href="./logout.php">Logout</a></li>
                        <?php
                    } else {
                        ?>
                        <li><a href="./signup.php">Signup</a></li>
                        <li><a href="./login.php">Login</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </li>
            <li class="<?php if (isset($ind)) { echo $ind; }?>"><a href="./index.php">Home</a></li>
            <li class="<?php if (isset($act)) { echo $act; }?>"><a href="./activities.php">Activities</a></li>
            <li class="<?php if (isset($dt)) { echo $dt; }?>"><a href="./diet.php">Diet</a></li>
            <li class="<?php if (isset($bg)) { echo $bg; }?>"><a href="./blog.php">Blog</a></li>
            <li class="<?php if (isset($dash)) { echo $dash; }?>"><a href="./gym/index.php">Dashboard</a></li>
            <li class="<?php if (isset($ot)) { echo $ot; }?>"><a href="">Other</a>
                <ul class="dropdown">
                    <li><a href="./bmi-calculator.php">BMI Calculator</a></li>
                    <li><a href="./about-us.php">About us</a></li>
                    <li><a href="./contact.php">Contact Us</a></li>
                    <li><a href="./feedback.php">Feedback</a></li>
                    <li><a href="./team.php">Our Team</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="canvas-social">
        <a href="https://www.facebook.com/profile.php?id=100078396220073"><i class="fa fa-facebook"></i></a>
        <a href="https://twitter.com/FitzySupport"><i class="fa fa-twitter"></i></a>
        <a href="https://www.youtube.com/channel/UCFS0WHqHg7ywpDoP4TJD5OA"><i class="fa fa-youtube-play"></i></a>
        <a href="https://www.instagram.com/fitzy_support/"><i class="fa fa-instagram"></i></a>
        <a href="mailto:help.fitzy@gmail.com"><i class="fa  fa-envelope-o"></i></a>
    </div>
</div>
<!-- Offcanvas Menu Section End -->

<!-- Header Section Begin -->
<header class="header-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <div class="logo">
                    <a href="./index.php">
                        <img src="img/logo.png" width="160px" alt="">
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="nav-menu">
                    <ul>
                        <li class="<?php if (isset($ind)) { echo $ind; }?>"><a href="./index.php">Home</a></li>
                        <li class="<?php if (isset($act)) { echo $act; }?>"><a href="./activities.php">Activities</a></li>
                        <li class="<?php if (isset($dt)) { echo $dt; }?>"><a href="./diet.php">Diet</a></li>
                        <li class="<?php if (isset($bg)) { echo $bg; }?>"><a href="./blog.php">Blog</a></li>
                        <li class="<?php if (isset($dash)) { echo $dash; }?>"><a href="./gym/index.php">Dashboard</a></li>
                        <li class="<?php if (isset($ot)) { echo $ot; }?>"><a href="">Other</a>
                            <ul class="dropdown">
                                <li><a href="./bmi-calculator.php">BMI Calculator</a></li>
                                <li><a href="./about-us.php">About us</a></li>
                                <li><a href="./contact.php">Contact Us</a></li>
                                <li><a href="./feedback.php">Feedback</a></li>
                                <li><a href="./team.php">Our Team</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>

            <?php
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $role = $_SESSION['role'];
    $user_id = $_SESSION['userid'];

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

    $sql = "SELECT * FROM $table WHERE `User_Id` = '$user_id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $profile = $row['Photo'];
                if ($role == 'customer' || $role == 'contributor'){
                    $c_id = $row['Customer_Id'];
                }
                ?>
                            <div class="col-lg-3">
                                <div class="top-option">
                                    <div class="to-search search-switch">
                                        <i class="fa fa-search"></i>
                                    </div>
                                    <div class="action">
                                        <div class="profile" onclick="menuToggle();">
                                            <img src="<?php if (!empty($profile)) {echo "data:image/jpg;charset=utf8;base64," . base64_encode($profile);} else {echo "img/profile.png";}?>" alt="">
                                        </div>
                                        <div class="menu">
                                            <ul>
                                                <li><img src="img/l_icons/profile.png"><a href="./user_profile.php">My Profile</a></li>
                                            <?php
                                            if ($role == 'customer' || $role == 'contributor') {
                                            $user_id = $_SESSION['userid'];
                                            $sql = "SELECT Customer_Id FROM `customer` WHERE `User_Id`='$user_id'";
                                            $query = mysqli_query($conn, $sql);
                                            if($query) {
                                                $row = mysqli_fetch_array($query);
                                                $customer_id = $row['Customer_Id'];

                                                $sql1 = "SELECT * FROM `membership` WHERE `Customer_Id`='$customer_id' && Status='1'";
                                                $query1 = mysqli_query($conn, $sql1);
                                                if ($query1) {
                                                    if(mysqli_num_rows($query1) > 0) {
                                                        ?><li><img src="img/l_icons/clock.png"><a href="./diet_routine.php">My Routine</a></li><?php
                                                        if ($role == 'customer'){
                                                            ?><li><img src="img/l_icons/donation.png"><a href="./contributor.php">Became Author</a></li><?php
                                                        }
                                                    }
                                                }
                                            }
                                            if ($role == 'contributor') {
                                                ?><li><img src="img/l_icons/file.png"><a href="./my_posts.php">My Posts</a></li><?php
                                            ?><li><img src="img/l_icons/add.png"><a href="./add_blog.php">Add Post</a></li><?php } }?>
                                                <!-- <li><img src="img/l_icons/help.png"><a href="#">Help</a></li> -->
                                                <li><img src="img/l_icons/logout.png"><a href="./logout.php">Logout</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php
}
        }
    }
} else {
    ?>
                <div class="col-lg-3">
                    <div class="top-option">
                        <div class="to-search search-switch">
                            <i class="fa fa-search"></i>
                        </div>
                        <div class="action">
                            <div class="profile" onclick="menuToggle();">
                                <img src="img/profile.png" alt="">
                            </div>
                            <div class="menu">
                                <!-- <h3>Someone famous<br><span>website designer</span></h3> -->
                                <ul>
                                    <li><img src="img/l_icons/add-user.png"><a href="./signup.php">Signup</a></li>
                                    <li><img src="img/l_icons/login.png"><a href="./login.php">Login</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
}
?>

        </div>
        <div class="canvas-open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header End -->

<!-- Profile Dropdown Begin -->
<script>
    function menuToggle() {
        const toggleMenu = document.querySelector('.menu');
        toggleMenu.classList.toggle('active')
    }
</script>
<!-- Profile Dropdown End -->

<!-- Search model Begin -->
<div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch">+</div>
        <form class="search-model-form" method="POST">
            <input type="text" name="search" id="search-input" placeholder="Search here.....">
        </form>
    </div>
</div>
<!-- Search model end -->
<?php
    if(isset($_POST['search'])){
        $search = $_POST['search'];
        echo '<script type="text/javascript"> window.location.href = "./blog.php?search='.$search.'"; </script>';
    }
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).on('click', '.nav-menu ul li', function() {
        $(this).addClass('active').siblings().removeClass('active')
    })
</script>

<script type="text/javascript">
    function del_acc(newurl) {
        if (confirm("Are you sure you want to delete your account?")) {
            document.location = newurl;
        }
    }
</script>