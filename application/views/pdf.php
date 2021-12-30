<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <style>
        @font-face {
            font-family: Gujrati Saral-1;
            src: url(<?= base_url('assets/back/css/fonts/Gujrati-Saral-1.ttf') ?>) format("truetype");
        }

        @font-face {
            font-family: Hindi Saral-1;
            src: url(<?= base_url('assets/back/css/fonts/hsaral-1.ttf') ?>) format("truetype");
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
</head>
<body>
    <?= $data['pdf'] ?>
</body>
</html>