<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$mpay_server = '1'; // 테스트서버 여부 0 : Test 서버, 1 : Real 서버
$mpay_js_url = 'https://pg.mainpay.co.kr/csStdPayment/resources/script/v1/c2StdPay.js'; // 결제자바스크립트
$mpay_cancel_url = 'https://pg.mainpay.co.kr/csStdPayment/'; // 승인취소 URL
$mpay_receipt_card_url = 'https://biz.mainpay.co.kr/card/cardReceipt_popup.do'; // 신용카드 영수증
$mpay_receipt_cash_url = 'https://biz.mainpay.co.kr/card/cashReceiptPopUp.do'; // 현금 영수증
if ($default['de_mainpay_test']) {
    $default['de_mainpay_mid']      = '100011';
    $default['de_mainpay_key']      = 'U1FVQVJFDDDFSFSDwMTU3OTIwMTcxMTAFDSFDSA';
    $default['de_mainpay_corpname'] = '테스트 상점';
    $mpay_js_url = 'https://testpg.mainpay.co.kr/csStdPayment/resources/script/v1/c2StdPay.js';
    $mpay_cancel_url = 'https://testpg.mainpay.co.kr/csStdPayment/';
    $mpay_receipt_card_url = 'https://dev-biz.mainpay.co.kr/card/cardReceipt_popup.do';
    $mpay_receipt_cash_url = 'https://dev-biz.mainpay.co.kr/card/cashReceiptPopUp.do';
    $mpay_server = '0';
}

$mpay_ver         = '3.1';
$mpay_site_mid    = $default['de_mainpay_mid']; // 가맹점 번호
$mpay_site_key    = $default['de_mainpay_key']; // 가맹점 키
$mpay_site_name   = $default['de_admin_company_name']; // 가맹점 명 ((주)씨스퀘어소프트에 등록한 가맹점 명)
$mpay_home_dir    = G5_SHOP_PATH.'/mainpay';

if(trim($mpay_site_mid) == '')
    alert('MAINPAY ID 를 입력해 주십시오.');

function mpay_payment_type($type = '1') { 
    switch ($type) {
        case '2':
            return '가상계좌';
        break;
        case '3':
            return '계좌이체';
        break;
        case '4':
            return '휴대폰결제';
        break;
        default:
            return '신용카드';
        break;
    }
}