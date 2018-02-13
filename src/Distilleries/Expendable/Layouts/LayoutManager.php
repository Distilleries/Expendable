<?php namespace Distilleries\Expendable\Layouts;

use Closure;
use Distilleries\Expendable\Contracts\LayoutManagerContract;
use Distilleries\Expendable\Contracts\StateDisplayerContract;
use Illuminate\Contracts\View\Factory;
use Illuminate\Filesystem\Filesystem;

class LayoutManager implements LayoutManagerContract {


    protected $config;
    protected $view;
    protected $state;
    protected $filesystem;
    protected $items = [];
    protected $layout = null;

    public function __construct(array $config, Factory $view, Filesystem $filesystem, StateDisplayerContract $state)
    {
        $this->config     = $config;
        $this->view       = $view;
        $this->filesystem = $filesystem;
        $this->state      = $state;
    }


    public function setupLayout($layout)
    {
        $this->layout = $layout;
    }

    public function initInterfaces(array $interfaces, $class)
    {

        foreach ($interfaces as $interface)
        {
            if (strpos($interface, 'StateContract') !== false)
            {
                $this->state->setState($interface);
            }
        }

        $this->state->setClass($class);
    }

    public function initStaticPart(Closure $closure = null)
    {
        if (!is_null($this->layout))
        {
            $header = $this->view->make('expendable::admin.part.header')->with([
                'title'   => ''
            ]);
            $footer = $this->view->make('expendable::admin.part.footer')->with([
                'title'   => ''
            ]);

            $this->add([
                'header' => $header,
                'footer' => $footer,
            ]);

            if (!empty($closure))
            {
                $closure($this);
            }

        }
    }

    public function add(array $items)
    {
        $this->items = array_merge($this->items, $items);
    }

    public function render()
    {
        return $this->view->make($this->layout, $this->items);
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return Factory
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @return StateDisplayerContract
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }


}