<?php
include_once("../cgi-bin/lib.php");

$types = array(
	array("device_type_id" => 1, "device_type_desc" => "tablets"),
	array("device_type_id" => 2, "device_type_desc" => "mobile phones")
	);

$devs = b_dev_listAll();

$_GET['devid'];

include_once("../cgi-bin/view_bookdev.php");

?>
