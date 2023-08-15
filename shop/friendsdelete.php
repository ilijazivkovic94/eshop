<?php
include_once('./_common.php');

session_start();
$mb_id = $_SESSION['ss_mb_id'];

if (!$mb_id) {
    goto_url(G5_BBS_URL.'/login.php');
}
$act = isset($_POST['act']) ? clean_xss_tags($_POST['act'], 1, 1) : '';
$post_ct_chk = (isset($_POST['ct_chk']) && is_array($_POST['ct_chk'])) ? $_POST['ct_chk'] : array();
$post_it_ids = (isset($_POST['it_id']) && is_array($_POST['it_id'])) ? $_POST['it_id'] : array();

if ($act == "alldelete") // 모두 삭제이면
{
    $sql = " delete from g5_friends where parent_mb_id = '$mb_id' ";
    sql_query($sql);
}
else if ($act == "seldelete") // 선택삭제
{
    if(!count($post_ct_chk))
        alert("삭제하실 상품을 하나이상 선택해 주십시오.");

    $sql = " delete from g5_friends where id IN (" . implode(',', $post_it_ids) . ")";
    sql_query($sql);
}

goto_url(G5_SHOP_URL.'/friends.php');