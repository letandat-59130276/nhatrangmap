//Begin: Hien thi popup
//Khai bao cac yeu to tao nen cua so hien thi
var container = document.getElementById('popup');
var content = document.getElementById('popup-content');
var closer = document.getElementById('popup-closer');

//Tao lop phu co dinh cua so bat len trong ban do
var overlay = new ol.Overlay(/** @type {olx.OverlayOptions} */({
    element: container,
    autoPan: true,
    autoPanAnimation: {
        duration: 250
    }
}));

//Click chuot de an cua so bat len
closer.onclick = function () {
    overlay.setPosition(undefined);
    closer.blur();
    return false;
};
//End: Hien thi popup

//Quy dinh kieu ban do
var format = 'image/png';

//Xac dinh extent cua ban do
var bounds = [109.11119079589844, 12.140849113464355, 109.37165069580078, 12.379751205444336];

//Bengin: Khai bao layer, kieu layer: image, kieu source: ImageWMS
var nt_phuong = new ol.layer.Image({
    source: new ol.source.ImageWMS({
        ratio: 1,
        url: "http://localhost:8080/geoserver/nhatrangmap/wms",
        params: {
            FORMAT: format,
            VERSION: "1.1.0",
            STYLES: "",
            LAYERS: "nhatrangmap:nt_phuong"
        },
        crossOrigin: 'anonymous'
    })
});

var nt_duong = new ol.layer.Image({
    source: new ol.source.ImageWMS({
        ratio: 1,
        url: "http://localhost:8080/geoserver/nhatrangmap/wms",
        params: {
            FORMAT: format,
            VERSION: "1.1.0",
            STYLES: "",
            LAYERS: "nhatrangmap:nt_duong"
        },
        crossOrigin: 'anonymous'
    })
});

var nt_diem = new ol.layer.Image({
    source: new ol.source.ImageWMS({
        ratio: 1,
        url: "http://localhost:8080/geoserver/nhatrangmap/wms",
        params: {
            FORMAT: format,
            VERSION: "1.1.0",
            STYLES: "",
            LAYERS: "nhatrangmap:nt_diem"
        },
        crossOrigin: 'anonymous'
    })
});

var nt_dia_vat = new ol.layer.Image({
    source: new ol.source.ImageWMS({
        ratio: 1,
        url: "http://localhost:8080/geoserver/nhatrangmap/wms",
        params: {
            FORMAT: format,
            VERSION: "1.1.0",
            STYLES: "",
            LAYERS: "nhatrangmap:nt_dia_vat"
        },
        crossOrigin: 'anonymous'
    })
});
//End: Khai bao layer, kieu layer: image, kieu source: ImageWMS

//Tuy chon he quy chieu cua ban do
var projection = new ol.proj.Projection({
    code: 'EPSG:4326',  //He toa do WGS-84
    units: 'degrees', //Zoom full ban do
    axisOrientation: 'neu'
});


//Hien thi map
var map = new ol.Map({
    controls: ol.control.defaults().extend([
        new ol.control.FullScreen(),                        //FullScreen
        new ol.control.ScaleLine(),                         //Thanh ti le
        new ol.control.Rotate()]),                          //Ghi de len nut FullScreen
    target: 'map',
    layers: [
        new ol.layer.Tile({                                 //Lay ban do nen OpenStreetMap
            source: new ol.source.OSM()                     //Lay ban do nen OpenStreetMap
        }),                                                 //Lay ban do nen OpenStreetMap
        nt_phuong, nt_duong, nt_diem, nt_dia_vat],
    overlays: [overlay],                                    //Khai bao overlay de hien thi Popup
    view: new ol.View({
        projection: projection
    })
});
//Thanh phong to, thu nho
map.addControl(new ol.control.ZoomSlider());

//Begin: Tro ve trung tam
function onClick(id, callback) {
    document.getElementById(id).addEventListener('click', callback);
}

onClick('dennhatrang', function () {
    map.getView().animate({
        center: ol.proj.fromLonLat([109.238292, 12.262469], 'EPSG:4326', 'EPSG:3857'),
        // duration: 2000,
        zoom: 11.5,
    });
});
//End: Tro ve trung tam

