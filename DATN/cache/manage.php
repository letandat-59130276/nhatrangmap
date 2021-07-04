<?php
include "../app/views/header.php";
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    echo ("<script>location.href = './index.php';</script>");
}
?>
<section class="p-5">
    <h3 class="fw-bold mb-2">Người dùng</h3>
    <table class="table table-hover">
        <caption class="mt-2">Danh sách người dùng</caption>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require "../app/configs/connection.php";

            $sql = "SELECT * FROM users";
            $result = pg_query($conn, $sql);
            $no = 1;
            while ($rows = pg_fetch_array($result)) {
            ?>
                <tr id="<?php echo $no ?>" name="<?php echo $rows[0] ?>">
                    <th scope="row"><?php echo $no ?></th>
                    <td class="row-data"><?php echo $rows[3] ?></td>
                    <td class="row-data"><?php echo $rows[4] ?></td>
                    <td class="row-data"><?php echo $rows[1] ?></td>
                    <td class="row-data"><?php if ($rows[5] == 1) {
                                                echo 'Super admin';
                                            } else {
                                                echo 'User';
                                            } ?></td>
                    <td>

                        <svg onclick="deleteModal(event)" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash2-fill" viewBox="0 0 16 16">
                            <path d="M2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225zm9.89-.69C10.966 2.214 9.578 2 8 2c-1.58 0-2.968.215-3.926.534-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466-.18-.14-.498-.307-.975-.466z" />
                        </svg>

                        |
                        <svg onclick="onEdit()" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                            <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z" />
                        </svg>


                    </td>
                </tr>
            <?php
                $no += 1;
            }
            ?>
        </tbody>
    </table>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div id="loading" class="text-success" role="status">
                </div>
                <div class="modal-body">
                    <h5 class="fw-bold">Họ tên: <span id="user-name"></span> </h5>
                    <h5 class="fw-bold">Email: <span id="user-email"></span></h5>
                    Bạn có chắc chắn muốn xóa người dùng này?
                </div>
                <div class="modal-footer ">
                    <div type="button" id="modal-close" data-bs-dismiss="modal" class="btn border fw-bold" data-dismiss="modal">Đóng</div>
                    <div type="button" id="modal-submit" onclick="onDelete()" class="btn border bg-success fw-bold">Có</div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <fieldset disabled>
                        <form id="modal-form" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-12 mb-1" id="modal-alert">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first" id="first">Họ</label>
                                    <input style="border-radius: 1rem" type="text" class="form-control" id="modal-first" required>
                                    <div class="invalid-feedback">
                                        Họ không được để trống.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last">Tên</label>
                                    <input style="border-radius: 1rem" type="text" class="form-control" id="modal-last" required>
                                    <div class="invalid-feedback">
                                        Tên không được để trống.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-12 mb-3">
                                    <label for="email">Email</label>
                                    <input style="border-radius: 1rem" type="email" class="form-control" id="modal-email" required>
                                    <div class="invalid-feedback">
                                        Email không được để trống
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="admin">
                                        <label class="form-check-label" for="admin">Người quản trị?</label>
                                    </div>
                                </div>
                            </div>


                        </form>
                    </fieldset>
                    <div class="row">
                        <div id="modal-loading" class="text-success" role="status">
                        </div>
                        <div class="col-md-12 justify-content-between" style="display: flex">
                            <div></div>
                            <div>
                                <div id="modal2-close" onclick="document.getElementsByTagName('fieldset')[0].setAttribute('disabled', true); document.getElementById('save').innerHTML = 'Sửa'" style="margin-right: 10px" type="button" class="btn fw-bold border" data-dismiss="modal" data-bs-dismiss="modal">Đóng</div>
                                <div onclick="document.getElementById('save').innerHTML === 'Sửa' ? clickEdit() : clickSave()" class="btn border bg-success fw-bold text-white" id="save">Sửa</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script src="../public/js/manage.js"></script>
</section>
<?php
include "../app/views/footer.php";
