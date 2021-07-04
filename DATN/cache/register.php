<!DOCTYPE html>
<html lang="en">

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

</head>

<body>
    <?php session_start();
    if (isset($_GET['error'])) {
        $error = $_GET['error'];
    } else {
        $error = "";
    }
    if (isset($_GET['first'])) {
        $first = $_GET['first'];
    } else {
        $first = "";
    }
    if (isset($_GET['last'])) {
        $last = $_GET['last'];
    } else {
        $last = "";
    }
    if (isset($_GET['name'])) {
        $name = $_GET['name'];
    } else {
        $name = "";
    }
    if (isset($_GET['email'])) {
        $email = $_GET['email'];
    } else {
        $email = "";
    }
    if (isset($_GET['password'])) {
        $password = $_GET['password'];
    } else {
        $password = "";
    }
    if (isset($_GET['cPassword'])) {
        $cPassword = $_GET['cPassword'];
    } else {
        $cPassword = "";
    }

    ?>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
        <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img style="width: 30px" src="https://avatars.githubusercontent.com/u/28373845?s=200&v=4" class="rounded me-2">
                <strong class="me-auto">Maps</strong>
                <small>1 min ago</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Tạo tài khoản thành công.
            </div>
        </div>
    </div>
    <div class="p-0 m-0 row">
        <div class="form-left col-md-8 col-sm-6 p-0">
            <img style="height: 100vh; object-fit: cover;" src="../public/img/register1.jpg" alt="">
        </div>
        <div class="form-right col-md-4 col-sm-6">
            <h2 class="fw-bold">Đăng ký</h2>
            <form action="../app/controllers/register.php" method="POST" class="row g-3 justify-content-center needs-validation" novalidate>

                <div class="col-12" id="alert">
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            <label for="first" class="form-label">Họ (<span>*</span>)</label>
                            <input type="first" class="form-control" value="<?php echo $first ?>" name="first" id="first" required>
                        </div>
                        <div class="col-6">
                            <label for="last" class="form-label">Tên (<span>*</span>)</label>
                            <input type="last" class="form-control" value="<?php echo $last ?>" name="last" id="last" required>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <label for="email" class="form-label">Email (<span>*</span>)</label>
                    <input type="email" class="form-control" value="<?php echo $email ?>" name="email" id="email" required>

                </div>
                <div class="col-12">
                    <label for="password" class="form-label">Password (<span>*</span>)</label>
                    <input type="password" class="form-control" value="<?php echo $password ?>" name="password" id="password" required>

                </div>
                <div class="col-12">
                    <label for="cPassword" class="form-label">Confirm password (<span>*</span>)</label>
                    <input type="password" class="form-control" id="cPassword" name="cPassword" required>

                </div>
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Remember me</label>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <button class="btn" name="submit" type="submit">Submit</button>
                    <button class="btn " type="button" id="reset">Reset</button>
                </div>
                <div class="col-12 text-center">
                    <h6 class="mb-3">Đăng nhập bằng cách khác?</h6>
                    <div class="mt-2 d-flex justify-content-around" style="color: rgb(68, 121, 235)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                            <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                            <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z" />
                        </svg>
                    </div>
                </div>
            </form>
            <style>
                body {
                    overflow-x: hidden;
                }

                .form-right {
                    height: 100vh;
                    background-color: #f8f8f8;
                }

                h2 {
                    color: rgb(77, 110, 219);
                    margin-top: 1rem;
                    text-align: center;
                }

                .row .col-6>label {
                    display: inline-block;
                    margin-right: 1rem;
                    color: rgb(22, 22, 22);
                    font-weight: 600;
                }

                .row .col-6>label span {
                    color: red;
                }

                .row .col-6>input {
                    background-color: #f8f8f8;
                    padding: .2rem 1rem;
                    border-radius: 1rem;
                    border: 1px solid rgb(233, 233, 233);
                    outline: none;
                    font-weight: bold;
                    width: 100%;
                }

                .row .col-6>input:focus {
                    border-color: #ced4da;
                    box-shadow: none;
                }

                .row .col-12>label {
                    display: inline-block;
                    margin-right: 1rem;
                    color: rgb(22, 22, 22);
                    font-weight: 600;
                }

                .row .col-12>label span {
                    color: red;
                }

                .row .col-12>input {
                    background-color: #f8f8f8;
                    padding: .2rem 1rem;
                    border-radius: 1rem;
                    border: 1px solid rgb(233, 233, 233);
                    outline: none;
                    font-weight: bold;
                    width: 100%;
                }

                .row .col-12>input:focus {
                    border-color: #ced4da;
                    box-shadow: none;
                }

                .row .col-12>button {
                    padding: .3rem 1rem;
                    border-radius: 2rem;
                    color: #fff;
                    font-weight: bold;
                    border: 1px solid #ced4da;
                    margin: 10px 10px;
                }

                .row .col-12>button:nth-child(1) {
                    background-color: rgb(49, 240, 151);
                }

                .row .col-12>button:nth-child(2) {
                    color: rgb(22, 22, 22);
                }
            </style>

        </div>
    </div>
    <style>
        body {
            height: 100vh;
            margin: 0;
            padding: 0;
        }
    </style>
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
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
        $('#reset').click(function() {
            $('#first').val('')
            $('#lasy').val('')
            $('#email').val('')
            $('#password').val('')
            $('#cPassword').val('')
            $('form').removeClass('was-validated')
            $('#alert').html(``)
        })

        function showToast() {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'))
            var toastList = toastElList.map(function(toastEl) {
                // Creates an array of toasts (it only initializes them)
                return new bootstrap.Toast(toastEl) // No need for options; use the default options
            });
            toastList.forEach(toast => toast.show()); // This show them

            console.log(toastList); // Testing to see if it works
        }
        $(document).ready(function() {
            $("form").submit(function(event) {
                var formData = {
                    password: $("#password").val(),
                    first: $("#first").val(),
                    last: $("#last").val(),
                    cPassword: $("#cPassword").val(),
                    email: $("#email").val(),
                };
                $.ajax({
                    type: "POST",
                    url: "../app/controllers/register.php",
                    data: formData,
                    dataType: "json",
                    encode: true,
                }).done(function(data) {
                    if (data.success) {
                        showToast();
                        setTimeout(() => {
                            $('#alert').html('')
                            location.replace("./index.php");
                        }, 1500)
                    } else {
                        $('#alert').html(`
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                            <div>
                            ${data.errors.password || data.errors.empty_field || data.errors.cPassword || data.errors.email}
                            </div>
                            </div>`)
                    }
                }).catch((err) => console.log(err))
                event.preventDefault();
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
</body>

</html>