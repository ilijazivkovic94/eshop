<?php
/**
 * @file    /adm/eyoom_admin/core/member/system_money_list.php
 */
if (!defined('_EYOOM_IS_ADMIN_')) exit;

$sub_menu = "200201";

$action_url1 = G5_ADMIN_URL . '/?dir=member&amp;pid=system_money_list_delete&amp;smode=1';
$action_url2 = G5_ADMIN_URL . '/?dir=member&amp;pid=system_money_update&amp;smode=1';

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from g5_system_money as po";

$sql_search = " where (1) ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'mb_id':
            $sql_search .= " (po.{$sfl} = '{$stx}') ";
            break;
        default:
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

// 기간검색이 있다면
if(! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = '';
if(! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = '';

if ($fr_date && $to_date) {
    $sql_search .= " and po_datetime between '$fr_date 00:00:00' and '$to_date 23:59:59' ";
    $qstr .= "&amp;fr_date={$fr_date}&amp;to_date={$to_date}";
}

if (!$sst) {
    $sst  = "po_id";
    $sod = "desc";
}
$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search}
            {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) {
    $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
}
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select po.*, mb.mb_name, mb.mb_nick, mb.mb_email, mb.mb_homepage, mb.mb_point, mb.mb_system_money
            {$sql_common}
            LEFT JOIN {$g5['member_table']} mb ON po.mb_id = mb.mb_id 
            {$sql_search}
            {$sql_order}
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$mb = array();
if ($sfl == 'mb_id' && $stx) {
    $mb = get_member($stx);
}

if (strstr($sfl, "mb_id")) {
    $mb_id = $stx;
} else {
    $mb_id = "";
}

if (!(isset($mb['mb_id']) && $mb['mb_id'])) {
    $row2 = sql_fetch(" select sum(po_money) as sum_money from g5_system_money ");
    $sum_money = $row2['sum_money'];
}

$list = array();
for ($i=0; $row=sql_fetch_array($result); $i++) {
    if ($i==0 || ($row2['mb_id'] != $row['mb_id'])) {
        $sql2 = " select mb_id, mb_name, mb_nick, mb_email, mb_homepage, mb_point from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
        $row2 = sql_fetch($sql2);
    }

    $mb_nick = get_sideview($row['mb_id'], $row2['mb_nick'], $row2['mb_email'], $row2['mb_homepage']);

    $link1 = $link2 = '';
    if (!preg_match("/^\@/", $row['po_rel_table']) && $row['po_rel_table']) {
        $link1 = '<a href="'.get_eyoom_pretty_url($row['po_rel_table'], $row['po_rel_id']).'" target="_blank">';
        $link2 = '</a>';
    }

    $expr = '';

    $list[$i] = $row;
    $list[$i]['mb_name'] = $row2['mb_name'];
    $list[$i]['mb_nick'] = $row2['mb_nick'];

    if (!preg_match("/^\@/", $row['po_rel_table']) && $row['po_rel_table']) {
        $list[$i]['link'] = true;
    }
}

/**
 * 페이징
 */
$paging = $eb->set_paging('admin', $dir, $pid, $qstr);

/**
 * 검색버튼
 */
$frm_submit  = ' <div class="text-center margin-top-10 margin-bottom-10"> ';
$frm_submit .= ' <input type="submit" value="검색" class="btn-e btn-e-lg btn-e-dark" accesskey="s">' ;
$frm_submit .= '</div>';
