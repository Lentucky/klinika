<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $database= new mysqli("localhost","root","","klinika");
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }

?>