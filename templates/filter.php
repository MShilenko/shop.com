<?php $pricesRange = functions\getProductsRange(); ?>
<section class="shop__filter filter">
  <form name="filter" method="get">
  <div class="filter__wrapper">
    <b class="filter__title">Категории</b>
    <ul class="filter__list">
      <li>
        <a class="filter__list-item active" href="/">Все</a>
      </li>
      <?php foreach(functions\getCategoriesMenu() as $menuItem): ?>
        <li>
          <a class="filter__list-item" href="<?= PRODUCTS_CATEGORIES_PATH . $menuItem['slug'] . '/' ?>"><?= $menuItem['name'] ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
    <div class="filter__wrapper">
      <b class="filter__title">Фильтры</b>
      <div class="filter__range range">
        <span class="range__info">Цена</span>
        <div class="range__line" aria-label="Range Line"></div>
        <div class="range__res">
          <span class="range__res-item min-price"><?= $_GET['minPrice'] ?? $pricesRange['min_price'] ?> руб.</span>
          <span class="range__res-item max-price"><?= $_GET['maxPrice'] ?? $pricesRange['max_price'] ?> руб.</span>
        </div>
      </div>
    </div>

    <fieldset class="custom-form__group">
      <input type="hidden" name="minPrice" value="<?= $_GET['minPrice'] ?? $pricesRange['min_price'] ?>">
      <input type="hidden" name="maxPrice" value="<?= $_GET['maxPrice'] ?? $pricesRange['max_price'] ?>">
      <?php if (isset($_GET['new'])): ?>
        <input type="checkbox" name="new" id="new" class="custom-form__checkbox"<?= $_GET['new'] == 'on' ? 'checked' : '' ?>>
      <?php else: ?>  
        <input type="checkbox" name="new" id="new" class="custom-form__checkbox">
      <?php endif; ?> 
      <label for="new" class="custom-form__checkbox-label custom-form__info" style="display: block;">Новинка</label>
      <?php if (isset($_GET['sale'])): ?>
        <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox"<?= $_GET['sale'] == 'on' ? 'checked' : '' ?>>
      <?php else: ?>  
        <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox">
      <?php endif; ?>    
      <label for="sale" class="custom-form__checkbox-label custom-form__info" style="display: block;">Распродажа</label>
    </fieldset>
    <button class="button" type="submit" style="width: 100%">Применить</button>
  </form>
</section>

<script type="text/javascript">
  const MIN_PRICE = <?= $pricesRange['min_price'] ?>;
  const MAX_PRICE = <?= $pricesRange['max_price'] ?>;
</script>