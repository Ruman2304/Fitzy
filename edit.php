<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="description" content="Blogs">
	<meta name="keywords" content="Gym, unica, creative, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Fitzy | Edit Profile</title>

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

	<!-- Profile CSS -->
	<style>
		body {
			background: #151515;
			/* margin-top: 20px; */
		}

		.up1 {
			color: #fff;
			cursor: pointer;
		}

		input[type="file"] {
			background-color: #151515;
			display: none;
		}

		.card {
			position: relative;
			display: flex;
			flex-direction: column;
			min-width: 0;
			word-wrap: break-word;
			background-color: #fff;
			background-clip: border-box;
			border: 0 solid transparent;
			border-radius: .25rem;
			margin-bottom: 1.5rem;
			box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%);
		}

		.me-2 {
			margin-right: .5rem !important;
		}

		#countrylist,
		#statelist {
			cursor: pointer;
		}

        .input-box {
            display: flex;
            align-items: center;
            max-width: 300px;
            background: #fff;
            border: 1px solid #a0a0a0;
            border-radius: 4px;
            padding-left: 0.5rem;
            overflow: hidden;
            font-family: sans-serif;
        }

        .input-box .prefix {
            font-weight: 300;
            color: #000;
        }

        .input-box input {
            flex-grow: 1;
            font-size: 14px;
            background: #fff;
            border: none;
            outline: none;
            padding: 0.5rem;
            padding-left: 0;
        }

        .input-box input::placeholder {
            font-weight: 300;
            color: #ccc;
        }

        .input-box:focus-within {
            border-color: #777;
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
    include("header.php");
    include("connect.php");

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
		default:
			$table = "customer";
	}

	$sql = "SELECT * FROM $table WHERE `User_Id` = '$user_id'";
	$result = mysqli_query($conn, $sql);

	if ($result) {
		if (mysqli_num_rows($result) > 0) {

			while ($row = mysqli_fetch_array($result)) {
				$name = $row['Name'];
				$gender = $row['Gender'];
				$dob = $row['Birth_Date'];
				$age = $row['Age'];
				$contact = $row['Contact_No'];
				$height = $row['Height'];
				$weight = $row['Weight'];
				$handicap = $row['Physicaly_Handicap'];
				$disease = $row['Disease_Check'];
				$disease_name = $row['Disease_Name'];
				$pincode = $row['Pincode'];
				$local_place = $row['Local_Place'];
				$city = $row['City'];
				$state = $row['State'];
				$country = $row['Country'];
				$profile = $row['Photo'];

				if ($role == "trainer" || $role == "dietician") {
					$experience = $row['Experience'];
				}
?>
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb-bg.jpg" style="margin-bottom: 20px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Edit Profile</h2>
                        <div class="bt-option">
                            <a href="./index.php">Home</a>
                            <a href="">Other</a>
                            <span>Edit Profile</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <?php
    if ($role == "customer" || $role == "contributor") {
    ?>
        <form action="" method="POST" class="post" enctype="multipart/form-data">
            <div class="container">
                <div class="main-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="<?php if (!empty($profile)) {echo "data:image/jpg;charset=utf8;base64," . base64_encode($profile);} else {echo "https://bootdey.com/img/Content/avatar/avatar6.png";} ?>" alt="Admin" class="rounded-circle bg-primary" width="150">
                                        <div class="mt-3">
                                            <h4><?= $name ?></h4>
                                            </br>
                                            <label for="pic" class="up1 btn btn-primary">Update Profile Photo</label>
                                            <input type="file" name="profile" id="pic" accept="image/png, image/gif, image/jpeg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($role == "contributor") {
                                $sql = "SELECT * FROM `contributor` WHERE `User_Id` = '$user_id'";
                                $qry = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($qry) == 1) {
                                    while ($row = mysqli_fetch_array($qry)) {
                            ?>
                            <input type="hidden" name="contributor" value="true">
                            <div class="card">
                                <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-youtube-play" style="font-size: 24px; margin-right: 8px; color: #ff0000; margin-bottom: 10px;"></i>YouTube</h6>
                                        <span class="text-secondary" class="form-control">
                                            <div class="input-box">
                                                <span class="prefix">youtube.com/</span>
                                                <input type="text" name="youtube" value="<?= $row['Youtube'] ?>" placeholder="channel_link">
                                            </div>
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-github" style="font-size: 25px; margin-right: 8px; color: #00004d; margin-bottom: 10px;"></i>Github</h6>
                                        <span class="text-secondary"><input type="text" name="github" class="form-control" value="<?= $row['Github'] ?>" placeholder="GitHub Username"></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-twitter" style="font-size: 24px; margin-right: 8px; color: #17a2b8; margin-bottom: 10px;"></i>Twitter</h6>
                                        <span class="text-secondary"><input type="text" name="twitter" class="form-control" value="<?= $row['Twitter'] ?>" placeholder="Twitter Username"></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-instagram" style="font-size: 24px; margin-right: 8px; color: #dc3545; margin-bottom: 10px;"></i>Instagram</h6>
                                        <span class="text-secondary"><input type="text" name="instagram" class="form-control" value="<?= $row['Instagram'] ?>" placeholder="Instagram Username"></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-facebook" style="font-size: 24px; margin-right: 8px; color: #007bff; margin-bottom: 10px;"></i>Facebook</h6>
                                        <span class="text-secondary" class="form-control">
                                            <div class="input-box">
                                                <span class="prefix">facebook.com/</span>
                                                <input type="text" name="facebook" value="<?= $row['Facebook'] ?>" placeholder="profile_link">
                                            </div>
                                        </span>
                                    </li>
                                </ul>
                                </div>
                            </div>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Full Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="name" class="form-control" value="<?= $name ?>">
                                        </div>
                                    </div>
                                    <hr />
                                    <?php
                                    if ($role == "contributor") {
                                        $sql = "SELECT * FROM `contributor` WHERE `User_Id` = '$user_id'";
                                        $qry = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($qry) == 1) {
                                            while ($row = mysqli_fetch_array($qry)) {
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Author Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="a_name" class="form-control" value="<?= $row['Author_Name'] ?>">
                                        </div>
                                    </div>
                                    <hr />
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="email" name="email" class="form-control" value="<?= $_SESSION['email'] ?>" readonly>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Gender</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="radio" name="gender" id="male" value="male" <?php if ($gender == 'male') {echo "checked";} ?> required>&nbsp;<label for="male" required>Male</label>
                                            <input type="radio" name="gender" <?php if ($gender == 'female') {echo "checked";} ?> value="female" id="female">&nbsp;<label for="female">Female</label>
                                            <input type="radio" name="gender" <?php if ($gender == 'other') {echo "checked";} ?> value="other" id="other">&nbsp;<label for="other">Other</label>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Date of Birth</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="date" name="b_date" class="form-control" value="<?= $dob ?>">
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Age</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="email" class="form-control" value="<?= $age ?>" readonly>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Phone</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input class="form-control" type="text" name="telephone" pattern="[0-9]{10}" value="<?= $contact ?>">
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Height</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input class="form-control" type="number" min="90" max="225" name="height" placeholder="Height in Centimeter" value="<?= $height ?>">
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Weight</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input class="form-control" type="number" min="10" max="250" name="weight" placeholder="Weight in Kilogram" value="<?= $weight ?>">
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Physicaly Handicap?</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="radio" name="handicap" id="yes" value="1" <?php if ($handicap == '1') {echo "checked";} ?> required>&nbsp;<label for="yes" required>Yes</label>
                                            <input type="radio" name="handicap" <?php if ($handicap == '0') {echo "checked";} ?> value="0" id="no">&nbsp;<label for="no">No</label>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Any Disease?</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="disease" id="disease" class="form-control" value="<?= $disease_name ?>">
                                            <div id="diseaselist"></div>
                                        </div>
                                    </div>
                                    <hr />
                                    <?php
                                    if ($role == "contributor") {
                                        $sql = "SELECT * FROM `contributor` WHERE `User_Id` = '$user_id'";
                                        $qry = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($qry) == 1) {
                                            while ($row = mysqli_fetch_array($qry)) {
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">About Author</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <textarea name="about" id="about" class="form-control" maxlength="500" cols="30" rows="5"><?= $row['About_Author'] ?></textarea>
                                        </div>
                                    </div>
                                    <hr />
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Near Place</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <textarea name="address" id="addr" class="form-control" cols="30" rows="4"><?= $local_place ?></textarea>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">City</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="city" id="city" class="form-control" value="<?= $city ?>">
                                            <div id="citylist"></div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">State</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="state" id="state" class="form-control" value="<?= $state ?>">
                                            <div id="statelist"></div>
                                        </div>
                                    </div>

                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Country</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="country" id="country" value="<?= $country ?>" class="form-control">
                                            <div id="countrylist"></div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Pincode</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="number" pattern="[0-9]{10}" name="pincode" class="form-control" value="<?= $pincode ?>">
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button class="btn btn-primary" name="update">Save Changes</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php
    } else if ($role == "trainer" || $role == "dietician") {
    ?>
        <form action="" method="POST" class="post" enctype="multipart/form-data">
            <div class="container">
                <div class="main-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="<?php if (!empty($profile)) {echo "data:image/jpg;charset=utf8;base64," . base64_encode($profile);} else {echo "https://bootdey.com/img/Content/avatar/avatar6.png";} ?>" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                                        <div class="mt-3">
                                            <h4><?= $name ?></h4>
                                            </br>
                                            <label for="pic" class="up1 btn btn-primary">Update Profile Photo</label>
                                            <input type="file" name="profile" id="pic" accept="image/png, image/gif, image/jpeg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Full Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="name" class="form-control" value="<?= $name ?>">
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="email" name="email" class="form-control" value="<?= $_SESSION['email'] ?>" readonly>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Gender</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="radio" name="gender" id="male" value="male" <?php if ($gender == 'male') {echo "checked";} ?> required>&nbsp;<label for="male" required>Male</label>
                                            <input type="radio" name="gender" <?php if ($gender == 'female') {echo "checked";} ?> value="female" id="female">&nbsp;<label for="female">Female</label>
                                            <input type="radio" name="gender" <?php if ($gender == 'other') {echo "checked";} ?> value="other" id="other">&nbsp;<label for="other">Other</label>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Date of Birth</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="date" name="b_date" class="form-control" value="<?= $dob ?>">
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Age</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="email" class="form-control" value="<?= $age ?>" readonly>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Phone</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input class="form-control" type="text" name="telephone" pattern="[0-9]{10}" value="<?= $contact ?>">
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Experience</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input class="form-control" type="text" name="experience" pattern="[0-9]{1}" value="<?= $experience ?>">
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Near Place</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <textarea name="address" id="addr" class="form-control" cols="30" rows="4"><?= $local_place ?></textarea>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">City</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="city" id="city" class="form-control" value="<?= $city ?>">
                                            <div id="citylist"></div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">State</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="state" id="state" class="form-control" value="<?= $state ?>">
                                            <div id="statelist"></div>
                                        </div>
                                    </div>

                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Country</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="country" id="country" value="<?= $country ?>" class="form-control">
                                            <div id="countrylist"></div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Pincode</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="number" pattern="[0-9]{10}" name="pincode" class="form-control" value="<?= $pincode ?>">
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button class="btn btn-primary" name="update">Save Changes</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php
    }
    ?>
    <?php
    if (isset($_POST['update'])) {

        session_start();
        if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
            $user_id = $_SESSION['userid'];
            $role = $_SESSION['role'];
        } else {
            header("Location: ./index.php");
        }
        $date = date("Y-m-d");
        $name = $_POST['name'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $b_date = $_POST['b_date'];
        $diff = date_diff(date_create($b_date), date_create($date));
        $age = $diff->format('%y');
        if (isset($_POST['telephone'])) {
            $telephone = $_POST['telephone'];
        } else {
            $telephone = '';
        }

        if (isset($_POST['contributor']) && $_POST['contributor']==true) {
            $youtube = addslashes($_POST['youtube']);
            $github = addslashes($_POST['github']);
            $twitter = addslashes($_POST['twitter']);
            $instagram = addslashes($_POST['instagram']);
            $facebook = addslashes($_POST['facebook']);
            $a_name = addslashes($_POST['a_name']);
            $about = addslashes($_POST['about']);
        }

        $height = $_POST['height'];
        $weight = $_POST['weight'];
        $handicap = $_POST['handicap'];
        $disease = $_POST['disease'];
        if ($disease != '') {
            $disease_chk = 1;
        } else {
            $disease_chk = 0;
        }
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $country = $_POST['country'];
        $pincode = $_POST['pincode'];
        $experience = $_POST['experience'];

        $filename = $_FILES['profile']['name'];
        $filetmp = $_FILES['profile']['tmp_name'];
        $fileext = explode('.', $filename);
        $filecheck = strtolower(end($fileext));
        $extention = array('png', 'jpg', 'jpeg', 'gif');

        if (empty($filename)) {
            if ($role == "customer" || $role == "contributor") {
                $sql = "UPDATE `$table` SET `Name`='$name',`Gender`='$gender',`Birth_Date`='$b_date',`Age`='$age',`Contact_No`='$telephone',`Height`='$height',`Weight`='$weight',`Physicaly_Handicap`='$handicap',`Disease_Check`='$disease_chk',`Disease_Name`='$disease',`Pincode`='$pincode',`Local_Place`='$address',`City`='$city',`State`='$state',`Country`='$country' WHERE `User_Id`='$user_id'";
                $query = mysqli_query($conn, $sql);

                if ($role == "contributor") {
                    $sql1 = "UPDATE `contributor` SET `Author_Name`='$a_name', `About_Author`='$about', `Facebook`='$facebook', `Twitter`='$twitter', `Github`='$github', `Instagram`='$instagram', `Youtube`='$youtube' WHERE `User_Id`='$user_id'";
                    $query1 = mysqli_query($conn, $sql1);
                }
            } else if ($role == "trainer" || $role == "dietician") {
                $sql = "UPDATE `$table` SET `Name`='$name',`Gender`='$gender',`Birth_Date`='$b_date',`Age`='$age',`Contact_No`='$telephone',`Experience` = '$experience',`Pincode`='$pincode',`Local_Place`='$address',`City`='$city',`State`='$state',`Country`='$country' WHERE `User_Id`='$user_id'";
                $query = mysqli_query($conn, $sql);
                $query1 = true;
            }

            if ($query && $query1) {
                echo '<b><script>if (swal("Profile Updated!", "Redirecting Now..", "success")) {setTimeout(function () { window.location.href="user_profile.php"; }, 3000); }</script></b>';
            } else {
                echo '<b><script>swal("Profile Not Updated!", "Please try again leter", "error");</script></b>';
            }
        } else if (in_array($filecheck, $extention)) {
            $image = addslashes(file_get_contents($filetmp));
            if ($role == "customer" || $role == "admin" || $role == "contributor") {
                $sql = "UPDATE `$table` SET `Name`='$name',`Gender`='$gender',`Birth_Date`='$b_date',`Age`='$age',`Contact_No`='$telephone',`Height`='$height',`Weight`='$weight',`Physicaly_Handicap`='$handicap',`Disease_Check`='$disease_chk',`Disease_Name`='$disease',`Pincode`='$pincode',`Local_Place`='$address',`City`='$city',`State`='$state',`Country`='$country',`Photo`='$image' WHERE `User_Id`='$user_id'";
                $query = mysqli_query($conn, $sql);
                
                if ($role == "contributor") {
                    $sql1 = "UPDATE `contributor` SET `Author_Name`='$a_name', `About_Author`='$about', `Photo`='$image', `Facebook`='$facebook', `Twitter`='$twitter', `Github`='$github', `Instagram`='$instagram', `Youtube`='$youtube' WHERE `User_Id`='$user_id'";
                    $query1 = mysqli_query($conn, $sql1);
                }
            } else if ($role == "trainer" || $role == "dietician") {
                $sql = "UPDATE `$table` SET `Name`='$name',`Gender`='$gender',`Birth_Date`='$b_date',`Age`='$age',`Contact_No`='$telephone',`Experience` = '$experience',`Pincode`='$pincode',`Local_Place`='$address',`City`='$city',`State`='$state',`Country`='$country',`Photo`='$image' WHERE `User_Id`='$user_id'";
                $query = mysqli_query($conn, $sql);
                $query1 = true;
            }
            if ($query && $query1) {
                echo '<b><script>if (swal("Profile Updated!", "Redirecting Now..", "success")) {setTimeout(function () { window.location.href="user_profile.php"; }, 3000); }</script></b>';
            } else {
                echo '<b><script>swal("Profile Not Updated!", "Please try again leter", "error");</script></b>';
            }
        } else {
            echo '<b><script>if (swal("Profile Not Updated!", "Upload only jpg, png, jpeg, gif image type", "error")) {setTimeout(function () { window.location.href="javascript:history.back(1)"; }, 3000); }</script></b>';
        }
    }
    ?>
    <?php
        include("footer.php");
                    }
                } else {
                    echo 'Location: 404.php';
                }
            }
        } else {
            header("Location: ./login.php");
        }
    ?>

    <script>
        $('#pic').change(function() {
            var file = $('#pic')[0].files[0].name;
            $(this).prev('label').text(file);
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#country').keyup(function() {
                var query1 = $("#country").val();
                if (query1 != '') {
                    $.ajax({
                        url: "search_country.php",
                        method: "POST",
                        data: {
                            query1: query1
                        },
                        success: function(data) {
                            $('#countrylist').fadeIn();
                            $('#countrylist').html(data);
                        }
                    });

                } else {
                    $('#countrylist').fadeOut();
                    $('#countrylist').html("");
                }
            });
            $("#countrylist").on('click', 'li', function() {
                $("#country").val($(this).text());
                $("#countrylist").fadeOut();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#state').keyup(function() {
                var query2 = $("#state").val();
                if (query2 != '') {
                    $.ajax({
                        url: "search_country.php",
                        method: "POST",
                        data: {
                            query2: query2
                        },
                        success: function(data) {
                            $('#statelist').fadeIn();
                            $('#statelist').html(data);
                        }
                    });

                } else {
                    $('#statelist').fadeOut();
                    $('#statelist').html("");
                }
            });
            $("#statelist").on('click', 'li', function() {
                $("#state").val($(this).text());
                $("#statelist").fadeOut();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#city').keyup(function() {
                var query3 = $("#city").val();
                if (query3 != '') {
                    $.ajax({
                        url: "search_country.php",
                        method: "POST",
                        data: {
                            query3: query3
                        },
                        success: function(data) {
                            $('#citylist').fadeIn();
                            $('#citylist').html(data);
                        }
                    });

                } else {
                    $('#citylist').fadeOut();
                    $('#citylist').html("");
                }
            });
            $("#citylist").on('click', 'li', function() {
                $("#city").val($(this).text());
                $("#citylist").fadeOut();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#disease').keyup(function() {
                var query4 = $("#disease").val();
                if (query4 != '') {
                    $.ajax({
                        url: "search_country.php",
                        method: "POST",
                        data: {
                            query4: query4
                        },
                        success: function(data) {
                            $('#diseaselist').fadeIn();
                            $('#diseaselist').html(data);
                        }
                    });

                } else {
                    $('#diseaselist').fadeOut();
                    $('#diseaselist').html("");
                }
            });
            $("#diseaselist").on('click', 'li', function() {
                $("#disease").val($(this).text());
                $("#diseaselist").fadeOut();
            });
        });
    </script>

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