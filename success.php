<?php

require('includes/config.php');
require('includes/paypal.php');

session_start();

$paypal = new PayPal($config);

$result = $paypal->call(array_merge([
    'method'  => 'DoExpressCheckoutPayment',
    'paymentrequest_0_paymentaction' => 'sale',
    'paymentrequest_0_amt'  => '19.99',
    'paymentrequest_0_currencycode'  => 'USD',
    'token'  => $_GET['token'],
    'payerid'  => $_GET['PayerID'],
], $_SESSION['SHIPPING']));

if ($result['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Completed') {
    $return = 'Payment completed';
} else {
    $return = 'Handle payment execution failure';
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sucess</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="bg-light">
<div class="container justify-content-center">
    <div class="py-5 text-center">
        <h2>Sucess!</h2>
        <p class="lead"><?= $return ?></p>
        <p class="lead">Transaction ID: <?= $result['PAYMENTINFO_0_TRANSACTIONID'] ?></p>
    </div>
    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2019 Rafael Corrêa Gomes</p>
    </footer>
</div>
<style>
    .container {
        max-width: 960px;
    }

    .lh-condensed { line-height: 1.25; }
    .bg-light{
        background-color: #f8f9fa!important;
    }
</style>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
<?php session_destroy();
