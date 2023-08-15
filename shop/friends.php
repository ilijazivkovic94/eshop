<?php
include_once('./_common.php');

session_start();
$mb_id = $_SESSION['ss_mb_id'];

if (!$mb_id) {
    goto_url(G5_BBS_URL.'/login.php');
}

$naverpay_button_js = '';
include_once(G5_SHOP_PATH.'/settle_naverpay.inc.php');

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/cart.php');
    return;
}

$friends_action_url = G5_SHOP_URL.'/friendsdelete.php';
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

    <form name="frmcartlist" id="sod_bsk_list" class="2017_renewal_itemform" method="post" action="<?php echo $friends_action_url; ?>">
        <input type="hidden" name="records" value="<?php echo $i; ?>">
        <input type="hidden" name="act" value="">
        <div class="tbl_head03 tbl_wrap">
        <table>
        <thead>
        <tr>
            <th scope="col" class="chk_box">
                <input type="checkbox" name="ct_all" value="1" id="ct_all" checked="checked" class="selec_chk">
                <label for="ct_all"><span></span><b class="sound_only">친구 전체</b></label>
            </th>
            <th scope="col">이름</th>
            <th scope="col">이메일</th>
            <th scope="col">퍼센트</th>
            <th scope="col">관리</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $tot_point = 0;
        $tot_sell_price = 0;
        $send_cost = 0;

        // $s_cart_id 로 현재 장바구니 자료 쿼리
        $sql = "select * from g5_friends where parent_mb_id='" . $mb_id . "'";
        $sql .= " order by accepted_at, sent_at";
        $result = sql_query($sql);

        $it_send_cost = 0;

        for ($i=0; $row=sql_fetch_array($result); $i++)
        {
            $total_money = 0;
            $member = null;
            $invited_email = $row['email'];
            if ($row['is_accepted']) {
                $member_sql = "select * from g5_member where mb_email='$invited_email'";
                $member_query = sql_query($sql);
                $member = sql_fetch_array($member_query);
            }
        ?>

        <tr>
            <td class="td_chk chk_box">
                <input type="checkbox" name="ct_chk[<?php echo $i; ?>]" value="1" id="ct_chk_<?php echo $i; ?>" checked="checked" class="selec_chk">
            	<label for="ct_chk_<?php echo $i; ?>"><span></span><b class="sound_only">친구</b></label>
            </td> 
            
            <td class="td_numbig">
                <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['id']; ?>">
                <?php echo $row['mb_id'] ? $row['mb_id'] : '등록대기중'; ?>
            </td>
            <td class="td_numbig"><?php echo $row['email']; ?></td>
            <td class="td_numbig"><?php echo $row['percentage']; ?>%</td>
            <td class="td_numbig action_btns">
                <button type="button" id="copy_btn_<?php echo $row['id']; ?>" onclick="copy_register_path('<?php echo $row['code']; ?>', '<?php echo $row['email']; ?>', <?php echo $row['id']; ?>)">등록경로복사</button>
                <button type="button" onclick="handle_edit(<?php echo $row['id']; ?>)">편집</button>
            </td>
        </tr>

        <?php
        } // for 끝

        if ($i == 0) {
            echo '<tr><td colspan="7" class="empty_table">등록된 친구가 없습니다.</td></tr>';
        }
        ?>
        </tbody>
        </table>
        <div class="btn_cart_del">
            <button type="button" onclick="return form_check('seldelete');">선택삭제</button>
            <button type="button" onclick="return form_check('alldelete');">전체삭제</button>
        </div>
    </div>
    </form>

    <div id="sod_bsk_act" style="display: flex; justify-content: center; align-items: center; gap: 20px;">
        <a href="<?php echo G5_SHOP_URL; ?>/" class="btn01">쇼핑 계속하기</a>
        <a href="<?php echo G5_SHOP_URL; ?>/add_friend.php" class="btn01">친구추가</a>
    </div>
</div>

<script>
$(function() {
    var close_btn_idx;

    // 선택사항수정
    $(".mod_options").click(function() {
        var it_id = $(this).closest("tr").find("input[name^=it_id]").val();
        var $this = $(this);
        close_btn_idx = $(".mod_options").index($(this));

        $.post(
            "./cartoption.php",
            { it_id: it_id },
            function(data) {
                $("#mod_option_frm").remove();
                $this.after("<div id=\"mod_option_frm\"></div><div class=\"mod_option_bg\"></div>");
                $("#mod_option_frm").html(data);
                price_calculate();
            }
        );
    });

    // 모두선택
    $("input[name=ct_all]").click(function() {
        if($(this).is(":checked"))
            $("input[name^=ct_chk]").attr("checked", true);
        else
            $("input[name^=ct_chk]").attr("checked", false);
    });

    // 옵션수정 닫기
    $(document).on("click", "#mod_option_close", function() {
        $("#mod_option_frm, .mod_option_bg").remove();
        $(".mod_options").eq(close_btn_idx).focus();
    });
    $("#win_mask").click(function () {
        $("#mod_option_frm").remove();
        $(".mod_options").eq(close_btn_idx).focus();
    });

});

function fsubmit_check(f) {
    if($("input[name^=ct_chk]:checked").length < 1) {
        alert("구매하실 상품을 하나이상 선택해 주십시오.");
        return false;
    }

    return true;
}

function handle_edit(id) {
    const url = '<?php echo G5_SHOP_URL; ?>/add_friend.php?id=' + id;
    window.location.href = url;
}

function copyTextToClipboard(text) {
    var textArea = document.createElement( "textarea" );
    textArea.value = text;
    document.body.appendChild( textArea );
    textArea.select();

    try {
        var successful = document.execCommand( 'copy' );
        var msg = successful ? 'successful' : 'unsuccessful';
        console.log('Copying text command was ' + msg);
    } catch (err) {
        console.log('Oops, unable to copy',err);
    }
    document.body.removeChild( textArea );
}

function copy_register_path(code, email, btn_id) {
    const url = '<?php echo G5_BBS_URL; ?>/register.php?code=' + code + '&email=' + email;
    copyTextToClipboard(url);
    document.querySelector('#copy_btn_' + btn_id).innerHTML = '복사됨';
    
    setTimeout(() => {
        document.querySelector('#copy_btn_' + btn_id).innerHTML = '등록경로복사';
    }, 2000);
}

function form_check(act) {
    var f = document.frmcartlist;
    var cnt = f.records.value;

    if (act == "alldelete")
    {
        f.act.value = act;
        f.submit();
    }
    else if (act == "seldelete")
    {
        if($("input[name^=ct_chk]:checked").length < 1) {
            alert("삭제하실 요청을 하나이상 선택해 주십시오.");
            return false;
        }

        f.act.value = act;
        f.submit();
    }

    return true;
}
</script>
<!-- } 장바구니 끝 -->

<?php
include_once('./_tail.php');