<?php

define('APP_ROOT', '/var/www/basicweb/app/');
// echo APP_ROOT;
define('PUBLIC_ROOT', 'http://192.168.153.129/');
// echo PUBLIC_ROOT;
define('URL', 'http://192.168.153.129/');

// File upload
define('UPLOAD_POST', 'images/post/');
define('FILE_MAX_SIZE', 4);

// Database
define('DBHOST', 'localhost');
define('DBUSER', 'tumeow');
define('DBPASS', '{v3ry_s3cr3t}');
define('DBNAME', 'basicweb');

// Start session
session_status() === PHP_SESSION_ACTIVE ?: session_start();

require_once 'App.php';
require_once 'Controller.php';
require_once 'Database.php';
require_once 'Model.php';
require_once 'Redirect.php';
require_once 'Validation.php';
require_once 'Request.php';
require_once 'File.php';