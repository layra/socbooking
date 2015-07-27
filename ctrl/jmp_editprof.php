<?php
include_once("../cgi-bin/lib.php");

$uid = b_lib_sessionGetUser()['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];

b_user_edit($uid, $name, $email, $address);

$user = b_lib_sessionGetUser();

$user['name'] = $name;
$user['email'] = $email;
$user['address'] = $address;

b_lib_sessionSetUser($user);

b_lib_jmp("/ctrl/page_prof_view.php");

?>
