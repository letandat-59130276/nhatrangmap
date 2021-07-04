<?php
$errors = [];
$data = [];

require "../configs/connection.php";

$email = $_POST['email'];
$sql = "DELETE FROM users WHERE email = $1";
pg_query_params($conn, $sql, array($email));
$data['success'] = true;
$data['errors'] = false;

echo json_encode($data);
