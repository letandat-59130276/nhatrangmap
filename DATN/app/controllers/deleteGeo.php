<?php
require "../configs/connection.php";
session_start();
$req = $_POST['req'];
pg_query_params($conn, 'DELETE from nt_diem where id = $1', array($req));
