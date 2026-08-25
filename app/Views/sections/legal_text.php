<section class="section section--tight">
  <div class="wrap wrap-narrow">
    <div class="prose"><?php echo $section['body']; ?></div>
    <p style="margin-top:2.5rem;color:var(--ink-50);font-size:.88rem">
      Última actualización: <?php echo e(fecha_es($page['updated_at'])); ?>.
    </p>
  </div>
</section>
