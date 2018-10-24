<?php
include_once('./_common.php');

// 일단은 설정
/*
$_REQUEST['order_no'] = '180516-000290';
$_REQUEST['state_cd'] = 'order_cancel';
$_REQUEST['state_data'] = '고객취소';
*/
$order_no = $_REQUEST['order_no'];
$state_cd = $_REQUEST['state_cd'];
$state_data = $_REQUEST['state_data'];
$extern_no = $_REQUEST['extern_no']; // 무통장, 신용카드, 계좌이체 등의 결제수단


$pg_cancel = 0; // 카드취소인지 여부 기본값은 0

// 주문상태 값
switch ($state_cd) {
    case 'cash_pay_ok':
    case 'card_pay_ok':
        $ct_status = '입금';
        break;
    case 'card_pay_cancel':
    case 'cash_pay_cancel':
    case 'order_cancel':
        $ct_status = '취소';
        break;
    case 'order_pass':
    case 'order_delivery':
        $ct_status = '배송';
        break;
    case 'order_done':
        $ct_status = '완료';
        break;
    default:
        $ct_status= '';
}

// 결제수단 값
switch ($extern_no) {
    case '신용카드':
        $od_settle_case = '신용카드';
        $pg_cancel = 1;
        break;
    case '무통장':
        $od_settle_case = '무통장';
        break;
    default:
        $od_settle_case= '';
}

// 넘어온 주문번호로 리본 테이블을 조회
$ribbon = get_ribbon_order_no($order_no);

// 리본 고유번호
$rb_id = $ribbon['rb_id'];

// 넘어온 주문번호로 장바구니 테이블 조회
$cart = get_cart_order_no($order_no);

$od_id = $ribbon['od_id']; // 주문번호


// 처리 시작
$ct_chk_count = count($cart);
if(!$ct_chk_count)
    echo 'success:"처리할 자료를 하나 이상 선택해 주십시오."';

$status_normal = array('주문','입금','준비','배송','완료');
$status_cancel = array('취소','반품','품절');

if (in_array($ct_status, $status_normal) || in_array($ct_status, $status_cancel)) {
    ; // 통과
} else {
    echo 'success:"변경할 상태가 올바르지 않습니다."';
}

$mod_history = '';
$cnt = count($cart);
$arr_it_id = array();

// cti 주문번호와 동일한 장바구니의 행의 개수 만큼 루프
for ($i=0; $i<$cnt; $i++)
{
    $ct_id = $cart[$i]['ct_id'];

    if(!$ct_id)
        continue;

    $sql = " select * from {$g5['g5_shop_cart_table']} where od_id = '$od_id' and ct_id  = '$ct_id' and order_no = '$order_no' and site_id = '$site_id' ";
    $ct = sql_fetch($sql);
    if(!$ct['ct_id'])
        continue;

    $point_use = $ct['ct_point_use'];
    // 회원이면서 포인트가 0보다 크면
    // 이미 포인트를 부여했다면 뺀다.
    if ($ct['mb_id'] && $ct['ct_point'] && $ct['ct_point_use'])
    {
        $point_use = 0;
        delete_point($ct['mb_id'], "@delivery", $ct['mb_id'], "$od_id,$ct_id");
    }

    // 히스토리에 남김
    // 히스토리에 남길때는 작업|아이디|시간|IP|그리고 나머지 자료
    $now = G5_TIME_YMDHIS;
    $ct_history="\nCTI에서 "."$ct_status|{$ct['mb_id']}|$now|$REMOTE_ADDR";

    $sql = " update {$g5['g5_shop_cart_table']}
                set ct_point_use  = '$point_use',
                    ct_stock_use  = '$stock_use',
                    ct_status     = '$ct_status',
                    ct_history    = CONCAT(ct_history,'$ct_history')
                where od_id = '$od_id'
                and ct_id  = '$ct_id'
                and order_no = '$order_no'
                and site_id = '$site_id' ";
    sql_query($sql);

    // it_id를 배열에 저장
    if($ct_status == '주문' || $ct_status == '취소' || $ct_status == '반품' || $ct_status == '품절' || $ct_status == '완료')
        $arr_it_id[] = $ct['it_id'];
}

// 상품 판매수량 반영
if(is_array($arr_it_id) && !empty($arr_it_id)) {
    $unq_it_id = array_unique($arr_it_id);

    foreach($unq_it_id as $it_id) {
        $sql2 = " select sum(ct_qty) as sum_qty from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and ct_status = '완료' and site_id = '$site_id' ";
        $row2 = sql_fetch($sql2);

        $sql3 = " update {$g5['g5_shop_item_table']} set it_sum_qty = '{$row2['sum_qty']}' where it_id = '$it_id' and site_id = '$site_id' ";
        sql_query($sql3);
    }
}

