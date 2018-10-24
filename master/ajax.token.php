<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/json.lib.php');

set_session('ss_master_token', '');

$error = admin_referer_check(true);
if($error)
    die(json_encode(array('error'=>$error, 'url'=>G5_URL)));

$token = get_master_token();

die(json_encode(array('error'=>'', 'token'=>$token, 'url'=>'')));
?>