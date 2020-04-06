<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>
<main class="page-order">
  <h1 class="h h--1">Список заказов</h1>
  <?php if (functions\canWorkWithOrders()): ?>
    <?php $allOrders = functions\getAllOrdersForAdminPanel(); ?>
    <ul class="page-order__list">
      <?php foreach ($allOrders as $order): ?>
        <li class="order-item page-order__item">
          <div class="order-item__wrapper">
            <div class="order-item__group order-item__group--id">
              <span class="order-item__title">Номер заказа</span>
              <span class="order-item__info order-item__info--id"><?= $order['id'] ?></span>
            </div>
            <div class="order-item__group">
              <span class="order-item__title">Сумма заказа</span>
              <?= functions\getTheFinalPrice($order['product_price']) ?> руб.
            </div>
            <button class="order-item__toggle"></button>
          </div>
          <div class="order-item__wrapper">
            <div class="order-item__group order-item__group--margin">
              <span class="order-item__title">Заказчик</span>
              <span class="order-item__info"><?= $order['customer'] ?></span>
            </div>
            <div class="order-item__group">
              <span class="order-item__title">Номер телефона</span>
              <span class="order-item__info"><?= $order['customer_phone'] ?></span>
            </div>
            <div class="order-item__group">
              <span class="order-item__title">Способ доставки</span>
              <span class="order-item__info"><?= $order['delivery'] ? 'Курьерная доставка' : 'Самовывоз' ?></span>
            </div>
            <div class="order-item__group">
              <span class="order-item__title">Способ оплаты</span>
              <span class="order-item__info"><?= $order['delivery'] ? 'Наличными' : 'Банковской картой' ?></span>
            </div>
            <div class="order-item__group order-item__group--status">
              <span class="order-item__title">Статус заказа</span>
              <span class="order-item__info <?= $order['processed'] ? 'order-item__info--yes' : 'order-item__info--no' ?>"><?= $order['processed'] ? 'Выполнено' : 'Не выполнено' ?></span>
              <button class="order-item__btn" data-order-id=<?= $order['id'] ?>>Изменить</button>
            </div>
          </div>
          <?php if ($order['delivery']): ?>
            <div class="order-item__wrapper">
              <div class="order-item__group">
                <span class="order-item__title">Адрес доставки</span>
                <span class="order-item__info"><?= $order['address'] ?></span>
              </div>
            </div>
          <?php endif; ?>  
          <?php if ($order['comment']): ?>
            <div class="order-item__wrapper">
              <div class="order-item__group">
                <span class="order-item__title">Комментарий к заказу</span>
                <span class="order-item__info"><?= $order['comment'] ?></span>
              </div>
            </div>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
    <? else: ?>
      <p>Доступ запрещен.</p>
    <? endif; ?>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>