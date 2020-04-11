<ul class="shop__paginator paginator">
  <?php $startQuery = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY); ?>  
  <?php for ($i = 1; $i <= $rows; $i++): ?>
    <li>
      <? if (isset($_GET['page'])): ?>      
        <a class="paginator__item<?= $i == $_GET['page'] ? ' active' : '' ?>" href="?page=<?= $i ?><?= !empty($startQuery) ? '&' . $startQuery : '' ?>"><?= $i ?></a>
      <? else: ?>  
        <a class="paginator__item" href="?page=<?= $i ?><?= !empty($startQuery) ? '&' . $startQuery : '' ?>"><?= $i ?></a>
      <? endif; ?>  
    </li>
  <?php endfor; ?>
</ul>
