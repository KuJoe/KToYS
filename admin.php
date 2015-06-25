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
	require('functions.php');
	if(isset($_POST['name'])) {
		$insert = dbinsert($_POST['name'], $_POST['provider'], $_POST['city'], $_POST['state'], $_POST['country'], $_POST['datacenter'], $_POST['cost'], $_POST['cycle'], $_POST['start'], $_POST['due'], $_POST['ram'], $_POST['swap'], $_POST['cpu'], $_POST['cpunum'], $_POST['cpuclock'], $_POST['bw'], $_POST['port'], $_POST['disk'], $_POST['disktype'], $_POST['ipv4'], $_POST['ipv6'], $_POST['notes'], $_POST['services']);
		if ($insert == true) {
			echo "<div style=\"width:100%;text-align:center;font-weight:bold;padding:10px 0;\">Success!</div>";
		} else {
			echo "<div style=\"width:100%;text-align:center;font-weight:bold;padding:10px 0;\">Failed. Please make sure all fields are filled out.";
		}
	}
	if(isset($_POST['delsid']) AND is_numeric($_POST['delsid'])) {
		$delete = dbdel($_POST['delsid']);
		if ($delete == true) {
			echo "<div style=\"width:100%;text-align:center;font-weight:bold;padding:10px 0;\">Success!</div>";
		} else {
			echo "<div style=\"width:100%;text-align:center;font-weight:bold;padding:10px 0;\">Failed.";
		}
	}
?>
<h2>Keep Track of Your Services!</h2>
	<form name="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<table id="invtable">
			<tr><th colspan="4">Add Service</th></tr>
			<tr><th>Name</th><td><input type="text" name="name"></td><th>RAM</th><td><input type="text" name="ram"></td></tr>
			<tr><th>Provider</th><td><input type="text" name="provider"></td><th>SWAP</th><td><input type="text" name="swap"></td></tr>
			<tr><th>City</th><td><input type="text" name="city"></td><th>CPU Type</th><td><input type="text" name="cpu"></td></tr>
			<tr><th>State</th><td><input type="text" name="state"></td><th>CPU Cores</th><td><input type="text" name="cpunum"></td></tr>
			<tr><th>Country</th><td><input type="text" name="country"></td><th>CPU Clock Speed</th><td><input type="text" name="cpuclock"></td></tr>
			<tr><th>Datacenter</th><td><input type="text" name="datacenter"></td><th>Bandwidth</th><td><input type="text" name="bw"></td></tr>
			<tr><th>Cost</th><td><input type="text" name="cost"></td><th>Port Speed</th><td><input type="text" name="port"></td></tr>
			<tr><th>Billing Cycle</th>
			<td><select name="cycle">
				<option value="Hourly">Hourly</option>
				<option value="Daily">Daily</option>
				<option value="Weekly">Weekly</option>
				<option value="Monthly" selected="selected">Monthly</option>
				<option value="Bimonthly">Bimonthly</option>
				<option value="Quarterly">Quarterly</option>
				<option value="Semiannually">Semiannually</option>
				<option value="Annually">Annually</option>
				<option value="Biennially">Biennially</option>
				<option value="Triennially">Triennially</option>
				<option value="Other">Other</option>
			</select></td>
			<th>Disk Space</th><td><input type="text" name="disk"></td></tr>
			<tr><th>Start Date</th><td><input name="start" type="text" id="startdate"></td>
			<th>Disk Type</th>
			<td><select name="disktype">
				<option value="SATA">SATA</option>
				<option value="SAS">SAS</option>
				<option value="SSD">SSD</option>
				<option value="SAN">SAN</option>
				<option value="Other">Other</option>
				<option value="Unknown">Unknown</option>
			</select></td></tr>
			<tr><th>Due Date</th><td><input name="due" type="text" id="duedate"></td><td></td><td></td></tr>
			<tr><th>IPv4 Addresses</th><td colspan="3"><textarea rows="4" cols="50" name="ipv4"></textarea></td></tr>
			<tr><th>IPv6 Addresses</th><td colspan="3"><textarea rows="4" cols="50" name="ipv6"></textarea></td></tr>
			<tr><th>Additional Notes</th><td colspan="3"><textarea rows="4" cols="50" name="notes"></textarea></td></tr>
			<tr><th>Services</th><td colspan="3"><textarea rows="4" cols="50" name="services"></textarea></td></tr>
	</table>
	<i>All fields must be filled out! If it does not apply put "none", "0", "NA", or something like that.</i>
	<center><input name="addsrv" type="submit" value="Add Service"></center>
	</form>
	<br />
	<form name="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<center>Service ID to Delete:</th><td><input type="text" name="delsid">
		<input name="delsrv" type="submit" value="Delete Service"></center>
	</form>
    </div>
	<div style="clear: both;"></div>
	<br /><br />
	<a href="https://github.com/KuJoe/KToYS" target="_blank">By KuJoe</a>
</body>
</html>