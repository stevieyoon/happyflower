<?php
define('FLOWER_MYSQL_HOST', 'localhost');
define('FLOWER_MYSQL_USER', 'flower');
define('FLOWER_MYSQL_PASSWORD', 'vmffkdnj!');
define('FLOWER_MYSQL_DB', 'flower3');
define('FLOWER_MYSQL_SET_MODE', false);

include_once(G5_PATH.'/yoon/flower_connect.php');
$flower_connect_db = sql_connect_flower(FLOWER_MYSQL_HOST, FLOWER_MYSQL_USER, FLOWER_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');
$flower_select_db  = sql_select_db_flower(FLOWER_MYSQL_DB, $flower_connect_db) or die('MySQL DB Error!!!');

$flower     = array();
$flower['connect_db'] = $flower_connect_db;

sql_set_charset_flower('utf8', $flower_connect_db);
if(defined('FLOWER_MYSQL_SET_MODE') && FLOWER_MYSQL_SET_MODE) sql_query_flower("SET SESSION sql_mode = ''");
if (defined('G5_TIMEZONE')) sql_query_flower(" set time_zone = '".G5_TIMEZONE."'");

?>