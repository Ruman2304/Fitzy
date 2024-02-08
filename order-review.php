<!DOCTYPE html>
<?php
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
  $url = "https://";
} else {
  $url = "http://";
}
$url .= $_SERVER['HTTP_HOST'];
$url .= $_SERVER['REQUEST_URI'];

?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="description" content="Fitzy Checkout">
  <meta name="keywords" content="Gym, unica, creative, html">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Fitzy | Checkout</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="css/flaticon.css" type="text/css">
  <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
  <link rel="stylesheet" href="css/barfiller.css" type="text/css">
  <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
  <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
  <link rel="shortcut icon" type="image/png" href="./favicon.png">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" rel="stylesheet" />
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" type="text/css">
  <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
  <style>
    body {
      font-family: "Oswald", sans-serif;
      background: #151515;
    }

    .container.py-5 {
      margin-top: 100px
    }

    .stripe-img {
      width: 150px;
      cursor: pointer;
    }

    .card-body a {
      text-decoration: none;
      color: white;
    }

    .card-body a:hover {
      color: white;
    }

    ul li {
      list-style: none;
    }
  </style>
</head>

<body>

  <?php
  session_start();
  if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    include "header.php";

    include "connect.php";

    if (isset($_GET['planid'])) {
      $planid = $_GET['planid'];
    }

    $sql = "SELECT * from packages WHERE `Package_Id` = '$planid'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
      $result = mysqli_fetch_array($query);
      $Package_Name = $result['Package_Name'];
      $Description = $result['Description'];
      $PackageAmount = $result['Amount'];
      $Photo = $result['Photo'];
      $duration = $result['Duration'];

      $_SESSION['planid'] = $planid;
      $_SESSION['pacname'] = $Package_Name;
      $_SESSION['desc'] = $Description;
      $_SESSION['amt'] = $PackageAmount;
      $_SESSION['duration'] = $duration;
      $_SESSION['photo'] = $Photo;
    }
  ?>
    <section class="h-100 gradient-custom">
      <div class="container py-5">
        <div class="row d-flex justify-content-center my-4">
          <div class="col-md-8">
            <div class="card mb-4">
              <div class="card-header py-3">
                <h5 class="mb-0">1 Item</h5>
              </div>
              <div class="card-body">
                <!-- Single item -->
                <div class="row">
                  <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                    <!-- Image -->
                    <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                      <img src="<?php if (!empty($Photo)) {
                                  echo "data:image/jpg;charset=utf8;base64," . base64_encode($Photo);
                                } else {
                                  echo "img/fitness-vector.png";
                                } ?>" class="w-100" alt="Blue Jeans Jacket" />
                      <a href="#!">
                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                      </a>
                    </div>
                    <!-- Image -->
                  </div>

                  <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                    <!-- Data -->
                    <p><strong>Plan Name: <?= $Package_Name ?></strong></p>
                    <p><strong>Description:</strong>
                    <ul>
                      <?php
                      $Keywords = explode(",", $Description);
                      if (is_array($Keywords)) {
                        foreach ($Keywords as $key => $val) {
                          $Keywords[$key] = trim($val);
                        }
                      }
                      foreach ($Keywords as $key => $val) {
                        ?><li><?php echo $val; ?></li><?php
                      }
                      ?>
                    </ul>
                    </p>
                    <p><strong>Amount: &#8377;<?= $PackageAmount ?></strong></p>

                    <!-- Data -->
                  </div>

                  <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">

                  </div>
                </div>



              </div>
            </div>
            <div class="card mb-4">
              <div class="card-body">
                <p><strong>Expected Activation</strong></p>
                <p class="mb-0">Under 24 Hours</p>
              </div>
            </div>
            <div class="card mb-4 mb-lg-0">
              <div class="card-body">
                <p><strong>We Accept</img></strong></p>
                <img class="me-2" width="45px" src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/visa.svg" alt="Visa" />
                <img class="me-2" width="45px" src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/amex.svg" alt="American Express" />
                <img class="me-2" width="45px" src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/mastercard.svg" alt="Mastercard" /></br></br>
                <p><strong><a href="https://stripe.com/"><img class="stripe-img"" src=" img/stripe.svg"></a></img></strong></p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card mb-4">
              <div class="card-header py-3">
                <h5 class="mb-0">Summary</h5>
              </div>
              <div class="card-body">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                    Amount
                    <span>&#8377;<?= $PackageAmount ?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <!-- Shipping
                <span>Gratis</span> -->
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                    <div>
                      <strong>Total amount (GST Included)</strong>
                      <strong>
                        <!-- <p class="mb-0">(including VAT)</p> -->
                      </strong>
                    </div>
                    <span><strong>&#8377;<?= $PackageAmount ?></strong></span>
                  </li>
                </ul>

                <a href="checkout.php" class="btn btn-primary btn-lg btn-block btn-checkout">
                  Checkout Now
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php
    include "footer.php";
  } else {
    header("Location: index.php?not_logged_in");
  }
  ?>


</body>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/masonry.pkgd.min.js"></script>
<script src="js/jquery.barfiller.js"></script>
<script src="js/jquery.slicknav.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/main.js"></script>
<script src="https://js.stripe.com/v3/"></script>

<script type="application/javascript">
  $(function() {
    $(document).on("click", ".btn-checkout", function(e) {
      let id = <?php echo $planid ?>;
      $(this).text("Please Wait...");
      $.ajax({
        url: "checkout.php",
        method: "post",
        dataType: 'json',
        data: {
          id: id,
          stripe_payment_process: 1,
        },
        success: function(response) {
          return stripe.redirectToCheckout({
            sessionId: response.id,
          });
        },
      });
    });
  });
</script>

</html>