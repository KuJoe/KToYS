Simple PHP and SQLite3 script for **K**eeping **T**rack **o**f **Y**our hosting, VPS, and dedicated **S**ervices.<br />
Version 1.1 by KuJoe (JMD.cc)<br />

1.1 - Fixed bug where SQLite3 database was being held open preventing updating from view.php

//Requirements:<br />
PHP5 and SQLite3 support (might work with over versions but I've only used the script PHP 5.4 with SQLite3 support)

//Installation:<br />
1) Upload the the PHP and CSS files to a web accessible directory.<br />
2) Navigate to the install.php file in your browser.

//Recommended:<br />
******At this time there is no password authentication or anything preventing somebody else from using this script on your website and altering your database. Please do one of the following.******<br />
A) Use mod_auth on Apache or some other method of password protecting the directory.<br />
OR<br />
B) Put this in a random directory that only you know about.