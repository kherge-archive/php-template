<?php

namespace Herrera\Template;

use Herrera\FileLocator\Collection;
use Herrera\FileLocator\Locator\FileSystemLocator;
use Herrera\FileLocator\Locator\LocatorInterface;
use Herrera\Template\Exception\InvalidArgumentException;

/**
 * Renders content using regular PHP scripts.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Engine
{
    /**
     * The template file locator.
     *
     * @var LocatorInterface
     */
    private $locator;

    /**
     * Sets the template file locator.
     *
     * @param LocatorInterface $locator The locator.
     */
    public function __construct(LocatorInterface $locator = null)
    {
        if (null === $locator) {
            $locator = new Collection();
        }

        $this->locator = $locator;
    }

    /**
     * Creates a new instance for the directory path(s).
     *
     * @param array|string The directory path(s).
     *
     * @return Engine The new instance.
     */
    public static function create($path)
    {
        $engine = new self();
        $engine->getLocator()->add(new FileSystemLocator($path));

        return $engine;
    }

    /**
     * Returns the variable, or the default value if not set.
     *
     * @param mixed $var     The variable.
     * @param mixed $default The default value.
     *
     * @return mixed The variable or default value.
     */
    public static function get(&$var, $default)
    {
        return isset($var) ? $var : $default;
    }

    /**
     * Returns the template file locator.
     *
     * @return LocatorInterface The locator.
     */
    public function getLocator()
    {
        return $this->locator;
    }

    /**
     * Renders and displays the template.
     *
     * @param string  $template The name of the template.
     * @param array   $vars     The template variables.
     * @param boolean $buffer   Buffer and return the result?
     *
     * @return string The template rendering.
     *
     * @throws InvalidArgumentException If the template does not exist.
     */
    public function render($template, array $vars = array(), $buffer = false)
    {
        if (null === ($path = $this->locator->locate($template))) {
            throw new InvalidArgumentException(sprintf(
                'The template "%s" does not exist.',
                $template
            ));
        }

        if ($buffer) {
            ob_start();
        }

        $this->renderInScope($path, $vars);

        if ($buffer) {
            return ob_get_clean();
        }

        // @codeCoverageIgnoreStart
    }
    // @codeCoverageIgnoreStop

    /**
     * Sets the template file locator.
     *
     * @param LocatorInterface $locator The locator.
     */
    public function setLocator(LocatorInterface $locator)
    {
        $this->locator = $locator;
    }

    /**
     * Renders the template in its own scope.
     *
     * @param string $__file__ The template file path.
     * @param array  $tpl      The template variables.
     */
    private function renderInScope($__file__, $tpl)
    {
        include $__file__;
    }
}