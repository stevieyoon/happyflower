<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$ApprovDate = str_replace('-', '', substr($od_receipt_time, 2, 8));
$API_URL = '';

if ($od_settle_case == '신용카드') {

    $fields = array(
        'version'        => $mpay_ver,
        'mbrId'          => $mpay_site_mid,
        'oid'            => $od_id,
        'cardTradeNo'    => $od_tno,
        'cardApprovDate' => $ApprovDate,
        'salesPrice'     => $pg_price,
        'payType'        => $od_app_no,
    );
    $API_URL = $mpay_cancel_url . 'cardCancel.do';
}
else if ($od_settle_case == '계좌이체') {

    $fields = array(
        'version'        => $mpay_ver,
        'mbrId'          => $mpay_site_mid,
        'oid'            => $od_id,
        'accountTradeNo' => $od_app_no,
        'accountApprov'  => $od_tno,
        'accountApprovDate' => $ApprovDate,
        'salesPrice'     => $pg_price,
    );
    $API_URL = $mpay_cancel_url . 'cashCancel.do';
}
else if ($od_settle_case == '휴대폰') {

    $fields = array(
        'version'        => $mpay_ver,
        'mbrId'          => $mpay_site_mid,
        'oid'            => $od_id,
        'mobileTradeNo'  => $od_tno,
        'mobileApprovDate' => $ApprovDate,
        'salesPrice'     => $pg_price,
    );
    $API_URL = $mpay_cancel_url . 'mobileCancel.do';
}

$result = httpPost($API_URL, $fields);
$obj = json_decode($result);

if (($obj->{'resultCode'}) == '0000' || ($obj->{'resultCode'}) == '00') {
    $res_cd = '00';
    $res_msg = $obj->{'resultMsg'};
}
else {
    $res_cd = $obj->{'resultCode'};
    $res_msg = $obj->{'resultMsg'};
}

function httpPost($url, $params) {

    $postData = '';

    foreach ($params as $k => $v) {
        $postData .= $k . '='.$v.'&';
    }
    $postData = rtrim($postData, '&');

    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, count($postData));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $output=curl_exec($ch);

    curl_close($ch);

    return $output;
}