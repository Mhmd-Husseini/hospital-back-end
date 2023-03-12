<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization');

$host = "localhost";
$db_user = "root";
$db_pass = null;
$db_name = "hospital_db";

$mysqli = new mysqli($host, $db_user, $db_pass, $db_name);
?>