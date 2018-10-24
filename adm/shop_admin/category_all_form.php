<?php
$sub_menu = '400200';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '분류 일괄등록';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$where = " where ";
$sql_search = "";
if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
    }
    if ($save_stx && ($save_stx != $stx))
        $page = 1;
}

$sql_common = " from {$g5['g5_shop_category_table']} $where site_id = 'master' ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

//$rows = $config['cf_page_rows'];
$rows = 100;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

if (!$sst)
{
    $sst  = "ca_id";
    $sod = "asc";
}
$sql_order = "order by $sst $sod";

// 출력할 레코드를 얻음
$sql  = " select *
             $sql_common
             $sql_order
             limit $from_record, $rows ";
$result = sql_query($sql);
?>

<div class="local_desc02 local_desc">
    <p>
        사용 할 상품 분류리스트, 분류의 상품을 설정합니다.<br>
        적용시 모든 분류와 상품이 재등록되며 기존 상품금액에 차이가 있을시 새로 변경하셔야 합니다.
    </p>
</div>

<div class="local_ov01 local_ov">
    <span class="btn_ov01"><span class="ov_txt">기본 분류 수</span><span class="ov_num">  <?php echo number_format($total_count); ?>개</span></span>
</div>

<form name="fcategorylist" method="post" action="./category_all_listupdate.php" onsubmit="return category_all_list_submit(this);" autocomplete="off">
    <input type="hidden" name="sst" value="<?php echo $sst; ?>">
    <input type="hidden" name="sod" value="<?php echo $sod; ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
    <input type="hidden" name="stx" value="<?php echo $stx; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">

    <div id="cate_adm" class="tbl_head03 tbl_wrap">
        <table>
            <caption><?php echo $g5['title']; ?> 목록</caption>
            <thead>
            <tr>
                <th scope="col" rowspan="2"><?php echo subject_sort_link("ca_id"); ?>분류코드</a></th>
                <th scope="col" id="sct_hpcert" rowspan="2">
                    <label for="chkall" class="sound_only">분류 전체</label>
                    <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                </th>
                <th scope="col" id="sct_cate" rowspan="2"><?php echo subject_sort_link("ca_name"); ?>분류명</a></th>
                <th scope="col" id="sct_amount" rowspan="2">상품수</th>
            </tr>
            </thead>
            <tbody>
            <?php
            for ($i=0; $row=sql_fetch_array($result); $i++)
            {
                $level = strlen($row['ca_id']) / 2 - 1;
                $p_ca_name = '';

                if ($level > 0) {
                    $class = 'class="name_lbl"'; // 2단 이상 분류의 label 에 스타일 부여 - 지운아빠 2013-04-02
                    // 상위단계의 분류명
                    $p_ca_id = substr($row['ca_id'], 0, $level*2);
                    $sql = " select ca_name from {$g5['g5_shop_category_table']} where ca_id = '$p_ca_id' and site_id = 'master' ";
                    $temp = sql_fetch($sql);
                    $p_ca_name = $temp['ca_name'].'의하위';
                } else {
                    $class = '';
                }

                $s_level = '<div><label for="ca_name_'.$i.'" '.$class.'><span class="sound_only">'.$p_ca_name.''.($level+1).'단 분류</span></label></div>';
                $s_level_input_size = 25 - $level *2; // 하위 분류일 수록 입력칸 넓이 작아짐 - 지운아빠 2013-04-02

                // 해당 분류에 속한 상품의 수
                $sql1 = " select COUNT(*) as cnt from {$g5['g5_shop_item_table']}
                      where (ca_id = '{$row['ca_id']}'
                      or ca_id2 = '{$row['ca_id']}'
                      or ca_id3 = '{$row['ca_id']}') 
                      and site_id = 'master' ";
                $row1 = sql_fetch($sql1);

                // 본인의 사이트에 등록된 분류인지 체크
                $site_sql = " select count(*) as cnt from {$g5['g5_shop_category_table']} where ca_id = '{$row['ca_id']}' and site_id = '$site_id' ";
                $site_row = sql_fetch($site_sql);

                $bg = 'bg'.($i%2);
                ?>
                <tr class="<?php echo $bg; ?>">
                    <td class="td_code">
                        <input type="hidden" name="ca_id[<?php echo $i; ?>]" value="<?php echo $row['ca_id']; ?>">
                        <?php echo $row['ca_id']; ?>
                    </td>
                    <td headers="sct_hpcert" class="td_possible">
                        <input type="checkbox" name="chk[]" value="<?php echo $i; ?>" id="ca_cert_use_yes<?php echo $i; ?>" <?php if($site_row['cnt']) echo 'checked="checked"'; ?>>
                        <label for="ca_cert_use_yes<?php echo $i; ?>">사용</label>
                    </td>
                    <td headers="sct_cate" class="sct_admin_name<?php echo $level; ?>"><?php echo $s_level; ?> <?php echo get_text($row['ca_name']); ?></td>
                    <td headers="sct_amount" class="td_amount"><?php echo $row1['cnt']; ?></td>
                </tr>

            <?php }
            if ($i == 0) echo "<tr><td colspan=\"9\" class=\"empty_table\">자료가 한 건도 없습니다.</td></tr>\n";
            ?>
            </tbody>
        </table>
    </div>

    <div class="btn_fixed_top">
        <input type="submit" value="일괄등록" onclick="document.pressed=this.value" class="btn_02 btn">

    </div>

</form>

<script>
    function category_all_list_submit(f)
    {
        if (!is_checked("chk[]")) {
            alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
            return false;
        }

        if(document.pressed == "일괄등록") {
            if(!confirm("이전 등록된 분류는 모두 초기화됩니다.\n선택한 분류를 정말 등록하시겠습니까?")) {
                return false;
            }
        }

        return true;
    }
</script>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
