<?php
$host = "localhost";
$dbname = "mnarch2v_store2";
$username = "mnarch2v_store2";
$password = "a61Yur*Y";

$mysqli = new mysqli(
    hostname: $host,
    username: $username,
    password: $password,
    database: $dbname
);

if ($mysqli->connect_errno) {
    die("Connection error {$mysqli->connect_error}");
}

return $mysqli;