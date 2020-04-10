<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>
<main class="shop-page">
  <section class="shop container">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/filter.php'; ?>
    <div class="shop__wrapper">  
      <?php if (functions\getCategoryId()): ?>
        <?php $products = functions\getAllProductsForCategory(functions\getCategoryId()); ?>
        <?php $categoryOptions = functions\getCategoryOptionsForFront(functions\getCategoryId()); ?>
        <h1 class="h h--1 category-h1"><?= $categoryOptions['name'] ?></h1>
        <?php if (isset($categoryOptions['description'])): ?>
          <div class="category-description">
            <p><?= $categoryOptions['description'] ?></p>
          </div>  
        <?php endif; ?>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/sorting.php'; ?>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/category.php'; ?>
      <?php else: ?>  
        <h1 class="h h--1">Категория не найдена</h1>
        <p>Вы можете перейта на <a href="/">главную страницу</a>.</p>
      <?php endif; ?>  
    </div>
  </section>  
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/order.php'; ?>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>
