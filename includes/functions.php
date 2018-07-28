<?php
error_reporting(0);
ini_set('display_errors', '1');
ob_start();
ini_set('max_execution_time', 12000);


// Constants File Loaded
require_once("constants.php");

// Initialize MySQL Database Engine
require_once("class.Mysqli.php");

// Set Timezone & Base Directory
date_default_timezone_set(AppParams::SERVER_TIMEZONE);
set_include_path(AppParams::BASE_DIR);

