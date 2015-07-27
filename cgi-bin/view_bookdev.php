<!DOCTYPE html>
<html>
<head>
	<title></title>
<script type="text/javascript">
var dev = <?php echo json_encode($dev); ?>;
var list = <?php echo json_encode($list); ?>;
var maxlen = 10;
var defaultopt = "<option value='NULL'>Please Select</option>";
function getDateOpt (index) {
	var html = defaultopt;
	for (var i = index; i < list.length ; i++) {
		html += "<option value='" + list[i].date + "'>" + list[i].date + "</option>";
	}
	return html;
}
function getLengthOpt (index) {
	var html = defaultopt;
	for (var i = 1 ; ; i++) {
		if (i + index > list.length) {
			break;
		}
		if (i > maxlen) {
			break;
		}
		html += "<option value='" + i + "'>" + i + "</option>";
	}
	return html;
}
function getHowmanyOpt (max) {
	var html = defaultopt;
	for (var i = 1; i <= max ; i++) {
		html += "<option value='" + i + "'>" + i + "</option>";
	}
	return html;
}
function upload_enddate () {
	document.getElementById('enddate').innerHTML = defaultopt;
	document.getElementById('howmany').innerHTML = defaultopt;
	var sd = '' + document.getElementById('startdate').value;
	if (sd == 'NULL') {
		return;
	}
	for (var i = 0; i < list.length; i++) {
		if (list[i].date == sd) {
			document.getElementById('enddate').innerHTML = getLengthOpt(i);
			return;
		}
	}
}
function upload_howmany () {
	document.getElementById('howmany').innerHTML = defaultopt;
	var sd = '' + document.getElementById('startdate').value;
	var len = '' + document.getElementById('enddate').value;
	if (len == 'NULL') {
		return;
	}
	var si;
	for (si = 0; si < list.length; si++) {
		if (list[si].date == sd) {
			break;
		}
	}
	len = parseInt(len);
	var ei = si + len - 1;
	// for (ei = si; ei < list.length; ei++) {
	// 	if (list[ei].date == ed) {
	// 		break;
	// 	}
	// }
	var maxbooking = dev.amount;
	console.log('se:'+si+' '+ei);
	for (var i = si; i <= ei; i++) {
		if (list[i].aval < maxbooking) {
			maxbooking = list[i].aval;
		}
	}
	document.getElementById('howmany').innerHTML = getHowmanyOpt(maxbooking);

}
</script>
<style type="text/css">
#calendar td {
	position: relative;
	width: 100px;
	height: 100px;
	background-color: rgb(190, 230, 89);/*可用*/
}
div.unaval {
	position: absolute;
	top: 0px;
	width: 100%;
	background-color: rgb(248, 190, 205);/*不可用*/
}
div.date {
	position: absolute;
	top: 0px;
	right: 0px;
	background-color: rgb(244, 244, 244);
}
div.aval {
	position: absolute;
	width: 100%;
	bottom: 0px;
	text-align: center;
}
#calendar td.unused {
	background-color: rgb(211, 220, 222);/*无效日期*/
}
</style>
</head>
<body>
<p>Device:<?php echo $dev['type']; ?>/<?php echo $dev['name']; ?></p>
<p>Amount:<?php echo $dev['amount']; ?></p>
<p>Owner:<?php echo $dev['owner_name']; ?></p>
<p>Office:<?php echo $dev['owner_office']; ?></p>
<p>Booking Calendar:</p>
<table border="1" id="calendar">
	<tbody>
		<tr>
			<th>Mon</th>
			<th>Tue</th>
			<th>Wed</th>
			<th>Thu</th>
			<th>Fri</th>
		</tr>
		<tr>
<?php for ($i = 0 ; $i < $start_s ; $i++) { ?>
			<td class="unused">&nbsp;</td>
<?php } for ($i = 0 ; $i < count($list) ; $i++) {?>
			<td>
				<div class="unaval" style="height:<?php echo $list[$i]['height']; ?>px;"></div>
				<div class="date"><?php echo $list[$i]['disp']; ?></div>
				<div class="aval"><?php echo $list[$i]['aval']; ?> avaliable</div>
			</td>
<?php 		if ($list[$i]['wday'] == 5) { ?>
		</tr>
		<tr>
<?php 		} ?>
<?php } for ($i = 0 ; $i < $end_s ; $i++) { ?>
			<td class="unused">&nbsp;</td>
<?php } ?>
		</tr>
	</tbody>
</table>
<p>Make your booking:</p>
Start:<br/>
<form method="POST" action="/ctrl/jmp_mkbooking.php">
	<input type="hidden" name="id" value="<?php echo $dev['id']; ?>" />
	<select name="s_date" id="startdate" onchange="upload_enddate();">
		<script type="text/javascript">
			document.write(getDateOpt(0));
		</script>
	</select><br/>
	Booking Days (1 means you need to return the device in the same day):<br/>
	<select name="length" id="enddate" onchange="upload_howmany();">
		<script type="text/javascript">
			document.write(defaultopt);
		</script>
	</select><br/>
	How many:<br/>
	<select name="amount" id="howmany" >
		<script type="text/javascript">
			document.write(defaultopt);
		</script>
	</select><br/>
	<input type="submit" value="submit" />	
</form>
</body>
</html>
