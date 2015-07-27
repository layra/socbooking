<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<p>User ID: <?php echo $user['id']; ?></p>
<p>Full Name: <?php echo $user['name']; ?></p>
<p>Email: <?php echo $user['email']; ?></p>
<?php if ($user['type'] == 'holder') { ?>
<p>Office: <?php echo $user['address']; ?></p>
<?php } ?>
<p><a href="/ctrl/page_prof_edit.php">Edit</a></p>
</body>
</html>