<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; ?>
<?php if (functions\isAuth()): ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/top.php'; ?>
  <?php if (functions\isAdministrator() || functions\isRedactor()): ?>
    <p>Админка</p>
  <?php else: ?>
    <p>Доступ закрыт</p>
  <?php endif; ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/bottom.php'; ?>
<?php else: ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/authorization.php'; ?> 
<?php endif; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>