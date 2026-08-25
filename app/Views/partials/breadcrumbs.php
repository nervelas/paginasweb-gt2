<?php if (!empty($crumbs) && count($crumbs) > 1): ?>
<nav class="breadcrumbs wrap" aria-label="Ruta de navegación">
  <ol>
    <?php $last = count($crumbs) - 1; foreach ($crumbs as $i => $crumb): ?>
    <li>
      <?php if ($i === $last): ?>
        <span aria-current="page"><?php echo e($crumb['name']); ?></span>
      <?php else: ?>
        <a href="<?php echo e($crumb['url']); ?>"><?php echo e($crumb['name']); ?></a>
      <?php endif; ?>
    </li>
    <?php endforeach; ?>
  </ol>
</nav>
<?php endif; ?>
