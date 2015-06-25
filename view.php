<?php
/**
Simple PHP and SQLite3 script for keeping track of your hosting, VPS, and dedicated services.
By KuJoe (JMD.cc)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
**/

$filename = './ktoys.db3';
if (!file_exists($filename)) {
    die('Database does not exist. Run the installer again.');
}
?>
<html>
<head>
	<link href="./style.css" rel="stylesheet">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script>
	$(function() {
		$( "#startdate" ).datepicker();
	});
	</script>
	<script>
	$(function() {
		$( "#duedate" ).datepicker();
	});
	</script>
</head>
<body>
	<br />
	<a href="index.php">Home</a> | <a href="admin.php">Admin</a>
	<div style="clear: both;"></div>
	<div class="container">
<?php
	$sid = $_GET['id'];
	if(empty($sid) OR !is_numeric($sid)) {
		echo "Invalid ID, please try again and make sure the ID is a valid sid in the database";
		exit;
	}
	require('functions.php');
	if(isset($_POST['name']) AND is_numeric($sid)) {
		$insert = dbupdate($_POST['name'], $_POST['provider'], $_POST['city'], $_POST['state'], $_POST['country'], $_POST['datacenter'], $_POST['cost'], $_POST['cycle'], $_POST['start'], $_POST['due'], $_POST['ram'], $_POST['swap'], $_POST['cpu'], $_POST['cpunum'], $_POST['cpuclock'], $_POST['bw'], $_POST['port'], $_POST['disk'], $_POST['disktype'], $_POST['ipv4'], $_POST['ipv6'], $_POST['notes'],$sid);
		if ($insert == true) {
			echo "<div style=\"width:100%;text-align:center;font-weight:bold;padding:10px 0;\">Success!</div>";
		} else {
			echo "<div style=\"width:100%;text-align:center;font-weight:bold;padding:10px 0;\">Failed.";
		}
	}
	$db = new SQLite3('ktoys.db3');
	$result = $db->query("SELECT * FROM services WHERE sid='$sid'") or die('Query failed');
	$cnt = $result->fetchArray();
	$cnt = $cnt['sid'];
	if($cnt <= '0') {
		echo "Invalid ID, please try again and make sure the ID is a valid sid in the database";
		exit;
	}
	$result = $db->query("SELECT * FROM services WHERE sid='$sid'") or die('Query failed');
	while ($row = $result->fetchArray()) {
?>
<h2>Keep Track of Your Services!</h2>
	<form name="form" method="post" action="<?php echo $_SERVER['PHP_SELF']."?id=".$sid; ?>">
	<table id="invtable">
			<tr><th colspan="4">View/Edit Service</th></tr>
			<tr><th>Name</th><td><input type="text" name="name" value="<?php echo $row['name']; ?>"></td><th>RAM</th><td><input type="text" name="ram" value="<?php echo $row['ram']; ?>"></td></tr>
			<tr><th>Provider</th><td><input type="text" name="provider" value="<?php echo $row['provider']; ?>"></td><th>SWAP</th><td><input type="text" name="swap" value="<?php echo $row['swap']; ?>"></td></tr>
			<tr><th>City</th><td><input type="text" name="city" value="<?php echo $row['city']; ?>"></td><th>CPU Type</th><td><input type="text" name="cpu" value="<?php echo $row['cpu']; ?>"></td></tr>
			<tr><th>State</th><td><input type="text" name="state" value="<?php echo $row['state']; ?>"></td><th>CPU Cores</th><td><input type="text" name="cpunum" value="<?php echo $row['cpunum']; ?>"></td></tr>
			<tr><th>Country</th><td><input type="text" name="country" value="<?php echo $row['country']; ?>"></td><th>CPU Clock Speed</th><td><input type="text" name="cpuclock" value="<?php echo $row['cpuclock']; ?>"></td></tr>
			<tr><th>Datacenter</th><td><input type="text" name="datacenter" value="<?php echo $row['datacenter']; ?>"></td><th>Bandwidth</th><td><input type="text" name="bw" value="<?php echo $row['bw']; ?>"></td></tr>
			<tr><th>Cost</th><td><input type="text" name="cost" value="<?php echo $row['cost']; ?>"></td><th>Port Speed</th><td><input type="text" name="port" value="<?php echo $row['port']; ?>"></td></tr>
			<tr><th>Billing Cycle</th>
			<td><select name="cycle">
				<option value="<?php echo $row['cycle']; ?>" selected="selected"><?php echo $row['cycle']; ?></option>
				<option value="Hourly">Hourly</option>
				<option value="Daily">Daily</option>
				<option value="Weekly">Weekly</option>
				<option value="Monthly">Monthly</option>
				<option value="Bimonthly">Bimonthly</option>
				<option value="Quarterly">Quarterly</option>
				<option value="Semiannually">Semiannually</option>
				<option value="Annually">Annually</option>
				<option value="Biennially">Biennially</option>
				<option value="Triennially">Triennially</option>
				<option value="Other">Other</option>
			</select></td>
			<th>Disk Space</th><td><input type="text" name="disk" value="<?php echo $row['disk']; ?>"></td></tr>
			<tr><th>Start Date</th><td><input name="start" type="text" value="<?php echo $row['start']; ?>" id="startdate"></td>
			<th>Disk Type</th>
			<td><select name="disktype">
				<option value="<?php echo $row['disktype']; ?>" selected="selected"><?php echo $row['disktype']; ?></option>
				<option value="SATA">SATA</option>
				<option value="SAS">SAS</option>
				<option value="SSD">SSD</option>
				<option value="SAN">SAN</option>
				<option value="Other">Other</option>
				<option value="Unknown">Unknown</option>
			</select></td></tr>
			<tr><th>Due Date</th><td><input name="due" type="text" value="<?php echo $row['due']; ?>" id="duedate"></td><td></td><td></td></tr>
			<tr><th>IPv4 Addresses</th><td colspan="3"><textarea rows="4" cols="50" name="ipv4"><?php echo $row['ipv4']; ?></textarea></td></tr>
			<tr><th>IPv6 Addresses</th><td colspan="3"><textarea rows="4" cols="50" name="ipv6"><?php echo $row['ipv6']; ?></textarea></td></tr>
			<tr><th>Additional Notes</th><td colspan="3"><textarea rows="4" cols="50" name="notes"><?php echo $row['notes']; ?></textarea></td></tr>
	</table>
	<i>Don't leave anything blank.</i>
	<center><input name="editsrv" type="submit" value="Edit Service"></center>
	</form>
    </div>
	<div style="clear: both;"></div>
	<br /><br />
	<a href="https://github.com/KuJoe/KToYS" target="_blank">By KuJoe</a>
</body>
</html>
<?php } ?>