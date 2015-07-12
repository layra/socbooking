<?php
include("../cgi-bin/lib.php");
include("../cgi-bin/db.php");
include("../cgi-bin/model_user.php");

$id = $_GET['id'];
$password = $_GET['password'];

$user = b_user_load($id, $password);
b_lib_assert($user, "no such user or wrong password");

?>
