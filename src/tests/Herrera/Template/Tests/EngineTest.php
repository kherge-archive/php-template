<?php

namespace Herrera\Template\Tests;

use Herrera\FileLocator\Locator\FileSystemLocator;
use Herrera\PHPUnit\TestCase;
use Herrera\Template\Engine;

class EngineTest extends TestCase
{
    private $cwd;
    private $dir;

    /**
     * @var Engine
     */
    private $engine;

    public function testConstructDefault()
    {
        $this->assertInstanceOf(
            'Herrera\\FileLocator\\Locator\\LocatorInterface',
            $this->getPropertyValue($this->engine, 'locator')
        );
    }

    public function testConstructAlt()
    {
        $locator = new FileSystemLocator(array());

        $engine = new Engine($locator);

        $this->assertSame(
            $locator,
            $this->getPropertyValue($engine, 'locator')
        );
    }

    public function testCreate()
    {
        $engine = Engine::create(__DIR__);

        $this->assertInstanceOf(
            'Herrera\\Template\\Engine',
            $engine
        );

        $locators = $this->getPropertyValue($engine, 'locator');

        /** @var $locators \SplObjectStorage */
        $locators = $this->getPropertyValue($locators, 'locators');

        $locators->rewind();

        $this->assertEquals(
            array(__DIR__),
            $this->getPropertyValue($locators->current(), 'directories')
        );
    }

    public function testDisplay()
    {
        $this->setPropertyValue(
            $this->engine,
            'locator',
            $this->getLocator()
        );

        file_put_contents(
            'test.php',
            <<<TEMPLATE
<?php echo \$var['title']; ?>:
<ul>
<?php foreach (\$var['items'] as \$item): ?>
  <li><?php echo \$item; ?></li>
<?php endforeach; ?>
</ul>
TEMPLATE
        );

        $this->expectOutputString(
            <<<OUTPUT
Example List:
<ul>
  <li>alpha</li>
  <li>beta</li>
  <li>gamma</li>
</ul>
OUTPUT
        );

        $this->engine['title'] = 'Example List';

        $this->engine->display(
            'test.php',
            array('items' => array('alpha', 'beta', 'gamma'))
        );
    }

    public function testDisplayException()
    {
        $this->setExpectedException(
            'Herrera\\Template\\Exception\\TemplateNotFoundException',
            'The template "test.php" does not exist.'
        );

        $this->engine->display('test.php');
    }

    public function testGetLocator()
    {
        $this->assertInstanceOf(
            'Herrera\\FileLocator\\Locator\\LocatorInterface',
            $this->getLocator()
        );
    }

    public function testRender()
    {
        $this->setPropertyValue(
            $this->engine,
            'locator',
            $this->getLocator()
        );

        file_put_contents(
            'test.php',
            <<<TEMPLATE
<?php echo \$var['title']; ?>:
<ul>
<?php foreach (\$var['items'] as \$item): ?>
  <li><?php echo \$item; ?></li>
<?php endforeach; ?>
</ul>
TEMPLATE
        );

        $this->engine['title'] = 'Example List';

        $this->assertEquals(
            <<<OUTPUT
Example List:
<ul>
  <li>alpha</li>
  <li>beta</li>
  <li>gamma</li>
</ul>
OUTPUT
            ,
            $this->engine->render(
                'test.php',
                array('items' => array('alpha', 'beta', 'gamma'))
            )
        );
    }

    public function testRenderException()
    {
        $this->setExpectedException(
            'Herrera\\Template\\Exception\\TemplateNotFoundException',
            'The template "test.php" does not exist.'
        );

        $this->engine->render('test.php');
    }

    public function testSetLocator()
    {
        $locator = $this->getLocator();

        $this->engine->setLocator($locator);

        $this->assertSame(
            $locator,
            $this->getPropertyValue($this->engine, 'locator')
        );
    }

    protected function getLocator()
    {
        return new FileSystemLocator(array($this->dir));
    }

    protected function setUp()
    {
        $this->cwd = getcwd();
        $this->dir = $this->createDir();

        chdir($this->dir);

        $this->engine = new Engine();
    }

    protected function tearDown()
    {
        chdir($this->cwd);
    }
}
