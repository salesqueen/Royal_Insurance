<?php

    error_reporting(0);
    
    //Database parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name="royal_insurance";
    // Create connection
    $connection = new mysqli($servername, $username, $password,$db_name);
    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
?>