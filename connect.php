<?php

$DB_Name = 'a1966630_db';
$DB_User = 'a1966630_admin';
$DB_Password = '5UhcecDExMwOcDZR';
$DB_Host = 'mysql1.000webhost.com';

#$link = mysql_connect($DB_Host, $DB_User, $DB_Password);
$link = mysql_connect("localhost", "root", "");

if(!$link)
{
    exit('Error: could not establish database connection');
}
if(!mysql_select_db($DB_Name))
{
    exit('Error: could not select the database');
}
?>