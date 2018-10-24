<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$subject = $config['cf_title'].' 결제정보 처리 오류 알림 메일';
$content = '<p>주문정보 결제 처리중 오류가 발생했습니다. 주문번호 : '.$od_id.'</p>';
$content .= '<p>정보 : '.$error.$cancel_msg.'</p>';

if($tno) {
    $content .= '<p>PG사 거래번호는 '.$tno.' 입니다.</p>';
}

// 메일발송
//mailer('관리자', $config['cf_admin_email'], $config['cf_admin_email'], $subject, $content, 1);
?>