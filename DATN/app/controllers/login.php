<?php
$errors = [];
$data = [];

require "../configs/connection.php";


$url = $_SERVER['HTTP_REFERER'] . "?";
$url = strtok($url, '?');

$email = $_POST['email'];
$password = $_POST['password'];

if (empty($email) || empty($password)) {
    // header("Location: " . $url . "?email=" . $email . "&password=" . $password . "&error=Empty field");
    $errors['empty_field'] = 'Tài khoản hoặc mật khẩu không được bỏ trống.';
    $data['errors'] = $errors;
} else {

    $result = pg_query_params($conn, "SELECT * FROM users WHERE email= $1", array($email));
    if ($row = pg_fetch_assoc($result)) {
        $pwdCheck = password_verify($password, $row['password']);

        if ($pwdCheck == false) {
            // header("Location: ".$url."?email=".$email."&error=Wrong password");
            $errors['password'] = 'Tài khoản hoặc mật khẩu không chính xác.';
            $data['errors'] = $errors;
        } else if ($pwdCheck == true) {
            session_start();
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            // header("Location: ".$url);
            $data['success'] = true;
            $data['errors'] = false;
        } else {
            // header("Location: ".$url."?email=".$email."&error=Wrong password");
            $errors['password'] = 'Tài khoản hoặc mật khẩu không chính xác.';
            $data['errors'] = $errors;
        }
    } else {
        // header("Location: ".$url."?email=".$email."&password=".$password."&error=No user");
        $errors['password'] = 'Tài khoản hoặc mật khẩu không chính xác.';
        $data['errors'] = $errors;
    }
}

echo json_encode($data);
