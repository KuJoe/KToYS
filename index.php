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
		$(document).ready(function() {
			$("input:checkbox:not(:checked)").each(function() {
				var column = "table ." + $(this).attr("name");
				$(column).hide();
			});

			$("input:checkbox").click(function(){
				var column = "table ." + $(this).attr("name");
				$(column).toggle();
			});
		});
	</script>
</head>
<body>
	<br />
	<a href="index.php">Home</a> | <a href="admin.php">Admin</a>
	<div style="clear: both;"></div>
	<div class="container">
	<h2>Keep Track of Your Services!</h2>
	<p><input type="checkbox" name="sid" checked="checked" /> Service ID <input type="checkbox" name="name" checked="checked" /> Service Name <input type="checkbox" name="provider"  checked="checked" /> Provider <input type="checkbox" name="datacenter" checked="checked" /> Datacenter <input type="checkbox" name="location" checked="checked" /> Location <input type="checkbox" name="cost" /> Cost <input type="checkbox" name="cycle" /> Billing Cycle <input type="checkbox" name="start" /> Start Date <input type="checkbox" name="due" checked="checked" /> Due Date<br />
	<input type="checkbox" name="ram" /> RAM <input type="checkbox" name="swap" /> SWAP <input type="checkbox" name="cpu" /> CPU Info <input type="checkbox" name="bw" /> Bandwidth <input type="checkbox" name="port" /> Port Speed <input type="checkbox" name="disk" /> Disk Space <input type="checkbox" name="disktype" /> Disk Type <input type="checkbox" name="ipv4" /> IPv4 Addresses <input type="checkbox" name="ipv6" /> IPv6 Addresses <input type="checkbox" name="notes" /> Notes <input type="checkbox" name="added" /> Added <input type="checkbox" name="updated"/> Updated</p>
	<table id="invtable">
	<tr>
	<th class="sid">Server ID</th>
	<th class="name">Name</th>
	<th class="provider">Provider</th>
	<th class="datacenter">Datacenter</th>
	<th class="location">Location</th>
	<th class="cost">Cost</th>
	<th class="cycle">Billing Cycle</th>
	<th class="start">Start Date</th>
	<th class="due">Due Date</th>
	<th class="ram">RAM</th>
	<th class="swap">SWAP</th>
	<th class="cpu">CPU Info</th>
	<th class="bw">Bandwidth</th>
	<th class="port">Port Speed</th>
	<th class="disk">Disk Space</th>
	<th class="disktype">Disk Type</th>
	<th class="ipv4">IPv4 Addresses</th>
	<th class="ipv6">IPv6 Addresses</th>
	<th class="notes">Notes</th>
	<th class="added">Added</th>
	<th class="updated">Updated</th></tr>
<?php
$db = new SQLite3('ktoys.db3');
$result = $db->query('SELECT * FROM services') or die('Query failed');
while ($row = $result->fetchArray()) {
	#echo "<tr><td>".var_dump($row)."</td></tr>"; //Debugging
	echo "	<tr><td class=\"sid\"><a href=\"view.php?id={$row['sid']}\">{$row['sid']}</a></td>
			<td class=\"name\">{$row['name']}</td>
			<td class=\"provider\">{$row['provider']}</td>
			<td class=\"datacenter\">{$row['datacenter']}</td>
			<td class=\"location\">{$row['city']}, {$row['state']}, {$row['country']}</td>
			<td class=\"cost\">{$row['cost']}</td>
			<td class=\"cycle\">{$row['cycle']}</td>
			<td class=\"start\">{$row['start']}</td>";
			if(date("n", strtotime($row['due'])) != date("n") OR date("Y", strtotime($row['due'])) != date("Y")) {
				echo "<td class=\"due\">{$row['due']}</td>";
			} else {
				echo "<td class=\"due\" style=\"background:yellow;\">{$row['due']}</td>";
			}			
	echo "	<td class=\"ram\">{$row['ram']}</td>
			<td class=\"swap\">{$row['swap']}</td>
			<td class=\"cpu\">{$row['cpu']} @ {$row['cpuclock']} (x{$row['cpunum']})</td>
			<td class=\"bw\">{$row['bw']}</td>
			<td class=\"port\">{$row['port']}</td>
			<td class=\"disk\">{$row['disk']}</td>
			<td class=\"disktype\">{$row['disktype']}</td>
			<td class=\"ipv4\">{$row['ipv4']}</td>
			<td class=\"ipv6\">{$row['ipv6']}</td>
			<td class=\"notes\">{$row['notes']}</td>
			<td class=\"added\">{$row['added']}</td>
			<td class=\"updated\">{$row['updated']}</td>
			</tr>";
}
?>
	</table>
	</div>
	<div style="clear: both;"></div>
	<br /><br />
	<a href="https://github.com/KuJoe/KToYS" target="_blank">By KuJoe</a>
</body>
</html>
<?php include('job.php'); ?>