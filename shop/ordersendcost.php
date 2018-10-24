<?php
include_once('./_common.php');

$code = preg_replace('#[^0-9]#', '', $_POST['zipcode']);
$s_cart_id = $_POST['s_cart_id'];

if(!$code || !$s_cart_id)
    die('0');

// 주문한 상품의 분류가 근조, 축하만 배송비를 부여함(gnuwiz)
$sql = " 	select sum(a.ct_qty) as sum_ct_qty
			   from g5_shop_cart a left join g5_shop_item b on ( a.it_id = b.it_id )
			  where a.od_id = '{$s_cart_id}'
				and a.ct_select = '1' and (substring(ca_id, 1,2) = '20' or substring(ca_id, 1,2) = '30') ";
$row = sql_fetch($sql);

$total_qty = $row['sum_ct_qty'];

// 조회된 건이 없다면 리턴 false
if(!$total_qty)
    die('0');

// 조회가 되었다면 배송비를 가져옴
$sql = " select sc_id, sc_price
			from {$g5['g5_shop_sendcost_table']}
			where sc_zip1 <= $code
			  and sc_zip2 >= $code ";
$row = sql_fetch($sql);

if(!$row['sc_id'])
    die('0');

$sum_sc_price = $row['sc_price'] * $total_qty;
echo $sum_sc_price;
?>