<?php
$sub_menu = "100050";
include_once('./_common.php');

check_demo();

if (!count($_POST['chk'])) {
    alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

auth_check($auth[$sub_menu], 'w');

check_master_token();

if ($_POST['act_button'] == "선택수정") {

    for ($i=0; $i<count($_POST['chk']); $i++)
    {
        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];

		// 테마를 update 함
		$sql = " update {$g5['config_table']} set cf_theme = '{$_POST['cf_theme'][$k]}' where site_id = '{$_POST['cf_admin'][$k]}' ";
		sql_query($sql);

		// 플랫폼 관리자의 상태(mb_level)를 update 함
		$sql = " update {$g5['member_table']} set mb_level = '{$_POST['mb_level'][$k]}' where site_id = '{$_POST['cf_admin'][$k]}' ";
		sql_query($sql);
    }

} else if ($_POST['act_button'] == "선택삭제") {

    for ($i=0; $i<count($_POST['chk']); $i++)
    {
        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];
		
		// 미구현 선택삭제는 과연 필요한 것 인가?
    }
}

if ($msg)
    //echo '<script> alert("'.$msg.'"); </script>';
    alert($msg);

goto_url('./config_list.php?'.$qstr);
?>
