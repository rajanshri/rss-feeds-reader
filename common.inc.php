<?php

set_time_limit(0);

error_reporting(E_ALL);
//ini_set('default_charset','ISO-8859-15');
//ini_set('default_charset','utf-8');

include "config/path_config.php";
include "config/db_config.php";

include "define/table_define.php";

include "library/database.class.php";
$db = new database();

include "library/functions.class.php";
$func = new functions();

?>