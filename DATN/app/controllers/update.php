<?php
$errors = [];
$data = [];


require "../configs/connection.php";
session_start();
$id = $_POST['id'];
$email = $_POST['email'];
$first = $_POST['first'];
$last = $_POST['last'];
$role = $_POST['role'];


if (empty($email) || empty($first) || empty($last)) {
    $errors['empty_field'] = 'Vui lòng nhập đầy đủ các trường.';
    $data['errors'] = $errors;
} else {
    $sql = "UPDATE users SET email = $1, first = $2, last = $3, role = $4 WHERE id = $5";
    pg_query_params($conn, $sql, array($email, $first, $last, $role, $id));
    $data['success'] = true;
    $data['errors'] = false;
}
echo json_encode($data);
