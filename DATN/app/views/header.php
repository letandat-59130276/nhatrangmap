<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,600;0,700;1,300;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../public/css/external.css">

    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-primary">
            <div class="container-fluid">
                <a href="./index.php" class="navbar-brand px-5 py-2" href="#">Maps</a>
                <div class="navbar-toggler" type="button" id="closeBTN">
                    <span class="navbar-toggler-icon"></span>
                </div>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item mx-4">
                            <a class="nav-link active" aria-current="page" href="./index.php">Giới thiệu</a>
                        </li>
                        <li class="nav-item mx-4">
                            <a class="nav-link" href="./maps.php">Bản đồ</a>
                        </li>
                        <?php if (isset($_SESSION['email'])) {
                            echo "<li class='nav-item mx-4'>
                            <a class='nav-link' href='./manage.php'>Quản lý</a>
                            </li>";
                        } ?>

                    </ul>
                    <div style="margin-left: auto" class="d-flex align-items-center">
                        <span class="search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </span>
                        <?php if (isset($_SESSION['email'])) {
                            echo "
                        <svg xmlns='http://www.w3.org/2000/svg' width='22' height='22' fill='currentColor' class='bi bi-person-circle' viewBox='0 0 16 16'>
                            <path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z'/>
                            <path fill-rule='evenodd' d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z'/>
                        </svg>

                        <span class='fw-bolder'>" . $_SESSION['email'] . "</span>
                        
                            <a class='btn btn-outline-none sign-in ml-5' href='../app/controllers/logout.php' name='logout'>Đăng xuất</a>
                    
                        ";
                        } else {
                            echo "<button class='btn btn-outline-none sign-in ml-5' type='submit' data-bs-toggle='modal' data-bs-target='#exampleModalFullscreen'>Đăng nhập</button>";
                        }

                        ?>

                    </div>


                </div>


                <script>
                    $('#closeBTN').click(() => {
                        $('#navbarNav').toggle('show');
                    })
                </script>
            </div>
        </nav>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalFullscreen" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true" style="display: none;">
            <div class="loading">
                <div class="spinner-wrapper">
                    <span class="spinner-text">Xin chờ</span>
                    <span class="spinner"></span>
                </div>
            </div>
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title h4" id="exampleModalFullscreenLabel">Maps</h5>
                        <button id="close" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body login-img d-flex justify-content-center w-100 ">
                        <?php
                        if (isset($_GET['error'])) {
                            $error = $_GET['error'];
                        } else {
                            $error = "";
                        }
                        if (isset($_GET['name'])) {
                            $name = $_GET['name'];
                        } else {
                            $name = "";
                        }
                        if (isset($_GET['password'])) {
                            $password = $_GET['password'];
                        } else {
                            $password = "";
                        }

                        ?>
                        <form id="modal" action="../app/controllers/login.php" method="POST" class="w-75" style="margin-left: 100px;">
                            <h2 class="mb-5 animate__animated animate__fadeInDown">Đăng nhập</h2>
                            <div id="alert" class="w-50"></div>
                            <div class="animate__animated animate__fadeInDown my-3">
                                <label for="email" class="fw-bold">Email</label>
                                <div class="input-group w-50">
                                    <div class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                            <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z" />
                                        </svg></div>
                                    <input type="email" style="font-weight: 600;" class="form-control" id="email" placeholder="name@example.com" name="email" value="<?php echo $name ?>">
                                </div>

                            </div>
                            <div class="my-3 animate__animated animate__fadeInDown w-100">
                                <label for="password" class="form-label fw-bold">Mật khẩu</label>

                                <div class="input-group w-50">
                                    <div class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key-fill" viewBox="0 0 16 16">
                                            <path d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2zM2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                        </svg></div>
                                    <input type="password" value="<?php echo $password ?>" name="password" style="font-weight: 600;" class="form-control" id="password" placeholder="*********">
                                </div>

                            </div>
                            <div class="form-check form-switch animate__animated animate__fadeInDown">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                <label class="form-check-label" for="flexSwitchCheckDefault">Remember me</label>
                            </div>
                            <div class="my-3">
                                <button type="submit" name="submit" class="btn btn-primary animate__animated animate__fadeInDown px-5 my-3 submit fw-bold">Đăng
                                    nhập</button>
                            </div>
                        </form>
                        <div class="w-25 text-center ">
                            <img class="animate__animated  animate__backInRight" src="../public/img/login.png" alt="">
                            <a style="cursor: pointer;" href="./register.php" class="mx-auto d-inline-block">Chưa có
                                tài khoản?</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Full screen modal -->
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </symbol>
            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
            </symbol>
            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
            </symbol>
        </svg>
        <script>
            $(document).ready(function() {
                let loading = document.querySelector("#exampleModalFullscreen > div.loading")
                $("#modal").submit(function(event) {
                    loading.style.display = 'block'
                    var formData = {
                        password: $("#password").val(),
                        email: $("#email").val(),
                    };
                    $.ajax({
                        type: "POST",
                        url: "../app/controllers/login.php",
                        data: formData,
                        dataType: "json",
                        encode: true,
                    }).done(function(data) {
                        if (data.success) {
                            setTimeout(() => {
                                loading.style.display = 'none'
                                $('#alert').html('')
                                $('#name').html('')
                                $('#email').html('')
                                $('#close').click()
                                location.reload()
                            }, 1000)
                        } else {
                            loading.style.display = 'none'
                            $('#alert').html(`
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                            <div>
                            ${data.errors.password || data.errors.empty_field}
                            </div>
                            </div>`)
                        }
                    }).catch((err) => console.log(err))
                    event.preventDefault();
                });
            });
        </script>
        <style>
            /* body {

            } */

            .loading {
                display: none;
                -webkit-animation: fadein;
                -moz-animation: fadein;
                -o-animation: fadein;
                animation: fadein;
            }

            @-moz-keyframes fadein {
                from {
                    opacity: 0
                }

                to {
                    opacity: 1
                }
            }

            @-webkit-keyframes fadein {
                from {
                    opacity: 0
                }

                to {
                    opacity: 1
                }
            }

            @-o-keyframes fadein {
                from {
                    opacity: 0
                }

                to {
                    opacity: 1
                }
            }

            @keyframes fadein {
                from {
                    opacity: 0
                }

                to {
                    opacity: 1
                }
            }

            .spinner-wrapper {
                min-width: 100%;
                min-height: 100%;
                height: 100%;
                top: 0;
                left: 0;
                background: rgba(255, 255, 255, 0.93);
                position: absolute;
                z-index: 300;
            }

            .spinner-text {
                position: absolute;
                top: 41.5%;
                left: 47%;
                margin: 16px 0 0 35px;
                font-size: 9px;
                font-family: Arial;
                color: #BBB;
                letter-spacing: 1px;
                font-weight: 700
            }

            .spinner {
                margin: 0;
                display: block;
                position: absolute;
                left: 45%;
                top: 40%;
                border: 25px solid rgb(0 123 255);
                width: 1px;
                height: 1px;
                border-left-color: transparent;
                border-right-color: transparent;
                -webkit-border-radius: 50px;
                -moz-border-radius: 50px;
                border-radius: 50px;
                -webkit-animation: spin 1.5s infinite;
                -moz-animation: spin 1.5s infinite;
                animation: spin 1.5s infinite;
            }

            @-webkit-keyframes spin {

                0%,
                100% {
                    -webkit-transform: rotate(0deg) scale(1)
                }

                50% {
                    -webkit-transform: rotate(720deg) scale(0.6)
                }
            }

            @-moz-keyframes spin {

                0%,
                100% {
                    -moz-transform: rotate(0deg) scale(1)
                }

                50% {
                    -moz-transform: rotate(720deg) scale(0.6)
                }
            }

            @-o-keyframes spin {

                0%,
                100% {
                    -o-transform: rotate(0deg) scale(1)
                }

                50% {
                    -o-transform: rotate(720deg) scale(0.6)
                }
            }

            @keyframes spin {

                0%,
                100% {
                    transform: rotate(0deg) scale(1)
                }

                50% {
                    transform: rotate(720deg) scale(0.6)
                }
            }
        </style>
    </header>