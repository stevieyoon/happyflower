<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- MD 추천상 { -->
<aside id="scomm">
    <h2>MD 추천상품</h2>
    <ul>
		<li><i class="fa fa-angle-right" aria-hidden="true"></i><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=1"> 히트상품</a></li>
		<li><i class="fa fa-angle-right" aria-hidden="true"></i><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=2"> 추천상품</a></li>
		<li><i class="fa fa-angle-right" aria-hidden="true"></i><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=3"> 최신상품</a></li>
		<li><i class="fa fa-angle-right" aria-hidden="true"></i><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=4"> 인기상품</a></li>
		<li><i class="fa fa-angle-right" aria-hidden="true"></i><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=5"> 할인상품</a></li>
     </ul>
</aside>
<!-- } MD 추천 끝 -->