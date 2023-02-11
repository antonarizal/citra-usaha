<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$title ?? "Selamat Datang";?></title>
    <link rel="stylesheet" href="<?=base_url()?>/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?=base_url()?>/assets/css/adminlte.min.css">
    <link rel="stylesheet" href="<?=base_url()?>/plugins/toastr/toastr.min.css">
    <script src="<?=base_url()?>/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>/assets/w2ui/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/w2ui/w2ui.min.css" />
    <script src="<?=base_url()?>/plugins/toastr/toastr.min.js"></script>
    <script src="<?=base_url()?>/assets/js/numeral.min.js"></script>
    <style>
    .modal-header {
        padding: 0.5rem !important;
        padding-left: 20px!important;

    }

    .table-sm td,
    .table-sm th {
        padding-left: 20px!important;
        padding-right: 20px!important;
    }
    .table td, .table th{
        border : none!important;
    }
    .full-width{
        width:100%
    }
    .text-right{
        text-align:right
    }
    .hide{
        display:none!important
    }
    .text-center{
        text-align:center!important;
    }
    .content-wrapper{
        margin-left: 0px !important;
    }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper" style="background:#f4f6f9">