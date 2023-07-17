
<?php

$type = "mysql";
$server = "localhost";
$db = "newhikingrver";
$port = "";
$charset = "utf8mb4";

$username = "Ed";
$password = "RE63@fi13";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$dsn = "$type:host=$server;dbname=$db;port=$port;charset=$charset";

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    echo "Connected to the New Hiking RVer database";
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), $e->getCode());
}

?>



