<?php
include_once('./_common.php');
require_once(G5_SHOP_PATH.'/settle_mainpay.inc.php');

$salesPrice   = preg_replace('/[^0-9]/', '', $_POST['salesPrice']);
$oid          = preg_replace('/[^0-9]/', '', $_POST['oid']);
$timestamp    = date('YmdHis');

// hashValue 생성
$sign = hash("sha256", $mpay_site_mid.'|'.$salesPrice.'|'.$oid.'|'.$timestamp, false);
$hashValue = $timestamp.$sign;

die('{"resdata":"'.$hashValue.'"}');