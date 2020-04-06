<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>
<?php if (functions\isAuth()): ?>
  <main class="page-products categories">
    <h1 class="h h--1">Административная панель</h1>    
    <?php if (functions\isAdministrator()): ?>
      <?php $settings = functions\getSettingForAdminForm(); ?>
      <section class="settings-block">
        <form class="custom-form settings" name="editSettings" method="post">
          <div class="h h--1">Адрес пункта самовывоза</div>
          <fieldset class="page-add__group custom-form__group">
            <legend class="custom-form__title">Город</legend>
            <input type="text" name="city" value="<?= htmlspecialchars($_POST['city'] ?? $settings['city']) ?>" class="custom-form__input" required="">
          </fieldset>
          <fieldset class="page-add__group custom-form__group">
            <legend class="custom-form__title">Улица</legend>
            <input type="text" name="street" value="<?= htmlspecialchars($_POST['street'] ?? $settings['street']) ?>" class="custom-form__input" required="">
          </fieldset>
          <fieldset class="page-add__group custom-form__group">
            <legend class="custom-form__title">Дом</legend>
            <input type="text" name="house" value="<?= htmlspecialchars($_POST['house'] ?? $settings['house']) ?>" class="custom-form__input" required="">
          </fieldset>
          <fieldset class="page-add__group custom-form__group">
            <legend class="custom-form__title">Метро</legend>
            <input type="text" name="metro" value="<?= htmlspecialchars($_POST['metro'] ?? $settings['metro']) ?>" class="custom-form__input">
          </fieldset>
          <hr>
          <div class="h h--1">Настройки заказа</div>
          <fieldset class="page-add__group custom-form__group">
            <legend class="custom-form__title">Минимальная цена заказа</legend>
            <input type="text" name="min_price" value="<?= htmlspecialchars($_POST['min_price'] ?? $settings['min_price']) ?>" class="custom-form__input" required="">
          </fieldset>
          <fieldset class="page-add__group custom-form__group">
            <legend class="custom-form__title">Стоимость доставки</legend>
            <input type="text" name="delivery_cost" value="<?= htmlspecialchars($_POST['delivery_cost'] ?? $settings['delivery_cost']) ?>" class="custom-form__input" required="">
          </fieldset>
          <button class="button" type="submit">Обновить</button>
        </form>
      </section>  
      <section class="shop-page__popup-end page-add__popup-end" hidden="">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
          <h2 class="h h--1 h--icon shop-page__end-title"></h2>
        </div>
      </section> 
    <?php elseif (functions\isRedactor()): ?>  
      <p>Для начала работы выберите раздел меню.</p>
    <?php else: ?>
      <p>Доступ закрыт.</p>
    <?php endif; ?>
  </main>
<?php else: ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/authorization.php'; ?> 
<?php endif; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>