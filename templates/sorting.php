<section class="shop__sorting">
  <div class="shop__sorting-item custom-form__select-wrapper">
    <select class="custom-form__select" name="sort_q">
      <option hidden="">Сортировка</option>
      <?php if (isset($_GET['sort_q'])): ?>
      <option value="price"<?= $_GET['sort_q'] == 'price' ? ' selected' : '' ?>>По цене</option>
      <option value="name"<?= $_GET['sort_q'] == 'name' ? ' selected' : '' ?>>По названию</option>
      <?php else: ?>
        <option value="price">По цене</option>
        <option value="name">По названию</option>
      <?php endif; ?>  
    </select>
  </div>
  <div class="shop__sorting-item custom-form__select-wrapper">
    <select class="custom-form__select" name="sort_d">
      <option hidden="">Порядок</option>
      <?php if (isset($_GET['sort_d'])): ?>
        <option value="asc"<?= $_GET['sort_d'] == 'asc' ? ' selected' : '' ?>>По возрастанию</option>
        <option value="desc"<?= $_GET['sort_d'] == 'desc' ? ' selected' : '' ?>>По убыванию</option>
      <?php else: ?>
        <option value="asc">По возрастанию</option>
        <option value="desc">По убыванию</option>
      <?php endif; ?> 
    </select>
  </div>
  <div class="shop__sorting-item">
    <button class="button">Сортировать</button>
  </div>
  <p class="shop__sorting-res">Найдено <span class="res-sort"><?= $products['count'] ?></span> <?= functions\getEnding($products['count']) ?></p>
</section>