<?php

$servername = "localhost";
$dbusername = "postgres";
$dbpassword = "";
$dbname = "abc";

$conn = pg_connect("host=localhost user=postgres dbname=CSDL password=admin");
if (!$conn) {
    echo "An error occurred.\n";
    exit;
  }