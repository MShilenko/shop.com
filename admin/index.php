<?php include $_SERVER['DOCUMENT_ROOT'] . './templates/header.php'; ?>
<main class="page-admin">
  <div class="side">
    <div class="head">Административный раздел | <a href="?login=no">Выйти</a></div>
  </div>
  <div class="main-block">
    <?php if (functions\isAdministrator() || functions\isRedactor()): ?>
      <p>Админка</p>
    <?php else: ?>
      <p>Доступ закрыт</p>
    <?php endif; ?>
  </div>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>