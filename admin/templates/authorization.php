<main class="page-authorization">
  <h1 class="h h--1">Авторизация</h1>
  <?php if (!empty($_POST['userAuthorization'])): ?>
    <div class="status error">Авторизация не пройдена. Проверьте данные.</div>
  <?php endif;?>
  <form class="custom-form" name="authorization" action="/admin/" method="POST">
    <input type="hidden" name="userAuthorization" value="yes">
    <?php if(isset($_COOKIE['login']) && !isset($_SESSION['auth'])): ?>
      <input type="email" name="email" value="<?= htmlspecialchars($_COOKIE['login']) ?>" placeholder="E-mail" class="custom-form__input" required="">
    <?php else: ?>
      <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="E-mail" class="custom-form__input" required="">
    <?php endif; ?>  
    <input type="password" name="password" value="<?= htmlspecialchars($_POST['password'] ?? '') ?>" placeholder="Пароль" class="custom-form__input" required="">
    <button class="button" type="submit">Войти в личный кабинет</button>
  </form> 
</main>


