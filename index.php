<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>
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
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>
