<?php
/**
 * theme file : /theme/THEME_NAME/shop.tail.html.php
 */
if (!defined('_EYOOM_')) exit;
?>

<?php if (!$wmode) { ?>
	<?php if(defined('_INDEX_')) { ?>
        </main>
        <?php } else { ?>
			</div><?php /* End .container */ ?>
		</main>
        <?php } ?>

	</div><?php /* End .basic-body */ ?>

	<?php /*----- footer 시작 -----*/ ?>
	<footer class="footer">
		<div class="container">
			<div class="footer-top">
				<div class="footer-nav">
					<a href="<?php echo get_eyoom_pretty_url('page','provision'); ?>">서비스이용약관</a>
					<a href="<?php echo get_eyoom_pretty_url('page','privacy'); ?>">개인정보처리방침</a>
					<a href="<?php echo get_eyoom_pretty_url('page','noemail'); ?>">이메일무단수집거부</a>
                    <a href="<?php echo G5_BBS_URL; ?>/faq.php">FAQ</a>
                    <a href="<?php echo G5_BBS_URL; ?>/qalist.php">1:1문의</a>
				</div>
				<div class="footer-right-nav">
                    <a class="btn-e btn-e-crimson m-b-5" href="https://m.customs.go.kr/pms/html/mos/extr/MOS0101053S.do" target="_blank">개인통관부호 모바일</a>
                    <a class="btn-e btn-light-green m-b-5" href="https://m.customs.go.kr/pms/html/mos/extr/MOS0101053S.do" target="_blank">개인통관부호 PC</a>
                    <a class="btn-e btn-cyan m-b-5" href="https://www.shiptrack.co.kr" target="_blank">배송조회</a>
				</div>
			</div>

			<div class="footer-cont-info">
				<?php if ($is_admin == 'super' && !G5_IS_MOBILE) { ?>
				<div class="adm-edit-btn btn-edit-mode hidden-xs hidden-sm" style="top:-31px">
					<div class="btn-group">
						<a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&amp;pid=biz_info&amp;amode=biz&amp;thema=<?php echo $theme; ?>&amp;wmode=1" onclick="eb_admset_modal(this.href); return false;" class="ae-btn-l"><i class="far fa-edit"></i> 기업정보 설정</a>
						<a href="<?php echo G5_ADMIN_URL; ?>/?dir=theme&amp;pid=biz_info&amp;amode=biz&amp;thema=<?php echo $theme; ?>" target="_blank" class="ae-btn-r" title="새창 열기">
							<i class="fas fa-external-link-alt"></i>
						</a>
						<button type="button" class="ae-btn-info" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-content="
							<span class='f-s-13r'>
							<strong class='text-indigo'>기업정보 사용가능한 변수</strong><br>
							<div class='margin-hr-10'></div>
							<strong class='text-indigo'>[설정정보]</strong><br>
							회사명 : $bizinfo['bi_company_name']<br>
							사업자등록번호 : $bizinfo['bi_company_bizno']<br>
							대표자명 : $bizinfo['bi_company_ceo']<br>
							대표전화 : $bizinfo['bi_company_tel']<br>
							팩스번호 : $bizinfo['bi_company_fax']<br>
							통신판매업 : $bizinfo['bi_company_sellno']<br>
							부가통신사업자 : $bizinfo['bi_company_bugano']<br>
							정보관리책임자 : $bizinfo['bi_company_infoman']<br>
							정보책임자메일 : $bizinfo['bi_company_infomail']<br>
							우편번호 : $bizinfo['bi_company_zip']<br>
							주소1 : $bizinfo['bi_company_addr1']<br>
							주소2 : $bizinfo['bi_company_addr2']<br>
							주소3 : $bizinfo['bi_company_addr3']<br>
							고객센터1 : $bizinfo['bi_cs_tel1']<br>
							고객센터2 : $bizinfo['bi_cs_tel2']<br>
							고객센터팩스 : $bizinfo['bi_cs_fax']<br>
							고객센터메일 : $bizinfo['bi_cs_email']<br>
							상담시간 : $bizinfo['bi_cs_time']<br>
							휴무안내 : $bizinfo['bi_cs_closed']
							</span>
						"><i class="fas fa-question-circle"></i></button>
					</div>
				</div>
				<?php } ?>
				<span>E-mail : <a href="mailto:<?php echo $bizinfo['bi_cs_email']; ?>"><?php echo $bizinfo['bi_cs_email']; ?></a></span>
			</div>

			<div class="footer-copyright">
				<span>Copyright </span>&copy; <strong class="text-black f-w-400"><?php echo $config['cf_title']; ?></strong>. All Rights Reserved.
			</div>
		</div>
	</footer>
	<?php /*----- footer 끝 -----*/ ?>
</div>
<?php /*----- wrapper 끝 -----*/ ?>

<?php /*----- 전체 검색 입력창 시작 -----*/ ?>
<div class="search-full">
	<div class="search-close-btn"></div>
	<fieldset class="search-field">
		<legend>쇼핑몰 전체검색</legend>
		<form name="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);">
		<input type="hidden" name="sfl" value="wr_subject||wr_content">
		<input type="hidden" name="sop" value="and">
		<label for="head_sch_str" class="sound_only">검색어 입력 필수</strong></label>
		<input type="text" name="q" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="search_input" class="sch_stx" placeholder="상품 검색어 입력">
		<button type="submit" class="search-btn" value="검색"><i class="fas fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
		</form>

		<script>
		function search_submit(f) {
			if (f.q.value.length < 2) {
				alert("검색어는 두글자 이상 입력하십시오.");
				f.q.select();
				f.q.focus();
				return false;
			}
			return true;
		}
		</script>
	</fieldset>
</div>
<?php /*----- 전체 검색 입력창 끝 -----*/ ?>

<?php /*----- 쇼핑몰 회원 사이드바 시작 -----*/ ?>
<button type="button" class="sidebar-shop-trigger sidebar-shop-member-btn mo-btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasShopRight" aria-controls="offcanvasShopRight"><i class="fas fa-user-alt"></i></button>
<div class="sidebar-shop-consults-wrap for-mo">
    <div class="m-b-5">
        <a href="https://open.kakao.com/o/sDmot0Hf" target="_blank">
            <img src="<?php echo EYOOM_THEME_URL; ?>/image/consult_icon/kakao-talk.png" width="45" class="site-logo" alt="카톡 문의">
        </a>
    </div>
    <div class="m-b-0">
        <a href="https://t.me/Arrive_24time" target="_blank">
            <img src="<?php echo EYOOM_THEME_URL; ?>/image/consult_icon/telegram.png" width="42" class="site-logo" alt="텔레그람 문의">
        </a>
    </div>
</div>
<div class="sidebar-shop-member-wrap">
    <button type="button" class="sidebar-shop-trigger sidebar-shop-member-btn pc-btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasShopRight" aria-controls="offcanvasShopRight"><i class="fas fa-user-alt"></i><span class="direction-icon"><i class="fas fa-outdent"></i></span></button>
    <div class="sidebar-shop-consults-wrap for-pc">
        <div class="m-b-5">
            <a href="https://open.kakao.com/o/sDmot0Hf" target="_blank">
                <img src="<?php echo EYOOM_THEME_URL; ?>/image/consult_icon/kakao-talk.png" width="42" class="site-logo" alt="카톡 문의">
            </a>
        </div>
        <div class="m-b-0">
            <a href="https://t.me/Arrive_24time" target="_blank">
                <img src="<?php echo EYOOM_THEME_URL; ?>/image/consult_icon/telegram.png" width="38" class="site-logo" alt="텔레그람 문의">
            </a>
        </div>
    </div>
    <div class="sidebar-shop-member offcanvas offcanvas-end" tabindex="-1" id="offcanvasShopRight" aria-labelledby="offcanvasShopRightLabel">
		<div class="offcanvas-header">
            <h5 class="offcanvas-title f-s-16r" id="offcanvasShopRightLabel"><i class="fas fa-boxes text-gray"></i> 나의 쇼핑 박스</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="sidebar-shop-member-in">
            <?php /* 아웃로그인 시작 */ ?>
            <?php if ( $eyoom['use_gnu_outlogin'] == 'y' ) { //그누보드 스킨일 경우 ?>
                <?php echo outlogin('basic'); ?>
            <?php } else { //이윰 스킨일 경우 ?>
                <?php echo eb_outlogin($eyoom['outlogin_skin']); ?>
            <?php } ?>
            <?php /* 아웃로그인 끝 */ ?>

            <div class="shop-member-box">
                <div class="shop-member-box-title">오늘본상품<span class="badge badge-red rounded"><?php echo get_view_today_items_count(); ?></span></div>
                <?php include(EYOOM_THEME_SHOP_SKIN_PATH.'/boxtodayview.skin.html.php'); // 오늘 본 상품 ?>
                <div class="shop-member-box-title">장바구니<span class="badge badge-red rounded"><?php echo get_boxcart_datas_count(); ?></span></div>
                <?php include_once(EYOOM_THEME_SHOP_SKIN_PATH.'/boxcart.skin.html.php'); // 장바구니 ?>
            </div>

            <?php /* 투표 시작 */ ?>
            <?php if ( $eyoom['use_gnu_poll'] == 'y' ) { //그누보드 스킨일 경우 ?>
                <?php echo poll('basic'); ?>
            <?php } else { //이윰 스킨일 경우 ?>
                <?php echo eb_poll($eyoom['poll_skin']); ?>
            <?php } ?>
            <?php /* 투표 끝 */ ?>
        </div>
    </div>
</div>
<?php /*----- 쇼핑몰 회원 사이드바 끝 -----*/ ?>

<?php /* Back To Top */ ?>
<div class="eb-backtotop">
	<svg class="backtotop-progress" width="100%" height="100%" viewBox="-1 -1 102 102">
		<path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
		<span class="progress-count"></span>
	</svg>
</div>
<?php } // !$wmode ?>

