<?php
/**
Simple PHP and SQLite3 script for keeping track of your hosting, VPS, and dedicated services.
By KuJoe (JMD.cc)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
**/

function sqlite_escape_string($string){
    $string = SQLite3::escapeString($string);
	$string = filter_var($string, FILTER_SANITIZE_STRING);
	return $string;
}

function dbinsert($name, $provider, $city, $state, $country, $datacenter, $cost, $cycle, $start, $due, $ram, $swap, $cpu, $cpunum, $cpuclock, $bw, $port, $disk, $disktype, $ipv4, $ipv6, $notes, $services) {
	$required_fields = array('name', 'provider', 'city', 'state', 'country', 'datacenter', 'cost', 'cycle', 'start', 'due', 'ram', 'swap', 'cpu', 'cpunum', 'cpuclock', 'bw', 'port', 'disk', 'disktype', 'ipv4', 'ipv6', 'notes', 'services');
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
		$services = sqlite_escape_string($services);
		$db = new SQLite3('ktoys.db3');
		$db->exec("INSERT INTO services (name, provider, city, state, country, datacenter, cost, cycle, start, due, ram, swap, cpu, cpunum, cpuclock, bw, port, disk, disktype, ipv4, ipv6, notes, services) VALUES ('$name', '$provider', '$city', '$state', '$country', '$datacenter', '$cost', '$cycle', '$start', '$due', '$ram', '$swap', '$cpu', '$cpunum', '$cpuclock', '$bw', '$port', '$disk', '$disktype', '$ipv4', '$ipv6', '$notes', '$services')");
		return true;
	} else {
		return false;
	}
}

function srvimport($name, $provider, $city, $state, $country, $datacenter, $cost, $cycle, $start, $due, $bw, $port, $disktype) {
	$required_fields = array('name', 'provider', 'city', 'state', 'country', 'datacenter', 'cost', 'cycle', 'start', 'due', 'bw', 'port', 'disktype');
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
		$bw = sqlite_escape_string($bw);
		$port = sqlite_escape_string($port);
		$disktype = sqlite_escape_string($disktype);
		$db = new SQLite3('ktoys.db3');
		$db->exec("INSERT INTO services (name, provider, city, state, country, datacenter, cost, cycle, start, due, bw, port, disktype) VALUES ('$name', '$provider', '$city', '$state', '$country', '$datacenter', '$cost', '$cycle', '$start', '$due', '$bw', '$port', '$disktype')");
		return true;
	} else {
		return false;
	}
}

function dbupdate($name, $provider, $city, $state, $country, $datacenter, $cost, $cycle, $start, $due, $ram, $swap, $cpu, $cpunum, $cpuclock, $bw, $port, $disk, $disktype, $ipv4, $ipv6, $notes, $services, $sid) {
	$required_fields = array('name', 'provider', 'city', 'state', 'country', 'datacenter', 'cost', 'cycle', 'start', 'due', 'ram', 'swap', 'cpu', 'cpunum', 'cpuclock', 'bw', 'port', 'disk', 'disktype', 'ipv4', 'ipv6', 'notes', 'services', 'sid');
	$valid = true;
	foreach ($required_fields as $f) {
		if (!isset($f)) {
			$valid = false;
		}
	}
	if($valid) {
		$sid = sqlite_escape_string($sid);
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
		$services = sqlite_escape_string($services);
		$db = new SQLite3('ktoys.db3');
		$db->exec("UPDATE services SET name = '$name', provider = '$provider', city = '$city', state = '$state', country = '$country', datacenter = '$datacenter', cost = '$cost', cycle = '$cycle', start = '$start', due = '$due', ram = '$ram', swap = '$swap', cpu = '$cpu', cpunum = '$cpunum', cpuclock = '$cpuclock', bw = '$bw', port = '$port', disk = '$disk', disktype = '$disktype', ipv4 = '$ipv4', ipv6 = '$ipv6', notes = '$notes', services = '$services' WHERE sid = '$sid'");
		return true;
	} else {
		return false;
	}
}

function srvspecsimp($ram,$swap,$cpu,$cpunum,$cpuclock,$disk,$ipv4,$ipv6,$sid) {
	$required_fields = array('ram', 'swap', 'cpu', 'cpunum', 'cpuclock', 'disk', 'ipv4', 'ipv6', 'sid');
	$valid = true;
	foreach ($required_fields as $f) {
		if (!isset($f)) {
			$valid = false;
		}
	}
	if($valid) {
		$sid = sqlite_escape_string($sid);
		$ram = sqlite_escape_string($ram);
		$swap = sqlite_escape_string($swap);
		$cpu = sqlite_escape_string($cpu);
		$cpunum = sqlite_escape_string($cpunum);
		$cpuclock = sqlite_escape_string($cpuclock);
		$disk = sqlite_escape_string($disk);
		$ipv4 = sqlite_escape_string($ipv4);
		$ipv6 = sqlite_escape_string($ipv6);
		$db = new SQLite3('ktoys.db3');
		$db->exec("UPDATE services SET ram = '$ram', swap = '$swap', cpu = '$cpu', cpunum = '$cpunum', cpuclock = '$cpuclock', disk = '$disk', ipv4 = '$ipv4', ipv6 = '$ipv6' WHERE sid = '$sid'");
		return true;
	} else {
		return false;
	}
}

function dbdel($sid) {
	$sid = sqlite_escape_string($sid);
	$db = new SQLite3('ktoys.db3');
	$db->exec("DELETE FROM services WHERE sid='$sid'");
	return true;
}

function chkDueDate($sid) {
	$sid = sqlite_escape_string($sid);
	$db = new SQLite3('ktoys.db3');
	$result = $db->querySingle('SELECT * FROM services WHERE sid='.$sid.' LIMIT 1', true);
	if(empty($result["due"]) OR $result["due"] == '00/00/0000') {
		return;
	} else {
		$cycle = $result["cycle"];
		$duedate = date('Y-m-d', strtotime($result["due"]));
		$date = new DateTime($duedate);
		$now = new DateTime();
		$db->close();
		if($date < $now) {
			if($cycle == 'Monthly') {
				$newdue = date('m/d/Y',strtotime("$duedate + 1 month"));
			} elseif($cycle == 'Quarterly') {
				$newdue = date('m/d/Y',strtotime("$duedate + 3 months"));
			} elseif($cycle == 'Semiannually') {
				$newdue = date('m/d/Y',strtotime("$duedate + 6 months"));
			} elseif($cycle == 'Annually') {
				$newdue = date('m/d/Y',strtotime("$duedate + 1 years"));
			} elseif($cycle == 'Biennially') {
				$newdue = date('m/d/Y',strtotime("$duedate + 2 years"));
			} elseif($cycle == 'Triennially') {
				$newdue = date('m/d/Y',strtotime("$duedate + 3 years"));
			} else {
				$newdue = '00/00/0000';
			}
			$db = new SQLite3('ktoys.db3');
			$db->exec("UPDATE services SET due = '$newdue' WHERE sid = '$sid'");
			$db->close();
		}
	}
}

?>