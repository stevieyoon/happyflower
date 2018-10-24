<?php
include_once('./common.php');
// 주문번호와 state_data에 배송사진 경로가 들어온다면 배송갤러리에 insert
$order_no = $_REQUEST['order_no'];
$state_cd = $_REQUEST['state_cd'];
$state_data = $_REQUEST['state_data'];
$extern_no = $_REQUEST['extern_no']; // 무통장, 신용카드, 계좌이체 등의 결제수단

if (contains('http://rest.18002019.com/v1/', $state_data)) {
    $sql = " select count(*) as cnt from {$g5['delivery_gallery']}
              where order_no = '$order_no'
                and site_id = '$site_id' ";
    $row = sql_fetch($sql);

    // 배송갤러리에 insert
    if (!$row['cnt']) {

        $mb_info = get_member($cart['mb_id'], 'mb_name, mb_email');

        $sql = " insert into {$g5['delivery_gallery']}
                    set dg_subject = '배송갤러리입니다.',
                         dg_name = '{$mb_info['mb_name']}',
                         dg_email = '{$mb_info['dg_email']}',
                         dg_datetime = '".G5_TIME_YMDHIS."',
                         state_data = '$state_data',
                         order_no = '$order_no',
                         od_id = '{$cart['od_id']}',
                         it_id = '{$cart['it_id']}',
                         site_id = '$site_id' ";
        sql_query($sql);
        echo $sql;
    }
}

include_once(G5_LIB_PATH.'/thumbnail.lib.php');
$url = "http://rest.18002019.com/v1/order_r_img?c=180227-000403&t=3";

//http://master.hpflower.com/shop/order_status.php?order_no=180523-000513&state_cd=order_done&state_data=http://rest.18002019.com/v1/order_r_img?c=180523-000513&t=3&extern_no=%EB%AC%B4%ED%86%B5%EC%9E%A5&
$filename = save_remote_image($state_data, $order_no);
echo $filename;

/*
if($http_code != 200) {
$tmpname = date('YmdHis').(microtime(true) * 10000);
$tmpname = $tmpname.'.jpg';
$path = G5_PATH.'/test/'.$tmpname.'/';
@mkdir($path, '0755');
@chmod($path, '0755');
$savefile = fopen($path. $tmpname, 'w');
fwrite($savefile, $content);
fclose($savefile);
}
*/
?>