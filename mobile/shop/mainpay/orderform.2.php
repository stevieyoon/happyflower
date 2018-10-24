<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<input type="hidden" name="good_mny"    value="<?php echo $tot_price; ?>"> <!-- 영카트 로직을 위한 값 -->
<input type="hidden" name="ordr_idxx"   value="<?php echo $od_id; ?>">


<div id="display_pay_button" class="btn_confirm">
    <span id="show_req_btn"><input type="button" name="submitChecked" onClick="pay_approval();" value="결제등록요청"class="btn_submit"></span>
    <span id="show_pay_btn" style="display:none;"><input type="button" onClick="forderform_check();" value="주문하기" class="btn_submit"></span>
    <a href="<?php echo G5_SHOP_URL; ?>" class="btn_cancel">취소</a>
</div>

<?php
// 무통장 입금만 사용할 때는 주문하기 버튼 보이게
if(!($default['de_iche_use'] || $default['de_vbank_use'] || $default['de_hp_use'] || $default['de_card_use'])) {
?>
<script>
document.getElementById("show_req_btn").style.display = "none";
document.getElementById("show_pay_btn").style.display = "";
</script>
<?php } ?>