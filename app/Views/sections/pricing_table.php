<?php
use App\Models\Content;
$grupos = Content::plansByService();
?>
<?php echo partial('partials/band-open', ['lienzo' => $lienzo, 'regla' => $regla, 'id' => 'comparativa']); ?>
  <?php echo partial('partials/head-block', ['section' => $section, 'n' => $n, 'split' => true]); ?>

  <div class="sheet rise">
    <div class="sheet__scroll">
      <table>
        <caption class="visually-hidden">Comparación de precios de los servicios de paginasweb.gt</caption>
        <thead>
          <tr>
            <th scope="col"><span class="visually-hidden">Concepto</span></th>
            <?php foreach ($grupos as $g): ?>
            <th scope="col" class="h-svc">
              <small>Servicio</small>
              <?php echo e($g['service']['short_name']); ?>
            </th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Precio anual</th>
            <?php foreach ($grupos as $g): $p = isset($g['plans'][0]) ? $g['plans'][0] : null; ?>
            <td>
              <span class="money"><?php echo $p && $p['price'] !== null ? e(money($p['price'])) : e($p ? $p['price_text'] : '—'); ?></span>
              <?php if ($p && $p['price_strike'] !== null): ?><span class="was"><?php echo e(money($p['price_strike'])); ?></span><?php endif; ?>
            </td>
            <?php endforeach; ?>
          </tr>
          <tr>
            <th scope="row">Pago inicial</th>
            <?php foreach ($grupos as $g): $p = isset($g['plans'][0]) ? $g['plans'][0] : null; ?>
            <td><?php echo $p && $p['initial_payment'] !== null ? e(money($p['initial_payment'])) : 'A convenir'; ?></td>
            <?php endforeach; ?>
          </tr>
          <tr>
            <th scope="row">Saldo al aprobar</th>
            <?php foreach ($grupos as $g): $p = isset($g['plans'][0]) ? $g['plans'][0] : null; ?>
            <td><?php echo $p && $p['balance_payment'] !== null ? e(money($p['balance_payment'])) : '—'; ?></td>
            <?php endforeach; ?>
          </tr>
          <tr>
            <th scope="row">Para quién es</th>
            <?php foreach ($grupos as $g): ?>
            <td><?php echo e($g['service']['tagline']); ?></td>
            <?php endforeach; ?>
          </tr>
          <tr>
            <th scope="row">Qué incluye</th>
            <?php foreach ($grupos as $g):
              $p = isset($g['plans'][0]) ? $g['plans'][0] : null;
              $feats = $p ? array_slice(array_filter(array_map('trim', explode("\n", $p['features']))), 0, 5) : []; ?>
            <td>
              <ul><?php foreach ($feats as $f): ?><li><?php echo e($f); ?></li><?php endforeach; ?></ul>
            </td>
            <?php endforeach; ?>
          </tr>
          <tr>
            <th scope="row">Detalle</th>
            <?php foreach ($grupos as $g): ?>
            <td class="sheet__cta">
              <a class="link-arrow" href="/<?php echo e($g['service']['page_slug']); ?>/">
                Ver servicio <?php echo partial('partials/icon', ['name' => 'flecha', 'size' => 13]); ?>
              </a>
            </td>
            <?php endforeach; ?>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="plans rise" style="margin-top:clamp(40px,5vw,72px)">
    <?php foreach ($grupos as $g) {
      foreach ($g['plans'] as $p) {
        echo partial('partials/plan', ['plan' => $p, 'servicioNombre' => $g['service']['short_name']]);
      }
    } ?>
  </div>
<?php echo partial('partials/band-close'); ?>
