<?php
include_once('./_common.php');
include_once(G5_INTERFACE_PATH.'/idna_convert.class.php');
$IDN = new idna_convert();

$str = $_SERVER['HTTP_HOST'];

$_SERVER['HTTP_HOST'] = $IDN->decode($_SERVER['HTTP_HOST']);
echo $_SERVER['HTTP_HOST'];

$decoded = htmlentities($str, null, 'UTF-8');
$IDN = new idna_convert();
if (isset($decoded)) {
    $decoded = isset($decoded) ? stripslashes($decoded) : '';
    $encoded = $IDN->encode($decoded);
}
echo $encoded;


echo idn_to_utf8('xn--tst-qla.de');



exit;
?>