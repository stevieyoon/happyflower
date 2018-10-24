<?php
$sub_menu = "100280";
include_once('./_common.php');

if ($is_admin != 'super')
    die('최고관리자만 접근 가능합니다.');

$site_id = trim($_POST['cf_admin']);

$site_config = get_config($site_id);

// 주문상태에 따른 합계 금액
function get_order_status_sum($status)
{
    global $g5, $site_id;

    $sql = " select count(*) as cnt,
                    sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price
                from {$g5['g5_shop_order_table']}
                where od_status = '$status'
                and site_id = '$site_id' ";
    $row = sql_fetch($sql);

    $info = array();
    $info['count'] = (int)$row['cnt'];
    $info['price'] = (int)$row['price'];
    $info['href'] = './orderlist.php?od_status='.urlencode($status);

    return $info;
}

// 일자별 주문 합계 금액
function get_order_date_sum($date)
{
    global $g5, $site_id;

    $sql = " select sum(od_cart_price + od_send_cost + od_send_cost2) as orderprice,
                    sum(od_cancel_price) as cancelprice
                from {$g5['g5_shop_order_table']}
                where SUBSTRING(od_time, 1, 10) = '$date'
                and site_id = '$site_id' ";
    $row = sql_fetch($sql);

    $info = array();
    $info['order'] = (int)$row['orderprice'];
    $info['cancel'] = (int)$row['cancelprice'];

    return $info;
}

// 일자별 결제수단 주문 합계 금액
function get_order_settle_sum($date)
{
    global $g5, $default, $site_id;

    $case = array('신용카드', '계좌이체', '가상계좌', '무통장', '휴대폰');
    $info = array();

    // 결제수단별 합계
    foreach($case as $val)
    {
        $sql = " select sum(od_cart_price + od_send_cost + od_send_cost2 - od_receipt_point - od_cart_coupon - od_coupon - od_send_coupon) as price,
                        count(*) as cnt
                    from {$g5['g5_shop_order_table']}
                    where SUBSTRING(od_time, 1, 10) = '$date'
                      and od_settle_case = '$val'
                      and site_id = '$site_id' ";
        $row = sql_fetch($sql);

        $info[$val]['price'] = (int)$row['price'];
        $info[$val]['count'] = (int)$row['cnt'];
    }

    // 포인트 합계
    $sql = " select sum(od_receipt_point) as price,
                    count(*) as cnt
                from {$g5['g5_shop_order_table']}
                where SUBSTRING(od_time, 1, 10) = '$date'
                  and od_receipt_point > 0
                  and site_id = '$site_id' ";
    $row = sql_fetch($sql);
    $info['포인트']['price'] = (int)$row['price'];
    $info['포인트']['count'] = (int)$row['cnt'];

    // 쿠폰 합계
    $sql = " select sum(od_cart_coupon + od_coupon + od_send_coupon) as price,
                    count(*) as cnt
                from {$g5['g5_shop_order_table']}
                where SUBSTRING(od_time, 1, 10) = '$date'
                  and ( od_cart_coupon > 0 or od_coupon > 0 or od_send_coupon > 0 )
                  and site_id = '$site_id' ";
    $row = sql_fetch($sql);
    $info['쿠폰']['price'] = (int)$row['price'];
    $info['쿠폰']['count'] = (int)$row['cnt'];

    return $info;
}

function get_max_value($arr)
{
    foreach($arr as $key => $val)
    {
        if(is_array($val))
        {
            $arr[$key] = get_max_value($val);
        }
    }

    sort($arr);

    return array_pop($arr);
}
?>

<div id="order_detail">
    <h2><span class="txt_true"><?php echo $site_config['cf_title'] ?></span> 결제수단별 주문현황</h2>
    <div class="theme_dt_if">
        <p><?php echo get_text($info['detail']); ?></p>
        <div class="theme_dt_btn">
            <button type="button" class="close_btn">닫기</button>
        </div>
    </div>

    <section id="anc_sidx_settle">

        <div id="sidx_settle" class="tbl_head01 tbl_wrap">
            <table>
                <thead>
                <tr>
                    <th scope="col" rowspan="2">구분</th>
                    <?php
                    $term = 3;
                    $info = array();
                    $info_key = array();
                    for($i=($term - 1); $i>=0; $i--) {
                        $date = date("Y-m-d", strtotime('-'.$i.' days', G5_SERVER_TIME));
                        $info[$date] = get_order_settle_sum($date);

                        $day = substr($date, 5, 5).' ('.get_yoil($date).')';
                        $info_key[] = $date;
                        ?>
                        <th scope="col" colspan="2"><?php echo $day; ?></th>
                    <?php } ?>
                </tr>
                <tr>
                    <?php
                    for($i=0; $i<$term; $i++) {
                        ?>
                        <th scope="col">건수</th>
                        <th scope="col">금액</th>
                    <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php
                $case = array('신용카드', '계좌이체', '가상계좌', '무통장', '휴대폰', '포인트', '쿠폰');

                foreach($case as $val)
                {
                    $val_cnt ++;
                    ?>
                    <tr>
                        <th scope="row" id="th_val_<?php echo $val_cnt; ?>" class="td_category"><?php echo $val; ?></th>
                        <?php
                        foreach($info_key as $date)
                        {
                            ?>
                            <td><?php echo number_format($info[$date][$val]['count']); ?></td>
                            <td><?php echo number_format($info[$date][$val]['price']); ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </section>







</div>

<script>
    $(".close_btn").on("click", function() {
        $("#order_detail").remove();
    });
</script>