<form name="fitem_for_list" method="post" action="" onsubmit="return fitem_for_list_submit(this);">
<input type="hidden" name="url">
<input type="hidden" name="it_id">
</form>

<?php
include_once(EYOOM_THEME_PATH . '/misc.html.php');
?>

<?php
if ($is_member && $eyoomer['onoff_push'] == 'on') {
    include_once(EYOOM_THEME_PATH . '/skin/push/basic/push.skin.html.php');
}
?>

<script src="<?php echo EYOOM_THEME_URL; ?>/js/shop_app.js?ver=<?php echo G5_JS_VER; ?>"></script>
<script>
function item_wish_for_list(it_id) {
    var f = document.fitem_for_list;
    f.url.value = "<?php echo G5_SHOP_URL; ?>/wishupdate.php?it_id="+it_id;
    f.it_id.value = it_id;
    f.action = "<?php echo G5_SHOP_URL; ?>/wishupdate.php";
    f.submit();
}

<?php if ($is_admin == 'super') { ?>
$(document).ready(function() {
    var edit_mode = "<?php echo $eyoom_default['edit_mode']; ?>";
    if (edit_mode == 'on') {
        $(".btn-edit-mode").show();
    } else {
        $(".btn-edit-mode").hide();
    }

    $("#btn_edit_mode").click(function() {
        var edit_mode = $("#edit_mode").val();
        if (edit_mode == 'on') {
            $(".btn-edit-mode").hide();
            $("#edit_mode").val('');
        } else {
            $(".btn-edit-mode").show();
            $("#edit_mode").val('on');
        }

        $.post("<?php echo G5_ADMIN_URL; ?>/?dir=theme&pid=theme_editmode&smode=1", { edit_mode: edit_mode });
    });
});
<?php } ?>
</script>