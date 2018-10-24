<?php
$sub_menu = '500800';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '현재접속자';
include_once (G5_MASTER_PATH.'/admin.head.php');

$list = array();

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt from {$g5['login_table']} where mb_id <> '{$config['cf_admin']}' ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = " select a.mb_id, b.mb_nick, b.mb_name, b.mb_email, b.mb_homepage, b.mb_open, b.mb_point, a.lo_ip, a.lo_location, a.lo_url
            from {$g5['login_table']} a left join {$g5['member_table']} b on (a.mb_id = b.mb_id)
            where a.mb_id <> '{$config['cf_admin']}'
            order by a.lo_datetime desc ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $row['lo_url'] = get_text($row['lo_url']);
    $list[$i] = $row;

    if ($row['mb_id']) {
        $list[$i]['name'] = get_sideview($row['mb_id'], cut_str($row['mb_nick'], $config['cf_cut_name']), $row['mb_email'], $row['mb_homepage']);
    } else {
        if ($is_admin)
            $list[$i]['name'] = $row['lo_ip'];
        else
            $list[$i]['name'] = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $row['lo_ip']);
    }

    $list[$i]['num'] = sprintf('%03d',$i+1);
}
?>

<div class="local_ov01 local_ov">
    <span class="btn_ov01"><span class="ov_txt">현재접속자 </span><span class="ov_num"> <?php echo number_format($total_count) ?>명 </span></span>
</div>

<div class="tbl_head03 tbl_wrap">
    <table>
        <caption><?php echo $g5['title']; ?> 목록</caption>
        <col width="5%"></col>
        <col width="5%"></col>
        <col width="10%"></col>
        <col width="5%"></col>
        <thead>
        <tr>
            <th scope="col">번호</th>
            <th scope="col">이름</th>
            <th scope="col">위치</th>
            <th scope="col">링크 바로가기</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i=0; $i<count($list); $i++) {
            $location = $list[$i]['lo_location'];

            if ($list[$i]['lo_url'] && $is_admin == 'super') $display_location = "<a href=\"".$list[$i]['lo_url']."\">".$location."</a>";
            else $display_location = $location;
            ?>

            <tr>
                <td class="td_num"><?php echo $list[$i]['num'] ?></td>
                <td class="td_num"><?php echo get_member_profile_img($list[$i]['mb_id']); ?><br><?php echo $list[$i]['name'] ?></td>
                <td class="td_num"><?php echo $location;?></td>
                <td class="td_num"><a href="<?php echo $list[$i]['lo_url'] ?>" target="_blank" class="btn btn_03">바로가기</a></td>
            </tr>

            <?php
        }

        if ($i == 0) {
            echo '<tr><td colspan="4" class="empty_table">현재 접속자가 없습니다.</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>

<?php
include_once (G5_MASTER_PATH.'/admin.tail.php');
?>
<?php
/**
 * Created by PhpStorm.
 * User: iamksg
 * Date: 2018-06-01
 * Time: 오후 12:34
 */