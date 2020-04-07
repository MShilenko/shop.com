<ul class="shop__paginator paginator">
  <?php for ($i = 1; $i <= $rows; $i++): ?>
    <li>
      <a class="paginator__item" href="?page=<?= $i ?>"><?= $i ?></a>
    </li>
  <?php endfor; ?>
</ul>
