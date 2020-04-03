<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>
<main class="page-add for-category">
  <h1 class="h h--1">Добавление категории</h1>
  <?php if (functions\isAdministrator()): ?>
    <form class="custom-form category" name="addCategory" method="post">
      <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" placeholder="Название" class="custom-form__input" required="">    
      <input type="text" name="slug" value="<?= htmlspecialchars($_POST['slug'] ?? '') ?>" placeholder="Символьный код" class="custom-form__input" required="">
      <textarea name="description" class="custom-form__textarea" placeholder="Описание"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
      <button class="button" type="submit">Добавить</button>
    </form>
    <section class="shop-page__popup-end page-add__popup-end" hidden="">
      <div class="shop-page__wrapper shop-page__wrapper--popup-end">
        <h2 class="h h--1 h--icon shop-page__end-title"></h2>
      </div>
    </section> 
  <? else: ?>
    <p>Доступ запрещен.</p>
  <? endif; ?>  
</main>  
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>