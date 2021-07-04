<?php
$errors = [];
$data = [];


require "../configs/connection.php";
session_start();
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$open = $_POST['open'];
$close = $_POST['close'];
$long = $_POST['long'];
$lat = $_POST['lat'];
$type = $_POST['type'];


if (empty($name) || empty($phone) || empty($address) || $phone == null || empty($open) || empty($close)) {
    $errors['empty_field'] = 'Vui lòng nhập đầy đủ các trường.';
    $data['errors'] = $errors;
} else {
    $s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
    $sql = 'INSERT INTO nt_diem ("MaDD", "TenDD", "DiaChi", "SDT", "GioMoCua", "GioDongCua", geom, "TenLDD") values ($1, $2, $4, $3, $5, $6, ST_SetSRID(ST_MakePoint($7, $8), 4326), $9)';
    pg_query_params($conn, $sql, array($s,
     $name,
      $phone,
       $address,
        $open,
         $close, $long, $lat, $type));
    $data['success'] = true;
    $data['errors'] = false;
}
echo json_encode($data);
