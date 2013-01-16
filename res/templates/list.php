<?php use Herrera\Template\Engine; ?>
<ul>
<?php foreach (Engine::get($tpl['items'], array()) as $item): ?>
  <li><?php echo htmlentities($item); ?></li>
<?php endforeach; ?>
</ul>