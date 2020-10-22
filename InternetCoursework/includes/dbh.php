<?php

//Initialises the Conection to the database
$dbServer = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "filo";

// $dbServer = "localhost";
// $dbUsername = "u-180125940";
// $dbPassword = "xXwQUBaMS0DCvSn";
// $dbName = "u_180125940_db";

$connect = mysqli_connect($dbServer, $dbUsername, $dbPassword, $dbName);
