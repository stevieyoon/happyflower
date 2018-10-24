<?php
include_once('./_common.php');
include_once(G5_PATH.'/head.sub.php');
require_once(G5_SHOP_PATH.'/settle_mainpay.inc.php');

$mbrId      = clean_xss_tags($_REQUEST['mbrId']); // 가맹점아이디
$rstCode    = clean_xss_tags($_REQUEST['rstCode']); // 결과코드
$rstMsg     = clean_xss_tags($_REQUEST['rstMsg']); // 결과 메세지 
$oid        = clean_xss_tags($_REQUEST['oid']); // 가맹점 주문번호
$payKind    = clean_xss_tags($_REQUEST['payKind']); // 결제종류[1:카드, 2:가상계좌, 3:계좌이체, 4:휴대폰]
$salesPrice = clean_xss_tags($_REQUEST['salesPrice']); // 결제 금액

$od_id      = $oid;
$amount     = $salesPrice;

$sql = " select * from {$g5['g5_shop_order_data_table']} where od_id = '$od_id' ";
if($is_member)
    $sql .= " and mb_id = '{$member['mb_id']}' ";

$row = sql_fetch($sql, true);

$od_time = $row['dt_time'];

$data = unserialize(base64_decode($row['dt_data']));
$od_ip = $data['wz_ip'];

// orderview 에서 사용하기 위해 session에 넣고
$uid = md5($od_id.$od_time.$od_ip);
set_session('ss_orderview_uid', $uid);

// 주문번호제거
set_session('ss_order_id', '');

// 기존자료 세션에서 제거
if (get_session('ss_direct'))
    set_session('ss_cart_direct', '');
?>

    <script type="text/javascript">
        <!--
        // 결제 중 새로고침 방지 샘플 스크립트 (중복결제 방지)
        function noRefresh()
        {
            /* CTRL + N키 막음. */
            if ((event.keyCode == 78) && (event.ctrlKey == true))
            {
                event.keyCode = 0;
                return false;
            }
            /* F5 번키 막음. */
            if(event.keyCode == 116)
            {
                event.keyCode = 0;
                return false;
            }
        }

        document.onkeydown = noRefresh ;

        window.onload = function (){
            gopage();
        }
        function gopage() {
            setTimeout(function(){
                    <?php if (!is_mobile()) { // 모바일은 새창을 사용하지 않음?>
                    opener.location.replace("<?php echo G5_SHOP_URL?>/orderinquiryview.php?od_id=<?php echo $od_id?>&uid=<?php echo $uid?>");
                    this.close();
                    <?php } else { ?>
                    location.replace("<?php echo G5_SHOP_URL?>/orderinquiryview.php?od_id=<?php echo $od_id?>&uid=<?php echo $uid?>");
                    <?php } ?>
                },
                3000);
        }
        //-->
    </script>

    <div style="text-align:center;margin-top:100px;">
        <div><img src="./img/loading.gif" border=0 /></div>
        <div style="margin:10px 0 0;">
            &copy; <?php echo $default['de_admin_company_name'];?>
        </div>
        <div style="margin:10px 0 0;">
            <img src="<?php echo G5_IMG_URL?>/card_error.jpg" style="width:491px; height:208px">
        </div>
    </div>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>