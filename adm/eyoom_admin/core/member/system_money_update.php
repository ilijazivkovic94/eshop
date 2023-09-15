<?php
/**
 * @file    /adm/eyoom_admin/core/member/point_update.php
 */
if (!defined('_EYOOM_IS_ADMIN_')) exit;

$sub_menu = "200201";

auth_check_menu($auth, $sub_menu, 'w');

check_admin_token();

$mb_id = isset($_POST['mb_id']) ? strip_tags(clean_xss_attributes($_POST['mb_id'])) : '';
$po_system_money = isset($_POST['po_system_money']) ? strip_tags(clean_xss_attributes($_POST['po_system_money'])) : 0;
$po_content = isset($_POST['po_content']) ? strip_tags(clean_xss_attributes($_POST['po_content'])) : '';
$expire = isset($_POST['po_expire_term']) ? preg_replace('/[^0-9]/', '', $_POST['po_expire_term']) : '';

$mb = get_member($mb_id);

if (!$mb['mb_id']) {
    alert('존재하는 회원아이디가 아닙니다.', G5_ADMIN_URL.'/?dir=member&amp;pid=system_money_list&amp;'.$qstr);
}

if ($po_system_money > 0) {
    if ($po_content === '환전') {
        $po_system_money *= -1;
        if (($po_system_money < 0) && abs($po_system_money) > $mb['mb_system_money']) {
            alert('회원의 보유머니 잔액이 부족합니다.', G5_ADMIN_URL.'/?dir=member&amp;pid=system_money_list&amp;'.$qstr);
        }
    }
} else {
    alert('0보다 큰 머니값을 입력하십시오.', G5_ADMIN_URL.'/?dir=member&amp;pid=system_money_list&amp;'.$qstr);
}

insert_system_money($mb_id, $po_system_money, $po_content, '@passive', $mb_id, $member['mb_id'] . '-' . uniqid(''), $expire);

alert("시스템머니 내역을 적용하였습니다.", G5_ADMIN_URL . '/?dir=member&amp;pid=system_money_list&amp;'.$qstr);