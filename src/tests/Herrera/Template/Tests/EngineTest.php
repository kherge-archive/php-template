<?php

namespace Herrera\Template\Tests;

use Herrera\Template\Engine;
use Herrera\FileLocator\Locator\FileSystemLocator;
use PHPUnit_Framework_TestCase as TestCase;

class EngineTest extends TestCase
{
    /**
     * @var Engine
     */
    private $engine;

    public function testDefaultLocator()
    {
        $this->assertInstanceOf(
            'Herrera\\FileLocator\\Collection',
            $this->engine->getLocator()
        );
    }

    public function testGet()
    {
        $this->assertSame(456, Engine::get($var, 456));

        $var = 123;

        $this->assertSame(123, Engine::get($var, 456));
    }

    public function testGetLocator()
    {
        $this->assertInstanceOf(
            'Herrera\\FileLocator\\Locator\\LocatorInterface',
            $this->engine->getLocator()
        );
    }

    public function testRenderNotExist()
    {
        $this->setExpectedException(
            'Herrera\\Template\\Exception\\InvalidArgumentException',
            'The template "test" does not exist.'
        );

        $this->engine->render('test');
    }

    public function testRender()
    {
        $this->assertEquals(trim(
            <<<RENDER
<ul>
  <li>1</li>
  <li>two</li>
  <li>3</li>
  <li>four</li>
</ul>
RENDER
            ),
            $this->engine->render(
                'list.php',
                array(
                    'items' => array(1, 'two', 3, 'four')
                ),
                true
            )
        );
    }

    public function testSetLocator()
    {
        $locator = new FileSystemLocator(null);

        $this->engine->setLocator($locator);

        $this->assertSame($locator, $this->engine->getLocator());
    }

    protected function setUp()
    {
        $this->engine = new Engine();
        $this->engine->getLocator()->add(new FileSystemLocator(
            __DIR__ . '/../../../../../res/templates'
        ));
    }
}