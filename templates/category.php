<section class="shop__list">
  <?php foreach ($products['items'] as $product): ?>
    <article class="shop__item product" tabindex="0" data-product-id="<?= $product['id'] ?>">
      <div class="product__image">
        <img src="/<?= PRODUCTS_IMAGE_FOLDER . $product['image'] ?>" alt="<?= $product['name'] ?>">
      </div>
      <p class="product__name"><?= $product['name'] ?></p>
      <span class="product__price"><?= $product['price'] ?> руб.</span>
    </article>
  <?php endforeach; ?>
</section>
<? if (functions\hasPagination($products['count'])): ?>
  <?php functions\getPagination($products['count']);  ?>
<? endif; ?>