<?php
/**
Simple PHP and SQLite3 script for keeping track of your hosting, VPS, and dedicated services.
By KuJoe (JMD.cc)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
**/

function sqlite_escape_string($string)
{
    $string = SQLite3::escapeString($string);
    $string = filter_var($string, FILTER_SANITIZE_STRING);
    return $string;
}

function dbinsert($data)
{
    $required_fields = [
        'name',
        'provider',
        'city',
        'state',
        'country',
        'datacenter',
        'cost',
        'cycle',
        'start',
        'due',
        'ram',
        'swap',
        'cpu',
        'cpunum',
        'cpuclock',
        'bw',
        'port',
        'disk',
        'disktype',
        'ipv4',
        'ipv6',
        'notes',
        'services'
    ];
    $data = array_combine($required_fields, $data);

    $valid = true;
    foreach ($required_fields as $f) {
        if (empty($data[$f])) {
            $valid = false;
        }
    }
    if ($valid) {
        array_walk($data, 'sqlite_escape_string');

        $db = new SQLite3('ktoys.db3');
        $stmt = $db->prepare("INSERT INTO services
            (name, provider, city, state, country, datacenter, cost, cycle,
            start, due, ram, swap, cpu, cpunum, cpuclock, bw, port, disk,
            disktype, ipv4, ipv6, notes, services)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $index = 1;
        foreach ($data as $item) {
            $stmt->bindValue($index, $item, SQLITE3_TEXT);
            $index++;
        }
        $stmt->execute();

        return true;
    } else {
        return false;
    }
}

function srvimport($data)
{
    $required_fields = [
        'name',
        'provider',
        'city',
        'state',
        'country',
        'datacenter',
        'cost',
        'cycle',
        'start',
        'due',
        'bw',
        'port',
        'disktype'
    ];
    $data = array_combine($required_fields, $data);

    $valid = true;
    foreach ($required_fields as $f) {
        if (empty($data[$f])) {
            $valid = false;
        }
    }

    if ($valid) {
        array_walk($data, 'sqlite_escape_string');

        $db = new SQLite3('ktoys.db3');
        $stmt = $db->prepare("INSERT INTO services
            (name, provider, city, state, country, datacenter, cost, cycle,
            start, due, bw, port, disktype)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $index = 1;
        foreach ($data as $item) {
            $stmt->bindValue($index, $item, SQLITE3_TEXT);
            $index++;
        }
        $stmt->execute();

        return true;
    } else {
        return false;
    }
}

function dbupdate($data)
{
    $required_fields = [
        'name',
        'provider',
        'city',
        'state',
        'country',
        'datacenter',
        'cost',
        'cycle',
        'start',
        'due',
        'ram',
        'swap',
        'cpu',
        'cpunum',
        'cpuclock',
        'bw',
        'port',
        'disk',
        'disktype',
        'ipv4',
        'ipv6',
        'notes',
        'services',
        'sid'
    ];
    $data = array_combine($required_fields, $data);

    $valid = true;
    foreach ($required_fields as $f) {
        if (empty($data[$f])) {
            $valid = false;
        }
    }
    if ($valid) {
        array_walk($data, 'sqlite_escape_string');

        $db = new SQLite3('ktoys.db3');
        $stmt = $db->prepare("UPDATE services SET name = ?, provider = ?, city = ?,
            state = ?, country = ?, datacenter = ?, cost = ?, cycle = ?,
            start = ?, due = ?, ram = ?, swap = ?, cpu = ?, cpunum = ?,
            cpuclock = ?, bw = ?, port = ?, disk = ?, disktype = ?, ipv4 = ?,
            ipv6 = ?, notes = ?, services = ? WHERE sid = ?");

        $index = 1;
        foreach ($data as $key => $value) {
            if ($key === 'sid') {
                $stmt->bindValue($index, (int) $value, SQLITE3_INTEGER);
            } else {
                $stmt->bindValue($index, $value, SQLITE3_TEXT);
            }
            $index++;
        }

        $stmt->execute();

        return true;
    } else {
        return false;
    }
}

function srvspecsimp($data)
{
    $required_fields = [
        'ram',
        'swap',
        'cpu',
        'cpunum',
        'cpuclock',
        'disk',
        'ipv4',
        'ipv6',
        'sid'
    ];
    array_combine($required_fields, $data);

    $valid = true;
    foreach ($required_fields as $f) {
        if (empty($data[$f])) {
            $valid = false;
        }
    }

    if ($valid) {
        array_walk($data, 'sqlite_escape_string');
        $db = new SQLite3('ktoys.db3');
        $stmt = $db->prepare("UPDATE services SET ram = ?, swap = ?, cpu = ?,
            cpunum = ?, cpuclock = ?, disk = ?, ipv4 = ?, ipv6 = ?
            WHERE sid = ?");
        $index = 1;
        foreach ($data as $key => $value) {
            if ($key !== 'sid') {
                $stmt->bindValue($index, $value, SQLITE3_TEXT);
            } else {
                $stmt->bindValue($index, (int) $value, SQLITE3_INTEGER);
            }
            $index++;
        }
        $stmt->execute();

        return true;
    } else {
        return false;
    }
}

function dbdel($sid)
{
    $sid = sqlite_escape_string($sid);
    $db = new SQLite3('ktoys.db3');

    $stmt = $db->prepare("DELETE FROM services WHERE sid = ?");
    $stmt->bindValue(1, (int) $sid, SQLITE3_INTEGER);
    $stmt->execute();
    return true;
}

function chkDueDate($sid)
{
    $sid = sqlite_escape_string($sid);
    $db = new SQLite3('ktoys.db3');

    $stmt = $db->prepare("SELECT * FROM services WHERE sid = ? LIMIT 1");
    $stmt->bindValue(1, (int) $sid, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $result = $result->fetchArray();

    if (empty($result["due"]) || $result["due"] == '00/00/0000') {
        return;
    } else {
        $cycle = $result["cycle"];
        $duedate = date('Y-m-d', strtotime($result["due"]));
        $date = new DateTime($duedate);
        $now = new DateTime();
        $db->close(); // Why close when we're going to use it right after this anyway?
        if ($date < $now) {
            if ($cycle == 'Monthly') {
                $newdue = date('m/d/Y', strtotime("$duedate + 1 month"));
            } elseif ($cycle == 'Quarterly') {
                $newdue = date('m/d/Y', strtotime("$duedate + 3 months"));
            } elseif ($cycle == 'Semiannually') {
                $newdue = date('m/d/Y', strtotime("$duedate + 6 months"));
            } elseif ($cycle == 'Annually') {
                $newdue = date('m/d/Y', strtotime("$duedate + 1 years"));
            } elseif ($cycle == 'Biennially') {
                $newdue = date('m/d/Y', strtotime("$duedate + 2 years"));
            } elseif ($cycle == 'Triennially') {
                $newdue = date('m/d/Y', strtotime("$duedate + 3 years"));
            } else {
                $newdue = '00/00/0000';
            }
            $db = new SQLite3('ktoys.db3');

            $stmt = $db->prepare("UPDATE services SET due = ? WHERE sid = ?");
            $stmt->bindValue(1, $newdue, SQLITE3_TEXT);
            $stmt->bindValue(2, (int) $sid, SQLITE3_INTEGER);
            $stmt->execute();

            $db->close();
        }
    }
}
