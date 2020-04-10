<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>
<main class="page-add">
  <h1 class="h h--1">Изменение товара</h1>
  <?php if (functions\isAdministrator()): ?>
    <?php if (isset($_GET['product_id']) && functions\issetRecord($_GET['product_id'], 'products')): ?> 
      <?php $productProperties = functions\getProductPropertiesForAdminPanel($_GET['product_id']); ?>
      <form class="custom-form editProduct" enctype="multipart/form-data" name="editProduct" method="post">
        <input type="hidden" name="productId" value="<?= $_GET['product_id'] ?>">
        <fieldset class="page-add__group custom-form__group">
          <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
          <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
            <input type="text" class="custom-form__input" name="product-name" id="product-name" value="<?= htmlspecialchars($_POST['product-name'] ?? $productProperties['name']) ?>" required="">
            <p class="custom-form__input-label">
              Название товара
            </p>
          </label>
          <label for="product-price" class="custom-form__input-wrapper">
            <input type="text" class="custom-form__input" name="product-price" id="product-price" value="<?= htmlspecialchars($_POST['product-price'] ?? $productProperties['price']) ?>" required="">
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
              <label for="product-photo">Заменить фотографию</label>
            </li>
          </ul>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
          <legend class="page-add__small-title custom-form__title">Раздел</legend>
          <div class="page-add__select">
            <select name="categories[]" class="custom-form__select" multiple="multiple">
              <option hidden="">Название раздела</option>
              <?php foreach (functions\getCategoiresDataForTheForm() as $categoryId => $categoryName): ?>
                <option <?= in_array($categoryId, $productProperties['categoriesIds']) ? 'selected' : '' ?> value="<?= $categoryId ?>"><?= $categoryName ?></option>
              <?php endforeach; ?>  
            </select>
          </div>
          <input type="checkbox" name="new" id="new" <?= $productProperties['new'] ? 'checked' : '' ?> class="custom-form__checkbox" value="1">
          <label for="new" class="custom-form__checkbox-label">Новинка</label>
          <input type="checkbox" name="sale" id="sale" <?= $productProperties['sale'] ? 'checked' : '' ?> class="custom-form__checkbox" value="1">
          <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
        </fieldset>
        <button class="button" type="submit">Обновить товар</button>
      </form>
      <section class="shop-page__popup-end page-add__popup-end" hidden="">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
          <h2 class="h h--1 h--icon shop-page__end-title"></h2>
        </div>
      </section>
    <?php else: ?>
      <p>Товар не найден.</p>
    <?php endif; ?>
  <?php else: ?>
    <p>Доступ запрещен.</p>
  <?php endif; ?>  
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>