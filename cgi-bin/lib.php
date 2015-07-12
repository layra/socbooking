<?php

function b_db_getDB () {
	$link = mysql_connect('localhost', 'root', '');
	b_lib_assert($link, "MySQL Connection Error");
	$sdb = mysql_select_db("socdevbooking", $link);
	b_lib_assert($sdb, "MySQL DB Selection Error");
}

function b_lib_assert ($assertion, $msg) {
	if (!$assertion) {
		die("System Error: " . $msg);
	}
}

function b_lib_jmp ($url) {
	Header("HTTP/1.1 303 See Other");
	Header("Location: $url");
	exit;
}

function b_lib_sessionInit () {
	if (!defined("B_LIB_SESSION")) {
		define("B_LIB_SESSION", "B_LIB_SESSION");
		session_start();
	}
}

function b_lib_sessionGetUser () {
	b_lib_sessionInit();
	return $_SESSION["USER"];
}

function b_lib_sessionSetUser ($user) {
	b_lib_sessionInit();
	$_SESSION["USER"] = $user;
}

function b_lib_sessionClose () {
	b_lib_sessionInit();
	session_destroy();
}


//UserModel
//	id
//	password
//	name
//	type
//	email
//	address

function b_user_load ($id, $password) {
	b_db_getDB();
	$user = array();
	$result = mysql_query("SELECT * FROM `user` WHERE `user_id` = '$id' AND `user_password` = '$password';");
	b_lib_assert($result, "SQL Error");
	if ($row = mysql_fetch_array($result)) {
		$user['id'] = $row['user_id'];
		$user['password'] = $row['user_password'];
		$user['name'] = $row['user_name'];
		$user['type'] = $row['user_type'];
		$user['email'] = $row['user_email'];
		$user['address'] = $row['user_address'];
		return $user;
	}
	else {
		return false;
	}
}


//DeviceModel
//	type
//	id
//	name
//	owner_name
//	amount

function b_dev_listAll () {
	b_db_getDB();
	$devlist = array();
	// array_push($devlist, )
	$result = mysql_query("SELECT * FROM `socdevbooking`.`device_view`;");
	b_lib_assert($result, "SQL Error" . mysql_error());
	while ($row = mysql_fetch_array($result)) {
		$dev = array();
		$dev['type'] = $row['device_type'];
		$dev['id'] = $row['device_id'];
		$dev['name'] = $row['device_name'];
		$dev['owner_name'] = $row['holder_name'];
		$dev['amount'] = $row['amount'];
		array_push($devlist, $dev);
	}
	return $devlist;
}

?>
