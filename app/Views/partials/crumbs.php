<?php if (!empty($crumbs) && count($crumbs) > 1): ?>
<nav class="crumbs" aria-label="Ruta de navegación">
  <div class="wrap">
    <ol>
      <?php $ultimo = count($crumbs) - 1; foreach ($crumbs as $i => $c): ?>
      <li>
        <?php if ($i === $ultimo): ?>
          <span aria-current="page"><?php echo e(excerpt($c['name'], 42)); ?></span>
        <?php else: ?>
          <a href="<?php echo e($c['url']); ?>"><?php echo e($c['name']); ?></a>
        <?php endif; ?>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</nav>
<?php endif; ?>
