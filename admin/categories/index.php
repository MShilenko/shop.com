<?php 

include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php'; 
include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/top.php';

$allCAtegories = functions\getAllCategoriesForAdminPanel();
?>
<h1>Категории</h1>
<table class="categories">
  <tbody>
    <tr>
      <th>Id</th>
      <th>Название</th>
      <th>Символьный код</th>
      <th>Описание</th>
      <th>Автор</th>
      <th><a href="add">Добавить новую</a></th>
    </tr>
    <?php foreach ($allCAtegories as $category): ?>
      <tr>
        <td><?= $category['id'] ?></td>
        <td><?= $category['name'] ?></td>
        <td><?= $category['slug'] ?></td>
        <td><?= $category['description'] ?></td>
        <td><?= $category['user_email'] ?></td>
        <td><a href="edit/?category_id=<?= $category['id'] ?>">Изменить</a></td>
      </tr>
    <?php endforeach; ?>    
  </tbody>
</table>
<?php 

include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/bottom.php';
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; 
?>