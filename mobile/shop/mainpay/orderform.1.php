<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<script type="text/javascript" src="<?php echo $mpay_js_url;?>"></script>
<script>
function  mpayFnSubmit( form, paytype )
{

    var mfrm = document.forms.mallForm;
	var order_name = "[<?php echo $config['cf_title']?>]"+form.od_name.value;
    mfrm.payKind.value = paytype;
    mfrm.buyerName.value = order_name;
    mfrm.buyerMobile.value = form.od_tel.value;
    mfrm.buyerEmail.value = form.od_email.value;
    mfrm.salesPrice.value = form.good_mny.value;
    
    var hashValue = "";
    $.ajax({
        type: "post",
        data: {'salesPrice': form.good_mny.value, 'oid': mfrm.oid.value},
        url: "<?php echo G5_SHOP_URL?>/mainpay/orderform.enc.php",
        cache: false,
        async: false,
        dataType: "json",
        success : function(req) {
            hashValue = req.resdata;
        }
    });

    if (!hashValue) {
        alert("전달값 초기화에 실패하였습니다. 다시 시도해주세요.");
        return false;
    }
    else {
        mfrm.hashValue.value = hashValue;
    }

    var order_data = $(form).serialize();
    var save_result = "";
    $.ajax({
        type: "POST",
        data: order_data,
        url: g5_url+"/shop/ajax.orderdatasave.php",
        cache: false,
        async: false,
        success: function(data) {
            save_result = data;
        }
    });

    if (save_result) {
        alert(save_result);
    }
    else {
        C2StdPay.pay();
    }
}

function checkClosed(){
    $('#display_pay_button').show();
    $('#display_pay_process').hide();
}

function mpayPpSubmit( form )
{
    $('#display_pay_button').hide();
    $('#display_pay_process').show();
}
</script>


<form name="sm_form" method="POST">
    <input type="hidden" name="good_mny" value="<?php echo $tot_price ?>" >
</form>