<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="fast2sms" content="p1ZicHySeAhjizMQQeizMA9SivOKP0i1">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="icon" href="<?= base_url(SITEICON) ?>" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css?v=' . VERSION) ?>" />
  <title>
  <?=@$title?>
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="<?=base_url("assets/admin/assets/css/nucleo-icons.css")?>" rel="stylesheet" />
  <link href="<?=base_url("assets/admin/assets/css/nucleo-svg.css")?>" rel="stylesheet" />
  <!-- Font Awesome Icons -->
   <script src="https://kit.fontawesome.com/cb80db648d.js" crossorigin="anonymous"></script>
  <link href="<?=base_url("assets/admin/assets/css/nucleo-svg.css")?>" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="<?=base_url("assets/admin/assets/css/soft-ui-dashboard.css?v=1.0.7")?>" rel="stylesheet" />

  <style>
.splbtn:hover{
  cursor: pointer;
  opacity:0.7;
}
    </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
<div style="display:none">
<audio id="notsound" controls>
        <source id="source" src="<?=base_url('assets/notify.wav')?>" type="audio/wav">
        Your browser does not support the audio element.
    </audio>

  </div>
  
    <div id="loader" style="display: none;">
        <div id="loading">
            <img src="<?= base_url('assets/images/loading2.svg') ?>" />
        </div>
    </div>

   