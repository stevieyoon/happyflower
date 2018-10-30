<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$g5['ribbon_table'] = G5_TABLE_PREFIX.'ribbon'; // 리본 테이블
$g5['cti_response'] = G5_TABLE_PREFIX.'cti_response'; // CTI 응답메제지 저장하기
$g5['shop_order_cti_table'] = G5_TABLE_PREFIX.'shop_order_cti'; // cti 에러테이블
$g5['delivery_gallery'] = G5_TABLE_PREFIX.'delivery_gallery'; // 배송 겔러리 테이블
$g5['itemuse_config'] = G5_TABLE_PREFIX.'itemuse_config'; // 상품후기 일관등록 설정 테이블

//==============================================================================


//==============================================================================
// 공용 함수(gnuwiz)
//------------------------------------------------------------------------------

// 테마 가져오기(gnuwiz)
function get_theme_select($class="", $name="", $selected='', $other='')
{
    global $config;
    $theme = array();
    $theme = array_merge($theme, get_theme_dir());

    $str = "<select class=\"$class\" name=\"$name\" data=\"$other\">\n";
    for ($i=0; $i<count($theme); $i++) {
        if ($i == 0) $str .= "<option value=\"\">선택</option>";
        if(preg_match('#^theme/(.+)$#', $theme[$i], $match))
            $text = '(테마) '.$match[1];
        else
            $text = $theme[$i];
        $str .= option_selected($theme[$i], $selected, $text);
    }
    $str .= "</select>";
    return $str;
}

// 사이트별 회원수(gnuwiz)
function get_member_count($site_id)
{
	global $g5;

	if ($site_id) {
		$result = sql_fetch("select count(*) as cnt from {$g5['member_table']} where site_id='{$site_id}'");
		$result = $result['cnt'];
	} else {
		$result = "00";
	}

	return $result;
}

// 플랫폼 config 정보를 얻는다.(gnuwiz)
function get_config($site_id, $fields='*')
{
    global $g5;

    return sql_fetch(" select $fields from {$g5['config_table']} where site_id = TRIM('$site_id') ");
}

// 플랫폼 shop_default 정보를 얻는다.(gnuwiz)
function get_shop_default($site_id, $fields='*')
{
    global $g5;

    return sql_fetch(" select $fields from {$g5['g5_shop_default_table']} where site_id = TRIM('$site_id') ");
}


// 메인페이 결제 로그
function wz_fwrite_log($log_dir, $error) {
    $log_file = fopen($log_dir, "a");
    fwrite($log_file, $error."\r\n");
    fclose($log_file);
}

// 리본 테이블 저장
function insert_ribbon($od_id, $rb_right_content='', $rb_left_content='', $card_msg='', $it_id, $rb_no, $tmp_cart_id, $it_name='', $ribbon_type)
{
	global $g5, $site_id;

	$sql = " insert into {$g5['ribbon_table']}
                set od_id = '$od_id',
                    ribbon_type = '$ribbon_type',
                    rb_no = '$rb_no',
                    rb_right_content = '".addslashes($rb_right_content)."',
                    rb_left_content = '".addslashes($rb_left_content)."',
                    card_msg = '".addslashes($card_msg)."',
                    rb_datetime = '".G5_TIME_YMDHIS."',
                    cart_id = '$tmp_cart_id',
					it_id = '$it_id',
					it_name = '".addslashes($it_name)."',
					site_id = '$site_id' ";
    $result = sql_query($sql);

	return $result;
}

// 장바구니 테이블에서 cti 주문번호에 해당하는 행을 배열로 가져옴(gnuwiz)
function get_cart_order_no($order_no)
{
    global $g5, $site_id;

    $sql = " select * from {$g5['g5_shop_cart_table']} where order_no = '$order_no' and site_id = '$site_id' order by ct_id asc ";
    $result = sql_query($sql);

    for($i=0; $row=sql_fetch_array($result); $i++) {
        $cart[$i] = $row;
    }

    return $cart;
}

// 리본 테이블에서 주문번호에 해당하는 행을 배열로 가져옴(gnuwiz)
function get_ribbon($od_id)
{
    global $g5, $site_id;

    $sql = " select * from {$g5['ribbon_table']} where od_id = '$od_id' and site_id = '$site_id' order by rb_id asc ";
    $result = sql_query($sql);

    for($i=0; $row=sql_fetch_array($result); $i++) {
        $ribbon[$i] = $row;
    }

    return $ribbon;
}

// 리본 테이블에서 cti 주문번호에 해당하는 한행을 가져옴(gnuwiz)
function get_ribbon_order_no($order_no)
{
    global $g5, $site_id;

    return sql_fetch(" select * from {$g5['ribbon_table']} where order_no = '$order_no'  and site_id = '$site_id' ");
}

// 상품의 주문번호에 해당하는 행을 가져옴(gnuwiz)
function get_order($od_id)
{
    global $g5, $site_id;

    // 주문정보
    $sql = " select * from {$g5['g5_shop_order_table']} where od_id = '$od_id' and site_id = '$site_id' ";
    $od = sql_fetch($sql);

    if(!$od['od_id'])
        return false;

    return $od;
}

