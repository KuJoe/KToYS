<?php
/**
Simple PHP and SQLite3 script for keeping track of your hosting, VPS, and dedicated services.
Version 1.0 by KuJoe (JMD.cc)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
**/

if (file_exists('INSTALL.LOCK')) {
    die('Looks like you already ran the install once. If the install ran successfully delete the install.php file, if not delete the INSTALL.LOCK file and re-run the install.');
} else {
	try {
		//Create the database
		$db = new SQLite3('ktoys.db3');
		echo "Database has been created.<br />";
		//Create the services table
		$db->exec('CREATE TABLE services (sid INTEGER PRIMARY KEY, name VARCHAR(255), provider VARCHAR(255), city VARCHAR(255), state VARCHAR(255), country VARCHAR(255), datacenter VARCHAR(255), cost VARCHAR(11), cycle VARCHAR(255), start DATETIME, due TIMESTAMP, ram VARCHAR(255), swap VARCHAR(255), cpu VARCHAR(255), cpunum INTEGER, cpuclock VARCHAR(11), bw VARCHAR(255), port VARCHAR(255), disk VARCHAR(255), disktype VARCHAR(255), ipv4 TEXT, ipv6 TEXT, notes TEXT, added DATETIME DEFAULT CURRENT_TIMESTAMP, updated DATETIME DEFAULT CURRENT_TIMESTAMP)');
		$db->exec("CREATE TRIGGER update_time AFTER UPDATE ON services
		BEGIN 
			update services SET updated = datetime('now') WHERE sid = NEW.sid;
		END;");
		echo "Table services has been created.<br />";
		//Close database connection and lock install
		$db = NULL;
		fopen("INSTALL.LOCK", "w");
		if (file_exists('INSTALL.LOCK')) {
			echo "INSTALL.LOCK created successfully.<br />(This prevents the install from running again.)";	
		} else {
			echo "INSTALL.LOCK creation failed.<br />(Either create a blank one in the same directory as install.php or delete install.php)";
		}
		echo '<br /><br />Install completed. <a href="index.php">THIS PAGE SHOULD WORK NOW.</a>';
	}
	catch(PDOException $e) {
		print 'Exception : '.$e->getMessage();
	}
}
?>