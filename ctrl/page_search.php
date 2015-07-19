<?php
include_once("../cgi-bin/lib.php");

$types = array(
	array("device_type_id" => 1, "device_type_desc" => "tablets"),
	array("device_type_id" => 2, "device_type_desc" => "mobile phones")
	);

$devs = array();

if(count($_GET)) {
	$type = $_GET['type'] == 'NULL' ? false : $_GET['type'];
	$keyword = $_GET['keyword'];
	if ($type && $keyword) {
		$devs = b_dev_listByTypeAndKW($type, $keyword);
	}
	else if ($type && !$keyword) {
		$devs = b_dev_listByType($type);
	}
	else if (!$type && $keyword) {
		$devs = b_dev_listByKW($keyword);
	}
	else {
		$devs = b_dev_listAll();
	}
}
else {
	$devs = b_dev_listAll();
}
include_once("../cgi-bin/view_search.php");

?>
