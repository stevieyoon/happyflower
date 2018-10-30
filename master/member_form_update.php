<?php
$sub_menu = "200100";
include_once("./_common.php");
include_once(G5_LIB_PATH."/register.lib.php");
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if ($w == 'u')
    check_demo();

auth_check($auth[$sub_menu], 'w');

check_master_token();

$mb_id = trim($_POST['mb_id']);

// 휴대폰번호 체크
$mb_hp = hyphen_hp_number($_POST['mb_hp']);
if($mb_hp) {
    $result = exist_mb_hp($mb_hp, $mb_id);
    if ($result)
        alert($result);
}

// 인증정보처리
if($_POST['mb_certify_case'] && $_POST['mb_certify']) {
    $mb_certify = $_POST['mb_certify_case'];
    $mb_adult = $_POST['mb_adult'];
} else {
    $mb_certify = '';
    $mb_adult = 0;
}

$mb_zip1 = substr($_POST['mb_zip'], 0, 3);
$mb_zip2 = substr($_POST['mb_zip'], 3);

$sql_common = "  mb_name = '{$_POST['mb_name']}',
                 mb_nick = '{$_POST['mb_nick']}',
                 mb_email = '{$_POST['mb_email']}',
                 mb_homepage = '{$_POST['mb_homepage']}',
                 mb_tel = '{$_POST['mb_tel']}',
                 mb_hp = '{$mb_hp}',
                 mb_certify = '{$mb_certify}',
                 mb_adult = '{$mb_adult}',
                 mb_zip1 = '$mb_zip1',
                 mb_zip2 = '$mb_zip2',
                 mb_addr1 = '{$_POST['mb_addr1']}',
                 mb_addr2 = '{$_POST['mb_addr2']}',
                 mb_addr3 = '{$_POST['mb_addr3']}',
                 mb_addr_jibeon = '{$_POST['mb_addr_jibeon']}',
                 mb_signature = '{$_POST['mb_signature']}',
                 mb_leave_date = '{$_POST['mb_leave_date']}',
                 mb_intercept_date='{$_POST['mb_intercept_date']}',
                 mb_memo = '{$_POST['mb_memo']}',
                 mb_mailling = '{$_POST['mb_mailling']}',
                 mb_sms = '{$_POST['mb_sms']}',
                 mb_open = '{$_POST['mb_open']}',
                 mb_profile = '{$_POST['mb_profile']}',
                 mb_level = '{$_POST['mb_level']}',
                 mb_1 = '{$_POST['mb_1']}',
                 mb_2 = '{$_POST['mb_2']}',
                 mb_3 = '{$_POST['mb_3']}',
                 mb_4 = '{$_POST['mb_4']}',
                 mb_5 = '{$_POST['mb_5']}',
                 mb_6 = '{$_POST['mb_6']}',
                 mb_7 = '{$_POST['mb_7']}',
                 mb_8 = '{$_POST['mb_8']}',
                 mb_9 = '{$_POST['mb_9']}',
                 mb_10 = '{$_POST['mb_10']}' ";

