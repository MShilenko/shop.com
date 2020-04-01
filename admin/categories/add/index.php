<?php 

include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; 
include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/top.php';

?>
<h1>Добавить новую категорию</h1>
  <form class="custom-form category" name="addCategory" method="post">
    <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" placeholder="Название" class="custom-form__input" required="">    
    <input type="text" name="slug" value="<?= htmlspecialchars($_POST['slug'] ?? '') ?>" placeholder="Символьный код" class="custom-form__input" required="">
    <textarea name="description" class="custom-form__textarea" placeholder="Описание"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
    <button class="button" type="submit">Добавить</button>
  </form> 
<?php 

include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/bottom.php';
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; 
?>