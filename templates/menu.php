<?php if (functions\isAuth() && functions\isAdminFolder()): ?>
  <li>
    <a class="main-menu__item" href="/admin/">Главная</a>
  </li>
  <?php if (functions\isAdministrator()): ?>
    <li>
      <a class="main-menu__item" href="/admin/categories/">Категории</a>
    </li>
    <li>
      <a class="main-menu__item" href="/admin/products/">Товары</a>
    </li>
  <? endif; ?> 
  <?php if (functions\isAdministrator() || functions\isRedactor()): ?> 
    <li>
      <a class="main-menu__item" href="/admin/orders/">Заказы</a>
    </li>
  <? endif; ?>
  <li>
    <a class="main-menu__item" href="/admin/?login=no">Выйти</a>
  </li>
<?php else: ?>
  <li>
    <a class="main-menu__item" href="/">Главная</a>
  </li>
  <li>
    <a class="main-menu__item" href="/?new=on">Новинки</a>
  </li>
  <li>
    <a class="main-menu__item" href="/?sale=on">Sale</a>
  </li>
  <li>
    <a class="main-menu__item" href="delivery.html">Доставка</a>
  </li>
<?php endif; ?>