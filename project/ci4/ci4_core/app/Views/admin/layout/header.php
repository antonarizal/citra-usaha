<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$title ?? "Selamat Datang";?></title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?=base_url()?>/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?=base_url()?>/assets/css/adminlte.min.css">
  <link rel="stylesheet" href="<?=base_url()?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?=base_url()?>/plugins/toastr/toastr.min.css">
  <script src="<?=base_url()?>/plugins/jquery/jquery.js"></script>
  <script type="text/javascript" src="<?=base_url()?>/assets/w2ui/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/w2ui/w2ui.min.css" />
    <script src="<?=base_url()?>/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="<?=base_url()?>/plugins/toastr/toastr.min.js"></script>
  <script src="<?=base_url()?>/assets/js/numeral.min.js"></script>
  <script>
        function inputNum(input) {
        var x = numeral(input.value).format("0,0");
        input.value = x;
    }
    </script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper" style="background:#f4f6f9">
