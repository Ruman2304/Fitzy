<?php
    include("connect.php");
    session_start();
    if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
        $role = $_SESSION['role'];
        $user_id = $_SESSION['userid'];
        if ($role == 'contributor' || $role == 'admin') {
            if (isset($_GET['article'])) {
                $article_id = $_GET['article'];
                $sql = "SELECT * FROM `contributor` WHERE `User_Id` = '$user_id'";
                $query = mysqli_query($conn, $sql);
                $result = mysqli_fetch_array($query);
                $Contributor_Id = $result['Contributor_Id'];
                
                $sql1 = "SELECT * FROM `contributor_articles` WHERE `Article_Id` = '$article_id'";
                $query1 = mysqli_query($conn, $sql1);
                $result1 = mysqli_fetch_array($query1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitzy | Update Post</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

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


    <style>
        body {
            background-color: #000;
        }

        #title,
        #quote,
        #remark,
        #keywords,
        #cate {
            height: 65px;
        }

        .title_img {
            height: 150px;
            border: 1px solid #FFF;
            font-size: 25px;
            text-align: center;
            border-radius: 5px;
            vertical-align: middle;
            background-color: #151515;
            margin-bottom: 25px;
        }
        
        .title {
            margin-top: 150px;
            color: white;
            font-size: 50px;
        }
        
        .img1 {
            display: inline-block;
            width: 48.2%;
            margin: 0px 1.6% 0 0%;
            height: 300px;
            border: 1px solid #FFF;
            font-size: 25px;
            text-align: center;
            border-radius: 5px;
            vertical-align: middle;
            background-color: #151515;
            margin-bottom: 25px;
        }
        
        .img2 {
            display: inline-block;
            width: 48.2%;
            margin: 0px 0% 0 1.6%;
            height: 300px;
            border: 1px solid #FFF;
            font-size: 25px;
            text-align: center;
            border-radius: 5px;
            vertical-align: middle;
            background-color: #151515;
            margin-bottom: 25px;
        }
        
        .input-group {
            margin-bottom: 25px;
        }
        
        .input-group input::placeholder,
        .input-group textarea::placeholder {
            color: #ccc;
            opacity: 1;
            /* Firefox */
        }
        
        .input-group input:-ms-input-placeholder,
        .input-group textarea:-ms-input-placeholder {
            /* Internet Explorer 10-11 */
            color: #ccc;
        }
        
        .input-group input::-ms-input-placeholder,
        .input-group textarea::-ms-input-placeholder {
            /* Microsoft Edge */
            color: #ccc;
        }
        
        .input-group input,
        .input-group select,
        .input-group textarea {
            background-color: #151515;
            border-color: #fff;
            resize: none;
            color: #FFF;
        }
        
        .input-group select {
            background-color: #151515;
            border-color: #fff;
            color: #ccc;
        }
        
        .input-group input:focus,
        .input-group select:focus,
        .input-group textarea:focus {
            background-color: #252525;
            color: #FFF;
            resize: none;
        }
        
        input[type="file"] {
            background-color: #151515;
            display: none;
        }
        
        .btn {
            background-color: #f36100;
            border: 1px solid #f36100;
            color: #fff;
            padding-left: 35px;
            padding-right: 35px;
            border-radius: 50px;
            margin: 10px 15px 50px 15px;
        }
        
        .btn:active {
            background-color: #151515;
            border: 1px solid #fff;
            color: #fff;
        }
        
        .btn:hover {
            background-color: #151515;
            border: 1px solid #fff;
            color: #fff;
        }
        
        .up1 {
            color: #fff;
            cursor: pointer;
            height: 100%;
            padding-top: 50px;
            width: 100%;
        }
        
        .up2 {
            color: #fff;
            cursor: pointer;
            height: 100%;
            padding-top: 125px;
            width: 100%;
        }
        
        .label {
            color: #FFF;
            font-weight: bold;
            font-size: 20px;
            /* background-color: #f36100; */
            display: block;
        }

        .required {
            color: #F00;
            padding: 0px 0px 0px 5px;
        }

        .require {
            color: #F00;
            /* background-color: #f36100; */
            margin: 0;
            display: block;
            text-align: right;
            padding-right: 10px;
        }
        </style>
</head>

<body>
    
    <?php
        include("header.php");
        if (isset($_POST['new_post'])) {
            $date = date("Y-m-d");
            
            $title = $_POST['title'];
            $content1 = $_POST['content1'];
            $quote = $_POST['quote'];
            $content2 = $_POST['content2'];
            $keywords = $_POST['keywords'];
            $category = $_POST['category'];
            
            if (isset($_POST['remark'])) {
                $remark = $_POST['remark'];
            } else {
                $remark = '';
            }
            
            $extention = array('gif', 'png', 'jpg', 'jpeg');
            $image_name = "";
            $image_name1 = "";
            $image_name2 = "";
            
            $filename = $_FILES['cover']['name'];
            if(!empty($filename)) {
                $filetmp = $_FILES['cover']['tmp_name'];
                $fileext = explode('.', $filename);
                $filecheck = strtolower(end($fileext));
                $image_name = "img/post/" . $filename;
                move_uploaded_file($filetmp, $image_name);
            }

            $filename1 = $_FILES['img1']['name'];
            if(!empty($filename1)) {
                $filetmp1 = $_FILES['img1']['tmp_name'];
                $fileext1 = explode('.', $filename1);
                $filecheck1 = strtolower(end($fileext1));
                $image_name1 = "img/post/" . $filename1;
                move_uploaded_file($filetmp1, $image_name1);
            }
            
            $filename2 = $_FILES['img2']['name'];
            if(!empty($filename2)) {
                $filetmp2 = $_FILES['img2']['tmp_name'];
                $fileext2 = explode('.', $filename2);
                $filecheck2 = strtolower(end($fileext2));
                $image_name2 = "img/post/" . $filename2;
                move_uploaded_file($filetmp2, $image_name2);
            }

            if(empty($filename)) {
                $cover = addslashes($result1['Img_Title']);
            } else if(in_array($filecheck,$extention)) {
                list($source_width, $source_height, $source_type) = getimagesize($image_name);
                if ($source_width >= 1536) {
                    if (round($source_width / $source_height, 2) == 1.78 || round($source_width / $source_height, 2) == 2.13) {
                        switch ($source_type) {

                            case IMAGETYPE_GIF:
                                $image = imagecreatefromgif($image_name);
                                break;
                            case IMAGETYPE_JPEG:
                                $image = imagecreatefromjpeg($image_name);
                                break;
                            case IMAGETYPE_PNG:
                                $image = imagecreatefrompng($image_name);
                                break;
                            default:
                                return false;
                        }
                        $imgResized = imagescale($image, 1920, 900);
                        imagejpeg($imgResized, $image_name);
                        $cover = addslashes(file_get_contents($image_name));
                        ?><img src="<?php if(!empty($cover)){ echo "data:image/jpg;charset=utf8;base64,".base64_encode($cover);} else { echo "img/blog/blog-1.jpg";} ?>" alt=""><?php
                    } else {
                        echo '<b><script>if (swal("Post Not Created!", "Cover Image Must Have Resolutions In 16:9 ratio", "error")) {setTimeout(function () { window.location.href="javascript:history.back(1)"; }, 3000); }</script></b>';
                    }
                } else {
                    echo '<b><script>if (swal("Post Not Created!", "Cover Image Must Have Width Greater Than 1536px", "error")) {setTimeout(function () { window.location.href="javascript:history.back(1)"; }, 3000); }</script></b>';
                }
            } else {
                echo '<b><script>if (swal("Post Not Created!", "Upload only jpg, png, jpeg, gif image type", "error")) {setTimeout(function () { window.location.href="javascript:history.back(1)"; }, 3000); }</script></b>';
            }
            
            if(empty($filename1)) {
                $img1 = addslashes($result1['Img1']);
            } else if(in_array($filecheck1,$extention)) {
                list($source_width1, $source_height1, $source_type1) = getimagesize($image_name1);
                if ($source_width1 >= 360) {
                    if (($source_width1 / $source_height1) == 1) {
                        switch ($source_type1) {

                            case IMAGETYPE_GIF:
                                $image1 = imagecreatefromgif($image_name1);
                                break;
                            case IMAGETYPE_JPEG:
                                $image1 = imagecreatefromjpeg($image_name1);
                                break;
                            case IMAGETYPE_PNG:
                                $image1 = imagecreatefrompng($image_name1);
                                break;
                            default:
                                return false;
                        }
                        $imgResized1 = imagescale($image1, 395, 395);
                        imagejpeg($imgResized1, $image_name1);
                        $img1 = addslashes(file_get_contents($image_name1));
                        ?><img src="<?php if(!empty($img1)){ echo "data:image/jpg;charset=utf8;base64,".base64_encode($img1);} else { echo "img/blog/blog-1.jpg";} ?>" alt=""><?php
                    } else {
                        echo '<b><script>if (swal("Post Not Created!", "Post Image 1 Must Be Square By Dimensions", "error")) {setTimeout(function () { window.location.href="javascript:history.back(1)"; }, 3000); }</script></b>';
                    }
                } else {
                    echo '<b><script>if (swal("Post Not Created!", "Post Image 1 Must Have Width Greater Than 360px", "error")) {setTimeout(function () { window.location.href="javascript:history.back(1)"; }, 3000); }</script></b>';
                }
            } else {
                echo '<b><script>if (swal("Post Not Created!", "Upload only jpg, png, jpeg, gif image type", "error")) {setTimeout(function () { window.location.href="javascript:history.back(1)"; }, 3000); }</script></b>';
            }
            
            if(empty($filename2)) {
                $img2 = addslashes($result1['Img2']);
            } else if(in_array($filecheck2,$extention)) {
                list($source_width2, $source_height2, $source_type2) = getimagesize($image_name2);
                if ($source_width2 >= 360) {
                    if (($source_width2 / $source_height2) == 1) {
                        switch ($source_type2) {

                            case IMAGETYPE_GIF:
                                $image2 = imagecreatefromgif($image_name2);
                                break;
                            case IMAGETYPE_JPEG:
                                $image2 = imagecreatefromjpeg($image_name2);
                                break;
                            case IMAGETYPE_PNG:
                                $image2 = imagecreatefrompng($image_name2);
                                break;
                            default:
                                return false;
                        }
                        $imgResized2 = imagescale($image2, 395, 395);
                        imagejpeg($imgResized2, $image_name2);
                        $img2 = addslashes(file_get_contents($image_name2));
                        ?><img src="<?php if(!empty($img2)){ echo "data:image/jpg;charset=utf8;base64,".base64_encode($img2);} else { echo "img/blog/blog-1.jpg";} ?>" alt=""><?php
                    } else {
                        echo '<b><script>if (swal("Post Not Created!", "Post Image 2 Must Be Square By Dimensions", "error")) {setTimeout(function () { window.location.href="javascript:history.back(1)"; }, 3000); }</script></b>';
                    }
                } else {
                    echo '<b><script>if (swal("Post Not Created!", "Post Image 2 Must Have Width Greater Than 360px", "error")) {setTimeout(function () { window.location.href="javascript:history.back(1)"; }, 3000); }</script></b>';
                }
            } else {
                echo '<b><script>if (swal("Post Not Created!", "Upload only jpg, png, jpeg, gif image type", "error")) {setTimeout(function () { window.location.href="javascript:history.back(1)"; }, 3000); }</script></b>';
            }

            $sql = "UPDATE `contributor_articles` SET `Img_Title`='$cover',`Title`='$title',`Content1`='$content1',`Img1`='$img1',`Img2`='$img2',`Sentence`='$quote',`Content2`='$content2',`Last_Modified`='$date',`Keywords`='$keywords',`Category`='$category',`Remarks`='$remark' WHERE `Article_Id` = '$article_id'";

            $query = mysqli_query($conn, $sql);
            if ($query) {
                echo '<b><script>if (swal("Post Updated!", "Your Post Updated Successfully", "success")) {setTimeout(function () { window.location.href="my_posts.php"; }, 3000); }</script></b>';
            } else {
                echo '<b><script>if (swal("Something Went Wrong!", "Please Try Again Later'.$img1.'", "error")) {setTimeout(function () { window.location.href="javascript:history.back(1)"; }, 3000); }</script></b>';
            }
            
            if (file_exists($image_name)) {
                unlink($image_name);
            }
            if (file_exists($image_name1)) {
                unlink($image_name1);
            }
            if (file_exists($image_name2)) {
                unlink($image_name2);
            }
        }
    ?>
        <div class="text-center title">Create a Blog Post</div>

        <div class="container mt-5">
            <form method="POST" enctype="multipart/form-data">

                <label class="require">* Indicates Required Fields</label>
                <label class="label">Cover Image For Post<label class="required">*</label></label>
                <div class="title_img">
                    <label for="file" class="up1">
                        <i class="fa fa-cloud-upload"></i> Update Cover Image
                    </label>
                    <input type="file" name="cover" id="file" accept="image/png, image/gif, image/jpeg">
                </div>

                <label class="label">Main Title For Post<label class="required">*</label></label>
                <div class="input-group">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Your Title" value="<?php echo $result1['Title']; ?>" aria-label="Title" aria-describedby="basic-addon1" required>
                </div>

                <label class="label">Details Before Image<label class="required">*</label></label>
                <div class="input-group">
                    <textarea class="form-control" name="content1" rows="10" id="content1" placeholder="Enter Content Before Image" aria-label="With textarea" required><?php echo $result1['Content1']; ?></textarea>
                </div>

                <label class="label">Images of Post<label class="required">*</label></label>
                <div class="img1">
                    <label for="img1" class="up2">
                        <i class="fa fa-cloud-upload"></i>
                        Update Image 1
                    </label>
                    <input type="file" name="img1" id="img1" accept="image/png, image/gif, image/jpeg">
                </div>

                <div class="img2">
                    <label for="img2" class="up2">
                        <i class="fa fa-cloud-upload"></i>
                        Update Image 2
                    </label>
                    <input type="file" name="img2" id="img2" accept="image/png, image/gif, image/jpeg">
                </div>

                <label class="label">Motivational Sentence<label class="required">*</label></label>
                <div class="input-group">
                    <input type="text" class="form-control" id="quote" name="quote" placeholder="Enter Motivational Sentence" value="<?php echo $result1['Sentence']; ?>" aria-label="Title" aria-describedby="basic-addon1" min="100" max="200" required>
                </div>

                <label class="label">Details After Image<label class="required">*</label></label>
                <div class="input-group">
                    <textarea class="form-control" name="content2" rows="10" id="content2" placeholder="Enter Content After Image" aria-label="With textarea" required><?php echo $result1['Content2']; ?></textarea>
                </div>

                <label class="label">Keywords For Post<label class="required">*</label></label>
                <div class="input-group">
                    <input type="text" class="form-control" id="keywords" name="keywords" placeholder="Example: keyword1, keyword2, keyword3" value="<?php echo $result1['Keywords']; ?>" aria-label="Title" aria-describedby="basic-addon1" max="200" required>
                </div>

                <label class="label">Categories<label class="required">*</label></label>
                <div class="input-group">
                    <select name="category" id="cate" class="input100 validate-input form-control" required>
                        <option value="">Choose Category</option>
                        <option value="Yoga" <?php if($result1['Category'] == 'Yoga') { echo "selected"; } ?>>Yoga</option>
                        <option value="Running" <?php if($result1['Category'] == 'Running') { echo "selected"; } ?>>Running</option>
                        <option value="Weightloss" <?php if($result1['Category'] == 'Weightloss') { echo "selected"; } ?>>Weightloss</option>
                        <option value="Cardio" <?php if($result1['Category'] == 'Cardio') { echo "selected"; } ?>>Cardio</option>
                        <option value="Body buiding" <?php if($result1['Category'] == 'Body buiding') { echo "selected"; } ?>>Body buiding</option>
                        <option value="Nutrition" <?php if($result1['Category'] == 'Nutrition') { echo "selected"; } ?>>Nutrition</option>
                        <option value="Other" <?php if($result1['Category'] == 'Other') { echo "selected"; } ?>>Other</option>
                    </select>
                </div>

                <label class="label">Author Remarks</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="remark" name="remark" placeholder="Enter remarks for Post" value="<?php echo $result1['Remarks']; ?>" aria-label="Title" aria-describedby="basic-addon1" max="200">
                </div>

                <div class="text-center">
                    <button class="btn btn-outline-light btn-lg" name="new_post" id="new_post" role="button">
                        <span id="add-post">Update Post</span>
                    </button>
                </div>
            </form>
        </div>

        <script>
            $('#file').change(function() {
                var file = $('#file')[0].files[0].name;
                $(this).prev('label').text(file);
            });
        </script>
        <script>
            $('#img1').change(function() {
                var file1 = $('#img1')[0].files[0].name;
                $(this).prev('label').text(file1);
            });
        </script>
        <script>
            $('#img2').change(function() {
                var file2 = $('#img2')[0].files[0].name;
                $(this).prev('label').text(file2);
            });
        </script>
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
    <script src="https://js.stripe.com/v3/"></script>
    <script src="notification.js"></script>
    
</body>
</html>

<?php
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