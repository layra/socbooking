<!DOCTYPE html>
<html>
<head>
	<title></title>
<script type="text/javascript">
var dev = <?php echo json_encode($dev); ?>;
var list = <?php echo json_encode($list); ?>;
var defaultopt = "<option value='NULL'>Please Select</option>";
function getDateOpt (index) {
	var html = defaultopt;
	for (var i = index; i < list.length ; i++) {
		html += "<option value='" + list[i].date + "'>" + list[i].date + "</option>";
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
			document.getElementById('enddate').innerHTML = getDateOpt(i);
			return;
		}
	}
}
function upload_howmany () {
	document.getElementById('howmany').innerHTML = defaultopt;
	var sd = '' + document.getElementById('startdate').value;
	var ed = '' + document.getElementById('enddate').value;
	if (ed == 'NULL') {
		return;
	}
	var si;
	for (si = 0; si < list.length; si++) {
		if (list[si].date == sd) {
			break;
		}
	}
	var ei;
	for (ei = si; ei < list.length; ei++) {
		if (list[ei].date == ed) {
			break;
		}
	}
	var maxbooking = dev.amount;
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
	background-color: #0F0;
}
div.unaval {
	position: absolute;
	top: 0px;
	width: 100%;
	background-color: #F00;
}
div.date {
	position: absolute;
	top: 0px;
	right: 0px;
	background-color: #FFF;
}
div.aval {
	position: absolute;
	bottom: 0px;
	text-align: center;
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
			<td>&nbsp;</td>
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
			<td><?php echo $end_s;?>&nbsp;</td>
<?php } ?>
		</tr>
	</tbody>
</table>
<p>Make your booking:</p>
Start:<br/>
<select id="startdate" onchange="upload_enddate();">
	<script type="text/javascript">
		document.write(getDateOpt(0));
	</script>
</select><br/>
End Date:<br/>
<select id="enddate" onchange="upload_howmany();">
	<script type="text/javascript">
		document.write(defaultopt);
	</script>
</select><br/>
How many:<br/>
<select id="howmany" >
	<script type="text/javascript">
		document.write(defaultopt);
	</script>
</select><br/>
<input type="submit" value="submit" />
</body>
</html>
