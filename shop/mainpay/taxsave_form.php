<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 주문번호에 해당하는 주문내역을 가져옴
$od = get_order($_GET['od_id']);
?>

<style type="text/css">
    .listview01 {
        text-decoration:none;
        text-indent:0px;
        line-height:30px;
        -moz-border-radius:2px;
        -webkit-border-radius:2px;
        border-radius:2px;
        text-align:center;
        vertical-align:middle;
        display:inline-block;
        font-size:20px;
        color:#fff;
        width:96px;
        height:30px;
        padding:13px;
        border-color:#659dab;
        border-width:1px;
        border-style:solid;
        background-color:#185c61;
    }

    .listview01:active {
        position:relative;
        top:3px
    }

    .listview01:hover {
    }
    .view {width:100%;height:100%;margin-top:80px;text-align:center;}
    .view h1{font-size:18px;padding:15px 0 25px 0;}
    .view h2{font-size:14px;padding:15px 0 25px 0;}
    .view a{color:#fff}
</style>

<?php
if($od['od_tno']) {
    $cash = unserialize($od['od_cash_info']);
    ?>
    <div id="scash" class="new_win">
        <div class="view">
            <h1><strong>현금영수증 발급</strong></h1>
            <h2>이미 <strong style="color:red"><?php echo $od['od_name']; ?></strong> 님 께서는 현금영수증을 발급 받았습니다.</h2>
            <a href="https://biz.mainpay.co.kr/card/cashReceiptPopUp.do?ref_no=<?php echo $od['od_tno']; ?>&section=01" class='listview01'><strong>보기</strong></a>
        </div>
    </div>
<?php } else { ?>
    <div id="scash" class="new_win">
        <h1 id="win_title"><?php echo $g5['title']; ?></h1>

        <section>
            <h2>주문정보</h2>

            <div class="tbl_head01 tbl_wrap">
                <table>
                    <colgroup>
                        <col class="grid_3">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">주문 번호</th>
                        <td><?php echo $od_id; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">상품 정보</th>
                        <td><?php echo $goods_name; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">주문자 이름</th>
                        <td><?php echo $od_name; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">주문자 E-Mail</th>
                        <td><?php echo $od_email; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">주문자 전화번호</th>
                        <td><?php echo $od_hp; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">영수증 요청사항</th>
                        <td>
                            <input type="radio" id="od_7_1" name="od_7" <?if($od["od_7"]=="세금계산서"){echo "checked";}?> onclick="receipt('1');" value="세금계산서" /> <label for="od_7_1">세금계산서</label>
                            <input type="radio" id="od_7_2" name="od_7" <?if($od["od_7"]=="현금영수증(사업자)"){echo "checked";}?> onclick="receipt('2');" value="현금영수증(사업자)" /> <label for="od_7_2">현금영수증(사업자)</label>
                            <input type="radio" id="od_7_3" name="od_7" <?if($od["od_7"]=="현금영수증(전화번호)"){echo "checked";}?> onclick="receipt('3');" value="현금영수증(전화번호)" /> <label for="od_7_3">현금영수증(전화번호)</label>
                            <input type="radio" id="od_7_4" name="od_7" <?if($od["od_7"]=="간이영수증"){echo "checked";}?> onclick="receipt('4');" value="간이영수증" /> <label for="od_7_4">간이영수증</label>
                            <input type="radio" id="od_7_5" name="od_7" <?if($od["od_7"]=="카드영수증"){echo "checked";}?> onclick="receipt('5');" value="카드영수증" /> <label for="od_7_5">카드영수증</label>
                        </td>
                    </tr>
                    <?php
                    if($od["od_7"]=="세금계산서"){
                    ?>
                    <tr class="od_9_1" style="">
                    <?php } else { ?>
                    <tr class="od_9_1" style="display:none;">
                        <?php } ?>
                        <th>세금계산서요청정보</th>
                        <td>
                            <table style="width:100%;border-right:1px solid #e9e9e9">
                                <tr>
                                    <th>등록<br/>번호</th>
                                    <td colspan="3"><input type="text" id="od_10" name="od_10" value="<?=$od["od_10"]?>" class="frm_input" /></td>
                                </tr>
                                <tr>
                                    <th>상호</th>
                                    <td><input type="text" id="od_11" name="od_11" value="<?=$od["od_11"]?>" class="frm_input" /></td>
                                    <th>성명</th>
                                    <td><input type="text" id="od_12" name="od_12" value="<?=$od["od_12"]?>" class="frm_input"/></td>
                                </tr>
                                <tr>
                                    <th>주소</th>
                                    <td colspan="3"><input type="text" id="od_13" name="od_13" value="<?=$od["od_13"]?>" class="frm_input"  size="40" /></td>
                                </tr>
                                <tr>
                                    <th>업태</th>
                                    <td><input type="text" id="od_14" name="od_14" value="<?=$od["od_14"]?>" class="frm_input"   /></td>
                                    <th>종목</th>
                                    <td><input type="text" id="od_15" name="od_15" value="<?=$od["od_15"]?>" class="frm_input"   /></td>
                                </tr>
                                <tr>
                                    <th>이메일</th>
                                    <td colspan="3">
                                        <input type="text" id="receipt_email_1" name="receipt_email_1" value="<?php echo $od_16[0]; ?>" class="frm_input"  size="15"/>@<input type="text" id="receipt_email_2" name="receipt_email_2" value="<?php echo $od_16[1]; ?>" class="frm_input"  size="15"/>
                                        <select id="mail_sel" onchange="$('#receipt_email_2').val($('#mail_sel').val())" class="frm_input">
                                            <option value="">직접입력</option>
                                            <option value="naver.com" <?if($od_16[1]=="naver.com"){echo "selected";}?>>naver.com</option>
                                            <option value="nate.com" <?if($od_16[1]=="nate.com"){echo "selected";}?>>nate.com</option>
                                            <option value="daum.net" <?if($od_16[1]=="daum.net"){echo "selected";}?>>daum.net</option>
                                            <option value="hanmail.net" <?if($od_16[1]=="hanmail.net"){echo "selected";}?>>hanmail.net</option>
                                            <option value="gmail.com" <?if($od_16[1]=="gmail.com"){echo "selected";}?>>gmail.com</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php
                    if($od["od_7"]=="현금영수증(사업자)" || $od["od_7"]=="현금영수증(전화번호)"){
                    ?>
                    <tr class="od_9" style="">
                        <?php } else { ?>
                    <tr class="od_9" style="display:none;">
                        <?php } ?>
                        <th scope="row">영수증 요청내용</th>
                        <td><input type="text" name="od_9" value="<?php echo $od['od_9']; ?>" id="od_9"  class="frm_input " size="40">&nbsp;
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section>
            <h2>현금영수증 발급 정보</h2>

            <form name="cash_form" action="<?php echo G5_SHOP_URL; ?>/<?php echo $dir; ?>/taxsave_form_updata.php" method="post">
                <input type="hidden" name="timestamp" value="<?php echo $trad_time; ?>">
                <input type="hidden" name="amount" value="<?php echo $amt_tot; ?>">
                <input type="hidden" name="goodsName" value="<?php echo addslashes($goods_name); ?>">
                <input type="hidden" name="customerName" value="<?php echo $od_name; ?>">
                <input type="hidden" name="buyr_mail" value="<?php echo $od_email; ?>">
                <input type="hidden" name="buyr_tel1" value="<?php echo $od_hp; ?>">
                <input type="hidden" name="timestamp" value="<?php echo $trad_time; ?>">
                <input type="hidden" name="od_id" value="<?php echo $od_id; ?>">
                <input type="hidden" name="site_id" value="<?php echo $od['site_id']; ?>">

                <div class="tbl_head01 tbl_wrap">
                    <table>
                        <colgroup>
                            <col class="grid_3">
                            <col>
                        </colgroup>
                        <tbody>
                        <tr>
                            <th scope="row">원 거래 시각</th>
                            <td><?php echo $trad_time; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">발행 용도</th>
                            <td>
                                <input type="radio" name="personType" value="01" id="personType" checked>
                                <label for="personType">개인사업자</label>
                                <input type="radio" name="personType" value="02" id="personType" >
                                <label for="personType">법인사업자</label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="id_info">
                                    <span id="span_tr_code_0" style="display:inline">용도</span>
                                </label>
                            </th>
                            <td>
                                <input type="text" name="customerPk" id="customerPk" class="frm_input" size="16" maxlength="13"> ("-" 생략) 주민(휴대폰)번호 / 사업자번호
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">거래금액 총합</th>
                            <td><?php echo number_format($amt_tot); ?>원</td>
                        </tr>
                        <tr>
                            <th scope="row">공급가액</th>
                            <td><?php echo number_format($amt_sup); ?>원<!-- ((거래금액 총합 * 10) / 11) --></td>
                        </tr>
                        <tr>
                            <th scope="row">부가가치세</th>
                            <td><?php echo number_format($amt_tax); ?>원<!-- 거래금액 총합 - 공급가액 - 봉사료 --></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div id="scash_apply">
            <span id="show_pay_btn">
                <button type="submit">등록요청</button>
            </span>
                </div>

            </form>
        </section>

        <p id="scash_copy">ⓒ Copyright 2018. <?php echo $default['de_admin_company_name']; ?>  All Rights Reserved.</p>

    </div>
    <script>
        function receipt(idx){
            if(idx=="1"){
                $(".od_9").hide();
                $(".od_9_1").show();
            }else if(idx=="2"){
                $(".od_9_1").hide();
                $(".od_9").show();
                $("#od_9").attr('placeholder','계산서, 영수증의 사업자번호 등 입력해주세요');
            }else if(idx=="3"){
                $(".od_9_1").hide();
                $(".od_9").show();
                $("#od_9").attr('placeholder','전화번호 등 입력해주세요');
            }else{
                $(".od_9_1").hide();
                $(".od_9").hide();
            }
        }
    </script>
<?php } ?>