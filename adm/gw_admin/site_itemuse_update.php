<?php
$sub_menu = "600100";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$sql = " select count(*) as cnt from {$g5['itemuse_config']} where site_id = '$site_id' ";
$row = sql_fetch($sql);

if(!$mode) {
    // 이미 등록된 설정이 있으면
    if ( $row['cnt'] ) {
        $sql = " update {$g5['itemuse_config']}
            set ic_count = '{$_POST['ic_count']}',
                ic_content = '{$_POST['ic_content']}',
                ic_name = '{$_POST['ic_name']}' 
            where site_id = '$site_id' ";
        sql_query($sql);
    } else {
        $sql = " insert into {$g5['itemuse_config']}
            set ic_count = '{$_POST['ic_count']}',
                ic_content = '{$_POST['ic_content']}',
                ic_name = '{$_POST['ic_name']}',
                site_id = '$site_id' ";
        sql_query($sql);
    }

    alert('설정 저장이 완료되었습니다.', './site_itemuse.php');
}


// 사용후기 일괄등록을 원하는 플랫폼의 정보를 가져옴
$itemuse_config = sql_fetch(" select * from {$g5['itemuse_config']} where site_id = '$site_id' ");

// 상품의 개수만큼 입력시작
if($mode == 'insert' && $itemuse_config['ic_count']) {

    $sql = " select * from {$g5['g5_shop_item_table']} where site_id = '$site_id' order by it_id asc ";
    $result = sql_query($sql);

    while ($row = sql_fetch_array($result))
    {
        for ($i=0; $i<$itemuse_config['ic_count']; $i++) {

            // 후기 내용
            $itemuse_content = explode("\n", trim($itemuse_config['ic_content']));
            for ($j=0; $j<count($itemuse_content); $j++) {
                $itemuse_content[$j] = trim($itemuse_content[$j]);
            }

            // 후기 작성자
            $itemuse_name = explode("\n", trim($itemuse_config['ic_name']));
            for ($k=0; $k<count($itemuse_name); $k++) {
                $itemuse_name[$k] = trim($itemuse_name[$k]);
            }

            $subject_num = array_rand($itemuse_content, 1); // 제목 랜덤
            $content_num = array_rand($itemuse_content, 1); // 내용 랜덤
            $name_num = array_rand($itemuse_name, 1); // 이름 랜덤

            $is_subject = $itemuse_content[$subject_num];
            $is_content = $itemuse_content[$content_num];
            $is_name = $itemuse_name[$name_num];

            // 후기 평점
            $is_score = rand(3, 5);

            $is_reply_subject = "저희 {$config['cf_title']} 이용해주셔서 감사합니다."; // 관리자 답변 제목
            $is_reply_content = '고객님 주문 감사합니다. 1000원 할인쿠폰 지급해드렸습니다.^^\\n앞으로도 저희 '.$config['cf_title'].' 많은 이용부탁드립니다.'; // 관리자 답변 내용

            // 사용후기 등록시작
            $sql = "insert {$g5['g5_shop_item_use_table']}
               set it_id = '{$row['it_id']}',
                   mb_id = 'admin',
                   is_score = '$is_score',
                   is_name = '$is_name',
                   is_password = '*DD26C2A1C032D814179245BCB5C5F5680CFC18EE',
                   is_subject = '$is_subject',
                   is_content = '$is_content',
                   is_time = '".G5_TIME_YMDHIS."',
                   is_ip = '{$_SERVER['REMOTE_ADDR']}',
				   is_confirm = '1',
				   is_reply_subject = '$is_reply_subject',
                   is_reply_content = '$is_reply_content',
                   is_reply_name = '{$config['cf_title']}',
				   site_id = '$site_id'";
            sql_query($sql);
        }

    }
    alert('사용후기 등록이 완료되었습니다.', './site_itemuse.php');
}

goto_url('./site_itemuse.php', false);
?>