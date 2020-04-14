<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>
<?php if (functions\isMain()): ?>
  <main class="shop-page">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/banner.php'; ?>
    <section class="shop container">
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/filter.php'; ?>
      <div class="shop__wrapper">
        <?php $products = functions\getAllProductsForFrontend(); ?>  
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/sorting.php'; ?>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/category.php'; ?>
      </div>
    </section>  
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/order.php'; ?>
  </main>
<?php elseif (functions\getPageId()): ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/page.php'; ?> 
<?php else: ?> 
  <main class="page-404"> 
    <section class="shop container">
      <h1 class="h h--1">Страница не найдена</h1>
      <p>Вы можете перейта на <a href="/">главную страницу</a>.</p>
    </section>
  </main>    
<?php endif; ?>   
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>
