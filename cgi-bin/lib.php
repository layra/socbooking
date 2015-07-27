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

function b_lib_date_getFullYear ($date) {
	$time = $date->getTimestamp();
	$y = '' . getdate($time)['year'];
	return $y;
}

function b_lib_date_getMonth ($date) {
	$time = $date->getTimestamp();
	$m = '' . getdate($time)['mon'];
	while (strlen($m) < 2) {
		$m = '0' . $m;
	}
	return $m;
}

function b_lib_date_getDate ($date) {
	$time = $date->getTimestamp();
	$d = getdate($time)['mday'];
	while (strlen($d) < 2) {
		$d = '0' . $d;
	}
	return $d;
}

function b_lib_date_getWeekday ($date) {
	$time = $date->getTimestamp();
	$wday = getdate($time)['wday'];
	return $wday;
}

function b_lib_date_getGBString ($date) {
	$y = b_lib_date_getFullYear($date);
	$m = b_lib_date_getMonth($date);
	$d = b_lib_date_getDate($date);
	return $d . '/' . $m;/* . '/' . $y;*/
}

function b_lib_date_getUSAString ($date) {
	$y = b_lib_date_getFullYear($date);
	$m = b_lib_date_getMonth($date);
	$d = b_lib_date_getDate($date);
	return $y . '-' . $m . '-' . $d;
}

function b_lib_date_isWeekend ($date) {
	$time = $date->getTimestamp();
	$wday = getdate($time)['wday'];
	return $wday == 0 || $wday == 6;
}

function b_lib_date_getTomorrow ($date) {
	$daylen = 24 * 60 * 60;
	$time = $date->getTimestamp();
	$time += $daylen;
	$tom = new DateTime();
	$tom->setTimestamp($time);
	return $tom;
}

function b_lib_date_getWeekDays ($start_date, $n) {
	$days = array();

	$date = $start_date;

	while (b_lib_date_isWeekend($date)) {
		$date = b_lib_date_getTomorrow($date);
	}

	while (count($days) < $n) {
		if (!b_lib_date_isWeekend($date)) {
			$dateindex = b_lib_date_getUSAString($date);
			array_push($days, $dateindex);
		}
		$date = b_lib_date_getTomorrow($date);
	}
	return $days;
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

function b_user_edit ($id, $name, $email, $address) {
	$sql = '';
	if ($address) {
		$sql = "UPDATE `user` SET `user_name` = '$name', `user_email` = '$email', `user_address` = '$address' WHERE `user_id` = '$id';";
	}
	else {
		$sql = "UPDATE `user` SET `user_name` = '$name', `user_email` = '$email' WHERE `user_id` = '$id';";
	}
	b_db_getDB();
	$result = mysql_query($sql);
	b_lib_assert($result, "SQL Error" . mysql_error());
	
	return true;
}

//DeviceModel
//	type
//	id
//	name
//	owner_name
//	owner_office
//	amount

function b_dev_listBySQL ($sql) {
	b_db_getDB();
	$devlist = array();
	$result = mysql_query($sql);
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

function b_dev_listAll () {
	return b_dev_listBySQL("SELECT * FROM `socdevbooking`.`device_view`;");
}

function b_dev_listByType ($type) {
	return b_dev_listBySQL("SELECT * FROM `socdevbooking`.`device_view` WHERE `device_type_id`='$type';");
}

function b_dev_listByKW ($keyword) {
	return b_dev_listBySQL("SELECT * FROM `socdevbooking`.`device_view` WHERE `device_name` LIKE '%$keyword%';");
}

function b_dev_listByTypeAndKW ($type, $keyword) {
	return b_dev_listBySQL("SELECT * FROM `socdevbooking`.`device_view` WHERE `device_type_id`='$type' AND `device_name` LIKE '%$keyword%';");
}


function b_dev_getDev ($id) {
	b_db_getDB();
	$result = mysql_query("SELECT * FROM `socdevbooking`.`device_view` WHERE `device_id`='$id';");
	b_lib_assert($result, "SQL Error" . mysql_error());
	$dev = array();
	if ($row = mysql_fetch_array($result)) {
		$dev['type'] = $row['device_type'];
		$dev['id'] = $row['device_id'];
		$dev['name'] = $row['device_name'];
		$dev['owner_name'] = $row['holder_name'];
		$dev['owner_office'] = $row['holder_office'];
		$dev['amount'] = $row['amount'];
	}
	return $dev;
}

function b_dev_getCalender ($id) {
	$dev = b_dev_getDev($id);

	$amount = $dev['amount'];
	$devlist = array();
	$result = mysql_query(
		"SELECT `booking_date` AS date, ($amount-sum(booking_amount)) AS avaliable"
		. " FROM `socdevbooking`.`booking`"
		. " WHERE `device_id`='$id' AND `booking_date`>=DATE(NOW())"
		. " GROUP BY `device_id`, `booking_date`"
		. " ORDER BY `booking_date`;"
		);
	b_lib_assert($result, "SQL Error" . mysql_error());
	$booklist = array();
	while ($row = mysql_fetch_array($result)) {
		$booklist[$row['date']] = $row['avaliable'];
	}

	$days = array();

	$weekday = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
	$date = new DateTime();
	$date->setTime(0, 0, 0);
	while (b_lib_date_isWeekend($date)) {
		$date = b_lib_date_getTomorrow($date);
	}
	while (count($days) < 20) {
		if (!b_lib_date_isWeekend($date)) {
			$dateindex = b_lib_date_getUSAString($date);
			if (array_key_exists($dateindex, $booklist)) {
				array_push($days, array(
					'date' => $dateindex,
					'wday' => b_lib_date_getWeekday($date),
					'disp' => b_lib_date_getGBString($date),
					'aval' => $booklist[$dateindex],
					'height' => 100 - 100 * $booklist[$dateindex] /  $dev['amount']
					)
				);
			}
			else {
				array_push($days, array(
					'date' => $dateindex,
					'wday' => b_lib_date_getWeekday($date),
					'disp' => b_lib_date_getGBString($date),
					'aval' => $dev['amount'],
					'height' => 0
					)
				);
			}
		}
		$date = b_lib_date_getTomorrow($date);
	}
	return $days;
}

function b_dev_mkBooking ($id, $uid, $s_date, $length, $amount) {
	$y = substr($s_date, 0, 4);
	$m = substr($s_date, 5, 2);
	$d = substr($s_date, 8, 2);

	$s_date = new DateTime();
	$s_date->setDate($y, $m, $d);
	$s_date->setTime(0, 0, 0);

	$list = b_dev_getCalender($id);
	$days = b_lib_date_getWeekDays($s_date, $length);

	for ($si=0; $si < count($list) ; $si++) { 
		if ($list[$si]['date'] == $days[0]) {
			break;
		}
	}

	if ($si + $length > count($list)) {
		return false;
	}

	for ($i=$si; $i < $si + $length; $i++) { 
		if ($list[$i]['aval'] < $amount) {
			return false;
		}
	}

	$sql = "";

	for ($i=0; $i < $length; $i++) {
		$sql = "INSERT INTO `socdevbooking`.`booking` (`borrower_id`, `device_id`, `booking_amount`, `booking_date`) VALUES ('$uid', '$id', '$amount', '".$days[$i]."');";
		$result = mysql_query($sql);
	}

	
	b_lib_assert($result, "SQL Error" . mysql_error());

	echo $sql;
	// print_r($list);
	// print_r($days);
	// echo "uid(".$uid.")";
}

?>
