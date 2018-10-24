<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/jquery.fancybox.css">', 0);
add_javascript('<script src="'.G5_JS_URL.'/jquery.fancybox.pack.js"></script>', 10); //<!-- Fancybox -->
?>

<!-- 상품 배송겔러리 시작 { -->
<section id="sit_gallery_list">
    <h3>등록된 배송사진</h3>

    <ol id="sit_gallery_ol">
        <?php
        for ($i=0; $arr=sql_fetch_array($result); $i++)
        {
            // 외부이미지를 못가져왔다면 실행, 너무 사이트가 느려지기 때문에 사용은 우선 중단
            //save_remote_image($arr['state_data'], $arr['order_no']);

            $is_num     = $total_count - ($page - 1) * $rows - $i;

            $dg_name = $arr['dg_name'];
            $dg_name = get_text($dg_name);
            $dg_name = mb_substr($dg_name, 0, 5, 'utf-8');
            $dg_name = preg_replace('/.(?=.$)/u','○',$dg_name);
            if($dg_name) {
                $ordermb	= '<strong>'.$dg_name.'</strong>님께서 구매하신 상품의 배송된 사진입니다';
            }else{
                $ordermb	= "저희 <strong>".$default['de_admin_company_name']."</strong> 회원님께서 구매하신 상품의 배송된 사진입니다. ";
            }

            $filename = $arr['order_no'].'.jpg'; // 파일명
            $filepath = G5_DATA_PATH.'/delivery_gallery'; // 파일경로
            $fileurl = G5_DATA_URL.'/delivery_gallery'; // 파일url

            $thumb = thumbnail($filename, $filepath, $filepath, 100, 133, false, false, 'center', false, '80/0.5/3');
            if($thumb) {
                $img_content = '<img src="'.$fileurl.'/'.$thumb.'" alt="'.$ordermb.'" >';
            } else {
                $img_content = '<span class="no_image" style="height:285px;">no image</span>';
            }
            ?>
            <li class="sit_gallery_li">
                <div class="sit_gallery_tit"><i class="fa fa-shopping-basket"></i> <?php echo $default['de_admin_company_name']; ?> | <i class="fa fa-clock"></i> <?php echo $arr['dg_datetime']; ?></div>
                <div class="sit_gallery_sub">안녕하세요 <?php echo $default['de_admin_company_name']; ?> 입니다. 저희 상품을 구매해주셔서 감사합니다.</div>
                <div class="sit_gallery_sub1"><?php echo $ordermb; ?></div>
                <dl class="sit_gallery_dl">
                    <dt><a href="<?php echo $fileurl ?>/<?php echo $filename ?>"  class="fancybox" data-fancybox-group="gallery"  title="<?php echo $arr['dg_subject']?>"><?php echo $img_content; ?></a><dt>
                </dl>
            </li>
        <?php } ?>
    </ol>
</section>
<?php
echo itemgallery_page($config['cf_write_pages'], $page, $total_page, "./delivery_gallery.php?it_id=$it_id&amp;page=");
?>
<script type="text/javascript">
    $(".ga_page").click(function(){
        $("#itemgallery").load($(this).attr("href"));
        return false;
    });

    jQuery(function($){

        var IAMKSG = window.IAMKSG || {};
        /* ==================================================
         FancyBox
         ================================================== */
        IAMKSG.fancyBox = function(){
            if($('.fancybox').length > 0 || $('.fancybox-media').length > 0 || $('.fancybox-various').length > 0){

                $(".fancybox").fancybox({
                    padding : 0,
                    beforeShow: function () {
                        this.title = $(this.element).attr('title');
                        this.title = '<h4>' + this.title + '</h4>' + '<p>' + $(this.element).parent().find('img').attr('alt') + '</p>';
                    },
                    helpers : {
                        title : { type: 'inside' },
                    }
                });

                $('.fancybox-media').fancybox({
                    openEffect  : 'none',
                    closeEffect : 'none',
                    helpers : {
                        media : {}
                    }
                });
            }
        }
        $(document).ready(function(){
            IAMKSG.fancyBox();
        });

    });
</script>
<!-- } 상품 배송겔러리 끝 -->


