Template
========

A simple templating engine using regular PHP files.

Usage
-----

```php
<?php

use Herrera\FileLocator\Locator\FileLocator;
use Herrera\Template\Engine;

$locator = new FileSystemLocator('/path/to/templates');
$engine = new Engine($locator);

$engine->render('list.php', array(
    'items' => array(1, 'two', 3, 'four')
));
```

render:

```html
<ul>
  <li>1</li>
  <li>two</li>
  <li>3</li>
  <li>four</li>
</ul>
```