// 상품 정보를 얻는다.(gnuwiz)
function get_item($it_id, $fields='*')
{
    global $g5, $site_id;

    return sql_fetch(" select $fields from {$g5['g5_shop_item_table']} where it_id = '$it_id' and site_id = '$site_id' ");
}

// cti 로그 테이블에 insert(gnuwiz)
function cti_response_insert($cti_success, $cti_message, $od_id, $it_id, $it_name, $ct_qty, $cti_num, $cti_option, $cti_price, $site_id)
{
    global $g5;

    $sql = " insert into {$g5['cti_response']}
                set cti_success = '$cti_success',
                    cti_message = '$cti_message',
                    cti_datetime = '".G5_TIME_YMDHIS."',
                    od_id = '$od_id',
                    it_id = '$it_id',
                    it_name = '$it_name',
                    ct_qty = '$ct_qty',
					cti_num = '$cti_num',
					cti_option = '$cti_option',
					cti_price = '$cti_price',
					site_id = '$site_id' ";
    sql_query($sql);

    return false;
}

// 상품분류 번호로 분류명 불러오기(gnuwiz)
function get_item_ca_name($ca_id)
{
    global $g5, $site_id;

    $sql = " select ca_name from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' and site_id = '$site_id' ";
    $row = sql_fetch($sql);

    return $row['ca_name'];
}

// 장바구니 옵션 합계 io_type=0:선택옵션, 1:추가옵션(gnuwiz)
function order_option_sum($od_id, $it_id, $io_type)
{
    global $g5, $site_id;

    // 합계금액 계산
    $sql = " select SUM(io_price * ct_qty) as price,
					SUM(ct_qty) as qty
				from {$g5['g5_shop_cart_table']}
				where od_id = '$od_id' and it_id = '$it_id' and io_type = '$io_type' and site_id = '$site_id' ";
    $cart_sum = sql_fetch($sql);

    return $cart_sum;
}

// 장바구니 옵션 이름 분리 io_type=0:선택옵션, 1:추가옵션(gnuwiz)
function order_option_name($od_id, $it_id, $io_type)
{
    global $g5, $site_id;

    $sql = " select ct_option, io_id from {$g5['g5_shop_cart_table']} 
              where it_id = '$it_id' 
              and od_id = '$od_id' 
              and io_type = '$io_type' 
              and site_id = '$site_id' ";
    $result = sql_query($sql);

    $option_name = array();
    for($i=0; $row=sql_fetch_array($result); $i++) {
        $option_name[] = $row['io_id'];
    }

    $option_name = implode('|||', $option_name);

    return $option_name;
}

// CTI 로 보내기(gnuwiz)
function cti_post($data)
{
    $data = json_encode($data);

    $headers[] = "Authorization:F4DD8B2E-6AAB-40B8-9D26-C77EF0F6B9EB";
    $headers[] = "Content-type: Application/json";
    $url = "http://rest.18002019.com/v1/order_reg";

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_VERBOSE, true);

    $response = curl_exec($curl);

    curl_close($curl);

    /*
    // 2018-06-04(월) cti적용완료
    // 결과 가 json 형태가 아니라서 문자열 앞뒤로 " 를 붙혀줌
    $response = str_replace('success', '"success"',$response);
    $response = str_replace('message', '"message"',$response);
    */

    $response = json_decode($response, true);

    return $response;
}

// 외부이미지 저장(gnuwiz)
function save_remote_image($url, $order_no)
{
    $filename = '';

    $url = $url.'&t=3';
    $filepath = G5_DATA_PATH.'/delivery_gallery';
    $path = $filepath.'/'.$order_no.'.jpg';

    @mkdir($filepath, G5_DIR_PERMISSION);
    @chmod($filepath, G5_DIR_PERMISSION);

    // 다운로드 파일이 이미 있다면 중단
    if(is_file($path)) {
        return true;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec ($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($http_code == 200) { // 성공했다면

        // 파일 다운로드
        $fp = fopen ($path, 'w+');

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
        curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
        curl_setopt( $ch, CURLOPT_FILE, $fp );
        curl_exec( $ch );
        curl_close( $ch );

        fclose( $fp );

        // 다운로드 파일이 이미지인지 체크
        if(is_file($path)) {
            $size = @getimagesize($path);
            if($size[2] < 1 || $size[2] > 3) {
                @unlink($path);
                $filename = '';
            } else {
                $ext = array(1=>'gif', 2=>'jpg', 3=>'png');
                $filename = $order_no.'.'.$ext[$size[2]];
                rename($path, $filepath.'/'.$filename);
                chmod($filepath.'/'.$filename, G5_FILE_PERMISSION);
            }
        }
    }

    return $filename;
}


// 문자열이 포함되어있는지 비교(gnuwiz)
function contains($needle, $haystack)
{
    return strpos($haystack, $needle) !== false;
}

// 상품번호로 상품정보를 가져옴(gnuwiz)
function get_item_info($it_id, $fields='*')
{
    global $g5, $site_id;
    $sql = " select $fields from {$g5['g5_shop_item_table']} where it_id = '$it_id' and site_id = '$site_id' ";
    $it = sql_fetch($sql);

    return $it;
}



?>