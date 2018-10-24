<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- 고객센터 시작 { -->
<aside id="scomm">
    <h2>고객센터</h2>
    <ul>
		<li><i class="fa fa-angle-right" aria-hidden="true"></i><a href="<?php echo G5_BBS_URL; ?>/faq.php"> FAQ</a></li>
		<li><i class="fa fa-angle-right" aria-hidden="true"></i><a href="<?php echo G5_BBS_URL; ?>/qalist.php"> 1:1문의</a></li>
		<li><i class="fa fa-angle-right" aria-hidden="true"></i><a href="<?php echo G5_SHOP_URL; ?>/personalpay.php"> 개인결제</a></li>
		<li><i class="fa fa-angle-right" aria-hidden="true"></i><a href="<?php echo G5_SHOP_URL; ?>/itemuselist.php"> 사용후기</a></li>
		<li><i class="fa fa-angle-right" aria-hidden="true"></i><a href="<?php echo G5_SHOP_URL; ?>/couponzone.php"> 쿠폰존</a></li>
     </ul>
</aside>
<!-- } 고객센터 끝 -->