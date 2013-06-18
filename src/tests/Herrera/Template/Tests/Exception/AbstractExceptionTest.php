<?php

namespace Herrera\Template\Tests\Exception;

use Herrera\PHPUnit\TestCase;
use Herrera\Template\Exception\TemplateNotFoundException;

class AbstractExceptionTest extends TestCase
{
    public function testFormat()
    {
        $this->assertEquals(
            'Test message.',
            TemplateNotFoundException::format('%s message.', 'Test')
                ->getMessage()
        );
    }
}
