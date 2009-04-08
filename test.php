<?php

$dbHost = 'localhost';
$dbName = 'inflections';
$dbUser = 'root';
$dbPass = 'password';

$db = mysql_connect($dbHost, $dbUser, $dbPass);
mysql_select_db($dbName, $db);

require_once 'Classes/inflections.php';
echo Inflection::Inflect('Аня', Inflection::P_DAVATELNY);

?>