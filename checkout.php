<?php
session_start();

if (isset($_SESSION['email']) && isset($_SESSION['password'])) {

    header('Content-Type', 'application/json');

    $planid = $_SESSION['planid'];
    $Package_Name = $_SESSION['pacname'];
    $Description = $_SESSION['desc'];
    $PackageAmount = $_SESSION['amt'];
    $email = $_SESSION['email'];
    $Keywords = explode(",", $Description);
    if (is_array($Keywords)) {
        foreach ($Keywords as $key => $val) {
            $Keywords[$key] = trim($val);
        }
    }

    include "connect.php";
    require 'vendor/autoload.php';

    // This is your test secret API key.
    \Stripe\Stripe::setApiKey('sk_test_51KRDqNSGYAuA7doF7tRqGWhAYsoBZEm33MeUJIQpdtsK6SVySL9TaXYiUgWWcikbYC5DQldp7pidv2OsC0N4Hbu600CSWrvfpH');

    $YOUR_DOMAIN = 'http://localhost/fitzy';
    $checkout_session = \Stripe\Checkout\Session::create([
        "payment_method_types" => ['card'],
        'mode' => 'payment',

        'line_items' => [[
            'price_data' => [
                'currency' => 'inr',
                'product_data' => [
                    'name' => $Package_Name,
                    'description' => $Description,
                ],
                'unit_amount' => $PackageAmount * 100,
            ],
            'quantity' => 1,
        ]],
        'success_url' => $YOUR_DOMAIN . '/success.php?session_id={CHECKOUT_SESSION_ID}&plan_id=' . $planid,
        'cancel_url' => $YOUR_DOMAIN . '/cancel.php',
    ]);

    echo json_encode(['id' => $checkout_session->id]);
    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url);
} else {
    header("Location: index.php");
}
