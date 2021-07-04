<?php
$errors = [];
$data = [];

require "../configs/connection.php";

$url = $_SERVER['HTTP_REFERER'] . "?";
$url = strtok($url, '?');

$email = $_POST['email'];
$first = $_POST['first'];
$last = $_POST['last'];
$password = $_POST['password'];
$cPassword = $_POST['cPassword'];
$role = 0;

if (empty($email) || empty($password) || empty($cPassword) || empty($first) || empty($last)) {
    $errors['empty_field'] = 'Vui lòng nhập đầy đủ các trường.';
    $data['errors'] = $errors;
} else if (!preg_match('/^(.+)@(.+)$/', $email)) {
    $errors['email'] = 'Email không hợp lệ.';
    $data['errors'] = $errors;
} else if ($password !== $cPassword) {
    $errors['cPassword'] = 'Mật khẩu không khớp.';
    $data['errors'] = $errors;
    // header("Location: " . $url . "?error=pwdcheck&email=" . $email);
} else {
    $result = pg_query_params($conn, 'SELECT email FROM users where email = $1', array($email));
    $resultCheck = (pg_fetch_array($result));
    if ($resultCheck > 0) {
        $errors['email'] = 'Email đã tồn tại.';
        $data['errors'] = $errors;
        // header("Location: " . $url . "?error=userTaken&email=" . $email);
    } else {
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
        $sql = pg_query_params($conn, "INSERT INTO users (email, password, role, first, last) VALUES ($1, $2, $3, $4,$5)", array($email, $hashedPwd, $role, $first, $last));

        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;
        $data['success'] = true;
        $data['errors'] = false;
    }
    pg_close($conn);
}


echo json_encode($data);
