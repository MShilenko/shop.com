<main class="page-delivery">
  <?php $pageOptions = functions\getPageOptionsForFront(functions\getPageId()); ?>
  <h1 class="h h--1 category-h1"><?= $pageOptions['name'] ?></h1>
  <?= functions\isDelivery() ? functions\replaceDeliveryInformation($pageOptions['description']) : $pageOptions['description'] ?>
</main>