<?php
$authPageTitle = $authPageTitle ?? 'Phone Store';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="theme-color" content="#fdf8fc">
  <title><?= htmlspecialchars($authPageTitle) ?> — Phone Store</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/vendor/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/client-auth.css">
  <link rel="icon" href="assets/img/logo/LOGO.png" type="image/png">
</head>
<body class="client-auth-page">
<div class="client-auth-deco" aria-hidden="true"></div>
<a class="client-auth-back" href="<?= htmlspecialchars(BASE_URL) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Về cửa hàng</a>
<main class="client-auth-card-wrap">
