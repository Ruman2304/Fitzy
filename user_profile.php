<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="description" content="Blogs">
  <meta name="keywords" content="Gym, unica, creative, html">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Fitzy | Profile</title>

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
      /* margin-top: 20px; */
      color: #1a202c;
      font-family: sans-serif;
      text-align: left;
      background-color: #151515;
    }

    .main-body {
      padding: 15px;
    }

    .card-profile {
      box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }

    .card-profile {
      position: relative;
      display: flex;
      flex-direction: column;
      min-width: 0;
      word-wrap: break-word;
      background-color: #fff;
      background-clip: border-box;
      border: 0 solid rgba(0, 0, 0, 0.125);
      border-radius: 0.25rem;
    }

    .card-body {
      flex: 1 1 auto;
      min-height: 1px;
      padding: 1rem;
    }

    .gutters-sm {
      margin-right: -8px;
      margin-left: -8px;
    }

    .gutters-sm>.col,
    .gutters-sm>[class*="col-"] {
      padding-right: 8px;
      padding-left: 8px;
    }

    .mb-3,
    .my-3 {
      margin-bottom: 1rem !important;
    }

    .bg-gray-300 {
      background-color: #e2e8f0;
    }

    .h-100 {
      height: 100% !important;
    }

    .shadow-none {
      box-shadow: none !important;
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
    include "header.php";
    include "connect.php";

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
          if ($role == 'customer' || $role == 'contributor'){
            $height = $row['Height'];
            $weight = $row['Weight'];
            $handicap = $row['Physicaly_Handicap'];
            $disease = $row['Disease_Check'];
            if (isset($row['Disease_Name'])) {
              $disease_name = $row['Disease_Name'];
            } else {
              $disease_name = 'Not Set';
            }
          }
          $pincode = $row['Pincode'];
          $local_place = $row['Local_Place'];
          $city = $row['City'];
          $state = $row['State'];
          $country = $row['Country'];
          $profile = $row['Photo'];

          $_SESSION['user_name'] = $name;
          if ($role == "trainer" || $role == "dietician") {
            $experience = $row['Experience'];
          }

  ?>
          <!-- Breadcrumb Section Begin -->
          <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb-bg.jpg">
            <div class="container">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <div class="breadcrumb-text">
                    <h2>My Profile</h2>
                    <div class="bt-option">
                      <a href="./index.php">Home</a>
                      <a href="">Other</a>
                      <span>My Profile</span>
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
            <div class="container">
              <div class="main-body">

                <div class="row gutters-sm">
                  <div class="col-md-4 mb-3">
                    <div class="card-profile">
                      <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                          <img src="<?php if (!empty($profile)) { echo "data:image/jpg;charset=utf8;base64," . base64_encode($profile); } else { echo "https://bootdey.com/img/Content/avatar/avatar7.png"; } ?>" alt="Profile" class="rounded-circle" width="150" />
                          <div class="mt-3">
                            <h4><?= $name ?></h4>
                          </div>
                          <hr />

                          <?php

                            $sql = "SELECT `Customer_Id` FROM `customer` WHERE User_Id = '$user_id'";
                            $query = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_row($query);
                            $c_id = $row['0'];

                            $sql1 = "SELECT * FROM `membership` WHERE Customer_Id='$c_id'";
                            $query1 = mysqli_query($conn, $sql1);
                            
                            $sta = "";
                            $start_date = "";
                            $end_date = "";
                            $start_time = "";
                            $end_time = "";
                            if (mysqli_num_rows($query1) > 0) {
                              $row = mysqli_fetch_array($query1);
                              $sta = $row['Status'];
                              $start_date = $row['Start_Date'];
                              $end_date = $row['End_Date'];
                              $package_id = $row['Package_Id'];
                          ?>
                            <div class="row">
                              <span class="badge">Premium Member</span>
                            </div>
                            <?php
                            if ($sta == 1) {
                              $sql2 = "SELECT * FROM `packages` WHERE Package_Id='$package_id'";
                              $query2 = mysqli_query($conn, $sql2);
                              if (mysqli_num_rows($query2) == 1) {
                                $row1 = mysqli_fetch_array($query2);
                            ?>
                              <br>
                              <div class="row">
                                <span class="badge badge-success">Package Name:- <?= $row1['Package_Name']?></span>
                              </div>
                              <br>

                              <div class="row">
                                <span class="badge badge-success">Valid Till:- <?= date("M d, Y", strtotime($end_date)) ?></span>
                              </div>
                            <?php
                              }
                            } else if ($sta == 0) {

                            ?>
                              <div class="row">
                                <span class="badge badge-danger">Membership Expired</span>
                              </div>
                          <?php
                            }
                          }
                          
                          ?>

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
                          <div class="card-profile" style="margin-top: 20px;">
                            <div class="card-body">
                              <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                  <h6 class="mb-0"><i class="fa fa-youtube-play" style="font-size: 24px; margin-right: 8px; color: #ff0000;"></i>YouTube</h6>
                                  <span class="text-secondary">youtube.com/<?= $row['Youtube'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                  <h6 class="mb-0"><i class="fa fa-github" style="font-size: 25px; margin-right: 8px; color: #00004d;"></i>Github</h6>
                                  <span class="text-secondary"><?= $row['Github'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                  <h6 class="mb-0"><i class="fa fa-twitter" style="font-size: 24px; margin-right: 8px; color: #17a2b8;"></i>Twitter</h6>
                                  <span class="text-secondary">@<?= $row['Twitter'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                  <h6 class="mb-0"><i class="fa fa-instagram" style="font-size: 24px; margin-right: 8px; color: #dc3545;"></i>Instagram</h6>
                                  <span class="text-secondary"><?= $row['Instagram'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                  <h6 class="mb-0"><i class="fa fa-facebook" style="font-size: 24px; margin-right: 8px; color: #007bff;"></i>Facebook</h6>
                                  <span class="text-secondary"><?= $row['Facebook'] ?></span>
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
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Full Name</h6>
                          </div>
                          <div class="col-sm-9 text-secondary"><?= $name ?></div>
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
                                <div class="col-sm-9 text-secondary"><?= $row['Author_Name'] ?></div>
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
                          <div class="col-sm-9 text-secondary"><?= $_SESSION['email'] ?></div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Gender</h6>
                          </div>
                          <div class="col-sm-9 text-secondary"><?= $gender ?></div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Date of Birth</h6>
                          </div>
                          <div class="col-sm-9 text-secondary"><?= $dob ?></div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Age</h6>
                          </div>
                          <div class="col-sm-9 text-secondary"><?= $age ?></div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Phone</h6>
                          </div>
                          <div class="col-sm-9 text-secondary"><?= $contact ?></div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Height</h6>
                          </div>
                          <div class="col-sm-9 text-secondary"><?php echo ($height != '0') ? number_format($height, 2) . " centimeter" : "Not Set"; ?></div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Weight</h6>
                          </div>
                          <div class="col-sm-9 text-secondary"><?php echo ($weight != '0') ? number_format($weight, 2) . " kilogram" : "Not Set"; ?></div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Physicaly Handicap?</h6>
                          </div>
                          <div class="col-sm-9 text-secondary"><?php echo ($handicap == 1) ? "Yes" : "No"; ?></div>
                        </div>
                        <hr />
                        <?php if ($disease == 1) { ?>
                          <div class="row">
                            <div class="col-sm-3">
                              <h6 class="mb-0">Any Disease?</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"><?php echo $disease_name; ?></div>
                          </div>
                          <hr />
                        <?php } ?>
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
                                  <?= $row['About_Author'] ?>
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
                            <?= $local_place ?>
                          </div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">City</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            <?= $city ?>
                          </div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">State</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            <?= $state ?>
                          </div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Country</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            <?= $country ?>
                          </div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Pincode</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            <?= $pincode ?>
                          </div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-12">
                            <a class="btn btn-info" href="./edit_profile.php">Edit</a>
                            <a class="btn btn-danger " href="javascript:del_acc('<?php echo "./delete_account.php"; ?>');">Delete Account</a>
                          </div>
                        </div>

                      </div>
                    </div>

                  </div>

                </div>
              </div>
            </div>
            </div>
            </div>
          <?php
          } else if ($role == 'trainer' || $role == "dietician") {
          ?>
            <div class="container">
              <div class="main-body">

                <div class="row gutters-sm">
                  <div class="col-md-4 mb-3">
                    <div class="card-profile">
                      <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                          <img src="<?php if (!empty($profile)) {
                                      echo "data:image/jpg;charset=utf8;base64," . base64_encode($profile);
                                    } else {
                                      echo "https://bootdey.com/img/Content/avatar/avatar7.png";
                                    } ?>" alt="Profile" class="rounded-circle" width="150" />
                          <div class="mt-3">
                            <h4><?= $name ?></h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="card mb-3">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Full Name</h6>
                          </div>
                          <div class="col-sm-9 text-secondary"><?= $name ?></div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                          </div>
                          <div class="col-sm-9 text-secondary"><?= $_SESSION['email'] ?></div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Gender</h6>
                          </div>
                          <div class="col-sm-9 text-secondary"><?= $gender ?></div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Date of Birth</h6>
                          </div>
                          <div class="col-sm-9 text-secondary"><?= $dob ?></div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Age</h6>
                          </div>
                          <div class="col-sm-9 text-secondary"><?= $age ?></div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Phone</h6>
                          </div>
                          <div class="col-sm-9 text-secondary"><?= $contact ?></div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Experience</h6>
                          </div>
                          <div class="col-sm-9 text-secondary"><?= $experience ?></div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Near Place</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            <?= $local_place ?>
                          </div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">City</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            <?= $city ?>
                          </div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">State</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            <?= $state ?>
                          </div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Country</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            <?= $country ?>
                          </div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Pincode</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            <?= $pincode ?>
                          </div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-12">
                            <a class="btn btn-info" href="./edit_profile.php">Edit</a>
                            <a class="btn btn-danger " href="javascript:del_acc('<?php echo "./delete_account.php"; ?>');">Delete Account</a>
                          </div>
                        </div>

                      </div>
                    </div>


                  </div>
                </div>
              </div>
            </div>
            </div>
            </div>
          <?php
          }
          ?>
          <script type="text/javascript">
            function del_acc(newurl) {
              if (confirm("Are you sure you want to delete your account?")) {
                document.location = newurl;
              }
            }
          </script>

  <?php
          include "footer.php";
        }
      } else {
        echo '<b><script>if (swal("Error!", "Your Profile is either deleted or you don\'t have an Account!", "error")) {setTimeout(function () { window.location.href="./index.php"; }, 3000); }</script></b>';
      }
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