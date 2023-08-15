<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');

$sw_direct = (isset($_REQUEST['sw_direct']) && $_REQUEST['sw_direct']) ? 1 : 0;

session_start();
$mb_id = $_SESSION['ss_mb_id'];

$email = $_POST['email'];
$percentage = $_POST['percentage'];
$code = uniqid($mb_id);
$sent_at = date('Y-m-d');
$current_id = $_POST['current_id'];

$sql = "select * from g5_friends where id=" . $current_id;
$result = sql_query($sql);
$exist_member = sql_fetch_array($result);

if (!$exist_member) {
    // 선택필드 초기화
    $sql = "insert into g5_friends (email, percentage, code, parent_mb_id, sent_at) values ('$email', $percentage, '$code', '$mb_id', '$sent_at')";
    sql_query($sql);
} else {
    $sql = "update g5_friends set email='$email', percentage='$percentage', sent_at='$sent_at' where id=" . $current_id;
    sql_query($sql);
    $code = $exist_member['code'];
}

$content = '<p>친구추가요청이 들어왔습니다.</p>';
$content .= '<a href="' . G5_DOMAIN . '/bbs/register.php?code=' . $code . '&email=' . $email . '">등록하기</a>';

try {
    mailer('쇼핑', $email, $config['cf_admin_email'], '친구추가 요청', $content, 1);
    goto_url(G5_SHOP_URL.'/friends.php');
} catch (Exception $err) {
    goto_url(G5_SHOP_URL.'/friends.php');
}