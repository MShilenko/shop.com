<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>
<main class="page-add for-category">
  <h1 class="h h--1">Изменение страницы</h1>
  <?php if (functions\isAdministrator()): ?>
    <?php if (isset($_GET['page_id']) && functions\issetRecord($_GET['page_id'], 'pages')): ?> 
      <?php $pageProperties = functions\getPagePropertiesForAdminPanel($_GET['page_id']); ?>
      <form class="custom-form page" name="editPage" method="post">
        <input type="hidden" name="pageId" value="<?= $_GET['page_id'] ?>">
        <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? $pageProperties['name']) ?>" placeholder="Название" class="custom-form__input" required="">    
        <input type="text" name="slug" value="<?= htmlspecialchars($_POST['slug'] ?? $pageProperties['slug']) ?>" placeholder="Символьный код" class="custom-form__input" required="">
        <textarea name="description" class="custom-form__textarea" placeholder="Описание"><?= htmlspecialchars($_POST['description'] ?? $pageProperties['description']) ?></textarea>
        <button class="button" type="submit">Изменить</button>
      </form>
      <section class="shop-page__popup-end page-add__popup-end" hidden="">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
          <h2 class="h h--1 h--icon shop-page__end-title"></h2>
        </div>
      </section> 
    <?php else: ?>  
      <p>Страница не найдена.</p>
    <?php endif; ?> 
  <? else: ?>
    <p>Доступ запрещен.</p>
  <? endif; ?>  
</main>  
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>