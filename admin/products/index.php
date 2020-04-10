<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>
<main class="page-products">
  <h1 class="h h--1">Товары</h1>
  <?php if (functions\isAdministrator()): ?>
    <a class="page-products__button button" href="/admin/products/add/">Добавить товар</a>
    <div class="page-products__header">
      <span class="page-products__header-field">Название товара</span>
      <span class="page-products__header-field">ID</span>
      <span class="page-products__header-field">Цена</span>
      <span class="page-products__header-field">Категория</span>
      <span class="page-products__header-field">Новинка</span>
      <!--span class="page-products__header-field">Распродажа</span-->
    </div>
    <ul class="page-products__list">
      <?php $products = functions\getAllProductsForAdminPanel(); ?>
      <?php foreach ($products['items'] as $product): ?>
        <li class="product-item page-products__item">
          <b class="product-item__name"><?= $product['name'] ?></b>
          <span class="product-item__field"><?= $product['id'] ?></span>
          <span class="product-item__field"><?= $product['price'] ?> руб.</span>
          <span class="product-item__field"><?= $product['categories'] ?></span>
          <span class="product-item__field"><?= $product['new'] ? 'Да' : 'Нет' ?></span>
          <!--span class="product-item__field"><?= $product['sale'] ? 'Да' : 'Нет' ?></span-->
          <a href="/admin/products/edit/?product_id=<?= $product['id'] ?>" class="product-item__edit" aria-label="Редактировать"></a>
          <button class="product-item__delete" data-product-id="<?= $product['id'] ?>"></button>
        </li>
     <?php endforeach; ?>
    </ul>
    <? if (functions\hasPagination($products['count'])): ?>
      <?php functions\getPagination($products['count']);  ?>
    <? endif; ?>
  <?php else: ?>  
    <p>Доступ запрещен.</p>
  <?php endif; ?>    
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>