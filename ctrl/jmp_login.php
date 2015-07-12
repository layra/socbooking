<?php
include_once("../cgi-bin/lib.php");

$id = $_GET['user_id'];
$password = $_GET['user_password'];

$user = b_user_load($id, $password);

b_lib_assert($user, "no such user or wrong password");

b_lib_sessionSetUser($user);

b_lib_jmp("/ctrl/page_search.php");

?>
