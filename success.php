<?php
ob_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Fitzy Checkout">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fitzy | Payment Successfull</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/barfiller.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="shortcut icon" type="image/png" href="./favicon.png">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js" rel="application/javascript" />
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

        body {
            background-color: #151515;
            font-family: 'Montserrat', sans-serif
        }

        .card {
            border: none
        }

        .totals tr td {
            font-size: 13px
        }


        .footer span {
            font-size: 12px
        }

        .product-qty span {
            font-size: 12px;
            color: #dedbdb
        }

        .container #main-page {
            margin-top: 120px;
        }

        .card .logo {
            background: #343434;
        }
    </style>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body>
    <?php

    session_start();
    include "connect.php";
    require_once 'vendor/autoload.php';

    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    $mail = new PHPMailer(true);

    if (!empty($_GET['session_id'])) {
        include "header.php";
        $session_id = $_GET['session_id'];

        \Stripe\Stripe::setApiKey('sk_test_51KRDqNSGYAuA7doF7tRqGWhAYsoBZEm33MeUJIQpdtsK6SVySL9TaXYiUgWWcikbYC5DQldp7pidv2OsC0N4Hbu600CSWrvfpH');

        try {
            $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);
        } catch (Exception $e) {
            $api_error = $e->getMessage();
        }

        if (empty($api_error) && $checkout_session) {
            try {
                $intent = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $api_error = $e->getMessage();
            }

            try {
                $customer = \Stripe\Customer::retrieve($checkout_session->customer);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $api_error = $e->getMessage();
            }

            if (empty($api_error) && $intent) {
                if ($intent->status == 'succeeded') {

                    $planid = $_GET['plan_id'];

                    $name = $intent->charges['data'][0]['billing_details']['name'];
                    $email = $_SESSION['email'];
                    $Package_Name = $_SESSION['pacname'];
                    $txn_id = $intent->id;
                    $amount = $intent->amount / 100;
                    $payment_method = $intent->payment_method_types[0];
                    $status = $intent->status;
                    $userid = $_SESSION['userid'];
                    $Photo = $_SESSION['photo'];

                    $Date = date("Y-m-d");
                    $Time = date("H:i:s");

                    $sql = "SELECT * FROM `transaction` WHERE session_id = '$session_id'";
                    $query = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($query);

                    $ses_id = "";
                    if (isset($row['11'])) {
                        $ses_id = $row['11'];
                    }

                    $start_date = "";
                    $start_time = "";
                    $end_time = "";
                    $end_date = "";

                    $sql = "SELECT `Customer_Id` FROM `customer` WHERE `User_Id` = $userid";
                    $query = mysqli_query($conn, $sql);
                    $result = mysqli_fetch_array($query);
                    $Customer_Id = $result['Customer_Id'];

                    if ($status == "succeeded") {
                        $sta = 1;
                    } else {
                        $sta = 0;
                    }

                    if ($row) {
                        echo '<script>if (swal("Expired link!", "This link has expired!", "error")) {setTimeout(function () { window.location.href="index.php"; }, 3000); }</script>';
                    } else {

                        $query = mysqli_query($conn, "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'fitzy_database' AND TABLE_NAME = 'transaction'");
                        if (mysqli_num_rows($query) == 1) {
                            $row = mysqli_fetch_row($query);
                            $t_id = $row[0];
                        }

                        $sql3 = "INSERT INTO `transaction`(`tx_no`, `txn_id`, `email`, `Sender_Id`, `package_name`, `Amount`, `Payment_Method`, `Trans_Status`, `Trans_Date`, `Trans_Time`, `session_id`) VALUES ('$t_id','$txn_id','$email','$userid','$Package_Name','$amount','$payment_method','$status','$Date','$Time','$session_id')";
                        $query3 = mysqli_query($conn, $sql3);

                        if ($query3) {
                            $sql = "SELECT * FROM `transaction` WHERE `Sender_Id` = '$userid'";
                            $query = mysqli_query($conn, $sql);
                            $result = mysqli_fetch_array($query);
                        }
                        if (mysqli_num_rows($query) > 0) {

                            $start_date = $result['Trans_Date'];
                            $start_time = $result['Trans_Time'];

                            if ($planid == "5") {
                                $end_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($start_date)) . "+ 30 day"));
                            } else if ($planid == "6") {
                                $end_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($start_date)) . "+ 90 day"));
                            } else if ($planid == "7") {
                                $end_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($start_date)) . "+ 365 day"));
                            }

                            $end_time = $start_time;

                            $sql8 = "SELECT * FROM `membership` WHERE Customer_Id = '$Customer_Id'";
                            $query8 = mysqli_query($conn, $sql8);
                            if (mysqli_num_rows($query8) > 0) {
                                $result8 = mysqli_fetch_array($query8);
                                $trainer_id = $result8['Trainer_Id'];
                                $dietician_id = $result8['Dietician_Id'];

                                $sql2 = "UPDATE `membership` SET `tx_no`='$t_id',`Package_Id`='$planid',`Status`='1',`Start_Date`='$start_date',`Start_Time`='$start_time',`End_Date`='$end_date',`End_Time`='$end_time' WHERE Customer_Id='$Customer_Id'";
                                $query2 = mysqli_query($conn, $sql2);

                                $sql6 = "SELECT * FROM `trainer` WHERE Trainer_Id='$trainer_id'";
                                $query6 = mysqli_query($conn, $sql6);
                                if ($query6 && mysqli_num_rows($query6) > 0) {
                                    $row6 = mysqli_fetch_array($query6);
                                }
                                $sql7 = "SELECT * FROM `dietician` WHERE Dietician_Id='$dietician_id'";
                                $query7 = mysqli_query($conn, $sql7);
                                if ($query7 && mysqli_num_rows($query7) > 0) {
                                    $row7 = mysqli_fetch_array($query7);
                                }
                                
                            } else {
                                $trainer = array();
                                $sql4 = "SELECT `Trainer_Id` FROM `trainer`";
                                $query4 = mysqli_query($conn, $sql4);
                                if (mysqli_num_rows($query4) > 0) {
                                    while ($row4 = mysqli_fetch_row($query4)) {
                                        $trainer[] = $row4[0];
                                    }
                                }

                                $dietician = array();
                                $sql5 = "SELECT `Dietician_Id` FROM `dietician`";
                                $query5 = mysqli_query($conn, $sql5);
                                if (mysqli_num_rows($query5) > 0) {
                                    while ($row5 = mysqli_fetch_row($query5)) {
                                        $dietician[] = $row5[0];
                                    }
                                }

                                $random_key1 = array_rand($trainer);
                                $random_key2 = array_rand($dietician);

                                $sql2 = "INSERT INTO `membership`(`Membership_Id`, `Customer_Id`, `tx_no`, `Package_Id`, `Trainer_Id`, `Dietician_Id`, `Status`, `Start_Date`, `Start_Time`, `End_Date`, `End_Time`) VALUES ('','$Customer_Id','$t_id','$planid','$trainer[$random_key1]','$dietician[$random_key2]','$sta','$start_date','$start_time','$end_date','$end_time')";
                                $query2 = mysqli_query($conn, $sql2);

                                $sql6 = "SELECT * FROM `trainer` WHERE Trainer_Id='$trainer[$random_key1]'";
                                $query6 = mysqli_query($conn, $sql6);
                                if ($query6 && mysqli_num_rows($query6) > 0) {
                                    $row6 = mysqli_fetch_array($query6);
                                }
                                $sql7 = "SELECT * FROM `dietician` WHERE Dietician_Id='$dietician[$random_key2]'";
                                $query7 = mysqli_query($conn, $sql7);
                                if ($query7 && mysqli_num_rows($query7) > 0) {
                                    $row7 = mysqli_fetch_array($query7);
                                }
                            }
                            
                        }
                        if ($status == "succeeded") {

                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'help.fitzy@gmail.com';
                            $mail->Password = 'Fitzy@12345';
                            $mail->SMTPSecure = 'tls';
                            $mail->Port = 587;

                            $mail->addAddress($email, $name);
                            $mail->addReplyTo("help.fitzy@gmail.com");

                            $mail->isHTML(true);
                            $mail->Subject = "Payment Recieved!";

                            $mail->Body = '<table width="500px" align="center" border="0" style="background-color: #FFFFFF;"><tr><th style="font-size: 28px; padding: 30px; text-align: center;">Hello, ' . $name . '</th></tr><tr><td style="font-size: 18px; padding: 10px; text-align: justify;">We have Recieved Your Payment of &#8377;' . $amount . '</td></tr><tr><td style="font-size: 18px; padding: 10px; text-align: justify;">Your Membership will be activated under 24 hours!</td></tr><tr><td style="font-size: 26px; padding: 10px; font-weight: bold; text-align: center;">Order ID: ' . $txn_id . '</td></tr><tr><td style="font-size: 18px; padding: 10px;">Thank You,<br>Fitzy</td></tr></table>';

                            if (!$mail->send()) {
                                echo '<b><script>if (swal("Error Occured!", "Something Went Wrong!", "error")) {setTimeout(function () { window.location.href="index.php"; }, 3000); }</script>';
                            } else {

                                $mail1 = new PHPMailer(true);

                                $mail1->isSMTP();
                                $mail1->Host = 'smtp.gmail.com';
                                $mail1->SMTPAuth = true;
                                $mail1->Username = 'help.fitzy@gmail.com';
                                $mail1->Password = 'Fitzy@12345';
                                $mail1->SMTPSecure = 'tls';
                                $mail1->Port = 587;

                                $mail1->addAddress($email, $name);
                                $mail1->addReplyTo("help.fitzy@gmail.com");

                                $mail1->isHTML(true);
                                $mail1->Subject = "Membership Activated!";

                                $mail1->Body = ' <table width="500px" align="center" border="0" style="background-color: #FFFFFF;"><tr> <th style="font-size: 28px; padding: 30px; text-align: center;">Hello, ' . $name . '</th> </tr> <tr> <td style="font-size: 18px; padding: 10px; text-align: justify;">Your Membership has been activated successfully! You can check info on your profile.</td> </tr> <tr> <td style="font-size: 18px; padding: 10px; text-align: justify;">We have assigned a trainer and dietician for you!</td> </tr> <tr> <td style="font-size: 26px; padding: 10px; font-weight: bold; text-align: center;">Your Trainer is: ' . $row6['Name'] . '</td> </tr> <tr> <td style="font-size: 26px; padding: 10px; font-weight: bold; text-align: center;">Your Trainer Contact No is: ' . $row6['Contact_No'] . '</td> </tr> <tr> <td style="font-size: 26px; padding: 10px; font-weight: bold; text-align: center;">Your Dietician is: ' . $row7['Name'] . '</td> </tr> <tr> <td style="font-size: 26px; padding: 10px; font-weight: bold; text-align: center;">Your Dietician Contact No is: ' . $row7['Contact_No'] . '</td> </tr> <tr> <td style="font-size: 18px; padding: 10px;">Thank You,<br>Fitzy</td> </tr> </table>';
                            }
                            $mail1->send();
                        } else {
                            echo '<script>if (swal("Declined!!", "Your Transaction has been declined! Try again after few hours.", "error")) {setTimeout(function () {  window.location.href="index.php"; }, 3000); }</script>';
                        }
                    }

    ?>
                    <div class="container mt-5 mb-5">
                        <div class="row d-flex justify-content-center" id="main-page">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="text-left logo p-3 px-1 logo"> <a href="./index.php"><img src="img/logo.png" width="150"> </a></div>
                                    <div class="invoice p-5">
                                        <h5>We have Recieved Your Payment!</h5> <span class="font-weight-bold d-block mt-4">Hello, <?= $name ?>!</span> <span>Your payment has been confirmed and your membership will be activated under 24 hours!</span>
                                        <div class="payment border-top mt-3 mb-3 border-bottom table-responsive">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="py-1"> <span class="d-block text-muted">Order Date</span> <span><?php echo date('Y-m-d'); ?></span> </div>
                                                        </td>
                                                        <td>
                                                            <div class="py-2"> <span class="d-block text-muted">Order No</span> <span><?= $txn_id ?></span> </div>
                                                        </td>
                                                        <td>
                                                            <div class="py-2"> <span class="d-block text-muted">Payment</span> <span><img src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/visa.svg" width="20" /></span> </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="product border-bottom table-responsive">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td width="40%"> <img src="<?php if (!empty($Photo)) {
                                                                                        echo "data:image/jpg;charset=utf8;base64," . base64_encode($Photo);
                                                                                    } else {
                                                                                        echo "img/fitness-vector.png";
                                                                                    } ?>" width="300"> </td>
                                                        <td width="60%"> <span class="font-weight-bold text-center h4"><?= $Package_Name ?></span>
                                                            <div class="product-qty"> <span class="d-block">Quantity: 1</span></div>
                                                        </td>
                                                        <td width="20%">
                                                            <div class="text-right"> <span class="font-weight-bold h4">&#8377;<?= $amount ?></span> </div>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row d-flex justify-content-end">
                                            <div class="col-md-5">
                                                <table class="table table-borderless">
                                                    <tbody class="totals">
                                                        <tr>

                                                        </tr>
                                                        <tr class="border-top border-bottom">
                                                            <td>
                                                                <div class="text-left"> <span class="font-weight-bold">Total</span> </div>
                                                            </td>
                                                            <td>
                                                                <div class="text-right"> <span class="font-weight-bold">&#8377;<?= $amount ?></span> </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <p>Your Membership will be activated on <?= $_SESSION['email'] ?></p>
                                        <p class="font-weight-bold mb-0">Thanks for shopping with us!</p> <span>Fitzy Team</span>
                                    </div>
                                    <div class="d-flex justify-content-between"></div>
                                </div>
                            </div>
                        </div>
                    </div>
    <?php
                    include "footer.php";
                }
            }
        }
    } else {
        header("Location: ./index.php");
    }
    ?>


</body>

</html>