// 장바구니 상품 모두 취소일 경우 주문상태 변경
$cancel_change = false;
if (in_array($ct_status, $status_cancel)) {
    $sql = " select count(*) as od_count1,
                    SUM(IF(ct_status = '취소' OR ct_status = '반품' OR ct_status = '품절', 1, 0)) as od_count2
                from {$g5['g5_shop_cart_table']}
                where od_id = '$od_id' and site_id = '$site_id' ";
    $row = sql_fetch($sql);

    if($row['od_count1'] == $row['od_count2']) {
        $cancel_change = true;

        $pg_res_cd = '';
        $pg_res_msg = '';
        $pg_cancel_log = '';

        // PG 신용카드 결제 취소일 때
        if($pg_cancel == 1) {
            $sql = " select * from {$g5['g5_shop_order_table']} where od_id = '$od_id' and site_id = '$site_id' ";
            $od = sql_fetch($sql);

            if($od['od_tno'] && ($od['od_settle_case'] == '신용카드' || $od['od_settle_case'] == '간편결제' || $od['od_settle_case'] == 'KAKAOPAY') || ($od['od_pg'] == 'inicis' && is_inicis_order_pay($od['od_settle_case']) )) {
                switch($od['od_pg']) {
                    case 'lg':
                        include_once(G5_SHOP_PATH.'/settle_lg.inc.php');

                        $LGD_TID = $od['od_tno'];

                        $xpay = new XPay($configPath, $CST_PLATFORM);

                        // Mert Key 설정
                        $xpay->set_config_value('t'.$LGD_MID, $config['cf_lg_mert_key']);
                        $xpay->set_config_value($LGD_MID, $config['cf_lg_mert_key']);

                        $xpay->Init_TX($LGD_MID);

                        $xpay->Set('LGD_TXNAME', 'Cancel');
                        $xpay->Set('LGD_TID', $LGD_TID);

                        if ($xpay->TX()) {
                            $res_cd = $xpay->Response_Code();
                            if($res_cd != '0000' && $res_cd != 'AV11') {
                                $pg_res_cd = $res_cd;
                                $pg_res_msg = $xpay->Response_Msg();
                            }
                        } else {
                            $pg_res_cd = $xpay->Response_Code();
                            $pg_res_msg = $xpay->Response_Msg();
                        }
                        break;
                    case 'inicis':
                        include_once(G5_SHOP_PATH.'/settle_inicis.inc.php');
                        $cancel_msg = iconv_euckr('쇼핑몰 운영자 승인 취소');

                        /*********************
                         * 3. 취소 정보 설정 *
                         *********************/
                        $inipay->SetField("type",      "cancel");                        // 고정 (절대 수정 불가)
                        $inipay->SetField("mid",       $default['de_inicis_mid']);       // 상점아이디
                        /**************************************************************************************************
                         * admin 은 키패스워드 변수명입니다. 수정하시면 안됩니다. 1111의 부분만 수정해서 사용하시기 바랍니다.
                         * 키패스워드는 상점관리자 페이지(https://iniweb.inicis.com)의 비밀번호가 아닙니다. 주의해 주시기 바랍니다.
                         * 키패스워드는 숫자 4자리로만 구성됩니다. 이 값은 키파일 발급시 결정됩니다.
                         * 키패스워드 값을 확인하시려면 상점측에 발급된 키파일 안의 readme.txt 파일을 참조해 주십시오.
                         **************************************************************************************************/
                        $inipay->SetField("admin",     $default['de_inicis_admin_key']); //비대칭 사용키 키패스워드
                        $inipay->SetField("tid",       $od['od_tno']);                   // 취소할 거래의 거래아이디
                        $inipay->SetField("cancelmsg", $cancel_msg);                     // 취소사유

                        /****************
                         * 4. 취소 요청 *
                         ****************/
                        $inipay->startAction();

                        /****************************************************************
                         * 5. 취소 결과                                           	*
                         *                                                        	*
                         * 결과코드 : $inipay->getResult('ResultCode') ("00"이면 취소 성공)  	*
                         * 결과내용 : $inipay->getResult('ResultMsg') (취소결과에 대한 설명) 	*
                         * 취소날짜 : $inipay->getResult('CancelDate') (YYYYMMDD)          	*
                         * 취소시각 : $inipay->getResult('CancelTime') (HHMMSS)            	*
                         * 현금영수증 취소 승인번호 : $inipay->getResult('CSHR_CancelNum')    *
                         * (현금영수증 발급 취소시에만 리턴됨)                          *
                         ****************************************************************/

                        $res_cd  = $inipay->getResult('ResultCode');
                        $res_msg = $inipay->getResult('ResultMsg');

                        if($res_cd != '00') {
                            $pg_res_cd = $res_cd;
                            $pg_res_msg = iconv_utf8($res_msg);
                        }
                        break;
                    case 'KAKAOPAY':
                        include_once(G5_SHOP_PATH.'/settle_kakaopay.inc.php');
                        $_REQUEST['TID']               = $od['od_tno'];
                        $_REQUEST['Amt']               = $od['od_receipt_price'];
                        $_REQUEST['CancelMsg']         = '쇼핑몰 운영자 승인 취소';
                        $_REQUEST['PartialCancelCode'] = 0;
                        include G5_SHOP_PATH.'/kakaopay/kakaopay_cancel.php';
                        break;
                    default:
                        include_once(G5_SHOP_PATH.'/settle_kcp.inc.php');
                        require_once(G5_SHOP_PATH.'/kcp/pp_ax_hub_lib.php');

                        // locale ko_KR.euc-kr 로 설정
                        setlocale(LC_CTYPE, 'ko_KR.euc-kr');

                        $c_PayPlus = new C_PP_CLI_T;

                        $c_PayPlus->mf_clear();

                        $tno = $od['od_tno'];
                        $tran_cd = '00200000';
                        $cancel_msg = iconv_euckr('쇼핑몰 운영자 승인 취소');
                        $cust_ip = $_SERVER['REMOTE_ADDR'];
                        $bSucc_mod_type = "STSC";

                        $c_PayPlus->mf_set_modx_data( "tno",      $tno                         );  // KCP 원거래 거래번호
                        $c_PayPlus->mf_set_modx_data( "mod_type", $bSucc_mod_type              );  // 원거래 변경 요청 종류
                        $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip                     );  // 변경 요청자 IP
                        $c_PayPlus->mf_set_modx_data( "mod_desc", $cancel_msg );  // 변경 사유

                        $c_PayPlus->mf_do_tx( $tno,  $g_conf_home_dir, $g_conf_site_cd,
                            $g_conf_site_key,  $tran_cd,    "",
                            $g_conf_gw_url,  $g_conf_gw_port,  "payplus_cli_slib",
                            $ordr_idxx, $cust_ip, "3" ,
                            0, 0, $g_conf_key_dir, $g_conf_log_dir);

                        $res_cd  = $c_PayPlus->m_res_cd;
                        $res_msg = $c_PayPlus->m_res_msg;

                        if($res_cd != '0000') {
                            $pg_res_cd = $res_cd;
                            $pg_res_msg = iconv_utf8($res_msg);
                        }

                        // locale 설정 초기화
                        setlocale(LC_CTYPE, '');
                        break;
                }

                // PG 취소요청 성공했으면
                if($pg_res_cd == '') {
                    $pg_cancel_log = ' PG 신용카드 승인취소 처리';
                    $sql = " update {$g5['g5_shop_order_table']}
                                set od_refund_price = '{$od['od_receipt_price']}'
                                where od_id = '$od_id' and site_id ='$site_id' ";
                    sql_query($sql);
                }
            }
        }

        // 관리자 주문취소 로그
        $mod_history .= 'CTI에서 '.G5_TIME_YMDHIS.' '.$mb_id.' 주문'.$ct_status.' 처리'.$pg_cancel_log."\n";
    }
}

