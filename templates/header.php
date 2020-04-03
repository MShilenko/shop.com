<?php include $_SERVER['DOCUMENT_ROOT'] . '/functions/connecting.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Fashion</title>

  <meta name="description" content="Fashion - интернет-магазин">
  <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

  <meta name="theme-color" content="#393939">

  <link rel="preload" href="/fonts/opensans-400-normal.woff2" as="font">
  <link rel="preload" href="/fonts/roboto-400-normal.woff2" as="font">
  <link rel="preload" href="/fonts/roboto-700-normal.woff2" as="font">

  <link rel="icon" href="/img/favicon.png">
  <link rel="stylesheet" href="/css/style.min.css">
  <link rel="stylesheet" href="/css/custom.css">

  <script src="/js/scripts.js" defer=""></script>
</head>
<body>
<header class="page-header">
  <a class="page-header__logo" href="/">
    <img src="/img/logo.svg" alt="Fashion">
  </a>
  <nav class="page-header__menu">
    <ul class="main-menu main-menu--header">
      <?php if (functions\isAuth() && functions\isAdminFolder()): ?>
        <li>
          <a class="main-menu__item" href="/admin/">Главная</a>
        </li>
        <?php if (functions\isAdministrator()): ?>
          <li>
            <a class="main-menu__item" href="/admin/categories/">Категории</a>
          </li>
          <li>
            <a class="main-menu__item" href="/admin/products/">Товары</a>
          </li>
        <? endif; ?> 
        <?php if (functions\isAdministrator() || functions\isRedactor()): ?> 
          <li>
            <a class="main-menu__item" href="/admin/orders/">Заказы</a>
          </li>
        <? endif; ?>
        <li>
          <a class="main-menu__item" href="/admin/?login=no">Выйти</a>
        </li>
      <?php else: ?>
        <li>
          <a class="main-menu__item" href="/">Главная</a>
        </li>
        <li>
          <a class="main-menu__item" href="#">Новинки</a>
        </li>
        <li>
          <a class="main-menu__item" href="index.html">Sale</a>
        </li>
        <li>
          <a class="main-menu__item" href="delivery.html">Доставка</a>
        </li>
      <?php endif; ?>
    </ul>
  </nav>
</header>