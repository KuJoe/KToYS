<?php
/**
Simple PHP and SQLite3 script for keeping track of your hosting, VPS, and dedicated services.
Version 1.0 by KuJoe (JMD.cc)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
**/

function sqlite_escape_string($string){
    return SQLite3::escapeString($string);
}

function dbinsert($name, $provider, $city, $state, $country, $datacenter, $cost, $cycle, $start, $due, $ram, $swap, $cpu, $cpunum, $cpuclock, $bw, $port, $disk, $disktype, $ipv4, $ipv6, $notes) {
	$required_fields = array('name', 'provider', 'city', 'state', 'country', 'datacenter', 'cost', 'cycle', 'start', 'due', 'ram', 'swap', 'cpu', 'cpunum', 'cpuclock', 'bw', 'port', 'disk', 'disktype', 'ipv4', 'ipv6', 'notes');
	$valid = true;
	foreach ($required_fields as $f) {
		if (!isset($f)) {
			$valid = false;
		}
	}
	if($valid) {
		$name = sqlite_escape_string($name);
		$provider = sqlite_escape_string($provider);
		$city = sqlite_escape_string($city);
		$state = sqlite_escape_string($state);
		$country = sqlite_escape_string($country);
		$datacenter = sqlite_escape_string($datacenter);
		$cost = sqlite_escape_string($cost);
		$cycle = sqlite_escape_string($cycle);
		$start = sqlite_escape_string($start);
		$due = sqlite_escape_string($due);
		$ram = sqlite_escape_string($ram);
		$swap = sqlite_escape_string($swap);
		$cpu = sqlite_escape_string($cpu);
		$cpunum = sqlite_escape_string($cpunum);
		$cpuclock = sqlite_escape_string($cpuclock);
		$bw = sqlite_escape_string($bw);
		$port = sqlite_escape_string($port);
		$disk = sqlite_escape_string($disk);
		$disktype = sqlite_escape_string($disktype);
		$ipv4 = sqlite_escape_string($ipv4);
		$ipv6 = sqlite_escape_string($ipv6);
		$notes = sqlite_escape_string($notes);
		$db = new SQLite3('ktoys.db3');
		$db->exec("INSERT INTO services (name, provider, city, state, country, datacenter, cost, cycle, start, due, ram, swap, cpu, cpunum, cpuclock, bw, port, disk, disktype, ipv4, ipv6, notes) VALUES ('$name', '$provider', '$city', '$state', '$country', '$datacenter', '$cost', '$cycle', '$start', '$due', '$ram', '$swap', '$cpu', '$cpunum', '$cpuclock', '$bw', '$port', '$disk', '$disktype', '$ipv4', '$ipv6', '$notes')");
		return true;
	} else {
		return false;
	}
}

function dbupdate($name, $provider, $city, $state, $country, $datacenter, $cost, $cycle, $start, $due, $ram, $swap, $cpu, $cpunum, $cpuclock, $bw, $port, $disk, $disktype, $ipv4, $ipv6, $notes, $sid) {
	$required_fields = array('name', 'provider', 'city', 'state', 'country', 'datacenter', 'cost', 'cycle', 'start', 'due', 'ram', 'swap', 'cpu', 'cpunum', 'cpuclock', 'bw', 'port', 'disk', 'disktype', 'ipv4', 'ipv6', 'notes', 'sid');
	$valid = true;
	foreach ($required_fields as $f) {
		if (!isset($f)) {
			$valid = false;
		}
	}
	if($valid) {
		$name = sqlite_escape_string($name);
		$provider = sqlite_escape_string($provider);
		$city = sqlite_escape_string($city);
		$state = sqlite_escape_string($state);
		$country = sqlite_escape_string($country);
		$datacenter = sqlite_escape_string($datacenter);
		$cost = sqlite_escape_string($cost);
		$cycle = sqlite_escape_string($cycle);
		$start = sqlite_escape_string($start);
		$due = sqlite_escape_string($due);
		$ram = sqlite_escape_string($ram);
		$swap = sqlite_escape_string($swap);
		$cpu = sqlite_escape_string($cpu);
		$cpunum = sqlite_escape_string($cpunum);
		$cpuclock = sqlite_escape_string($cpuclock);
		$bw = sqlite_escape_string($bw);
		$port = sqlite_escape_string($port);
		$disk = sqlite_escape_string($disk);
		$disktype = sqlite_escape_string($disktype);
		$ipv4 = sqlite_escape_string($ipv4);
		$ipv6 = sqlite_escape_string($ipv6);
		$notes = sqlite_escape_string($notes);
		$db = new SQLite3('ktoys.db3');
		$db->exec("UPDATE services SET name = '$name', provider = '$provider', city = '$city', state = '$state', country = '$country', datacenter = '$datacenter', cost = '$cost', cycle = '$cycle', start = '$start', due = '$due', ram = '$ram', swap = '$swap', cpu = '$cpu', cpunum = '$cpunum', cpuclock = '$cpuclock', bw = '$bw', port = '$port', disk = '$disk', disktype = '$disktype', ipv4 = '$ipv4', ipv6 = '$ipv6', notes = '$notes' WHERE sid = '$sid'");
		return true;
	} else {
		return false;
	}
}

function dbdel($sid) {
		$db = new SQLite3('ktoys.db3');
		$db->exec("DELETE FROM services WHERE sid='$sid'");
		return true;
}

function getLatency($server) {
	require('Ping.php');
	$ping = new Ping($server);
	$latency = $ping->ping();
	return $latency;
}

?>