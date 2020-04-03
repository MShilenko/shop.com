<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>
<?php if (functions\isAuth()): ?>
  <main class="page-products categories">
    <h1 class="h h--1">Административная панель</h1>    
    <?php if (functions\isAdministrator() || functions\isRedactor()): ?>
      <p>Для начала работы выберите раздел в меню.</p>
    <?php else: ?>
      <p>Доступ закрыт.</p>
    <?php endif; ?>
  </main>
<?php else: ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/authorization.php'; ?> 
<?php endif; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>