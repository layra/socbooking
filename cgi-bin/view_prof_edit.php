<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form method="POST" action="/ctrl/jmp_editprof.php">
<p>User ID: <?php echo $user['id']; ?></p>
<p>Full Name: <input type='text' name="name" value='<?php echo $user['name']; ?>' /></p>
<p>Email: <input type='text' name="email" value='<?php echo $user['email']; ?>' /></p>
<?php if ($user['type'] == 'holder') { ?>
<p>Office: <input type='text' name="address" value='<?php echo $user['address']; ?>' /></p>
<?php } else { ?>
<input type='hidden' name="address" value='' />
<?php }?>
<p><input type="submit" value="submit" /></p>

</form>
</body>
</html>