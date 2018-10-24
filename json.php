<?php
include_once('./common.php');

print_r2($_REQUEST);

$str = '';
foreach($_REQUEST as $key => $val) {
	$str .= $key.'='.$val;
}
echo $str;
?>