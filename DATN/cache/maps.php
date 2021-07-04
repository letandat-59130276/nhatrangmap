<?php include '../app/views/header.php' ?>
<div class="mt-2 py-3" style="height: 90vh">
    <div style="text-align: center;" class="col-md-12 m-auto text-center">
        <h3 class="pricing-header fw-bold semi-bold-600">BẢN ĐỒ DU LỊCH</h3>
        <p class="pricing-footer fw-bolder">
            "MỘT NGÀY KHÁM PHÁ THÀNH PHỐ NHA TRANG"
        </p>
    </div>
    <div class="row p-0 m-0" style="height: calc(100% - 10vh)">
        <!--Begin: Bat, Tat layer-->
        <div id="right" class="col-md-2 bg-light pt-2">
            <div class="input-group flex-nowrap" style="position: relative;">
                <span class="input-group-text" id="addon-wrapping"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg></span>
                <input id="search" type="text" class="form-control" placeholder="Tìm kiếm địa điểm">
            </div>
            <div style="z-index: 100; position: absolute" id="location">
                <script>
                    const search = document.getElementById('search')
                    const searchResult = document.getElementById('location')

                    const searchLocation = async searchText => {
                        const response = await fetch('../app/controllers/locations.php')
                        const locations = await response.json()
                        let matches = locations.filter(location => {
                            const regex = new RegExp(`^${searchText}`, 'gi');
                            return location.DiaChi.match(regex) || location.TenDD.match(regex)
                        })
                        if (searchText.length === 0) {
                            matches = [];
                            searchResult.innerHTML = ''
                        }

                        outputHTML(matches);
                    }

                    const outputHTML = matches => {
                        if (matches.length > 0) {
                            const html = matches.map(match => `
                        <div class="card card-body mb-1" onclick="getData(this)">
                            <h5 class="text-primary">${match.TenDD}</h5>
                            <h6>${match.DiaChi}</h6>
                            <small>${match.st_x} ${match.st_y}</small>
                        </div>
                        
                        `).join('')
                            searchResult.innerHTML = html
                        }
                    }

                    search.addEventListener('input', () => searchLocation(search.value))
                </script>
            </div>
            <div class="form-check form-switch my-2">
                <input class="form-check-input" type="checkbox" id="nt_phuong" checked>
                <label class="form-check-label" for="nt_phuong">Phường</label>
            </div>
            <div class="form-check form-switch my-2">
                <input class="form-check-input" type="checkbox" id="nt_duong" checked>
                <label class="form-check-label" for="nt_duong">Đường</label>
            </div>
            <div class="form-check form-switch my-2">
                <input class="form-check-input" type="checkbox" id="nt_diem" checked>
                <label class="form-check-label" for="nt_diem">Điểm du lịch</label>
            </div>
            <div class="form-check form-switch my-2">
                <input class="form-check-input" type="checkbox" id="nt_dia_vat" checked>
                <label class="form-check-label" for="nt_dia_vat">Địa vật</label>
            </div>
            <div class="form-check form-switch my-2">
                <input class="form-check-input" type="checkbox" id="track">
                <label class="form-check-label" for="track">Vị trí của tôi</label>
            </div>
            <small id="trackHelpBlock" class="form-text text-muted">
                Độ sai lệch: <code id="accuracy"></code>
            </small>
            <div>
                <button id="showDeep" class="w-100 my-2 bg-warning" style="border: none; border-radius: .5rem">Bật chỉ đường</button>
                <div id="timduong" style="display: none;">
                    <input type="text" id="txtPoint1" class="form-control mb-2" style="height: 1.3rem;border-radius: 1rem; outline: none; padding-left: 10px" />

                    <input type="text" id="txtPoint2" class="form-control" style="height: 1.3rem;border-radius: 1rem; outline: none; padding-left: 10px" />

                    <div class="d-flex justify-content-between mt-2">
                        <button id="btnSolve" style="border: none; border-radius: .5rem; height: 30px" class="bg-primary text-white">Tìm đường</button>
                        <button id="btnReset" style="border: none; border-radius: .5rem; height: 30px" class="bg-danger text-white">Xóa đường</button><br><br>
                    </div>
                </div>
            </div>
            <div class="">
                <button class="w-100 my-2 bg-warning" style="border: none; border-radius: .5rem" id="dennhatrang">Về trung tâm</button>
                <button class="w-100 my-2 bg-success" style="border: none; border-radius: .5rem" id="export-png">Tải bản đồ</button>
                <?php if (isset($_SESSION['email']) && $_SESSION['role'] == 1) {

                    echo '<button class="w-100 my-2 bg-secondary" style="border: none; border-radius: .5rem" id="addNew" onclick="addNew()">Thêm mới</button>';
                }
                ?>
                <a id="image-download" download="nhatrangmap.png"></a>
            </div>
        </div>
        <!--End: Bat, Tat layer-->

        <!-- Hien thi ban do -->
        <div id="map" class="col-md-8 p-0"></div>

        <!--Begin: Legend-->
        <div id="left" style="max-height: 500px; overflow-y: scroll" class="col-md-2 bg-light">
            <h5 class="text-center fw-bold">Chú Giải</h5>

            <div class="d-flex flex-column p-3">

                <img style="width: 150px" class="my-3" src="http://localhost:8080/geoserver/nhatrangmap/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&LAYER=nhatrangmap:nt_diem" />
                <img style="width: 125px" class="my-3" src="http://localhost:8080/geoserver/nhatrangmap/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&LAYER=nhatrangmap:nt_dia_vat" />

            </div>
        </div>
        <script>
            function removeEl() {

                document
                    .querySelector(
                        "#map > div > div.ol-overlaycontainer-stopevent > div.ol-attribution.ol-unselectable.ol-control.ol-uncollapsible > ul"
                    ).remove()

            }
            setTimeout(() => {
                removeEl();
            }, 500)
        </script>
        <!--End Legend-->
        <div class="modal fade" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div id='errors'></div>
                    <div id="loading" class="text-success" role="status">
                    </div>
                    <div id="CM-errors"></div>
                    <form class="py-1 px-2" id="create-form" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-12 mb-1" id="modal-alert">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first" id="first">Tên</label>
                                <input style="border-radius: 1rem" type="text" class="form-control" id="CM-name" required>

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="first" id="first">Số điện thoại</label>
                                <input style="border-radius: 1rem" type="number" class="form-control" id="CM-phone" required>

                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="types">Loại địa điểm</label>
                                <select class="form-control border-1" id="types"></select>
                                <script>
                                    (function(locations) {
                                        $.ajax({
                                            type: "POST",
                                            url: "../app/controllers/types.php",
                                            dataType: "json",
                                            encode: true,
                                        }).done(function(data) {
                                            function addItems(list, container) {
                                                list.forEach(function(item) {
                                                    const option = document.createElement('option');

                                                    option.setAttribute('value', item[1]);
                                                    option.innerHTML = item[1];
                                                    container.appendChild(option);
                                                });
                                            }

                                            addItems(data, locations);
                                        })


                                    }(document.getElementById('types')));
                                </script>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="last">Địa chỉ</label>
                                <textarea style="border-radius: 1rem" class="form-control" id="CM-address"></textarea>

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="first" id="first">Giờ mở cửa</label>
                                <input style="border-radius: 1rem" type="time" class="form-control" id="CM-open">

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="first" id="first">Giờ đóng cửa</label>
                                <input style="border-radius: 1rem" type="time" class="form-control" id="CM-close">

                            </div>

                        </div>
                    </form>


                    <div class="modal-footer ">
                        <div type="button" id="modal-close" onclick="location.reload()" data-bs-dismiss="modal" class="btn border fw-bold" data-dismiss="modal">Đóng</div>
                        <div type="button" id="modal-submit" onclick="onCreate()" class="btn border bg-success fw-bold">Lưu</div>

                    </div>'


                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div id='EM-errors'></div>
                    <div id="loading" class="text-success" role="status">
                    </div>
                    <fieldset disabled>
                        <form class="py-1 px-2" id="modal-form" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-12 mb-1" id="modal-alert">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first" id="first">Tên</label>
                                    <input style="border-radius: 1rem" type="text" class="form-control" id="EM-name" required>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="first" id="first">Số điện thoại</label>
                                    <input style="border-radius: 1rem" type="number" class="form-control" id="EM-phone" required>

                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="last">Địa chỉ</label>
                                    <textarea style="border-radius: 1rem" class="form-control" id="EM-address"></textarea>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="first" id="first">Giờ mở cửa</label>
                                    <input style="border-radius: 1rem" type="time" class="form-control" id="EM-open" required>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="first" id="first">Giờ đóng cửa</label>
                                    <input style="border-radius: 1rem" type="time" class="form-control" id="EM-close" required>

                                </div>
                            </div>
                        </form>
                    </fieldset>
                    <?php
                    if (isset($_SESSION['email']) && $_SESSION['role'] == 1) {
                        echo ' <div class="modal-footer ">
                        <div type="button" id="modal-close" onclick="location.reload()" data-bs-dismiss="modal" class="btn border fw-bold" data-dismiss="modal">Đóng</div>
                        <div type="button" id="modal-submit" onclick="onSaveEdit(this);" class="btn border bg-success fw-bold">Sửa</div>
                        <div type="button" id="modal-delete" onclick="onDelete()" class="btn border bg-danger fw-bold">Xoá</div>

                    </div>';
                    }

                    ?>

                </div>
            </div>
        </div>

    </div>