// 미수금 등의 정보
$info = get_order_info($od_id);

if(!$info)
    echo 'success:"주문자료가 존재하지 않습니다."';

$sql = " update {$g5['g5_shop_order_table']}
            set od_cart_price   = '{$info['od_cart_price']}',
                od_cart_coupon  = '{$info['od_cart_coupon']}',
                od_coupon       = '{$info['od_coupon']}',
                od_send_coupon  = '{$info['od_send_coupon']}',
                od_cancel_price = '{$info['od_cancel_price']}',
                od_send_cost    = '{$info['od_send_cost']}',
                od_misu         = '{$info['od_misu']}',
                od_tax_mny      = '{$info['od_tax_mny']}',
                od_vat_mny      = '{$info['od_vat_mny']}',
                od_free_mny     = '{$info['od_free_mny']}' ";
if ($mod_history) { // 주문변경 히스토리 기록
    $sql .= " , od_mod_history = CONCAT(od_mod_history,'$mod_history') ";
}

if($cancel_change) {
    $sql .= " , od_status = '취소' "; // 주문상품 모두 취소, 반품, 품절이면 주문 취소
} else {
    if (in_array($ct_status, $status_normal)) { // 정상인 주문상태만 기록
        $sql .= " , od_status = '$ct_status ";
    }
}

