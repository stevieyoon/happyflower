<?php
include_once('./_common.php');
include_once(G5_PATH.'/yoon/dbconnect.php');


############### 메인 db에서 상품을 복사해서 insert함 

// rm -rf 옵션 : exec(), system() 함수를 사용할 수 없는 서버 또는 win32용 대체
// www.php.net 참고 : pal at degerstrom dot com
function rm_rf($file)
{
    if (file_exists($file)) {
        if (is_dir($file)) {
            $handle = opendir($file);
            while($filename = readdir($handle)) {
                if ($filename != '.' && $filename != '..')
                    rm_rf($file.'/'.$filename);
            }
            closedir($handle);

            @chmod($file, G5_DIR_PERMISSION);
            @rmdir($file);
        } else {
            @chmod($file, G5_FILE_PERMISSION);
            @unlink($file);
        }
    }
}

$site_id = 'master'; // 사이트 아이디

// main db에서 상품정보 테이블 조회
$sql = " select * from {$g5['g5_shop_item_table']} ";
$result = sql_query_flower($sql);

// 기존 상품정보 삭제
sql_query(" delete from {$g5['g5_shop_item_table']} where site_id = '$site_id' ");


$site_dir = G5_DATA_PATH.'/item/'.$site_id; // 복사본 사이트 아이디 고유 디렉토리
rm_rf($site_dir);

@mkdir($site_dir, G5_DIR_PERMISSION);
@chmod($site_dir, G5_DIR_PERMISSION);

