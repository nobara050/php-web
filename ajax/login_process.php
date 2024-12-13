<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../classes/customer.php');
include_once ($filepath.'/../lib/session.php'); // Đảm bảo include class Session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $customer = new Customer();
    $response = $customer->login_customer($_POST);
    echo $response;
}
?>
