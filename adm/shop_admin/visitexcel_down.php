<?php
$sub_menu = "500900";
include_once("./_common.php");

function utf8_urldecode($str, $chr_set='CP949') {
    $callback_function = create_function('$matches, $chr_set="'.$chr_set.'"', 'return iconv("UTF-16BE", $chr_set, pack("n*", hexdec($matches[1])));');
    return rawurldecode(preg_replace_callback('/%u([[:alnum:]]{4})/', $callback_function, $str));
}

function contains($needle, $haystack)

{
    return strpos($haystack, $needle) !== false;
}

if ( ! function_exists('utf2euc')) {
    function utf2euc($str) {
        return iconv("UTF-8","cp949//IGNORE", $str);
    }
}
if ( ! function_exists('is_ie')) {
    function is_ie() {
        return isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false);
    }
}

auth_check($auth[$sub_menu], "r");

if (empty($fr_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = G5_TIME_YMD;
if (empty($to_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = G5_TIME_YMD;

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

$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

if (!$total_count) alert_just('데이터가 없습니다.');

$qry = sql_query(" select * $sql_common order by vi_id desc ");

/*================================================================================
php_writeexcel http://www.bettina-attack.de/jonny/view.php/projects/php_writeexcel/
=================================================================================*/

include_once(G5_LIB_PATH.'/Excel/php_writeexcel/class.writeexcel_workbook.inc.php');
include_once(G5_LIB_PATH.'/Excel/php_writeexcel/class.writeexcel_worksheet.inc.php');

$fname = tempnam(G5_DATA_PATH, "tmp.xls");
$workbook = new writeexcel_workbook($fname);
$worksheet = $workbook->addworksheet();

$num2_format =& $workbook->addformat(array(num_format => '\0#'));

// Put Excel data
$data = array(
    "vi_ip"=>"아이피",
    "vi_date"=>"날짜",
    "vi_time"=>"시간",
    "vi_referer"=>"검색어",
    "vi_agent"=>"사이트"
);

$data = array_map('iconv_euckr', $data);

$col = 0;
foreach($data as $cell) {
    $worksheet->write(0, $col++, $cell);
}

for($i=1; $res=sql_fetch_array($qry); $i++)
{
    $res = array_map('iconv_euckr', $res);

    $col = 0;
    foreach($data as $key=>$cell) {

        $column_data = $res[$key];

        if ($key == 'vi_referer' || $key == 'vi_agent') {

            // 어느 사이트인지 찾기
            foreach($surl_arr as $site_chk => $surl) {
                if(strstr($res[vi_referer], str_replace("%", "", $surl))) {
                    $engine = $site_chk;
                    break;
                }
            }

            // 검색문자열 찾기
            $regex = "/(\?|&){$svar_arr[$engine]}\=([^&]*)/i";
            preg_match($regex, $res[vi_referer], $matches);
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

            if ($key == 'vi_referer') $column_data = iconv_euckr($querystr);
            if ($key == 'vi_agent') $column_data = $engine;

        }

        $worksheet->write($i, $col++, $column_data);
    }
}

$workbook->close();

$filename = "유입통계목록-".date("ymd", time()).".xls";
if( is_ie() ) $filename = utf2euc($filename);

header("Content-Type: application/x-msexcel; name=".$filename);
header("Content-Disposition: inline; filename=".$filename);
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);

exit;
?>