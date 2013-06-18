<?php

namespace Herrera\Template;

use ArrayObject;
use Exception;
use Herrera\FileLocator\Collection;
use Herrera\FileLocator\Locator\FileSystemLocator;
use Herrera\FileLocator\Locator\LocatorInterface;
use Herrera\Template\Exception\TemplateNotFoundException;

/**
 * Renders content using regular PHP scripts.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Engine extends ArrayObject
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

        /** @var $locator Collection*/
        $locator = $engine->getLocator();

        $locator->add(new FileSystemLocator($path));

        return $engine;
    }

    /**
     * Renders a template and displays the result.
     *
     * @param string  $template The name of the template.
     * @param array   $vars     The template variables.
     *
     * @throws TemplateNotFoundException If the template does not exist.
     */
    public function display($template, array $vars = array())
    {
        if (null === ($path = $this->locator->locate($template))) {
            throw TemplateNotFoundException::format(
                'The template "%s" does not exist.',
                $template
            );
        }

        $this->renderInScope(
            $path,
            array_replace($this->getArrayCopy(), $vars)
        );
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
     * Renders a template and returns the result.
     *
     * @param string  $template The name of the template.
     * @param array   $vars     The template variables.
     *
     * @return string The template rendering.
     */
    public function render($template, array $vars = array())
    {
        ob_start();

        try {
            $this->display($template, $vars);
        } catch (Exception $exception) {
            ob_end_clean();

            throw $exception;
        }

        return ob_get_clean();
    }

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
     * @param array  $var      The template variables.
     */
    private function renderInScope($__file__, $var)
    {
        extract($var, EXTR_SKIP);

        include $__file__;
    }
}