$sql .= " where od_id = '$od_id' and site_id = '$site_id' ";
sql_query($sql);

// 신용카드 취소 때 오류가 있으면 알림
if($pg_cancel == 1 && $pg_res_cd && $pg_res_msg) {
    echo 'success: "오류코드 : '.$pg_res_cd.' 오류내용 : '.$pg_res_msg.'"';
} else {
    // 1.06.06
    $od = sql_fetch(" select od_receipt_point from {$g5['g5_shop_order_table']} where od_id = '$od_id' and site_id = '$site_id' ");
    if ($od['od_receipt_point'])
        echo 'success:"포인트로 결제한 주문은,\\n\\n주문상태 변경으로 인해 포인트의 가감이 발생하는 경우\\n\\n회원관리 > 포인트관리에서 수작업으로 포인트를 맞추어 주셔야 합니다."';
}


// 무통장 입금시 개별 상품별 처리
if ($od_settle_case == '무통장') {

    $sql = " select * from {$g5['g5_shop_order_table']} where od_id = '$od_id' and site_id = '$site_id' ";
    $od  = sql_fetch($sql);
    if(!$od['od_id'])
        echo 'success: "주문자료가 존재하지 않습니다."';

    if ($ct_status == '입금') {
        $ribbon_total_price = $ribbon['cti_price'] + $ribbon['cti_option'] + $od['od_send_cost'] + $od['od_send_cost2'];

        if ($od['od_receipt_price'] > 0) {
            $ribbon_total_price = $od['od_receipt_price'] + $ribbon['cti_price'] + $ribbon['cti_option'];
        }
    }

    if ($ct_status == '취소') {
        $ribbon_total_price = 0; // 기존 입금 금액이 없다면 그대로 0으로 셋팅

        if ($od['od_receipt_price'] > 0) {
            if ( $od['od_receipt_price'] == ($ribbon['cti_price'] + $ribbon['cti_option'] + $od['od_send_cost'] + $od['od_send_cost2']) ) {
                $ribbon_total_price = 0;
            } else {
                $ribbon_total_price = $od['od_receipt_price'] - ($ribbon['cti_price'] + $ribbon['cti_option']);
            }
        }
    }


    $sql = " update {$g5['g5_shop_order_table']}
            set od_receipt_time    = '".G5_TIME_YMDHIS."',
                od_receipt_price   = '$ribbon_total_price'
            where od_id = '$od_id' ";
    sql_query($sql);

    // 주문정보
    $info = get_order_info($od_id);
    if(!$info)
        echo 'success: "주문자료가 존재하지 않습니다."';

    // 미수금액
    $od_misu = ( $od['od_cart_price'] - $od['od_cancel_price'] + $od['od_send_cost'] + $od['od_send_cost2'] )
        - ( $od['od_cart_coupon'] + $od['od_coupon'] + $od['od_send_coupon'] )
        - ( $ribbon_total_price + $od['od_receipt_point'] - $od['od_refund_price'] );

    // 미수금 정보 등 반영
    $sql = " update {$g5['g5_shop_order_table']}
            set od_misu         = '$od_misu',
                od_tax_mny      = '{$info['od_tax_mny']}',
                od_vat_mny      = '{$info['od_vat_mny']}',
                od_free_mny     = '{$info['od_free_mny']}'
            where od_id = '$od_id' ";
    sql_query($sql);
}

// 리본 테이블에 cti_status 상태 값을 바꿈
$sql = " update {$g5['ribbon_table']} set cti_status  = '$ct_status' where od_id = '$od_id' and rb_id  = '$rb_id' and order_no = '$order_no' and site_id = '$site_id' ";
sql_query($sql);


// 주문번호가 있고, 완료상태, state_data에 배송사진 경로가 들어온다면 배송갤러리에 insert
if ($order_no && $ct_status == "완료" && contains('http://rest.18002019.com/v1/', $state_data)) {

    $sql = " select count(*) as cnt from {$g5['delivery_gallery']}
              where order_no = '$order_no'
                and site_id = '$site_id' ";
    $row = sql_fetch($sql);

    // 배송갤러리에 insert
    if (!$row['cnt']) {

        // 장바구니에서 한 행을 가져옴
        $sql = " select * from {$g5['g5_shop_cart_table']} where od_id = '$od_id' ";
        $cart = sql_fetch($sql);

        // 회원 정보를 가져옴
        $mb_info = get_member($cart['mb_id'], 'mb_name');

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

        // 외부 이미지 저장함
        $filename = save_remote_image($state_data, $order_no);
    }
}


// 미구현???????????????? 뭘해야할지 생각...
if ($ribbon) {

}

?>