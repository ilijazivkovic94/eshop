<?php
include_once('./_common.php');
$naverpay_button_js = '';
include_once(G5_SHOP_PATH.'/settle_naverpay.inc.php');

$friend_action_url = G5_SHOP_URL.'/friendupdate.php';

$current_id = $_GET['id'];
$exist_member = null;
if ($current_id) {
    $sql = "select * from g5_friends where id=" . $current_id;
    $result = sql_query($sql);
    $exist_member = sql_fetch_array($result);
}


if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/cart.php');
    return;
}

// 테마에 cart.php 있으면 include
if(defined('G5_THEME_SHOP_PATH')) {
    $theme_cart_file = G5_THEME_SHOP_PATH.'/cart.php';
    if(is_file($theme_cart_file)) {
        include_once($theme_cart_file);
        return;
        unset($theme_cart_file);
    }
}

$g5['title'] = '친구목록';
include_once('./_head.php');
?>

<!-- 장바구니 시작 { -->
<script src="<?php echo G5_JS_URL; ?>/shop.js?ver=<?php echo G5_JS_VER; ?>"></script>
<script src="<?php echo G5_JS_URL; ?>/shop.override.js?ver=<?php echo G5_JS_VER; ?>"></script>

<div id="sod_bsk" class="od_prd_list">
    <h2>친구요청 보내기</h2>
    <form name="frmcartlist" id="sod_bsk_list" class="2017_renewal_itemform d-flex flex-column align-items-center" method="post" action="<?php echo $friend_action_url; ?>">
        <input type="hidden" value="<?php echo $current_id; ?>" name="current_id" />
        <div class="row w-100 d-flex align-items-center">
            <div class="col-md-10 col-sm-12">
                <input type="email" placeholder="이메일" class="form-control m-t-20" name="email" value="<?php echo $exist_member ? $exist_member['email'] : ''; ?>" />
            </div>
            <div class="col-md-2 col-sm-12">
                <input type="number" placeholder="이율%" min="0" max="100" class="form-control m-t-15" value="<?php echo $exist_member ? $exist_member['percentage'] : ''; ?>" name="percentage" />
            </div>
        </div>
        <?php if ($exist_member) { ?>
            <button type="submit" class="btn-e btn-e-xl btn-e-red m-t-25">재전송하기</button>
        <?php } else { ?>
            <button type="submit" class="btn-e btn-e-xl btn-e-red m-t-25">전송하기</button>
        <?php }?>
    </form>
</div>
<!-- } 장바구니 끝 -->

<?php
include_once('./_tail.php');