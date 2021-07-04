<?php
$errors = [];
$data = [];


require "../configs/connection.php";
session_start();
$req = $_POST['req'];
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$open = $_POST['open'];
$close = $_POST['close'];


if (empty($name) || empty($phone) || empty($address) || $phone == null) {
    $errors['empty_field'] = 'Vui lòng nhập đầy đủ các trường.';
    $data['errors'] = $errors;
} else {
    $sql = 'UPDATE public.nt_diem SET "TenDD" = $1::character varying, "SDT" = $2::character varying, "DiaChi" = $3::character varying, "GioMoCua" = $5::time with time zone, "GioDongCua" = $6::time with time zone WHERE "id" = $4';
    pg_query_params($conn, $sql, array($name, $phone, $address, $req, $open, $close));
    $data['success'] = true;
    $data['errors'] = false;
}
echo json_encode($data);