//Begin: download PNG
document.getElementById('export-png').addEventListener('click', function () {
    map.once('rendercomplete', function () {
        var mapCanvas = document.createElement('canvas');
        var size = map.getSize();
        mapCanvas.width = size[0];
        mapCanvas.height = size[1];
        var mapContext = mapCanvas.getContext('2d');
        Array.prototype.forEach.call(
            document.querySelectorAll('.ol-layer canvas'),
            function (canvas) {
                if (canvas.width > 0) {
                    var opacity = canvas.parentNode.style.opacity;
                    mapContext.globalAlpha = opacity === '' ? 1 : Number(opacity);
                    var transform = canvas.style.transform;
                    // Get the transform parameters from the style's transform matrix
                    var matrix = transform
                        .match(/^matrix\(([^\(]*)\)$/)[1]
                        .split(',')
                        .map(Number);
                    // Apply the transform to the export map context
                    CanvasRenderingContext2D.prototype.setTransform.apply(
                        mapContext,
                        matrix
                    );
                    mapContext.drawImage(canvas, 0, 0);
                }
            }
        );
        if (navigator.msSaveBlob) {
            // link download attribuute does not work on MS browsers
            navigator.msSaveBlob(mapCanvas.msToBlob(), 'map.png');
        } else {
            var link = document.getElementById('image-download');
            link.href = mapCanvas.toDataURL();
            link.click();
        }
    });
    map.renderSync();
});
//End: download PNG


//Begin: GeoLocation
var geolocation = new ol.Geolocation({
    //enableHighAccuracy phai la "true" de xac dinh gia tri dau
    trackingOptions: {
        enableHighAccuracy: true
    },
});

function el(id) {
    return document.getElementById(id);
}

el('track').addEventListener('change', function () {
    geolocation.setTracking(this.checked);
});

//Cap nhat lai trang html khi vi tri thay doi.
geolocation.on('change', function () {
    el('accuracy').innerText = geolocation.getAccuracy() + ' [m]';
});

//Xu ly loi vi tri dia ly
geolocation.on('error', function (error) {
    var info = document.getElementById('info');
    info.innerHTML = error.message;
    info.style.display = '';
});

var accuracyFeature = new ol.Feature();
geolocation.on('change:accuracyGeometry', function () {
    accuracyFeature.setGeometry(geolocation.getAccuracyGeometry());
});

var positionFeature = new ol.Feature();
positionFeature.setStyle(new ol.style.Style({
    image: new ol.style.Circle({
        radius: 6,
        fill: new ol.style.Fill({
            color: '#3399CC'
        }),
        stroke: new ol.style.Stroke({
            color: '#fff',
            width: 2
        })
    })
}));

geolocation.on('change:position', function () {
    var coordinates = geolocation.getPosition();
    positionFeature.setGeometry(coordinates ?
        new ol.geom.Point(coordinates) : null);
});

new ol.layer.Vector({
    map: map,
    source: new ol.source.Vector({
        features: [accuracyFeature, positionFeature]
    })
});
//End: GeoLocation

//Zoom full extent vao vung quy dinh trong bien bounds
map.getView().fit(bounds, map.getSize());

//Begin: Bat, Tat Layer
$("#nt_phuong").change(function () {
    if ($("#nt_phuong").is(":checked")) {
        nt_phuong.setVisible(true);
    } else {
        nt_phuong.setVisible(false);
    }
});

$("#nt_duong").change(function () {
    if ($("#nt_duong").is(":checked")) {
        nt_duong.setVisible(true);
    } else {
        nt_duong.setVisible(false);
    }
});

$("#nt_diem").change(function () {
    if ($("#nt_diem").is(":checked")) {
        nt_diem.setVisible(true);
    } else {
        nt_diem.setVisible(false);
    }
});

$("#nt_dia_vat").change(function () {
    if ($("#nt_dia_vat").is(":checked")) {
        nt_dia_vat.setVisible(true);
    } else {
        nt_dia_vat.setVisible(false);
    }
});
//End: Bat, Tat Layer
map.on('click', function (evt) {
    if (document.getElementById("showDeep").innerHTML === "Tắt chỉ đường") {
        return
    }

    var view = map.getView();
    var viewResolution = view.getResolution();
    var source = nt_diem.getSource();
    var url = source.getFeatureInfoUrl(
        evt.coordinate, viewResolution, view.getProjection(),
        { 'INFO_FORMAT': 'application/json', 'FEATURE_COUNT': 50 });
    var vectorLayer = new ol.layer.Vector({
        source: new ol.source.Vector({
            features: [startPoint, destPoint]
        })
    });
    if (url) {
        $.ajax({
            type: "POST",
            url: url,
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            success: function (n) {
                var content = "<table style='width: 600px' class='table table-hover'><thead><tr><th scope='col'>Tên</th><th scope='col'>Địa chỉ</th><th scope='col'>SĐT</th><th scope='col'>Giờ mở cửa</th><th scope='col'>Giờ đóng cửa</th><th scope='col'>Actions</th></tr></thead><tbody>";
                for (var i = 0; i < n.features.length; i++) {
                    var feature = n.features[i];
                    var featureAttr = feature.properties;
                    let open = () => {
                        if (featureAttr.GioMoCua !== null) {
                            let temp = new Date(featureAttr.GioMoCua);
                            const hour = temp.getHours() - 1
                            return `${hour.toString().length === 1 ? '0'.concat(hour) : hour}:${temp.getUTCMinutes().toString().length === 1 ? '0'.concat(temp.getUTCMinutes()) : temp.getUTCMinutes()}:${temp.getUTCSeconds().toString().length === 1 ? '0'.concat(temp.getUTCSeconds()) : temp.getUTCSeconds()}`
                        }
                        return null
                    }
                    let close = () => {
                        if (featureAttr.GioDongCua !== null) {
                            let temp = new Date(featureAttr.GioDongCua);
                            const hour = temp.getHours() - 1
                            return `${hour.toString().length === 1 ? '0'.concat(hour) : hour}:${temp.getUTCMinutes().toString().length === 1 ? '0'.concat(temp.getUTCMinutes()) : temp.getUTCMinutes()}:${temp.getUTCSeconds().toString().length === 1 ? '0'.concat(temp.getUTCSeconds()) : temp.getUTCSeconds()}`
                        }
                        return null
                    }
                    content += `<tr id='col-${featureAttr['id']}'>  
                        <td scope='row'>${featureAttr["TenDD"]}</td>
                        <td scope='row'>${featureAttr["DiaChi"]}</td>
                        <td scope='row'>${featureAttr["SDT"]}</td>
                        <td scope='row'>${open()}</td>
                        <td scope='row'>${close()}</td>
                        <td scope='row' onclick='onEdit(${featureAttr.id})'>Chi tiết</td>
                        </tr>`
                }
                content += "</tbody>";

                //Begin: Hien thi len lop phu de xem thong tin dia diem
                $("#popup-content").html(content);
                overlay.setPosition(evt.coordinate);
                var vectorSource = new ol.source.Vector({
                    features: (new ol.format.GeoJSON()).readFeatures(n)
                });
                vectorLayer.setSource(vectorSource);
                //End: Hien thi len lop phu de xem thong tin dia diem

            }
        });
    }
});
//Bengin: Su kien click ban do de lay thong tin dia diem du lich
$('#showDeep').click(function () {
    startPoint.setGeometry(null);
    destPoint.setGeometry(null);
    $("#txtPoint1").val('')
    $("#popup-closer").click()
    $("#txtPoint2").val('')
    // Remove the result layer.
    map.removeLayer(result);
    if (document.getElementById("showDeep").innerHTML === "Tắt chỉ đường") {
        document.getElementById("showDeep").innerHTML = "Bật chỉ đường"
        document.getElementById("timduong").style.display = 'none';
        return
    }
    document.getElementById("timduong").style.display = 'block';
    document.getElementById("showDeep").innerHTML = "Tắt chỉ đường"


    //Nut xoa duong

})
var startPoint = new ol.Feature();
var destPoint = new ol.Feature();

var vectorLayer = new ol.layer.Vector({
    source: new ol.source.Vector({
        features: [startPoint, destPoint]
    })
});
var coor
//Lay toa do diem dau va diem cuoi
map.on('click', function (event) {
    coor = event.coordinate
    if (startPoint.getGeometry() == null) {
        // First click.
        startPoint.setGeometry(new ol.geom.Point(event.coordinate));
        $("#txtPoint1").val(event.coordinate);
    } else if (destPoint.getGeometry() == null) {
        // Second click.
        destPoint.setGeometry(new ol.geom.Point(event.coordinate));
        $("#txtPoint2").val(event.coordinate);
    }
});

//Lay toa do diem de hien thi route
var result;

$("#btnSolve").click(function () {
    var startCoord = startPoint.getGeometry().getCoordinates();
    var destCoord = destPoint.getGeometry().getCoordinates();
    var params = {
        LAYERS: 'nhatrangmap:route',
        FORMAT: 'image/png'
    };
    var viewparams = [
        'x1:' + startCoord[0], 'y1:' + startCoord[1],
        'x2:' + destCoord[0], 'y2:' + destCoord[1]
    ];
    params.viewparams = viewparams.join(';');

    result = new ol.layer.Image({
        source: new ol.source.ImageWMS({
            url: 'http://localhost:8080/geoserver/nhatrangmap/wms',
            params: params,
            crossOrigin: 'anonymous'
        })
    });

    map.addLayer(result);
});
$("#btnReset").click(function () {
    startPoint.setGeometry(null);
    destPoint.setGeometry(null);
    $("#txtPoint1").val('')
    $("#txtPoint2").val('')
    // Remove the result layer.
    map.removeLayer(result);
});
//End: Su kien click ban do de lay thong tin dia diem du lich


var getData = function (el) {
    let value = el.querySelector("small").innerHTML;
    let evt = {
        coordinate: value.split(" ").map(x => +x)
    }
    map.listeners_.click[0](evt)
    document.querySelector("#location").innerHTML = ''

}
let req
function onEdit(id) {
    req = id
    const data = document.getElementById(`col-${id}`).querySelectorAll("td");
    let myModal = new bootstrap.Modal(document.getElementById("edit-modal"));
    myModal.show();
    $('#EM-name').val(data[0].innerHTML)
    $('#EM-address').val(data[1].innerHTML)
    $('#EM-phone').val(data[2].innerHTML)
    console.log(data[3].innerHTML, data[4].innerHTML);
    if (data[3].innerHTML !== null) {
        document.getElementById("EM-open").value = data[3].innerHTML;
        // console.log( $('#EM-open'));
        // debugger
    }
    if (data[4].innerHTML !== null) {
        document.getElementById("EM-close").value = data[4].innerHTML;
        // console.log( $('#EM-open'));
        // debugger
    }
}

function onSaveEdit(e) {
    // console.log($('#modal-submit').text());
    if (e.innerHTML === 'Sửa') {
        document.getElementsByTagName("fieldset")[0].removeAttribute("disabled");
        e.innerHTML = "Lưu"
        return
    }
    else {
        let name = $('#EM-name').val()
        let phone = $('#EM-phone').val()
        let address = $('#EM-address').val()
        let open = $('#EM-open').val();
        let close = $('#EM-close').val();
        $.ajax({
            type: "POST",
            url: "../app/controllers/updateGeo.php",
            data: {
                req,
                name, phone, address, open, close
            },
            dataType: "json",
            encode: true,
        })
            .done(function (data) {
                console.log( document.getElementById("EM-errors"));
                if (data.errors) {
                    document.getElementById("EM-errors").innerHTML = `
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                <div>
                                ${data.errors.empty_field}
                                </div>
                                </div>`;

                    e.innerHTML = 'Lưu'
                }
                if (data.success) {
                    document.getElementById("EM-errors").innerHTML = "";
                    document.getElementsByTagName("fieldset")[0].setAttribute("disabled", true);

                    e.innerHTML = 'Sửa'
                }
            })
            .catch((err) => console.log(err));
    }

}
function onDelete() {
    let result = confirm("Bạn có chắc chắn muốn xoá địa điểm này?")
    if (result) {
        $.ajax({
            type: "POST",
            url: "../app/controllers/deleteGeo.php",
            data: {
                req
            },
            dataType: "json",
            encode: true,
        }).done(() => {

        }).catch((err) => {
            alert("Xoá thành công")
            location.reload()
        })
    }
}
function addNew() {
    document.getElementById("showDeep").innerHTML = "Tắt chỉ đường"
    $("#left").css("display", "none")
    $("#right").css("display", "none")
    $("#map").css("margin", "0 auto")
    let myModal = new bootstrap.Modal(document.getElementById("create-modal"));
    setTimeout(() => {
        let result = confirm("Vui lòng chọn địa điểm.")
        function waitForElement() {
            if (!result) location.reload()
            if (typeof coor !== "undefined") {
                myModal.show();
                //variable exists, do what you want
            }
            else {
                setTimeout(waitForElement, 250);
            }
        }
        waitForElement();
        // coor = undefined
    }, 300)
}
function onCreate() {
    let name = $('#CM-name').val()
    let phone = $('#CM-phone').val()
    let address = $('#CM-address').val()
    let open = ($('#CM-open').val() + ':00').split(":").map(x => { if (x.length == 1) { return '0' + x } return x }).join(':')
    let close = ($('#CM-close').val() + ':00').split(":").map(x => { if (x.length == 1) { return '0' + x } return x }).join(':')
    let type = $("#types").val();
    console.log(type);
    $.ajax({
        type: "POST",
        url: "../app/controllers/createGeo.php",
        data: {
            name, phone, address, open, close, long: coor[0], lat: coor[1], type
        },
        dataType: "json",
        encode: true,
    })
        .done(function (data) {
            console.log(data);
            if (data.success) {
                location.reload()
            }
            if (data.errors) {
                $("#CM-errors").html(`
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                <div>
                                ${data.errors.empty_field}
                                </div>
                                </div>`);
                console.log(data);
            }
        })
        .catch((err) => console.log(err));
}
// document.getElementById("hien").onclick = function () {
//     document.getElementById("timduong").style.display = 'block';
// };
