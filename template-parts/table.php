<?php
/*
    Template Name: Tabela - kursy walut
   
*/
get_header();

$currenty = get_currenty();
$array_currency = ['USD', 'EUR', 'PLN', 'GBP', 'NOK', 'CHF', 'CZK', 'SEK'];

?>
<div class="container">
  <div class="currency">
    <table>
      <thead>
        <tr>
          <th>Waluta</th>
          <th>Buy</th>
          <th>Sell</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($currenty as $item) : ?>
          <?php if (in_array($item['post_title'], $array_currency)) : ?>
            <tr>
              <td> <?= $item['post_title'] ?></td>
              <td> <?= currency_status($item) ?></td>
              <td> <?= currency_status($item, 'sell') ?></td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php

get_footer();
