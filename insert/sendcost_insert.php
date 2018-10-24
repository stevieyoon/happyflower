<?php
include_once('./dbconnect.php');

$sql = " select * from {$g5['g5_shop_sendcost_table']} group by sc_name ";
$result = sql_query_flower($sql);
?>

<?


for($i=0; $array=sql_fetch_array($result); $i++) {

    $sql = " INSERT INTO {$g5['g5_shop_sendcost_table']}
                     SET  sc_name	= '".$array["sc_name"]."',
                        sc_zip1	    = '".$array["sc_zip1"]."',
                        sc_zip2     = '".$array["sc_zip2"]."',
                        sc_price    = '".$array["sc_price"]."',
                        site_id     = 'master'
						 ";

    echo $sql."<br/><br/>";
    //$res = sql_query($sql, false);
    if($res) {
        echo "성공";
    } else {
        echo "실패";
    }

}

?>