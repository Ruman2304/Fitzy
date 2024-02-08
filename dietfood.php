<!DOCTYPE html>
<?php
if (isset($_GET['category']) && ($_GET['category']==1 || $_GET['category']==2 || $_GET['category']==3)) {
    $category = $_GET['category'];
?>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gym Template">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fitzy | Dietfood</title>

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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        .crop-text-1 {
            -webkit-line-clamp: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
        }
        .wd-diet {
            height: 120px;
        }
        .crop-text-5 {
            -webkit-line-clamp: 5;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
        }
        .diet-text ul li {
            list-style: none;
            text-align: left;
            color: #a9a9a9;
        }
        .diet-text .tooltip-text ul li {
            list-style: none;
            text-align: left;
            color: #FFF;
        }
        .diet-title .tooltip-title,
        .diet-text .tooltip-text {
            visibility: hidden;
            width: 90%;
            max-width: 90%;
            background-color: #b5b5b5;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 7px;

            position: absolute;
            z-index: 1;
            /* bottom: 90%; */
            margin-bottom: 10px;
            left: 5%;
            margin-left: 0;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }
        .diet-title .tooltip-title {
            bottom: 90%;
        }
        .diet-text .tooltip-text {
            bottom: 65%;
        }
        .diet-title:hover .tooltip-title,
        .diet-text:hover .tooltip-text {
            visibility: visible;
        }

        .diet-title .tooltip-title:after,
        .diet-text .tooltip-text:after {
            position: absolute;
            left: 50%;
            margin-left: -10px;
            margin-top: 1px;
            top: 100%;
            height: 10px;
            width: 10px;
            background: #b5b5b5;
            content: "";
            -webkit-transform: rotate(45deg) translateY(-10px);
            -ms-transform: rotate(45deg) translateY(-10px);
            transform: rotate(45deg) translateY(-10px);
            z-index: -1;
        }
        .btn-primary {
            color: #fff;
            background-color: #f36100;
            border-color: #f36100;
        }
        .diet-pagination .active_page{
            background: #f36100;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    include("connect.php");
    $user_id = $_SESSION['userid'];
    $role = $_SESSION['role'];
    if ($role == 'customer' || $role == 'contributor'){
        $sql = "SELECT * FROM `customer` WHERE `User_Id` = '$user_id'";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            $result = mysqli_fetch_array($query);
            $customer_id = $result['Customer_Id'];
        }
    }
    
    if (isset($_GET['diet_id'])) {
        $diet_id = $_GET['diet_id'];
        $sql1 = "SELECT * FROM `dietfood_routine` WHERE `Customer_Id`='$customer_id' && `Dietfood_Id`='$diet_id'";
        $query1 = mysqli_query($conn, $sql1);
        if ($query1) {
            if(mysqli_num_rows($query1) > 0) {
                echo '<b><script>if (swal("Dietfood already exists in routine", "", "error")) {setTimeout(function () { window.location.href="dietfood.php?category='.$category.'"; }, 2000); }</script></b>';
            } else {
                $sql = "INSERT INTO `dietfood_routine`(`Dietfood_Routine_Id`, `Customer_Id`, `Dietfood_Id`) VALUES ('','$customer_id','$diet_id')";
                $query = mysqli_query($conn, $sql);
                echo '<b><script>if (swal("Dietfood added to routine", "", "success")) {setTimeout(function () { window.location.href="dietfood.php?category='.$category.'"; }, 2000); }</script></b>';
            }
        }
    }
?>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php
    include("header.php");
    $limit = 20;
    $lmt = 5;
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }
    else{
        $page = 1;
    }
    $offset = ($page - 1) * $limit;
    ?>
    
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/food-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Dietfood</h2>
                        <div class="bt-option">
                            <a href="./index.php">Home</a>
                            <span>Dietfood</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <section class="services-section spad">
        <div class="container">
            <div class="row">
        <?php
            $count = 0;
            $sql = "SELECT * FROM `dietfood` WHERE `Category_Id` = '$category' ORDER BY Food_Name LIMIT {$offset}, {$limit}";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                if(mysqli_num_rows($query)>0) {
                    while ($row = mysqli_fetch_array($query)) {
                        $Nutraints = "";
                        $Dietfood_Id = $row['Dietfood_Id'];
                        $Food_Name = $row['Food_Name'];
                        $Protein_g = $row['Protein_g'];
                        if(isset($Protein_g) && $Protein_g >= 12.00) {
                            $Nutraints .= "<li>Protein</li>";
                        }
                        $Glucose_g = $row['Glucose_g'];
                        if(isset($Glucose_g) && $Glucose_g >= 2.50) {
                            $Nutraints .= "<li>Glucose</li>";
                        }
                        $Sugar_g = $row['Sugar_g'];
                        if(isset($Sugar_g) && $Sugar_g >= 9.75) {
                            $Nutraints .= "<li>Sugar</li>";
                        }
                        $Starch_g = $row['Starch_g'];
                        if(isset($Starch_g) && $Starch_g >= 20.50) {
                            $Nutraints .= "<li>Starch</li>";
                        }
                        $Carbohydrate_g = $row['Carbohydrate_g'];
                        if(isset($Carbohydrate_g) && $Carbohydrate_g >= 20.50) {
                            $Nutraints .= "<li>Carbohydrate</li>";
                        }
                        $Acetic_acid_g = $row['Acetic_acid_g'];
                        if(isset($Acetic_acid_g) && $Acetic_acid_g >= 0.45) {
                            $Nutraints .= "<li>Acetic acid</li>";
                        }
                        $Citric_acid_g = $row['Citric_acid_g'];
                        if(isset($Citric_acid_g) && $Citric_acid_g >= 0.40) {
                            $Nutraints .= "<li>Citric acid</li>";
                        }
                        $Lactic_acid_g = $row['Lactic_acid_g'];
                        if(isset($Lactic_acid_g) && $Lactic_acid_g >= 0.73) {
                            $Nutraints .= "<li>Lactic acid</li>";
                        }
                        $Calcium_Ca_mg = $row['Calcium_Ca_mg'];
                        if(isset($Calcium_Ca_mg) && $Calcium_Ca_mg >= 52.50) {
                            $Nutraints .= "<li>Calcium</li>";
                        }
                        $Copper_Cu_mg = $row['Copper_Cu_mg'];
                        if(isset($Copper_Cu_mg) && $Copper_Cu_mg >= 0.15) {
                            $Nutraints .= "<li>Copper</li>";
                        }
                        $Iron_Fe_mg = $row['Iron_Fe_mg'];
                        if(isset($Iron_Fe_mg) && $Iron_Fe_mg >= 2.00) {
                            $Nutraints .= "<li>Iron</li>";
                        }
                        $Magnesium_Mg_mg = $row['Magnesium_Mg_mg'];
                        if(isset($Magnesium_Mg_mg) && $Magnesium_Mg_mg >= 35.50) {
                            $Nutraints .= "<li>Magnesium</li>";
                        }
                        $Phosphorus_P_mg = $row['Phosphorus_P_mg'];
                        if(isset($Phosphorus_P_mg) && $Phosphorus_P_mg >= 165.50) {
                            $Nutraints .= "<li>Phosphorus</li>";
                        }
                        $Vitamin_A_ug = $row['Vitamin_A_ug'];
                        if(isset($Vitamin_A_ug) && $Vitamin_A_ug >= 2.50) {
                            $Nutraints .= "<li>Vitamin A</li>";
                        }
                        $Vitamin_B1_mg = $row['Vitamin_B1_mg'];
                        if(isset($Vitamin_B1_mg) && $Vitamin_B1_mg >= 130.00) {
                            $Nutraints .= "<li>Vitamin B1</li>";
                        }
                        $Vitamin_B2_mg = $row['Vitamin_B2_mg'];
                        if(isset($Vitamin_B2_mg) && $Vitamin_B2_mg >= 0.172) {
                            $Nutraints .= "<li>Vitamin B2</li>";
                        }
                        $Vitamin_B3_mg = $row['Vitamin_B3_mg'];
                        if(isset($Vitamin_B3_mg) && $Vitamin_B3_mg >= 3.45) {
                            $Nutraints .= "<li>Vitamin B3</li>";
                        }
                        $Vitamin_B5_mg = $row['Vitamin_B5_mg'];
                        if(isset($Vitamin_B5_mg) && $Vitamin_B5_mg >= 0.58) {
                            $Nutraints .= "<li>Vitamin B5</li>";
                        }
                        $Vitamin_B6_mg = $row['Vitamin_B6_mg'];
                        if(isset($Vitamin_B6_mg) && $Vitamin_B6_mg >= 0.20) {
                            $Nutraints .= "<li>Vitamin B6</li>";
                        }
                        $Vitamin_B7_ug = $row['Vitamin_B7_ug'];
                        if(isset($Vitamin_B7_ug) && $Vitamin_B7_ug >= 6.70) {
                            $Nutraints .= "<li>Vitamin B7</li>";
                        }
                        $Vitamin_B12_ug = $row['Vitamin_B12_ug'];
                        if(isset($Vitamin_B12_ug) && $Vitamin_B12_ug >= 1.56) {
                            $Nutraints .= "<li>Vitamin B12</li>";
                        }
                        $Vitamin_C_mg = $row['Vitamin_C_mg'];
                        if(isset($Vitamin_C_mg) && $Vitamin_C_mg >= 18.50) {
                            $Nutraints .= "<li>Vitamin C</li>";
                        }
                        $Vitamin_D3_ug = $row['Vitamin_D3_ug'];
                        if(isset($Vitamin_D3_ug) && $Vitamin_D3_ug >= 1.00) {
                            $Nutraints .= "<li>Vitamin D3</li>";
                        }
                        $Vitamin_E_mg = $row['Vitamin_E_mg'];
                        if(isset($Vitamin_E_mg) && $Vitamin_E_mg >= 1.65) {
                            $Nutraints .= "<li>Vitamin E</li>";
                        }
                        $Cholesterol_mg = $row['Cholesterol_mg'];
                        if(isset($Cholesterol_mg) && $Cholesterol_mg >= 76.18) {
                            $Nutraints .= "<li>Cholesterol</li>";
                        }
                ?>
                <div class="col-lg-3" style="margin-bottom: 30px;">
                    <center>
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="diet-title">
                                    <h5 class="card-title crop-text-1"><?php echo $Food_Name;?></h5>
                                    <span class="tooltip-title"><?php echo $Food_Name;?></span>
                                </div>
                                <p class="card-text text-left md-diet">
                                    <div class="diet-text wd-diet">
                                        <ul class="crop-text-5">
                                            <?php echo $Nutraints;?>
                                        </ul>
                                        <span class="tooltip-text">
                                            <ul>
                                                <?php echo $Nutraints;?>
                                            </ul>
                                        </span>
                                    </div>
                                </p>
                                <?php
                                if ($role == 'customer' || $role == 'contributor'){
                                    $sql1 = "SELECT * FROM `membership` WHERE `Customer_Id`='$customer_id' && Status='1'";
                                    $query1 = mysqli_query($conn, $sql1);
                                    if ($query1) {
                                        if(mysqli_num_rows($query1) > 0) {
                                            ?><a href="./dietfood.php?diet_id=<?= $Dietfood_Id ?>&category=<?= $category ?>" class="btn btn-primary">Add to routine</a><?php
                                        }
                                    }
                                }
                                ?>
                                
                            </div>
                        </div>
                    </center>
                </div>
                <?php
                    }
                }
            }
            ?>
            </div>
        <?php
            $sql2 = "SELECT * FROM `dietfood` WHERE `Category_Id` = '$category'";
            $query2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($query2) > 0) {
                
                $total_records = mysqli_num_rows($query2);
                $total_page = ceil($total_records / $limit);

                echo '<div class="diet-pagination">';
                if($page > 1){
                    echo '<a href="dietfood.php?category='.$category.'&page=' .($page - 1). '">Prev</a>';
                }

                if ($total_page >=1 && $page <= $total_page)
                {
                    $counter = 1;
                    $link = "";
                    if ($page > ($lmt/2)) {
                        if(1 == $page){
                            $active = "active_page";
                        }
                        else{
                            $active = "";
                        }
                        echo "<a class='$active' href='dietfood.php?category=".$category."&page=1'>1</a> <a>. . .</a>";
                    }
                    for ($x=$page; $x<=$total_page;$x++)
                    {
                        if($x == $page){
                            $active = "active_page";
                        }
                        else{
                            $active = "";
                        }
                        if($counter < $lmt)
                            $link .= "<a class='$active' href='dietfood.php?category=".$category."&page=" .$x."'>".$x." </a>";

                        $counter++;
                    }
                    if ($page < $total_page - ($lmt/2)) {
                        if($total_page == $page){
                            $active = "active_page";
                        }
                        else{
                            $active = "";
                        }
                        $link .= "<a>. . .</a> <a class='$active' href='dietfood.php?category=".$category."&page=" .$total_page."'>".$total_page." </a>";
                    }
                }
                echo $link;

                if($total_page > $page){
                    echo '<a href="dietfood.php?category='.$category.'&page=' .($page + 1). '">Next</a>';
                }
                echo '</div>';
            }
        ?>
        </div>
    </section>

    <?php
    include("footer.php");
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

<?php
} else {
    header('Location: index.php');
}
?>