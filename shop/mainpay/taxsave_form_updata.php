<?php
include_once('./_common.php');

// 쇼핑몰 정보를 가져옴
$shop_default = get_shop_default($_POST['site_id']);

$site_id = $_POST['site_id'];
$od_id = $_POST['od_id'];
$amount = $_POST['amount'];
$stamp_time = date("YmdHis");
$goodsName = $_POST['goodsName'];
$od_name = $_POST['customerName'];
$customerPk = $_POST['customerPk'];
$num = sprintf('%02d',$_POST['personType']);


$de_mainpay_mid = $shop_default['de_mainpay_mid'];
$de_cpcode = $shop_default['de_cpcode'];

$sign = hash('sha256', $de_mainpay_mid.'|'.$od_id.'|'.$amount.'|'.$de_cpcode.'|'.$stamp_time);
$hash = $sign;

$mbrNo = $shop_default['de_mainpay_mid'];

$mbrRefNo = $od_id;
$personType = $num; // 개인, 법인 01 : 개인 (자진발급 포함) 02 : 법인사업자
$customerPk = $customerPk; // 01034254500, 11112222111122 휴대폰번호, 주민번호, 사업자번호 현금영수증카드 번호, 기타 식별자 @자진발급 시에 아래와 같이 고정
$amount = $amount; // 결제금액 1000 공급가 + 부가세
$taxAmt = 0; // 부가세0  Default : 0
$goodsName = $goodsName; //  상품명 축구공 판매 상품명 Y
$customerName = $od_name; // 구매자명 홍길동 30
$signature = $hash; // 서명값  a4fad567bd46611ed7dad73086080241df956d7d9d9cc2c0e518ee22af5299e3 결제 위변조 방지를 위한 파라미터 서명 값 (참고 2.1.1 요청signature 생성 )
$timestamp = $stamp_time;   //타임스템프 20160614210832 YYYYMMDDHHMI24SS 형식의 문자열 Y
$clientType = "web";  // 클라이언트 타입 Online , pos 클라이언트 타입 (고정) 10


$ch = curl_init();

$post_data = array(
    "mbrNo" => $mbrNo,
    "mbrRefNo" => $mbrRefNo,
    "personType" => $personType,
    "customerPk" => $customerPk,
    "amount" => $amount,
    "taxAmt" => $taxAmt,
    "goodsName" => $goodsName,
    "customerName" => $customerName,
    "signature" => $signature,
    "timestamp" => $timestamp,
    "clientType" => $clientType
);

$url = "https://relay.mainpay.co.kr/v1/api/payments/payment/cash-receipt/trans";
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch,CURLOPT_HEADER,0);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
curl_setopt($ch,CURLOPT_TIMEOUT,30);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_HTTPHEADER,array(
));
$result = curl_exec($ch);
curl_close($ch);

$data = json_decode($result);

$refNo = $data->data->refNo;
$applNo = $data->data->applNo;
if($data->resultCode == 200){

    $sql = " update {$g5['g5_shop_order_table']}
				set od_tno = '$refNo',
					 od_app_no = '$applNo'
				where od_id = '$od_id' ";
    sql_query($sql);
}

$urllike = G5_SHOP_URL.'/taxsave.php?od_id='.$od_id;
goto_url($urllike);
?>