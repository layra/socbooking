<?php
include_once("../cgi-bin/lib.php");

$id = $_GET['devid'];

$dev = b_dev_getDev($id);
$list = b_dev_getCalender($id);
$start_s = $list[0]['wday'] - 1;
$end_s = 5 - $list[count($list)-1]['wday'];

include_once("../cgi-bin/view_bookdev.php");

?>
