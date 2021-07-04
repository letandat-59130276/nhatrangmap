<?php
require "../configs/connection.php";
$data = [];
$result = pg_query($conn, 'select "DiaChi"::character varying, "TenDD"::character varying, ST_X(geom), ST_Y(geom) from public.nt_diem');
while ($location = pg_fetch_array($result)) {
    if($location['DiaChi'] !== null && $location['DiaChi'] !== ''){
        array_push($data, $location);
    }
}
echo json_encode($data);
