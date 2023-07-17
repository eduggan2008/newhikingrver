<?php

define("DEV", true);
define("DOC_ROOT", '/newhikingrver/public/');
define("ROOT_FOLDER", 'public');
define('DOMAIN', 'http://localhost:3306');  // Domain (used to create links in emails)


$type = "mysql";
$server = "localhost";
$db = "newhikingrver";
$port = "";
$charset = "utf8mb4";

$username = "Ed";
$password = "RE63@fi13";

$dsn = "$type:host=$server;dbname=$db;port=$port;charset=$charset";

define("UPLOADS", dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . ROOT_FOLDER . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR);
define("MEDIA_TYPES", ['image/jpeg', 'image/png', 'image/gif']);
define("FILE_EXTENSIONS", ['jpeg', 'jpg', 'png', 'gif']);
define("MAX_SIZE", '5242880');





