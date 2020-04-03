<?php 

include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; 
$allCAtegories = functions\getAllCategoriesForAdminPanel();
?>
<main class="page-products categories">
  <h1 class="h h--1">Категории товаров</h1>
  <?php if (functions\isAdministrator()): ?>
  <a class="page-products__button button" href="/admin/categories/add/">Добавить категорию</a>
  <div class="page-products__header">
    <span class="page-products__header-field">Название категории</span>
    <span class="page-products__header-field">ID</span>
    <span class="page-products__header-field">Символьный код</span>
    <span class="page-products__header-field description">Описание</span>
    <span class="page-products__header-field">Автор</span>
  </div>
  <ul class="page-products__list">
    <?php foreach ($allCAtegories as $category): ?>
      <li class="product-item page-products__item">
        <b class="product-item__name"><?= $category['name'] ?></b>
        <span class="product-item__field"><?= $category['id'] ?></span>
        <span class="product-item__field"><?= $category['slug'] ?></span>
        <span class="product-item__field description"><?= $category['description'] ?></span>
        <span class="product-item__field"><?= $category['user_email'] ?></span>
        <a href="/admin/categories/edit/?category_id=<?= $category['id'] ?>" class="product-item__edit" aria-label="Редактировать"></a>
      </li>
    <?php endforeach; ?>  
  </ul>
  <? else: ?>
    <p>Доступ запрещен.</p>
  <? endif; ?>  
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>