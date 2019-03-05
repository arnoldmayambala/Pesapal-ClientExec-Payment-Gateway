<?php

if (isset($_GET['demo'])){
exit('working');   
}
global $CONFIG;
/*
  include("../../../dbconnect.php");
  include("../../../includes/gatewayfunctions.php"); */

require_once __DIR__ . '/../../../init.php';
require_once __DIR__ . '/../../../includes/gatewayfunctions.php';
require_once __DIR__ . '/../../../includes/invoicefunctions.php';

$gatewaymodule = "pesapal";
$gateway = getGatewayVariables($gatewaymodule);
$systemurl = ($CONFIG['SystemSSLURL']) ? $CONFIG['SystemSSLURL'] . '/' : $CONFIG['SystemURL'] . '/';


$baseURL = $gateway['basedomainurl'] ? $gateway['basedomainurl'] : $systemurl;


# Checks gateway module is active before accepting callback
if (!$gateway["type"])
    die("PesaPal Module Not Activated");

$ca = new ClientExec_ClientArea();
$ca->initPage();
$ca->requireLogin();

# Get Returned Variables
$data['invoiceid'] = $_GET['pesapal_merchant_reference'];
$data['transactionid'] = $_GET['pesapal_transaction_tracking_id'];
$data = serialize($data);
$data = base64_encode($data);

$returnURL = $baseURL . 'modules/gateways/pesapal/return.php?pid=' . $data;

header("Location: $returnURL");
exit;
?>
