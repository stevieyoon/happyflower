<?php
$sub_menu = '400200';
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

check_admin_token();

// 기존에 셋팅된 분류를 모두 지움
$sql = " delete from {$g5['g5_shop_category_table']} where site_id = '$site_id' ";
sql_query($sql);

// 기존에 셋팅된 상품을 모두 지움
$sql = " delete from {$g5['g5_shop_item_table']} where site_id = '$site_id' ";
sql_query($sql);

// 기존에 셋팅된 상품의 옵션을 모두 지움
$sql = " delete from {$g5['g5_shop_item_option_table']} where site_id = '$site_id' ";
sql_query($sql);

// 기존에 셋팅된 추가배송비 지역을 모두 지움
$sql = " delete from {$g5['g5_shop_sendcost_table']} where site_id = '$site_id' ";
sql_query($sql);

// 기존에 저장된 상품의 이미지를 모두 지우고 새 디렉토리를 생성함
$site_dir = G5_DATA_PATH.'/item/'.$site_id; // 복사본 사이트 아이디 고유 디렉토리
rm_rf($site_dir);

@mkdir($site_dir, G5_DIR_PERMISSION);
@chmod($site_dir, G5_DIR_PERMISSION);

for ($i=0; $i<count($_POST['chk']); $i++)
{
    // 실제 번호를 넘김
    $k = $_POST['chk'][$i];

    // 체크박스에 선택한 분류의 정보를 가져옴
    $sql = " select * from {$g5['g5_shop_category_table']} where ca_id = '{$_POST['ca_id'][$k]}' and site_id = 'master' ";
    $row = sql_fetch($sql);

    // 해당 site_id의 상품분류로 insert
    $sql = " insert {$g5['g5_shop_category_table']}
                set ca_id               = '{$row['ca_id']}',
                ca_name                 = '{$row['ca_name']}',
                ca_order                = '{$row['ca_order']}',
                ca_skin_dir             = '{$row['ca_skin_dir']}',
                ca_mobile_skin_dir      = '{$row['ca_mobile_skin_dir']}',
                ca_skin                 = '{$row['ca_skin']}',
                ca_mobile_skin          = '{$row['ca_mobile_skin']}',
                ca_img_width            = '{$row['ca_img_width']}',
                ca_img_height           = '{$row['ca_img_height']}',
				ca_list_mod             = '{$row['ca_list_mod']}',
				ca_list_row             = '{$row['ca_list_row']}',
                ca_mobile_img_width     = '{$row['ca_mobile_img_width']}',
                ca_mobile_img_height    = '{$row['ca_mobile_img_height']}',
				ca_mobile_list_mod      = '{$row['ca_mobile_list_mod']}',
                ca_mobile_list_row      = '{$row['ca_mobile_list_row']}',
                ca_sell_email           = '{$row['ca_sell_email']}',
                ca_use                  = '{$row['ca_use']}',
                ca_stock_qty            = '{$row['ca_stock_qty']}',
                ca_explan_html          = '{$row['ca_explan_html']}',
                ca_head_html            = '{$row['ca_head_html']}',
                ca_tail_html            = '{$row['ca_tail_html']}',
                ca_mobile_head_html     = '{$row['ca_mobile_head_html']}',
                ca_mobile_tail_html     = '{$row['ca_mobile_tail_html']}',
                ca_include_head         = '{$row['ca_include_head']}',
                ca_include_tail         = '{$row['ca_include_tail']}',
                ca_mb_id                = '{$row['ca_mb_id']}',
                ca_cert_use             = '{$row['ca_cert_use']}',
                ca_adult_use            = '{$row['ca_adult_use']}',
                ca_nocoupon             = '{$row['ca_nocoupon']}',
                ca_1_subj               = '{$row['ca_1_subj']}',
                ca_2_subj               = '{$row['ca_2_subj']}',
                ca_3_subj               = '{$row['ca_3_subj']}',
                ca_4_subj               = '{$row['ca_4_subj']}',
                ca_5_subj               = '{$row['ca_5_subj']}',
                ca_6_subj               = '{$row['ca_6_subj']}',
                ca_7_subj               = '{$row['ca_7_subj']}',
                ca_8_subj               = '{$row['ca_8_subj']}',
                ca_9_subj               = '{$row['ca_9_subj']}',
                ca_10_subj              = '{$row['ca_10_subj']}',
                ca_1                    = '{$row['ca_1']}',
                ca_2                    = '{$row['ca_2']}',
                ca_3                    = '{$row['ca_3']}',
                ca_4                    = '{$row['ca_4']}',
                ca_5                    = '{$row['ca_5']}',
                ca_6                    = '{$row['ca_6']}',
                ca_7                    = '{$row['ca_7']}',
                ca_8                    = '{$row['ca_8']}',
                ca_9                    = '{$row['ca_9']}',
                ca_10                   = '{$row['ca_10']}',
                site_id                 = '$site_id' ";
    sql_query($sql);

    // 해당 상품분류의 default 상품을 가져옴
    $sql2 = " select * from {$g5['g5_shop_item_table']} where ca_id = '{$_POST['ca_id'][$k]}'
                      or ca_id2 = '{$_POST['ca_id'][$k]}'
                      or ca_id3 = '{$_POST['ca_id'][$k]}'
                      and site_id = 'master' ";
    $result2 = sql_query($sql2);

    for ($j=0; $row2=sql_fetch_array($result2); $j++) {

        $re_img = array();
        for ($re=1; $re <= 10; $re++) {

            if ($row2["it_img{$re}"]) {
                $re_img_file_name = explode('/', $row2["it_img{$re}"]); // 파일이름을 찾기 위해서 배열로 자름
                $re_file_name = $re_img_file_name[count($re_img_file_name)-1]; // 배열의 마지막이 파일임
                $re_img[$re] = "{$site_id}/{$row2['it_id']}/{$re_file_name}";
            }
        }
        
        // default 상품을 insert
        $sql3 = " insert {$g5['g5_shop_item_table']}
                set it_id               = '{$row2['it_id']}',
                    ca_id               = '{$row2['ca_id']}',
                    ca_id2              = '{$row2['ca_id2']}',
                    ca_id3              = '{$row2['ca_id3']}',
                    it_skin             = '{$row2['it_skin']}',
                    it_mobile_skin      = '{$row2['it_mobile_skin']}',
                    it_name             = '{$row2['it_name']}',
                    it_maker            = '{$row2['it_maker']}',
                    it_origin           = '{$row2['it_origin']}',
                    it_brand            = '{$row2['it_brand']}',
                    it_model            = '{$row2['it_model']}',
                    it_option_subject   = '{$row2['it_option_subject']}',
                    it_supply_subject   = '{$row2['it_supply_subject']}',
                    it_type1            = '{$row2['it_type1']}',
                    it_type2            = '{$row2['it_type2']}',
                    it_type3            = '{$row2['it_type3']}',
                    it_type4            = '{$row2['it_type4']}',
                    it_type5            = '{$row2['it_type5']}',
                    it_basic            = '{$row2['it_basic']}',
                    it_explan           = '{$row2['it_explan']}',
                    it_explan2          = '{$row2['it_explan2']}',
                    it_mobile_explan    = '{$row2['it_mobile_explan']}',
                    it_cust_price       = '{$row2['it_cust_price']}',
                    it_price            = '{$row2['it_price']}',
                    it_point            = '{$row2['it_point']}',
                    it_point_type       = '{$row2['it_point_type']}',
                    it_supply_point     = '{$row2['it_supply_point']}',
                    it_notax            = '{$row2['it_notax']}',
                    it_sell_email       = '{$row2['it_sell_email']}',
                    it_use              = '{$row2['it_use']}',
                    it_nocoupon         = '{$row2['it_nocoupon']}',
                    it_soldout          = '{$row2['it_soldout']}',
                    it_stock_qty        = '{$row2['it_stock_qty']}',
                    it_stock_sms        = '{$row2['it_stock_sms']}',
                    it_noti_qty         = '{$row2['it_noti_qty']}',
                    it_sc_type          = '{$row2['it_sc_type']}',
                    it_sc_method        = '{$row2['it_sc_method']}',
                    it_sc_price         = '{$row2['it_sc_price']}',
                    it_sc_minimum       = '{$row2['it_sc_minimum']}',
                    it_sc_qty           = '{$row2['it_sc_qty']}',
                    it_buy_min_qty      = '{$row2['it_buy_min_qty']}',
                    it_buy_max_qty      = '{$row2['it_buy_max_qty']}',
                    it_head_html        = '{$row2['it_head_html']}',
                    it_tail_html        = '{$row2['it_tail_html']}',
                    it_mobile_head_html = '{$row2['it_mobile_head_html']}',
                    it_mobile_tail_html = '{$row2['it_mobile_tail_html']}',
                    it_ip               = '{$_SERVER['REMOTE_ADDR']}',
                    it_order            = '{$row2['it_order']}',
                    it_tel_inq          = '{$row2['it_tel_inq']}',
                    it_info_gubun       = '{$row2['it_info_gubun']}',
                    it_info_value       = '{$row2['it_info_value']}',
                    it_use_avg          = '{$row2['it_use_avg']}',
                    it_shop_memo        = '{$row2['it_shop_memo']}',
                    ec_mall_pid         = '{$row2['ec_mall_pid']}',
                    it_img1             = '{$re_img[1]}',
                    it_img2             = '{$re_img[2]}',
                    it_img3             = '{$re_img[3]}',
                    it_img4             = '{$re_img[4]}',
                    it_img5             = '{$re_img[5]}',
                    it_img6             = '{$re_img[6]}',
                    it_img7             = '{$re_img[7]}',
                    it_img8             = '{$re_img[8]}',
                    it_img9             = '{$re_img[9]}',
                    it_img10            = '{$re_img[10]}',
                    it_1_subj           = '{$row2['it_1_subj']}',
                    it_2_subj           = '{$row2['it_2_subj']}',
                    it_3_subj           = '{$row2['it_3_subj']}',
                    it_4_subj           = '{$row2['it_4_subj']}',
                    it_5_subj           = '{$row2['it_5_subj']}',
                    it_6_subj           = '{$row2['it_6_subj']}',
                    it_7_subj           = '{$row2['it_7_subj']}',
                    it_8_subj           = '{$row2['it_8_subj']}',
                    it_9_subj           = '{$row2['it_9_subj']}',
                    it_10_subj          = '{$row2['it_10_subj']}',
                    it_1                = '{$row2['it_1']}',
                    it_2                = '{$row2['it_2']}',
                    it_3                = '{$row2['it_3']}',
                    it_4                = '{$row2['it_4']}',
                    it_5                = '{$row2['it_5']}',
                    it_6                = '{$row2['it_6']}',
                    it_7                = '{$row2['it_7']}',
                    it_8                = '{$row2['it_8']}',
                    it_9                = '{$row2['it_9']}',
                    it_10               = '{$row2['it_10']}',
                    site_id             = '$site_id' ";
        sql_query($sql3);
/*
        // 해당 상품의 default 옵션을 가져옴
        $sql4 = " select * from {$g5['g5_shop_item_option_table']} where it_id = '{$row2['it_id']}' and site_id = 'master' ";
        $result4 = sql_query($sql4);

        for ($a=0; $row4=sql_fetch_array($result4); $a++) {
            $sql5 = " insert {$g5['g5_shop_item_option_table']}
		                set io_id       = '{$row4['io_id']}',
                        io_type         = '{$row4['io_type']}',
                        it_id           = '{$row4['it_id']}',
                        io_price        = '{$row4['io_price']}',
                        io_stock_qty    = '{$row4['io_stock_qty']}',
                        io_noti_qty     = '{$row4['io_noti_qty']}',
                        io_use          = '{$row4['io_use']}',
                        site_id         = '$site_id' ";
            sql_query($sql5);
        }
*/
        // 이미지 복사 시작
        $dst_dir = G5_DATA_PATH.'/item/'.$site_id.'/'.$row2['it_id']; // 복사본 디렉토리 생성

        @mkdir($dst_dir, G5_DIR_PERMISSION);
        @chmod($dst_dir, G5_DIR_PERMISSION);

        for ($cp=1; $cp <= 10; $cp++) {

            if ($row2["it_img{$cp}"]) {
                $src_dir = G5_DATA_PATH.'/item/'.$row2["it_img{$cp}"]; // 원본 파일

                $item_img_file_name = explode('/', $row2["it_img{$cp}"]); // 파일이름을 찾기 위해서 배열로 자름
                $file_name = $item_img_file_name[count($item_img_file_name)-1]; // 배열의 마지막이 파일임

                // 원본파일을 복사하고 퍼미션을 변경
                @copy($src_dir, $dst_dir.'/'.$file_name);
                @chmod($dst_dir/$file_name, G5_FILE_PERMISSION);
            }
        }

        unset($re_img);

    }
}
/*
// default 추가배송비 insert
// 해당 상품의 default 옵션을 가져옴
$sql = " select * from {$g5['g5_shop_sendcost_table']} where site_id = 'master' ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
    $sql = " insert into {$g5['g5_shop_sendcost_table']}
                  ( sc_name, sc_zip1, sc_zip2, sc_price, site_id )
                values
                  ( '{$row['sc_name']}', '{$row['sc_zip1']}', '{$row['sc_zip2']}', '{$row['sc_price']}', '$site_id' ) ";
    sql_query($sql);
}
*/
goto_url("./categorylist.php");
?>
