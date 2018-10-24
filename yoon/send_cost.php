<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$source_file = '/home/master/public_html/data/delivery_gallery/180523-000513.jpg';
$source_file = '/home/master/public_html/data/qa/3554402693_2Nd60BW8_dd1b34002accd7de834a02aedf727fb55a42b65e.jpg';
$source_file = '/home/master/public_html/data/delivery_gallery/180523-000513.jpg';



$size = getimagesize($source_file);
print_r2($size);
?>