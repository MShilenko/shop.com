<?php 

include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; 
$allPages = functions\getAllPagesForAdminPanel();
?>
<main class="page-products pages">
  <h1 class="h h--1">Страницы</h1>
  <?php if (functions\isAdministrator()): ?>
  <a class="page-products__button button" href="/admin/pages/add/">Добавить страницу</a>
  <div class="page-products__header">
    <span class="page-products__header-field">Название категории</span>
    <span class="page-products__header-field">ID</span>
    <span class="page-products__header-field">Символьный код</span>
    <span class="page-products__header-field description">Описание</span>
    <span class="page-products__header-field">Автор</span>
  </div>
  <ul class="page-products__list">
    <?php foreach ($allPages as $page): ?>
      <li class="product-item page-products__item">
        <b class="product-item__name"><?= $page['name'] ?></b>
        <span class="product-item__field"><?= $page['id'] ?></span>
        <span class="product-item__field"><?= $page['slug'] ?></span>
        <span class="product-item__field description"><?= functions\prepareDescription($page['description']) ?></span>
        <span class="product-item__field"><?= $page['user_email'] ?></span>
        <a href="/admin/pages/edit/?page_id=<?= $page['id'] ?>" class="product-item__edit" aria-label="Редактировать"></a>
        <button class="product-item__delete" data-page-id="<?= $page['id'] ?>"></button>
      </li>
    <?php endforeach; ?>  
  </ul>
  <? else: ?>
    <p>Доступ запрещен.</p>
  <? endif; ?>  
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>