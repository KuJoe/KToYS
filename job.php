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
require('functions.php');
$db = new SQLite3('ktoys.db3');
$result = $db->query('SELECT * FROM services') or die('Query failed');
$arr = array();
while ($row = $result->fetchArray()) {
	$arr[] = $row['sid'];
}
$db->close();
foreach ($arr as $value) {
    chkDueDate($value);
}
echo "Completed";
?>