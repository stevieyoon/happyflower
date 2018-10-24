<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<form name="mallForm" id="mallForm" method="POST">

    <?php
    /* ============================================================================== */
    /* =   2. 가맹점 필수 정보 설정                                                 = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ※ 필수 - 결제에 반드시 필요한 정보입니다.                               = */
    /* = -------------------------------------------------------------------------- = */
    ?>
    <input type="hidden" name="version"     id="version"        value="<?php echo $mpay_ver; ?>" />
    <input type="hidden" name="server"      id="server"         value="<?php echo $mpay_server; ?>" />
    <input type="hidden" name="mbrId"       id="mbrId"          value="<?php echo $mpay_site_mid; ?>" />
    <input type="hidden" name="payKind"     id="payKind"        value="1" />
    <input type="hidden" name="mbrName"     id="mbrName"        value="<?php echo $mpay_site_name;?>" />

    <input type="hidden" name="buyerName"   id="buyerName"      value="" />
    <input type="hidden" name="buyerMobile" id="buyerMobile"    value="" />
    <input type="hidden" name="buyerEmail"  id="buyerEmail"     value="" />
    <input type="hidden" name="productName" id="productName"    value="<?php echo str_replace(' ', '', $goods)?>" />
    <input type="hidden" name="salesPrice"  id="salesPrice"     value="<?php echo $tot_price?>" />
    <input type="hidden" name="bizNo"       id="bizNo"          value="<?php echo str_replace('-', '', $default['de_admin_company_saupja_no'])?>" />
    <input type="hidden" name="oid"         id="oid"            value="<?php echo $od_id?>" />
    <input type="hidden" name="returnType"  id="returnType"     value="payment" > <!-- 고정 -->
    <input type="hidden" name="authType"    id="authType"       value="auth" /> <!-- 고정 -->
    <input type="hidden" name="returnUrl"   id="returnUrl"      value="<?php echo G5_SHOP_URL.'/mainpay/pay_hub.php';?>" />
    <input type="hidden" name="callbackUrl" id="callbackUrl"    value="<?php echo G5_SHOP_URL.'/mainpay/pay_result.php';?>" />
    <input type="hidden" name="cancelUrl"   id="cancelUrl"      value="<?php echo G5_SHOP_URL.'/mainpay/pay_back.php';?>" />
    <input type="hidden" name="hashValue"   id="hashValue"      value="" />
    <?php
    /* = -------------------------------------------------------------------------- = */
    /* =   2. 가맹점 필수 정보 설정 END                                             = */
    /* ============================================================================== */
    ?>

    <input type="hidden" name="viewType"    id="viewType"       value="<?php echo (is_mobile() ? 'self' : 'popup');?>" />
    <input type="hidden" name="notiYn"      id="notiYn"         value="Y" />
    <input type="hidden" name="BILLTYPE"    id="BILLTYPE"       value="00" />
    <input type="hidden" name="payType"     id="payType"        value="CSQ" />
    <input type="hidden" name="host"        id="host"           value="<?php echo G5_SHOP_URL.'/mainpay/';?>" />

</form>