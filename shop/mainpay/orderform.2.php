<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<input type="hidden" name="good_mny"        value="<?php echo $tot_price; ?>"> <!-- 영카트 로직을 위한 값 -->
<input type="hidden" name="wz_mobile"       value="0" />
<input type="hidden" name="wz_ip"           value="<?php echo $_SERVER['REMOTE_ADDR'];?>" />