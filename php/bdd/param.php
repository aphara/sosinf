<?php
# test si le script est sur le disque C ou D local
define("DBHOST", "127.0.0.1");
define("DBNAME", "sosinf");
define("DBUSER", "root");
define("DBPASSWD", "");

function dbConnect()
{
    $conn = new mysqli(DBHOST, DBUSER, DBPASSWD, DBNAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

