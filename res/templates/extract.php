<?php use Herrera\Template\Engine; ?>
<ul>
<?php foreach (Engine::get($items, array()) as $item): ?>
  <li><?php echo htmlentities($item); ?></li>
<?php endforeach; ?>
</ul>
