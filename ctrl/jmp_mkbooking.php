<?php
include_once("../cgi-bin/lib.php");

$id = $_POST['id'];
$uid = b_lib_sessionGetUser()['id'];
$s_date = $_POST['s_date'];
$length = $_POST['length'];
$amount = $_POST['amount'];

if (b_dev_mkBooking($id, $uid, $s_date, $length, $amount)) {
// b_lib_jmp("/ctrl/page_prof_mybooking.php");
}
else {
	die('Error');
}

?>
