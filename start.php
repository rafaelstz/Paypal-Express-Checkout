<?php

require('includes/config.php');
require('includes/paypal.php');

session_start();

$paypal = new PayPal($config);

$shippingAddress = [
    'EMAIL' => $_POST["email"],
    'PAYMENTREQUEST_n_SHIPTONAME' => $_POST["firstName"],
    'PAYMENTREQUEST_n_SHIPTOPHONENUM' => $_POST["phone"],
    'PAYMENTREQUEST_n_SHIPTOSTREET' => $_POST["address"],
    'PAYMENTREQUEST_n_SHIPTOSTREET2' => $_POST["address2"],
    'PAYMENTREQUEST_n_SHIPTOCITY' => $_POST["city"],
    'PAYMENTREQUEST_n_SHIPTOCOUNTRYCODE' => $_POST["country"],
    'PAYMENTREQUEST_n_SHIPTOSTATE' => $_POST["state"],
    'PAYMENTREQUEST_n_SHIPTOZIP' => $_POST["zip"]
];

$_SESSION['SHIPPING'] = $shippingAddress;

$paymentData = [
    'method'  => 'SetExpressCheckout',
    'paymentrequest_0_paymentaction' => 'sale',
    'paymentrequest_0_amt'  => '20.00',
    'paymentrequest_0_currencycode'  => 'USD',
    'paymentrequest_0_itemamt'  => '25.00',
    'paymentrequest_0_shipdiscamt'  => '-5',
    'l_paymentrequest_0_name0'  => 'First product',
    'l_paymentrequest_0_amt0'  => '12.00',
    'l_paymentrequest_0_qty0'  => '1',
    'l_paymentrequest_0_taxamt0'  => '0',
    'l_paymentrequest_0_number0'  => '369TR',
    'l_paymentrequest_0_itemcategory0'  => 'Digital',
    'l_paymentrequest_0_name1'  => 'Second product',
    'l_paymentrequest_0_amt1'  => '8.00',
    'l_paymentrequest_0_qty1'  => '1',
    'l_paymentrequest_0_taxamt1'  => '0',
    'l_paymentrequest_0_number1'  => '287XR',
    'l_paymentrequest_0_itemcategory1'  => 'Digital',
    'l_paymentrequest_0_name2'  => 'Third product',
    'l_paymentrequest_0_amt2'  => '5.00',
    'l_paymentrequest_0_qty2'  => '1',
    'l_paymentrequest_0_taxamt2'  => '0',
    'l_paymentrequest_0_number2'  => '832EC',
    'l_paymentrequest_0_itemcategory2'  => 'Digital',
    'returnurl'  => 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/success.php',
    'cancelurl'  => 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/cancel.php',
];

$result = $paypal->call(array_merge($_SESSION['SHIPPING'], $paymentData));

if ($result['ACK'] == 'Success') {
    $paypal->redirect($result);
} else {
    var_dump($result);exit;
    echo 'Handle the payment creation failure <br>';
}