<?php
use App\Models\Content;
$grupos = Content::plansByService();
?>
<section class="section section--white reveal" id="comparativa">
  <div class="wrap">
    <div class="section-head">
      <?php if ($section['eyebrow']): ?><p class="eyebrow"><?php echo e($section['eyebrow']); ?></p><?php endif; ?>
      <h2><?php echo e($section['heading']); ?></h2>
      <?php if ($section['subheading']): ?><p class="sub"><?php echo e($section['subheading']); ?></p><?php endif; ?>
    </div>

    <div class="price-table-wrap">
      <table class="price-table">
        <caption class="visually-hidden">Comparación de precios de los servicios de paginasweb.gt</caption>
        <thead>
          <tr>
            <th scope="col">Concepto</th>
            <?php foreach ($grupos as $grupo): ?>
            <th scope="col"><?php echo e($grupo['service']['short_name']); ?></th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Precio anual</th>
            <?php foreach ($grupos as $grupo):
              $p = isset($grupo['plans'][0]) ? $grupo['plans'][0] : null; ?>
            <td>
              <span class="is-price"><?php echo $p && $p['price'] !== null ? e(money($p['price'])) : e($p ? $p['price_text'] : '—'); ?></span>
              <?php if ($p && $p['price_strike'] !== null): ?>
                <span class="is-strike"><?php echo e(money($p['price_strike'])); ?></span>
              <?php endif; ?>
            </td>
            <?php endforeach; ?>
          </tr>
          <tr>
            <th scope="row">Pago inicial</th>
            <?php foreach ($grupos as $grupo):
              $p = isset($grupo['plans'][0]) ? $grupo['plans'][0] : null; ?>
            <td><?php echo $p && $p['initial_payment'] !== null ? e(money($p['initial_payment'])) : 'A convenir'; ?></td>
            <?php endforeach; ?>
          </tr>
          <tr>
            <th scope="row">Saldo al aprobar</th>
            <?php foreach ($grupos as $grupo):
              $p = isset($grupo['plans'][0]) ? $grupo['plans'][0] : null; ?>
            <td><?php echo $p && $p['balance_payment'] !== null ? e(money($p['balance_payment'])) : '—'; ?></td>
            <?php endforeach; ?>
          </tr>
          <tr>
            <th scope="row">Para quién es</th>
            <?php foreach ($grupos as $grupo): ?>
            <td><?php echo e($grupo['service']['tagline']); ?></td>
            <?php endforeach; ?>
          </tr>
          <tr>
            <th scope="row">Qué incluye</th>
            <?php foreach ($grupos as $grupo):
              $p = isset($grupo['plans'][0]) ? $grupo['plans'][0] : null;
              $features = $p ? array_slice(array_filter(array_map('trim', explode("\n", $p['features']))), 0, 5) : []; ?>
            <td>
              <ul style="margin:0;padding-left:1.1em;font-size:.9rem">
                <?php foreach ($features as $f): ?><li><?php echo e($f); ?></li><?php endforeach; ?>
              </ul>
            </td>
            <?php endforeach; ?>
          </tr>
          <tr>
            <th scope="row">Más información</th>
            <?php foreach ($grupos as $grupo): ?>
            <td><a class="btn btn--ghost btn--sm" href="/<?php echo e($grupo['service']['page_slug']); ?>/">Ver detalle</a></td>
            <?php endforeach; ?>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="plans" style="margin-top:2.4rem">
      <?php foreach ($grupos as $grupo) {
        foreach ($grupo['plans'] as $plan) {
          echo partial('partials/plan-card', [
            'plan' => $plan,
            'mostrarServicio' => true,
            'servicioNombre' => $grupo['service']['short_name'],
          ]);
        }
      } ?>
    </div>
  </div>
</section>
