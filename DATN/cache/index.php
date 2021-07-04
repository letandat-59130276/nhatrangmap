<?php
include "../app/views/header.php";
// $db_connection = pg_connect("host=localhost user=postgres dbname=CSDL password=admin");
// $result = pg_query($db_connection, "insert into users (id, name) values (2,'cutee')");
?>
<section>
    <div class="greetings animate__animated text-center d-flex flex-column justify-content-center align-items-center">
        <img class=" animate__animated animate__fadeInDown" src="../public/img/earth.png" alt="">
        <h1 class="animate__animated animate__fadeInLeft pb-1 mb-0">INFOTECH NTU</h1>
        <hr class="animate__animated animate__fadeInLeft" style="width: 40px;">
        <div class="abc">
            <p class="description animate__animated animate__fadeInLeft ">Ngày 17/01/2003 Khoa Công nghệ thông tin được thành lập với 3 bộ môn: Khoa học máy tính, Hệ thống thông tin và Công nghệ tri thức. Từ năm 2006, Khoa Công nghệ Thông tin có 4 bộ môn: Khoa học máy tính, Hệ thống thông tin, Mạng máy tính & truyền thông và Kỹ thuật phần mềm. Đầu tháng 11/2011, Bộ môn Khoa học máy tính sát nhập vào Bộ môn Kỹ thuật phần mềm; Khoa tiếp nhận Bộ môn Toán từ Khoa khoa học cơ bản.</p>
            <!-- <span class="animate__animated animate__fadeInLeft ">Xem thêm</span> -->
            <?php
            if (!isset($_SESSION['email'])) {
                echo "<div style='width: 200px' class='button p-3 mt-3 mx-auto animate__animated animate__fadeInLeft ' data-bs-toggle='modal' data-bs-target='#exampleModalFullscreen'><span>
                            Đăng nhập
                        </span></div>";
            } ?>

        </div>
    </div>
    <img src="../public/img/overview.jpeg" class=" overview " alt="...">
</section>
<?php
include "../app/views/footer.php";
