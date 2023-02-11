<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$title?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=base_url();?>/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?=base_url();?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=base_url();?>/assets/css/adminlte.min.css">
    <style>
    /*
*
* ==========================================
* CUSTOM UTIL CLASSES
* ==========================================
*
*/
    .login,
    .image {
        min-height: 100vh;
    }

    .bg-image {
        background-image: url('<?=base_url("images/bg_login.jpg")?>');
        background-size: cover;
        background-position: center center;
    }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- The image half -->
            <div class="col-md-6 d-none d-md-flex bg-image"></div>
            <!-- The content half -->
            <div class="col-md-6 bg-light">
                <div class="login d-flex align-items-center py-5">
                    <!-- Demo content-->
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-10 col-xl-7 mx-auto">
                                <h3 class="display-4">Login <?php//$_COOKIE["isLogin"]?></h3>

                                <p class="text-muted mb-4">Masukkan username dan password untuk masuk</p>
                                <form id="login">
                                    <div class="form-group mb-3">
                                        <input id="inputEmail" type="text" name="username" placeholder="Username"
                                            required="" autofocus=""
                                            class="form-control rounded-pill border-0 shadow-sm px-4">
                                    </div>
                                    <div class="form-group mb-3">
                                        <input id="inputPassword" type="password" name="password" placeholder="Password"
                                            required=""
                                            class="form-control rounded-pill border-0 shadow-sm px-4 text-primary">
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary btn-block text-uppercase mb-2 rounded-pill shadow-sm">Sign
                                        in</button>

                                </form>
                            </div>
                        </div>
                    </div><!-- End -->

                </div>
            </div><!-- End -->

        </div>
    </div>

    <!-- jQuery -->
    <script src="<?=base_url();?>/assets/js/localdb.min.js"></script>
    <script src="<?=base_url();?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?=base_url();?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?=base_url();?>/assets/js/adminlte.min.js"></script>
    <script>
    //https://github.com/mike183/localDB#getting-table-meta-data
    var db = new localdb('db_weringin');

    db.dropTable('users');
    console.log(db.exportData('users'));


    document.cookie = "isLogin=false";
    document.cookie = "username=";
    document.cookie = "user_id=";
    var auth_url = "http://192.168.1.70:7038/api/User/Login";
    var base_url = '<?=base_url()?>';
    $("#login").on('submit', (function(e) {
        var _data = {
            "username": $("#inputEmail").val(),
            "password": $("#inputPassword").val()
        };
        e.preventDefault();
        $.ajax({
            url: auth_url,
            type: 'POST',
            data: JSON.stringify(_data),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response)
                // res = jQuery.parseJSON(data);
                if (response.success) {
                    if (!db.tableExists('users')) {
                        console.log('Table users already exists');
                        db.createTable('users');

                    }

                    db.insert('users', {
                        'username': response.data.username.trim(),
                        'password': response.data.password.trim(),
                        'grp': response.data.grp.trim(),
                        'descgrp': response.data.descgrp.trim(),
                    });

                    document.cookie = "isLogin=true";
                    // document.cookie = "username="+data.username;
                    // document.cookie = "user_id="+data.user_id;
                    window.location.replace(base_url + "/admin/panel");
                } else {
                    alert(response.message);
                }
            },
            statusCode: {
                404: function(xhr) {
                    console.log(xhr.responseText);
                },
                400: function(xhr) {
                    console.log(xhr.responseText);
                },
                401: function(xhr) {
                    console.log(xhr.responseText);
                }
            }

        });


    }));
    </script>

</body>

</html>