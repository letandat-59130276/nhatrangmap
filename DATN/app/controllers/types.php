<?php
require "../configs/connection.php";
$data = [];
$result = pg_query($conn, 'select "MaLDD"::character varying, "TenLDD"::character varying from public.loaidiadiem');
while ($location = pg_fetch_array($result)) {
        array_push($data, $location);
}
echo json_encode($data);