// 상품 정보 테이블 insert
for($i=0; $row=sql_fetch_array($result); $i++) {

    $re_img = array();
    for ($a=1; $a <= 10; $a++) {

        if ($row["it_img{$a}"]) {
            $re_img_file_name = explode('/', $row["it_img{$a}"]); // 파일이름을 찾기 위해서 배열로 자름
            $re_file_name = $re_img_file_name[count($re_img_file_name)-1]; // 배열의 마지막이 파일임
            $re_img[$a] = "{$site_id}/{$row['it_id']}/{$re_file_name}";
        }
    }

    $sql = " INSERT INTO {$g5['g5_shop_item_table']}
			    SET it_id = '{$row['it_id']}',
                    ca_id               = '{$row['ca_id']}',
                    ca_id2              = '{$row['ca_id2']}',
                    ca_id3              = '{$row['ca_id3']}',
                    it_skin             = '{$row['it_skin']}',
                    it_mobile_skin      = '{$row['it_mobile_skin']}',
                    it_name             = '{$row['it_name']}',
                    it_maker            = '국내',
                    it_origin           = '국내',
                    it_brand            = '',
                    it_model            = '{$row['it_model']}',
                    it_option_subject   = '{$row['it_option_subject']}',
                    it_supply_subject   = '{$row['it_supply_subject']}',
                    it_type1            = '{$row['it_type1']}',
                    it_type2            = '{$row['it_type2']}',
                    it_type3            = '{$row['it_type3']}',
                    it_type4            = '{$row['it_type4']}',
                    it_type5            = '{$row['it_type5']}',
                    it_basic            = '{$row['it_basic']}',
                    it_explan           = '".addslashes($row["it_explan"])."',
				    it_explan2          = '".addslashes($row["it_explan2"])."',
					it_mobile_explan    = '".addslashes($row["it_mobile_explan"])."',
                    it_cust_price       = '{$row['it_cust_price']}',
                    it_price            = '{$row['it_price']}',
                    it_point            = '{$row['it_point']}',
                    it_point_type       = '{$row['it_point_type']}',
                    it_supply_point     = '{$row['it_supply_point']}',
                    it_notax            = '{$row['it_notax']}',
                    it_sell_email       = '{$row['it_sell_email']}',
                    it_use              = '{$row['it_use']}',
                    it_nocoupon         = '{$row['it_nocoupon']}',
                    it_soldout          = '{$row['it_soldout']}',
                    it_stock_qty        = '{$row['it_stock_qty']}',
                    it_stock_sms        = '{$row['it_stock_sms']}',
                    it_noti_qty         = '{$row['it_noti_qty']}',
                    it_sc_type          = '{$row['it_sc_type']}',
                    it_sc_method        = '{$row['it_sc_method']}',
                    it_sc_price         = '{$row['it_sc_price']}',
                    it_sc_minimum       = '{$row['it_sc_minimum']}',
                    it_sc_qty           = '{$row['it_sc_qty']}',
                    it_buy_min_qty      = '{$row['it_buy_min_qty']}',
                    it_buy_max_qty      = '{$row['it_buy_max_qty']}',
                    it_head_html        = '{$row['it_head_html']}',
                    it_tail_html        = '{$row['it_tail_html']}',
                    it_mobile_head_html = '{$row['it_mobile_head_html']}',
                    it_mobile_tail_html = '{$row['it_mobile_tail_html']}',
                    it_ip               = '{$_SERVER['REMOTE_ADDR']}',
                    it_order            = '{$row['it_order']}',
                    it_tel_inq          = '{$row['it_tel_inq']}',
                    it_info_gubun       = '{$row['it_info_gubun']}',
                    it_info_value       = '{$row['it_info_value']}',
                    it_shop_memo        = '{$row['it_shop_memo']}',
                    ec_mall_pid         = '{$row['ec_mall_pid']}',
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
                    it_1_subj           = '{$row['it_1_subj']}',
                    it_2_subj           = '{$row['it_2_subj']}',
                    it_3_subj           = '{$row['it_3_subj']}',
                    it_4_subj           = '{$row['it_4_subj']}',
                    it_5_subj           = '{$row['it_5_subj']}',
                    it_6_subj           = '{$row['it_6_subj']}',
                    it_7_subj           = '{$row['it_7_subj']}',
                    it_8_subj           = '{$row['it_8_subj']}',
                    it_9_subj           = '{$row['it_9_subj']}',
                    it_10_subj          = '{$row['it_10_subj']}',
                    it_1                = '{$row['it_1']}',
                    it_2                = '{$row['it_2']}',
                    it_3                = '{$row['it_3']}',
                    it_4                = '{$row['it_4']}',
                    it_5                = '{$row['it_5']}',
                    it_6                = '{$row['it_6']}',
                    it_7                = '{$row['it_7']}',
                    it_8                = '{$row['it_8']}',
                    it_9                = '{$row['it_9']}',
                    it_10               = '{$row['it_10']}',
                    site_id			 = '$site_id' ";
    sql_query($sql,true);


    $dst_dir = G5_DATA_PATH.'/item/'.$site_id.'/'.$row['it_id']; // 복사본 디렉토리

    @mkdir($dst_dir, G5_DIR_PERMISSION);
    @chmod($dst_dir, G5_DIR_PERMISSION);

    // 이미지 복사
    for ($k=1; $k <= 10; $k++) {

        if ($row["it_img{$k}"]) {
            $src_dir = '/home/flower3/public_html/data/item/'.$row["it_img{$k}"]; // 원본 파일

            if(!is_file($src_dir)) {
                $src_dir = '/home/flower7/public_html/data/item/'.$row["it_img{$k}"]; // 원본 파일
            }

            $item_img_file_name = explode('/', $row["it_img{$k}"]); // 파일이름을 찾기 위해서 배열로 자름
            $file_name = $item_img_file_name[count($item_img_file_name)-1]; // 배열의 마지막이 파일임

            // 원본파일을 복사하고 퍼미션을 변경
            copy($src_dir, $dst_dir.'/'.$file_name);
            echo $dst_dir.'/'.$file_name;
            echo '<br>';
            chmod($dst_dir/$file_name, G5_FILE_PERMISSION);
        }
    }

    unset($re_img);
}
?>