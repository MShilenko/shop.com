<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>
<main class="page-add">
  <h1 class="h h--1">Добавление товара</h1>
  <?php if (functions\isAdministrator()): ?>
    <form class="custom-form" enctype="multipart/form-data" name="addProduct" method="post">
      <fieldset class="page-add__group custom-form__group">
        <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
        <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
          <input type="text" class="custom-form__input" name="product-name" id="product-name" value="<?= htmlspecialchars($_POST['product-name'] ?? '') ?>" required="">
          <p class="custom-form__input-label">
            Название товара
          </p>
        </label>
        <label for="product-price" class="custom-form__input-wrapper">
          <input type="text" class="custom-form__input" name="product-price" id="product-price" value="<?= htmlspecialchars($_POST['product-price'] ?? '') ?>" required="">
          <p class="custom-form__input-label">
            Цена товара
          </p>
        </label>
      </fieldset>
      <fieldset class="page-add__group custom-form__group">
        <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
        <ul class="add-list">
          <li class="add-list__item add-list__item--add">
            <input type="file" name="product-photo" id="product-photo" hidden="" accept="<?= ALLOWED_FILE_TYPES ?>">
            <label for="product-photo">Добавить фотографию</label>
          </li>
        </ul>
      </fieldset>
      <fieldset class="page-add__group custom-form__group">
        <legend class="page-add__small-title custom-form__title">Раздел</legend>
        <div class="page-add__select">
          <select name="categories[]" class="custom-form__select" multiple="multiple">
            <option hidden="">Название раздела</option>
            <?php foreach (functions\getCategoiresDataForTheForm() as $categoryId => $categoryName): ?>
              <option value="<?= $categoryId ?>"><?= $categoryName ?></option>
            <?php endforeach; ?>  
          </select>
        </div>
        <input type="checkbox" name="new" id="new" class="custom-form__checkbox" value="1">
        <label for="new" class="custom-form__checkbox-label">Новинка</label>
        <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox" value="1">
        <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
      </fieldset>
      <button class="button" type="submit">Добавить товар</button>
    </form>
    <section class="shop-page__popup-end page-add__popup-end" hidden="">
      <div class="shop-page__wrapper shop-page__wrapper--popup-end">
        <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно добавлен</h2>
      </div>
    </section>
  <?php else: ?>
    <p>Доступ запрещен.</p>
  <?php endif; ?>  
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>