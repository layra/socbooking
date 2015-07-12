<!DOCTYPE html>
<html>
<head>
	<title>Search Devices</title>
</head>
<body>
<a href="/ctrl/page_prof_view.php">my profile</a>
<a href="/ctrl/logout.php">logout</a>
<form method="GET" action="/ctrl/page_search.php">
<select name="type">
	<option value="NaN">all</option>
	<?php for ( $i=0 ; $i < count($types) ; $i++) { ?>
	<option value="<?php echo $types[$i]["device_type_id"];?>">
		<?php echo $types[$i]["device_type_desc"];?>
	</option>
	<?php } ?>
</select>
<input type="text" name="keyword" />
<input type="submit" value="search"/>
</form>
<table border="1">
	<tbody>
	<tr>
		<th>Type</th>
		<th>Name</th>
		<th>Owner</th>
		<th>Amount</th>
	</tr>
	<?php for ( $i=0 ; $i < count($devs) ; $i++) { ?>
	<tr>
		<td><?php echo $devs[$i]['type']; ?></td>
		<td><a href=""><?php echo $devs[$i]['name']; ?></a></td>
		<td><?php echo $devs[$i]['owner_name']; ?></td>
		<td><?php echo $devs[$i]['amount']; ?></td>
	</tr>
	<?php } ?>
	</tbody>
</table>
</body>
</html>