<?php
//DB details
$dbHost = 'localhost';
$dbUsername = 'alegra6_hemanta';
$dbPassword = 'hmtALS^77';
$dbName = 'alegra6_hemanta';

//Create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Unable to connect database: " . $db->connect_error);
}

// Change character set to utf8
mysqli_set_charset($db,"utf8");
mb_internal_encoding("UTF-8");

$baseUrl = 'http://alegralabs.com/hemanta/quelle-import/';