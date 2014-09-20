<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'choice');
define('DB_PASSWORD', 'choice_123');
define('DB_DATABASE', 'choice');
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
$database = mysql_select_db(DB_DATABASE) or die(mysql_error());
?>
