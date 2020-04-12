<ul class="shop__paginator paginator">
  <?php for ($i = 1; $i <= $rows; $i++): ?>
    <li>
      <? if (isset($_GET['page'])): ?>      
        <a class="paginator__item<?= $i == $_GET['page'] ? ' active' : '' ?>" href="<?= functions\getPaginationStartQuery($i) ?>"><?= $i ?></a>
      <? else: ?>  
        <a class="paginator__item" href="<?= functions\getPaginationStartQuery($i) ?>"><?= $i ?></a>
      <? endif; ?>  
    </li>
  <?php endfor; ?>
</ul>
