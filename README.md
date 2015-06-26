Simple PHP and SQLite3 script for **K**eeping **T**rack **o**f **Y**our hosting, VPS, and dedicated **S**ervices.<br />
Version 1.6 by KuJoe (JMD.cc)<br />

1.1 - Fixed bug where SQLite3 database was being held open preventing updating from view.php<br />
<br />
1.2 - Some security fixes in case somebody leaves this in a public directory or doesn't know what HTML is.<br />
<br />
1.3 - Viewing the index.php page automatically checks and updates the Due Date for each service (I apologize ahead of time for those order services on the 29th, 30th, or 31st of a month and my logic doesn't work properly for you).<br />
      Adjusted the default checked boxes on index.php to show the Due Date column and remove the Added and Updated columns.<br />
	  The Due Date cell is highlighted yellow if the due date is this month.<br />
<br />
1.4 - Added new field for services (i.e. HTTP, DNS, MySQL, SSH, etc...) as requested by Cronus89.<br />
<br />
1.5 - Added the ability to retrieve data using JSON (contributed by GIANTCRAB).<br />
<br />
1.6 - Added an import feature to make it easier to add and update services (see additional info below).<br />
      Code clean up by GIANTCRAB.<br />
<br />

//Demo<br />
Demo: http://iam.clouded.us/ktoys/index.php

//Requirements:<br />
PHP5 and SQLite3 support (might work with over versions but I've only used the script PHP 5.4 with SQLite3 support)

//Installation:<br />
1) Upload the the PHP and CSS files to a browser accessible directory.<br />
2) Navigate to the install.php file in your browser.

//Upgrading:<br />
1) Overwrite the current PHP files in the directory (install.php is not needed).
2) If there is an associated upgrade file (i.e. upgrade_1_4.php would be for version 1.4) then delete the INSTALL.LOCK file and run that upgrade file. If there is more than one upgrade file make sure to run them in order and delete the INSTALL.LOCK file between upgrades.

//Recommended:<br />
******At this time there is no password authentication or anything preventing somebody else from using this script on your website and altering your database. Please do one of the following.******<br />
A) Use mod_auth on Apache or some other method of password protecting the directory.<br />
OR<br />
B) Put this in a random directory that only you know about.

//Known Bugs:<br />
1) Invoices due on the 29th, 30th, or 31st will update to the incorrect date if the following month does not have that many days in it. I tried some workarounds I found online but in the end I gave up so for a few months a year you might have to manually adjust your due date.

//Importing:<br />
To import a new service without manually filling out the fields, you can generate a comma separated string like this (most of this data can be pulled off a single page from WHMCS) to input at the bottom of the Admin page:<br />
name,provider,city,state,country,datacenter,cost,billing_cycle,start_date,due_date,bandwidth,port_speed,disk_type<br />
If you do not know a value or there is no value leave a blank space between the commas (you must have 12 commas for this to work).<br /><br />
Some values are from a list and using other values will break something somewhere so here are those values:<br />
billing_cycle = Hourly, Daily, Weekly, Monthly, Bimonthly, Quarterly, Semiannually, Annually, Biennially, Triennially, Other<br />
disk_type = SATA, SAS, SSD, SAN, Other, Unknown<br /><br />
Date specific values (start_date & due_date) must be in MM/DD/YYYY format or it will break something somewhere.<br />
<br />
Once you have the service added, you can import the service specs by generating a comma separated string provided by the export.sh script included.<br />
Copy the export.sh script to your service and run it (sh export.sh), then copy and paste the output into the "Import Service Specs" input on the View page of that service.<br />
The export might not be perfect, so you can edit or create you own using this template:<br />
ram,swap,cpu,number_of_cpus,cpu_clock_speed,disk_space,ipv4_addresses,ipv6_addresses<br />
If you do not know a value or there is no value leave a blank space between the commas (you must have 7 commas for this to work).<br />
Here is an example of the output from the script:<br />
128,128,Intel(R) Xeon(R) CPU E5-2630 v3 @ 2.40GHz,1,2400MHz,2,11.22.33.44 ,1111:2222:3333:4444::beef/128