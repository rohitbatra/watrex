<?php

$database = "SAMPLE";
$user = "db2admin";
$password = "admin123";

$conn = db2_connect($database, $user, $password);

if ($conn) {
    echo "Connection succeeded.";
    db2_close($conn);
}
else {
    echo "Connection failed.";
}

die();