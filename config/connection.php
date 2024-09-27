<?php
require 'constants.php';

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $database= new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }

?>
