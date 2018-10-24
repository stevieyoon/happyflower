<?php
include_once('./_common.php');
include_once(G5_PATH.'/head.sub.php');
require_once(G5_SHOP_PATH.'/settle_mainpay.inc.php');

$sw_direct = get_session("ss_direct") ? '1' : '';

if (!is_mobile()) {
    ?>
    <script type="text/javascript">
        <!--
        alert('결제가 실패되었습니다.');
        $('#display_pay_button', opener.document).show();
        $('#display_pay_process', opener.document).hide();
        this.close();
        //-->
    </script>
    <?php
}
else {
    alert('결제가 취소되었습니다.', G5_SHOP_URL.'/orderform.php?sw_direct='.$sw_direct);
}

include_once(G5_PATH.'/tail.sub.php');
?>