<?php

    $database= new mysqli("localhost","root","","klinika");
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }

?>