</div>

<!-- Hien thi thong tin dia diem len ban do -->
<div id="popup" class="ol-popup">
    <a href="#" id="popup-closer" class="ol-popup-closer"></a>
    <div id="popup-content"></div>
</div>
<style>
    /* Begin: Popup hien thi thong tin tren ban do */
    .ol-popup {
        position: absolute;
        background-color: white;
        -webkit-filter: drop-shadow(0 1px 4px rgba(0, 0, 0, 0.2));
        filter: drop-shadow(0 1px 4px rgba(0, 0, 0, 0.2));
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #cccccc;
        bottom: 12px;
        left: -50px;
        min-width: 180px;
    }

    .ol-popup:after,
    .ol-popup:before {
        top: 100%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
    }

    .ol-popup:after {
        border-top-color: white;
        border-width: 10px;
        left: 48px;
        margin-left: -10px;
    }

    .ol-popup:before {
        border-top-color: #cccccc;
        border-width: 11px;
        left: 48px;
        margin-left: -11px;
    }

    .ol-popup-closer {
        text-decoration: none;
        position: absolute;
        top: 2px;
        right: 8px;
    }

    .ol-popup-closer:after {
        content: "✖";
    }
</style>
<script src="../public/js/maps.js">
</script>
<?php include '../app/views/footer.php' ?>