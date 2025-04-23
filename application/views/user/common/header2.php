<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="fast2sms" content="p1ZicHySeAhjizMQQeizMA9SivOKP0i1">
    <title><?= @$title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="icon" href="<?= base_url(SITEICON) ?>" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css?v=' . VERSION) ?>" />
      <link rel="manifest" href="<?=base_url('assets/manifest.json?v=' . VERSION)?>">

</head>

<body style='background-image: url(<?= base_url("assets/images/background.jpg") ?>);'>

    <div id="loader" style="display: none;">
        <div id="loading">
            <img src="<?= base_url('assets/images/loading.svg') ?>" />
        </div>
    </div>

    <div class="col-md-5 mx-auto">
        <div class="">
            <a href="<?=base_url()?>" class="showloader btn btn-warning gold-btn mx-3 mt-4"><i class="bi bi-arrow-left-circle"></i> Go Back To Home</a>