if ($w == '')
{
    $mb = get_member($mb_id);
    if ($mb['mb_id'])
        alert('이미 존재하는 회원아이디입니다.\\nＩＤ : '.$mb['mb_id'].'\\n이름 : '.$mb['mb_name'].'\\n닉네임 : '.$mb['mb_nick'].'\\n메일 : '.$mb['mb_email']);

    // 닉네임중복체크
    $sql = " select mb_id, mb_name, mb_nick, mb_email from {$g5['member_table']} where mb_nick = '{$_POST['mb_nick']}' ";
    $row = sql_fetch($sql);
    if ($row['mb_id'])
        alert('이미 존재하는 닉네임입니다.\\nＩＤ : '.$row['mb_id'].'\\n이름 : '.$row['mb_name'].'\\n닉네임 : '.$row['mb_nick'].'\\n메일 : '.$row['mb_email']);

    // 이메일중복체크
    $sql = " select mb_id, mb_name, mb_nick, mb_email from {$g5['member_table']} where mb_email = '{$_POST['mb_email']}' ";
    $row = sql_fetch($sql);
    if ($row['mb_id'])
        alert('이미 존재하는 이메일입니다.\\nＩＤ : '.$row['mb_id'].'\\n이름 : '.$row['mb_name'].'\\n닉네임 : '.$row['mb_nick'].'\\n메일 : '.$row['mb_email']);

    // master 사이트에서 가입시 회원을 관리자로 생성함(gnuwiz)
    if($config['site_id'] == 'master') {

        // config 테이블에 추가
        $sql = " insert into {$g5['config_table']}
					set cf_title = '".G5_VERSION."',
						cf_theme = 'basic',
						cf_admin = '$mb_id',
						cf_admin_email = '$mb_email',
						cf_admin_email_name = '".G5_VERSION."',
						cf_use_point = '1',
						cf_use_copy_log = '1',
						cf_login_point = '100',
						cf_memo_send_point = '500',
						cf_cut_name = '15',
						cf_nick_modify = '60',
						cf_new_skin = 'theme/basic',
						cf_new_rows = '15',
						cf_search_skin = 'theme/basic',
						cf_connect_skin = 'theme/basic',
						cf_read_point = '$read_point',
						cf_write_point = '$write_point',
						cf_comment_point = '$comment_point',
						cf_download_point = '$download_point',
						cf_write_pages = '10',
						cf_mobile_pages = '5',
						cf_link_target = '_blank',
						cf_delay_sec = '30',
						cf_filter = '18아,18놈,18새끼,18뇬,18노,18것,18넘,개년,개놈,개뇬,개새,개색끼,개세끼,개세이,개쉐이,개쉑,개쉽,개시키,개자식,개좆,게색기,게색끼,광뇬,뇬,눈깔,뉘미럴,니귀미,니기미,니미,도촬,되질래,뒈져라,뒈진다,디져라,디진다,디질래,병쉰,병신,뻐큐,뻑큐,뽁큐,삐리넷,새꺄,쉬발,쉬밸,쉬팔,쉽알,스패킹,스팽,시벌,시부랄,시부럴,시부리,시불,시브랄,시팍,시팔,시펄,실밸,십8,십쌔,십창,싶알,쌉년,썅놈,쌔끼,쌩쑈,썅,써벌,썩을년,쎄꺄,쎄엑,쓰바,쓰발,쓰벌,쓰팔,씨8,씨댕,씨바,씨발,씨뱅,씨봉알,씨부랄,씨부럴,씨부렁,씨부리,씨불,씨브랄,씨빠,씨빨,씨뽀랄,씨팍,씨팔,씨펄,씹,아가리,아갈이,엄창,접년,잡놈,재랄,저주글,조까,조빠,조쟁이,조지냐,조진다,조질래,존나,존니,좀물,좁년,좃,좆,좇,쥐랄,쥐롤,쥬디,지랄,지럴,지롤,지미랄,쫍빱,凸,퍽큐,뻑큐,빠큐,ㅅㅂㄹㅁ',
						cf_possible_ip = '',
						cf_intercept_ip = '',
						cf_member_skin = 'theme/basic',
						cf_mobile_new_skin = 'theme/basic',
						cf_mobile_search_skin = 'theme/basic',
						cf_mobile_connect_skin = 'theme/basic',
						cf_mobile_member_skin = 'theme/basic',
						cf_faq_skin = 'theme/basic',
						cf_mobile_faq_skin = 'theme/basic',
						cf_editor = 'smarteditor2',
						cf_captcha_mp3 = 'basic',
						cf_register_level = '2',
						cf_register_point = '1000',
						cf_icon_level = '2',
						cf_leave_day = '30',
						cf_search_part = '10000',
						cf_email_use = '1',
						cf_prohibit_id = 'admin,administrator,관리자,운영자,어드민,주인장,webmaster,웹마스터,sysop,시삽,시샵,manager,매니저,메니저,root,루트,su,guest,방문객',
						cf_prohibit_email = '',
						cf_new_del = '30',
						cf_memo_del = '180',
						cf_visit_del = '180',
						cf_popular_del = '180',
						cf_use_member_icon = '2',
						cf_member_icon_size = '5000',
						cf_member_icon_width = '22',
						cf_member_icon_height = '22',
						cf_member_img_size = '50000',
						cf_member_img_width = '60',
						cf_member_img_height = '60',
						cf_login_minutes = '10',
						cf_image_extension = 'gif|jpg|jpeg|png',
						cf_flash_extension = 'swf',
						cf_movie_extension = 'asx|asf|wmv|wma|mpg|mpeg|mov|avi|mp3',
						cf_formmail_is_member = '1',
						cf_page_rows = '15',
						cf_mobile_page_rows = '15',
						cf_cert_limit = '2',
						cf_stipulation = '해당 홈페이지에 맞는 회원가입약관을 입력합니다.',
						cf_privacy = '해당 홈페이지에 맞는 개인정보처리방침을 입력합니다.',
						cf_captcha = 'kcaptcha',
						cf_domain = '{$mb_id}.hpflower.com',
						site_id = '$mb_id'
						";
        sql_query($sql);

        // default 설정 (쇼핑몰 설정)

        // 이미지 사이즈
        $ssimg_width = 130;
        $ssimg_height = 130;
        $simg_width = 230;
        $simg_height = 230;
        $mimg_width = 400;
        $mimg_height = 400;
        $mmimg_width = 400;
        $mmimg_height = 200;

        $sql = " insert into {$g5['g5_shop_default_table']}
                set de_admin_company_name = '회사명',
                    de_admin_company_saupja_no = '123-45-67890',
                    de_admin_company_owner = '대표자명',
                    de_admin_company_tel = '02-123-4567',
                    de_admin_company_fax = '02-123-4568',
                    de_admin_tongsin_no = '제 OO구 - 123호',
                    de_admin_buga_no = '12345호',
                    de_admin_company_zip = '123-456',
                    de_admin_company_addr = 'OO도 OO시 OO구 OO동 123-45',
                    de_admin_info_name = '정보책임자명',
                    de_admin_info_email = '정보책임자 E-mail',
                    de_shop_skin = 'theme/basic',
                    de_shop_mobile_skin = 'theme/basic',
                    de_type1_list_use = '1',
                    de_type1_list_skin = 'main.10.skin.php',
                    de_type1_list_mod = '4',
                    de_type1_list_row = '2',
                    de_type1_img_width = '$simg_width',
                    de_type1_img_height = '$simg_height',
                    de_type2_list_use = '1',
                    de_type2_list_skin = 'main.10.skin.php',
                    de_type2_list_mod = '4',
                    de_type2_list_row = '2',
                    de_type2_img_width = '$simg_width',
                    de_type2_img_height = '$simg_height',
                    de_type3_list_use = '1',
                    de_type3_list_skin = 'main.40.skin.php',
                    de_type3_list_mod = '4',
                    de_type3_list_row = '2',
                    de_type3_img_width = '$simg_width',
                    de_type3_img_height = '$simg_height',
                    de_type4_list_use = '1',
                    de_type4_list_skin = 'main.50.skin.php',
                    de_type4_list_mod = '1',
                    de_type4_list_row = '5',
                    de_type4_img_width = '$simg_width',
                    de_type4_img_height = '$simg_height',
                    de_type5_list_use = '1',
                    de_type5_list_skin = 'main.10.skin.php',
                    de_type5_list_mod = '4',
                    de_type5_list_row = '2',
                    de_type5_img_width = '$simg_width',
                    de_type5_img_height = '$simg_height',
                    de_mobile_type1_list_use = '1',
                    de_mobile_type1_list_skin = 'main.10.skin.php',
                    de_mobile_type1_list_mod = '2',
                    de_mobile_type1_list_row = '2',
                    de_mobile_type1_img_width = '$simg_width',
                    de_mobile_type1_img_height = '$simg_height',
                    de_mobile_type2_list_use = '1',
                    de_mobile_type2_list_skin = 'main.20.skin.php',
                    de_mobile_type2_list_mod = '3',
                    de_mobile_type2_list_row = '2',
                    de_mobile_type2_img_width = '$ssimg_width',
                    de_mobile_type2_img_height = '$ssimg_height',
                    de_mobile_type3_list_use = '1',
                    de_mobile_type3_list_skin = 'main.30.skin.php',
                    de_mobile_type3_list_mod = '1',
                    de_mobile_type3_list_row = '8',
                    de_mobile_type3_img_width = '$mmimg_width',
                    de_mobile_type3_img_height = '$mmimg_height',
                    de_mobile_type4_list_use = '1',
                    de_mobile_type4_list_skin = 'main.10.skin.php',
                    de_mobile_type4_list_mod = '22',
                    de_mobile_type4_list_row = '2',
                    de_mobile_type4_img_width = '$simg_width',
                    de_mobile_type4_img_height = '$simg_height',
                    de_mobile_type5_list_use = '1',
                    de_mobile_type5_list_skin = 'main.10.skin.php',
                    de_mobile_type5_list_mod = '2',
                    de_mobile_type5_list_row = '2',
                    de_mobile_type5_img_width = '$simg_width',
                    de_mobile_type5_img_height = '$simg_height',
                    de_bank_use = '1',
                    de_bank_account = 'OO은행 12345-67-89012 예금주명',
                    de_vbank_use = '0',
                    de_iche_use = '0',
                    de_card_use = '0',
                    de_settle_min_point = '5000',
                    de_settle_max_point = '50000',
                    de_settle_point_unit = '100',
                    de_cart_keep_term = '15',
                    de_card_point = '0',
                    de_point_days = '7',
                    de_pg_service = 'kcp',
                    de_kcp_mid = '',
                    de_send_cost_case = '차등',
                    de_send_cost_limit = '20000;30000;40000',
                    de_send_cost_list = '4000;3000;2000',
                    de_hope_date_use = '0',
                    de_hope_date_after = '3',
                    de_baesong_content = '배송 안내 입력전입니다.',
                    de_change_content = '교환/반품 안내 입력전입니다.',
                    de_rel_list_use = '1',
                    de_rel_list_skin = 'relation.10.skin.php',
                    de_rel_list_mod = '5',
                    de_rel_img_width = '$simg_width',
                    de_rel_img_height = '$simg_height',
                    de_mobile_rel_list_use = '1',
                    de_mobile_rel_list_skin = 'relation.10.skin.php',
                    de_mobile_rel_list_mod = '3',
                    de_mobile_rel_img_width = '$simg_width',
                    de_mobile_rel_img_height = '$simg_height',
                    de_search_list_skin = 'list.10.skin.php',
                    de_search_img_width = '$simg_width',
                    de_search_img_height = '$simg_height',
                    de_search_list_mod = '4',
                    de_search_list_row = '5',
                    de_mobile_search_list_skin = 'list.10.skin.php',
                    de_mobile_search_img_width = '$simg_width',
                    de_mobile_search_img_height = '$simg_height',
                    de_mobile_search_list_mod = '3',
                    de_mobile_search_list_row = '5',
                    de_listtype_list_skin = 'list.10.skin.php',
                    de_listtype_img_width = '$simg_width',
                    de_listtype_img_height = '$simg_height',
                    de_listtype_list_mod = '4',
                    de_listtype_list_row = '5',
                    de_mobile_listtype_list_skin = 'list.10.skin.php',
                    de_mobile_listtype_img_width = '$simg_width',
                    de_mobile_listtype_img_height = '$simg_height',
                    de_mobile_listtype_list_mod = '3',
                    de_mobile_listtype_list_row = '5',
                    de_simg_width = '$simg_width',
                    de_simg_height = '$simg_height',
                    de_mimg_width = '$mimg_width',
                    de_mimg_height = '$mimg_height',
                    de_item_use_use = '1',
                    de_level_sell = '1',
                    de_code_dup_use = '1',
                    de_card_test = '1',
                    de_sms_cont1 = '{이름}님의 회원가입을 축하드립니다.\nID:{회원아이디}\n{회사명}',
                    de_sms_cont2 = '{이름}님 주문해주셔서 고맙습니다.\n{주문번호}\n{주문금액}원\n{회사명}',
                    de_sms_cont3 = '{이름}님께서 주문하셨습니다.\n{주문번호}\n{주문금액}원\n{회사명}',
                    de_sms_cont4 = '{이름}님 입금 감사합니다.\n{입금액}원\n주문번호:\n{주문번호}\n{회사명}',
                    de_sms_cont5 = '{이름}님 배송합니다.\n택배:{택배회사}\n운송장번호:\n{운송장번호}\n{회사명}',
					site_id = '$mb_id'
                    ";
        sql_query($sql);


        // 내용관리 생성
        sql_query(" insert into {$g5['content_table']} set co_id = 'company', co_html = '1', co_subject = '회사소개', co_content= '<p align=center><b>회사소개에 대한 내용을 입력하십시오.</b></p>', co_skin = 'theme/basic', co_mobile_skin = 'theme/basic', site_id = '$mb_id' ");
        sql_query(" insert into {$g5['content_table']} set co_id = 'privacy', co_html = '1', co_subject = '개인정보 처리방침', co_content= '<p align=center><b>개인정보 처리방침에 대한 내용을 입력하십시오.</b></p>', co_skin = 'theme/basic', co_mobile_skin = 'theme/basic', site_id = '$mb_id' ");
        sql_query(" insert into {$g5['content_table']} set co_id = 'provision', co_html = '1', co_subject = '서비스 이용약관', co_content= '<p align=center><b>서비스 이용약관에 대한 내용을 입력하십시오.</b></p>', co_skin = 'theme/basic', co_mobile_skin = 'theme/basic', site_id = '$mb_id' ");

        // FAQ Master
        sql_query(" insert into {$g5['faq_master_table']} set fm_subject = '자주하시는 질문', site_id = '$mb_id' ");

    }

    sql_query(" insert into {$g5['member_table']} set mb_id = '{$mb_id}', mb_password = '".get_encrypt_string($mb_password)."', mb_datetime = '".G5_TIME_YMDHIS."', mb_ip = '{$_SERVER['REMOTE_ADDR']}', mb_email_certify = '".G5_TIME_YMDHIS."', {$sql_common}, site_id = '{$mb_id}' ");
}
else if ($w == 'u')
{
    $mb = get_member($mb_id);
    if (!$mb['mb_id'])
        alert('존재하지 않는 회원자료입니다.');

    if ($is_admin != 'super' && $mb['mb_level'] >= $member['mb_level'])
        alert('자신보다 권한이 높거나 같은 회원은 수정할 수 없습니다.');

    if ($is_admin !== 'super' && is_admin($mb['mb_id']) === 'super' ) {
        alert('최고관리자의 비밀번호를 수정할수 없습니다.');
    }

    if ($_POST['mb_id'] == $member['mb_id'] && $_POST['mb_level'] != $mb['mb_level'])
        alert($mb['mb_id'].' : 로그인 중인 관리자 레벨은 수정 할 수 없습니다.');

    // 닉네임중복체크
    $sql = " select mb_id, mb_name, mb_nick, mb_email from {$g5['member_table']} where mb_nick = '{$_POST['mb_nick']}' and mb_id <> '$mb_id' ";
    $row = sql_fetch($sql);
    if ($row['mb_id'])
        alert('이미 존재하는 닉네임입니다.\\nＩＤ : '.$row['mb_id'].'\\n이름 : '.$row['mb_name'].'\\n닉네임 : '.$row['mb_nick'].'\\n메일 : '.$row['mb_email']);

    // 이메일중복체크
    $sql = " select mb_id, mb_name, mb_nick, mb_email from {$g5['member_table']} where mb_email = '{$_POST['mb_email']}' and mb_id <> '$mb_id' ";
    $row = sql_fetch($sql);
    if ($row['mb_id'])
        alert('이미 존재하는 이메일입니다.\\nＩＤ : '.$row['mb_id'].'\\n이름 : '.$row['mb_name'].'\\n닉네임 : '.$row['mb_nick'].'\\n메일 : '.$row['mb_email']);

    $mb_dir = substr($mb_id,0,2);

    // 회원 아이콘 삭제
    if ($del_mb_icon)
        @unlink(G5_DATA_PATH.'/member/'.$mb_dir.'/'.$mb_id.'.gif');

    $image_regex = "/(\.(gif|jpe?g|png))$/i";
    $mb_icon_img = $mb_id.'.gif';

    // 아이콘 업로드
    if (isset($_FILES['mb_icon']) && is_uploaded_file($_FILES['mb_icon']['tmp_name'])) {
        if (!preg_match($image_regex, $_FILES['mb_icon']['name'])) {
            alert($_FILES['mb_icon']['name'] . '은(는) 이미지 파일이 아닙니다.');
        }

        if (preg_match($image_regex, $_FILES['mb_icon']['name'])) {
            $mb_icon_dir = G5_DATA_PATH.'/member/'.$mb_dir;
            @mkdir($mb_icon_dir, G5_DIR_PERMISSION);
            @chmod($mb_icon_dir, G5_DIR_PERMISSION);

            $dest_path = $mb_icon_dir.'/'.$mb_icon_img;

            move_uploaded_file($_FILES['mb_icon']['tmp_name'], $dest_path);
            chmod($dest_path, G5_FILE_PERMISSION);
            
            if (file_exists($dest_path)) {
                $size = @getimagesize($dest_path);
                if ($size[0] > $config['cf_member_icon_width'] || $size[1] > $config['cf_member_icon_height']) {
                    $thumb = null;
                    if($size[2] === 2 || $size[2] === 3) {
                        //jpg 또는 png 파일 적용
                        $thumb = thumbnail($mb_icon_img, $mb_icon_dir, $mb_icon_dir, $config['cf_member_icon_width'], $config['cf_member_icon_height'], true, true);
                        if($thumb) {
                            @unlink($dest_path);
                            rename($mb_icon_dir.'/'.$thumb, $dest_path);
                        }
                    }
                    if( !$thumb ){
                        // 아이콘의 폭 또는 높이가 설정값 보다 크다면 이미 업로드 된 아이콘 삭제
                        @unlink($dest_path);
                    }
                }
            }
        }
    }
    
    $mb_img_dir = G5_DATA_PATH.'/member_image/';
    if( !is_dir($mb_img_dir) ){
        @mkdir($mb_img_dir, G5_DIR_PERMISSION);
        @chmod($mb_img_dir, G5_DIR_PERMISSION);
    }
    $mb_img_dir .= substr($mb_id,0,2);

    // 회원 이미지 삭제
    if ($del_mb_img)
        @unlink($mb_img_dir.'/'.$mb_icon_img);

    // 아이콘 업로드
    if (isset($_FILES['mb_img']) && is_uploaded_file($_FILES['mb_img']['tmp_name'])) {
        if (!preg_match($image_regex, $_FILES['mb_img']['name'])) {
            alert($_FILES['mb_img']['name'] . '은(는) 이미지 파일이 아닙니다.');
        }
        
        if (preg_match($image_regex, $_FILES['mb_img']['name'])) {
            @mkdir($mb_img_dir, G5_DIR_PERMISSION);
            @chmod($mb_img_dir, G5_DIR_PERMISSION);
            
            $dest_path = $mb_img_dir.'/'.$mb_icon_img;
            
            move_uploaded_file($_FILES['mb_img']['tmp_name'], $dest_path);
            chmod($dest_path, G5_FILE_PERMISSION);

            if (file_exists($dest_path)) {
                $size = @getimagesize($dest_path);
                if ($size[0] > $config['cf_member_img_width'] || $size[1] > $config['cf_member_img_height']) {
                    $thumb = null;
                    if($size[2] === 2 || $size[2] === 3) {
                        //jpg 또는 png 파일 적용
                        $thumb = thumbnail($mb_icon_img, $mb_img_dir, $mb_img_dir, $config['cf_member_img_width'], $config['cf_member_img_height'], true, true);
                        if($thumb) {
                            @unlink($dest_path);
                            rename($mb_img_dir.'/'.$thumb, $dest_path);
                        }
                    }
                    if( !$thumb ){
                        // 아이콘의 폭 또는 높이가 설정값 보다 크다면 이미 업로드 된 아이콘 삭제
                        @unlink($dest_path);
                    }
                }
            }
        }
    }

    if ($mb_password)
        $sql_password = " , mb_password = '".get_encrypt_string($mb_password)."' ";
    else
        $sql_password = "";

    if ($passive_certify)
        $sql_certify = " , mb_email_certify = '".G5_TIME_YMDHIS."' ";
    else
        $sql_certify = "";

    $sql = " update {$g5['member_table']}
                set {$sql_common}
                     {$sql_password}
                     {$sql_certify}
                where mb_id = '{$mb_id}' ";
    sql_query($sql);
}
else
    alert('제대로 된 값이 넘어오지 않았습니다.');

goto_url('./member_form.php?'.$qstr.'&amp;w=u&amp;mb_id='.$mb_id, false);
?>