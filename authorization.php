<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>    
<main class="page-authorization">
  <h1 class="h h--1">Авторизация</h1>
  <?php if (isset($_SESSION['auth'])): ?>
    <p>Вы авторизованы. Перейти в <a href="/admin/">административный раздел</a>.</p>
  <?php else: ?>
    <?php if (!empty($_POST['userAuthorization']) && !$isAuth): ?>
      <div class="status error">Авторизация не пройдена. Проверьте данные.</div>
    <?php endif;?>
    <form class="custom-form" name="authorization" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
      <input type="hidden" name="userAuthorization" value="yes">
      <?php if(isset($_COOKIE['login']) && !isset($_SESSION['auth'])): ?>
        <input type="email" name="email" value="<?= htmlspecialchars($_COOKIE['login']) ?>" class="custom-form__input" required="">
      <?php else: ?>
        <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" class="custom-form__input" required="">    
      <?php endif; ?>  
      <input type="password" name="password" value="<?= htmlspecialchars($_POST['password'] ?? '') ?>" class="custom-form__input" required="">
      <button class="button" type="submit">Войти в личный кабинет</button>
    </form>
  <?php endif; ?> 
</main>   
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>

