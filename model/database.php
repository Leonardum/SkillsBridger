<?php

$host = 'localhost';
$username = 'skilwnwi_user';
$databasePassword = 'a6da5502c6ba818c4e053bed193d47b9';
$database = 'skilwnwi_skillsbridger';

$db = new mysqli($host,$username,$databasePassword,$database);

$error_message = $db->connect_error;
if ($error_message != NULL) {
    include 'errors/db_error_connect.php';
    exit();
}

function display_db_error($error_message) {
    global $app_path;
    include 'errors/db_error.php';
    exit();
}

?>