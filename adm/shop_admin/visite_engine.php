<?php
$sub_menu = '500900';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '활성도 통계';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

function utf8_urldecode($str, $chr_set='CP949') {
    $callback_function = create_function('$matches, $chr_set="'.$chr_set.'"', 'return iconv("UTF-16BE", $chr_set, pack("n*", hexdec($matches[1])));');
    return rawurldecode(preg_replace_callback('/%u([[:alnum:]]{4})/', $callback_function, $str));
}

if (empty($fr_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = G5_TIME_YMD;
if (empty($to_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = G5_TIME_YMD;

$qstr = "fr_date=".$fr_date."&amp;to_date=".$to_date;
$query_string = $qstr ? '?'.$qstr : '';

// 검색사이트들
$site_arr = array("Google", "Daum", "Naver");
$surl_arr = array("Google" => "http://www.google.%", "Daum" => "%search.daum.net%", "Naver" => "%search.naver.com%");
$svar_arr = array("Google" => "q", "Daum" => "q", "Naver" => "query");

if($site) {
    $sql_add = " vi_referer LIKE '{$surl_arr[$site]}' ";
} else {
    foreach($surl_arr as $site_chk => $surl) {
        $sql_add[] = " vi_referer LIKE '$surl' ";
    }
    $sql_add = implode("or", $sql_add);
}

$sql_add = '('.$sql_add.')';

$sql_common = " from {$g5['visit_table']} where {$sql_add} and vi_date between '{$fr_date}' and '{$to_date}' and site_id = '$site_id' ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select * $sql_common order by vi_id desc limit $from_record, $rows ";
$result = sql_query($sql);

// 네이버
$sql = " select count(*) as cnt from {$g5['visit_table']} where vi_referer LIKE '%search.naver.com%' and vi_date between '{$fr_date}' and '{$to_date}' and site_id = '$site_id' ";
$row = sql_fetch($sql);
$naver_count = $row['cnt'];

// 다음
$sql = " select count(*) as cnt from {$g5['visit_table']} where vi_referer LIKE '%search.daum.net%' and vi_date between '{$fr_date}' and '{$to_date}' and site_id = '$site_id' ";
$row = sql_fetch($sql);
$daum_count = $row['cnt'];

// 구글
$sql = " select count(*) as cnt from {$g5['visit_table']} where vi_referer LIKE 'http://www.google.%' and vi_date between '{$fr_date}' and '{$to_date}' and site_id = '$site_id' ";
$row = sql_fetch($sql);
$google_count = $row['cnt'];
?>

<div class="local_ov01 local_ov">
    <!--
    <span class="btn_ov01"><span class="ov_txt">전체 유입수 </span><span class="ov_num"> <?php echo number_format($total_count) ?>건 </span></span>
	-->
    <span class="btn_ov01"><span class="ov_txt">네이버 </span><span class="ov_num"><?php echo number_format($naver_count) ?>건</span></span>
    <span class="btn_ov01"><span class="ov_txt">다음  </span><span class="ov_num"><?php echo number_format($daum_count) ?>건</span></span>
    <span class="btn_ov01"><span class="ov_txt">구글  </span><span class="ov_num"><?php echo number_format($google_count) ?>건</span></span>
</div>

<form name="fvisit" id="fvisit" class="local_sch03 local_sch" method="get">
    <div class="sch_last">
        <strong>기간별검색</strong>
        <input type="text" name="fr_date" value="<?php echo $fr_date ?>" id="fr_date" class="frm_input" size="11" maxlength="10">
        <label for="fr_date" class="sound_only">시작일</label>
        ~
        <input type="text" name="to_date" value="<?php echo $to_date ?>" id="to_date" class="frm_input" size="11" maxlength="10">
        <label for="to_date" class="sound_only">종료일</label>
        <input type="submit" value="검색" class="btn_submit">
    </div>
</form>

<ul class="anchor">
    <li><a href="./visite_engine.php<?php echo $query_string ?>">전체</a></li>
    <li><a href="./visite_engine.php<?php echo $query_string ?>&amp;site=Naver">네이버</a></li>
    <li><a href="./visite_engine.php<?php echo $query_string ?>&amp;site=Daum">다음</a></li>
    <li><a href="./visite_engine.php<?php echo $query_string ?>&amp;site=Google">구글</a></li>
</ul>

<div class="tbl_head03 tbl_wrap">
    <table>
        <caption><?php echo $g5['title']; ?> 목록</caption>
        <col width="5%"></col>
        <col width="10%"></col>
        <col width="5%"></col>
        <col width="5%"></col>
        <thead>
        <tr>
            <th scope="col">사이트</th>
            <th scope="col">검색어</th>
            <th scope="col">날짜</th>
            <th scope="col">시간</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i=0; $row=sql_fetch_array($result); $i++) {
            // 어느 사이트인지 찾기
            foreach($surl_arr as $site_chk => $surl) {
                if(strstr($row[vi_referer], str_replace("%", "", $surl))) {
                    $engine = $site_chk;
                    break;
                }
            }

            // 검색문자열 찾기
            $regex = "/(\?|&){$svar_arr[$engine]}\=([^&]*)/i";
            preg_match($regex, $row[vi_referer], $matches);
            $querystr = $matches[2];
            // 보통 검색어 사이를 +로 넘긴다
            $querystr = str_replace("+", " ", $querystr);
            // %ab 이런 식으로 된 걸 바꿔주기
            $querystr = urldecode($querystr);
            // 네이버는 unicode로 된 경우도 있어서
            if($engine=="Naver") $querystr = utf8_urldecode($querystr);
            // 캐릭터셋이 utf-8인 경우는 euc-kr 고치기 (utf-8 유저는 euc-KR과 utf-8을 서로 바꿔주면 될 듯)
            $charset = mb_detect_encoding($querystr, "ASCII, euc-KR, utf-8");
            if($charset=="euc-kr") $querystr = iconv("euc-kr", "utf-8", $querystr);
            // 자잘한 처리들
            $querystr = trim($querystr);
            $querystr = htmlspecialchars($querystr);

            $site_logo = "<img src=".G5_ADMIN_URL."/img/".strtolower($engine).".png>";

            ?>

            <tr>
                <td class="td_num"><?php echo $site_logo; ?></td>
                <td class="td_left"><?php echo $querystr; ?></td>
                <td class="td_num"><?php echo $row['vi_date']; ?></td>
                <td class="td_boolean"><?php echo $row['vi_time']; ?></td>
            </tr>

            <?php
        }

        if ($i == 0) {
            echo '<tr><td colspan="4" class="empty_table">자료가 없습니다.</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <?php if ($is_admin == 'super') { ?>
        <a href="./visitexcel_down.php?fr_date=<?php echo $fr_date ?>&amp;to_date=<?php echo $to_date ?>&amp;site=<?php echo $site ?>" onclick="return excel_down(f);" target="_blank" class="btn btn_01">엑셀다운</a>
    <?php } ?>
</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page=", "&amp;site=".$_GET['site']); ?>

<script>
    $(function(){
        $("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
    });
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
