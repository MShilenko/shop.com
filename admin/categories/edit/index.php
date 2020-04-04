<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>
<main class="page-add for-category">
  <h1 class="h h--1">Изменение категории</h1>
  <?php if (functions\isAdministrator()): ?>
    <?php if (isset($_GET['category_id']) && functions\issetRecord($_GET['category_id'], 'categories')): ?> 
      <?php $categoryProperties = functions\getCategoryPropertiesForAdminPanel($_GET['category_id']); ?>
      <form class="custom-form category" name="editCategory" method="post">
        <input type="hidden" name="categoryId" value="<?= $_GET['category_id'] ?>">
        <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? $categoryProperties['name']) ?>" placeholder="Название" class="custom-form__input" required="">    
        <input type="text" name="slug" value="<?= htmlspecialchars($_POST['slug'] ?? $categoryProperties['slug']) ?>" placeholder="Символьный код" class="custom-form__input" required="">
        <textarea name="description" class="custom-form__textarea" placeholder="Описание"><?= htmlspecialchars($_POST['description'] ?? $categoryProperties['description']) ?></textarea>
        <button class="button" type="submit">Обновить</button>
      </form>
      <section class="shop-page__popup-end page-add__popup-end" hidden="">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
          <h2 class="h h--1 h--icon shop-page__end-title"></h2>
        </div>
      </section> 
    <?php else: ?>  
      <p>Категория не найдена.</p>
    <?php endif; ?>  
  <? else: ?>    
    <p>Доступ запрещен.</p>
  <? endif; ?>  
</main>  
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>