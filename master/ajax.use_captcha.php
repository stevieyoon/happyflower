<?php
include_once('./_common.php');

if( isset($_POST['admin_use_captcha']) ){
    set_session('ss_master_use_captcha', true);
}
?>