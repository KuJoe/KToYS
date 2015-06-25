<?php
/**
Simple PHP and SQLite3 script for keeping track of your hosting, VPS, and dedicated services.
By KuJoe (JMD.cc)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
**/

if (file_exists('INSTALL.LOCK')) {
    die('Please delete the the INSTALL.LOCK file and re-run this upgrade file.');
} else {
	try {
		$db = new SQLite3('ktoys.db3');
		// Database update for version 1.4
		$db->exec('ALTER TABLE services ADD COLUMN services TEXT');
		echo "Services column added per version 1.4<br />";

		$db = NULL;
		fopen("INSTALL.LOCK", "w");
		if (file_exists('INSTALL.LOCK')) {
			echo "INSTALL.LOCK created successfully.<br />(This prevents the install/upgrade from running again.)";	
		} else {
			echo "INSTALL.LOCK creation failed.<br />(Either create a blank one in the same directory as install.php or delete all install & upgrade files.)";
		}
		echo '<br /><br />Upgrade for version 1.4 completed.';
	}
	catch(PDOException $e) {
		print 'Exception : '.$e->getMessage();
	}
}
?>