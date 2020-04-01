<?php 

include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; 
include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/top.php';
?>
<h1>Изменить категорию</h1>
  <?php if (isset($_GET['category_id']) && functions\issetCategory($_GET['category_id'])): ?> 
    <?php $categoryProperties = functions\getCategoryPropertiesForAdminPanel($_GET['category_id']); ?>
    <form class="custom-form category" name="editCategory" method="post">
      <input type="hidden" name="categoryId" value="<?= $_GET['category_id'] ?>">
      <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? $categoryProperties['name']) ?>" placeholder="Название" class="custom-form__input" required="">    
      <input type="text" name="slug" value="<?= htmlspecialchars($_POST['slug'] ?? $categoryProperties['slug']) ?>" placeholder="Символьный код" class="custom-form__input" required="">
      <textarea name="description" class="custom-form__textarea" placeholder="Описание"><?= htmlspecialchars($_POST['description'] ?? $categoryProperties['description']) ?></textarea>
      <button class="button" type="submit">Обновить</button>
    </form> 
  <?php else: ?>  
    <p>Нет такой категории.</p>
  <?php endif; ?>    
<?php 

include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/bottom.php';
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; 
?>