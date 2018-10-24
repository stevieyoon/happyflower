<?php
include_once('/home/master/public_html/common.php');

$sql = " select * from {$g5['g5_shop_order_table']} where cti_post = '0' ";
$result = sql_query($sql);
for($i=0; $row=sql_fetch_array($result); $i++) {

    $site_id = $row['site_id']; // 사이트 고유 아이디
    $od_id = $row['od_id']; // 주문번호
    $default = get_shop_default($site_id); // 사이트 정보

    /*  리본 테이블과 오더/카트 테이블 로 배열로 만들어서 저장*/
    $ribbon = get_ribbon($od_id);
    $info = get_order($od_id);

    // 공통 정보는 루프 밖에서 미리 담는다.
    if($info['od_hope_now'] == 1){ // 즉시 배달요청 이라면
        $od_hope_date = 0;
        $od_hope_time = 0;
    } else {
        $od_hope_date = str_replace('-','',$info['od_hope_date']);  // 배달요청 일자 20171112 형식, 즉시는 0
        $od_hope_time = str_replace(':','',$info['od_hope_time']); // 배달요청 시간 1400 형식, 즉시는 0
    }

    // 결제의 경우 신용카드는 현재 api가 적용되나 계좌이체, 모바일결제는 아직 미구현
    switch ($info["od_settle_case"]) {
        case '신용카드':
            $ct_status = 'card_pay_ok';
            break;
        default:
            $ct_status= '';
    }

    // 기타 공통정보
    $company_key = str_replace('-','',$default['de_admin_company_tel']); // 등록할 회사(사이트)의 고유 키 값
    $call_no = $info['od_hp']; // 고객번호 "01057662790" 형식
    $customer_nm = $info['od_name']; // 고객 이름
    $account_nm = $info['od_deposit_name']; // 고객 입금자명
    $email = $info['od_email']; //고객 이메일
    $cust_pay_state = $ct_status; // 고객결제 정보 (아래의 state_cd에 따름)
    $cust_pay_data = ''; // 고객결제 관련 추가 데이터 - 필요시 넘김
    $receipt_type = $info['od_receipt_type']; // 요청 영수증, 세금계산서, 현금영수증 등
    $receipt_memo = $info['od_receipt_memo']; // 요청 영수증 추가내용, 사업자번호 등
    $receipt_extra_00 = $info['od_receipt_saupja_no']; // 요청 영수증 전자계산서 - 등록(사업자)번호
    $receipt_extra_01 = $info['od_receipt_company_name']; // 요청 영수증 전자계산서 - 상호
    $receipt_extra_02 = $info['od_receipt_company_owner']; // 요청 영수증 전자계산서 - 대표자명
    $receipt_extra_03 = $info['od_receipt_company_uptae']; // 요청 영수증 전자계산서 - 업태
    $receipt_extra_04 = $info['od_receipt_company_upjong']; // 요청 영수증 전자계산서 - 업종
    $receipt_extra_05 = $info['od_receipt_company_email']; // 요청 영수증 전자계산서 - 이메일
    $receipt_extra_06 = $info['od_receipt_company_addr']; // 요청 영수증 전자계산서 - 사업장 주소
    $request_date = $od_hope_date; // 배송요청 일자 "20180101" 형식, 즉시는 "0"
    $request_time = $od_hope_time;; // 배송요청 시간 "1600" 형식, 즉시는 "0"
    $request_picture = $info['od_delivery_gallery_type']; // 요청사진 (배송전,현장,배송후) 복수는 콤마로 구분
    $arv_address = $info['od_b_addr1'].' '.$info['od_b_addr2'].' '.$info['od_b_addr3']; // 배달주소 "부산 해운대구 해운대로" 형식
    $arv_prsn_nm = $info['od_b_name']; // 받으실 분 성함
    $arv_prsn_tel_no = $info['od_b_hp']; // 받으실 분 연락처
    $reg_count = '1'; // 등록 콜수

    // 리본 테이블에 있는 개수만큼 루프
    foreach($ribbon as $cti) {

        // 해당 상품의 정보를 가져옴
        $it = get_item($cti['it_id']);

        // 카드만 있는 경우는 아직 미구현 상태. orderform.sub.php 파일에서 라디오버튼으로 분기해야함.
        // 메세지 타입 ("ribbon", "card", "ribbon+card")
        switch ($cti["ribbon_type"]) {
            case '0':
                $msg_type = 'ribbon';
                break;
            case '1':
                $msg_type = 'ribbon+card';
                break;
            default:
                $msg_type= 'card';
        }

        $option_price_io_type0 = order_option_sum($cti['od_id'], $cti['it_id'], 0); // 해당 상품의 선택 옵션의 합한가격을 구함
        $option_price_io_type1 = order_option_sum($cti['od_id'], $cti['it_id'], 1); // 해당 상품의 추가 옵션의 합한가격을 구함

        $order_no = ''; // 주문번호 최초 등록시 빈값으로 전달 수정 시 필요함

        $product_id = ''; // 상품 코드
        $product_category = ''; // 상품 분류코드
        $product_nm = get_item_ca_name($it['ca_id']); // 상품 이름 // 분류명으로 하면 됨
        $product_memo = $it['it_name']; // 상품 상세 내용 // 상품 이름으로 하면됨
        $product_img_url = G5_DATA_URL.'/item/'.$it['it_img1']; // 상품 이미지 url
        $cost = $it['it_price'] + $option_price_io_type0['price']; //상품가격 // 상품가격 + 선택옵션 가격
        $additional_cost = $cti['od_20']; // 추가요금(배송비 등)

        $ribbon_msg_0 = $cti['rb_right_content']; // 리본 메시지 - 보내는 분(오른쪽 문구)
        $ribbon_msg_1 = $cti['rb_left_content']; // 리본 메시지 - 경조사어(왼쪽 문구)
        $card_msg = $cti['card_msg']; // 카드 내용

        $extra_item_cost = $option_price_io_type1['price']; //기타(추가) 상품 가격
        $extra_item_memo = order_option_name($cti['od_id'], $cti['it_id'], 1); // 기타(추가) 상품 메모 // 그냥 추가 옵션명을 구분자로 이어서 넘겨주면 됨
        $extern_id = ''; // 외부 번호 - 연계 서비스에서 사용
        $extern_no = $od_settle_case; // 외부 데이터 - 연계 서비스에서 사용

        $data = array(
            "company_key" => $company_key,
            "call_no" => $call_no,
            "product_id" => $product_id,
            "product_category" => $product_category,
            "product_nm" => $product_nm,
            "product_memo" => $product_memo,
            "cost" => $cost,
            "request_date" => $request_date,
            "request_time" => $request_time,
            "arv_address" => $arv_address,
            "arv_prsn_nm" => $arv_prsn_nm,
            "arv_prsn_tel_no" => $arv_prsn_tel_no,
            "msg_type" => $msg_type,
            "ribbon_msg_0" => $ribbon_msg_0,
            "ribbon_msg_1" => $ribbon_msg_1,
            "card_msg" => $card_msg,
            "email" => $email,
            "account_nm" => $account_nm,
            "product_img_url" => $product_img_url,
            "customer_nm" => $customer_nm,
            "request_picture" => $request_picture,
            "receipt_memo" => $receipt_memo,
            "additional_cost" => $additional_cost,
            "receipt_type" => $receipt_type,
            "extern_id" => $extern_id,
            "reg_count" => $reg_count,
            "cust_pay_state" => $cust_pay_state,
            "receipt_extra_00" => $receipt_extra_00,
            "receipt_extra_01" => $receipt_extra_01,
            "receipt_extra_02" => $receipt_extra_02,
            "receipt_extra_03" => $receipt_extra_03,
            "receipt_extra_04" => $receipt_extra_04,
            "receipt_extra_05" => $receipt_extra_05,
            "receipt_extra_06" => $receipt_extra_06,
            "extern_no" => $extern_no,
            "extra_item_cost" => $extra_item_cost,
            "extra_item_memo" => $extra_item_memo
        );

        $result = cti_post($data); // cti로 전송
        //print_r2($cti);
        //print_r2($it);
        //print_r2($info);
        //print_r2($ribbon);


        // api 전송이 성공했다면
        if ($result['success']) {

            // cti_response 테이블에 insert
            cti_response_insert($result['success'], $result['message'], $cti['od_id'], $cti['it_id'], $cti['it_name'], $cti['ct_qty'], $cti['rb_no'], $extra_item_cost, $cost, $site_id);

            // 리본 테이블에 cti 고유 주문번호 등 update
            $sql = "update {$g5['ribbon_table']} 
					set order_no = '{$result['message']}', 
						cti_option = '$extra_item_cost',
						cti_price = '$cost',
						cti_status = '$od_status'
						where rb_no = '{$cti['rb_no']}' and od_id = '{$cti['od_id']}' and site_id = '$site_id' ";
            sql_query($sql);

            // 상품 주문시 장바구니에 cti 고유 주문번호 update
            $sql = "update {$g5['g5_shop_cart_table']} 
					set order_no = '{$result['message']}' where it_id = '{$cti['it_id']}' and od_id = '{$cti['od_id']}' and site_id = '$site_id' ";
            sql_query($sql);

            // 전송이 성공했으면 해당 주문서의 cti 전송 결과를 1로 바꿈
            // 그렇지 않으면 계속 0이기 때문에 반복 전송을 하도록함
            $sql = " update {$g5['g5_shop_order_table']}
				  set cti_post = '1' where od_id = '$od_id' ";
            sql_query($sql);

        }

    }
}
?>