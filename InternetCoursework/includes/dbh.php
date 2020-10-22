<?php

//Initialises the Conection to the database
$dbServer = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "filo";

$connect = mysqli_connect($dbServer, $dbUsername, $dbPassword, $dbName);
