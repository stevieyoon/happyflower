<?php
$sub_menu = "600100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$g5['title'] = '사용후기 일괄등록';
include_once (G5_ADMIN_PATH.'/admin.head.php');

// 사용후기 일괄등록을 원하는 플랫폼의 정보를 가져옴
$itemuse_config = sql_fetch(" select * from {$g5['itemuse_config']} where site_id = '$site_id' ");

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="설정저장" class="btn_submit" accesskey="s">
    <a href="'.G5_URL.'/">메인으로</a>
    <a href="'.G5_ADMIN_URL.'/gw_admin/site_itemuse_update.php?mode=insert" class="btn_submit">일괄등록 실행</a>
</div>';
?>

<form name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);">
    <input type="hidden" name="token" value="" id="token">

    <section id="anc_cf_basic">
        <h2 class="h2_frm">사용후기 일괄등록 설정</h2>
        <?php echo $pg_anchor ?>

        <div class="tbl_frm01 tbl_wrap">
            <table>
                <caption>사용후기 일괄등록 설정</caption>
                <colgroup>
                    <col class="grid_4">
                    <col>
                    <col class="grid_4">
                    <col>
                </colgroup>
                <tbody>

                <tr>
                    <th scope="row">등록개수</th>
                    <td colspan="3">
                        <?php echo help('ex) 등록한 개수만큼 사용후기가 등록됩니다.') ?>
                        <input type="text" name="ic_count" value="<?php echo $itemuse_config['ic_count'] ?>" required class="required frm_input" size="5"> 개
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ic_content">후기내용</label></th>
                    <td>
                        <?php echo help('후기내용을 입력합니다. (엔터로 구분)') ?>
                        <textarea name="ic_content"><?php echo $itemuse_config['ic_content'] ?></textarea>
                    </td>
                    <th scope="row"><label for="ic_name">작성자</label></th>
                    <td>
                        <?php echo help('작성자를 입력합니다. (엔터로 구분)') ?>
                        <textarea name="ic_name"><?php echo $itemuse_config['ic_name'] ?></textarea>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>

    <?php echo $frm_submit; ?>

</form>

<script>
    function fconfigform_submit(f)
    {
        f.action = "./site_itemuse_update.php";
        return true;
    }
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
