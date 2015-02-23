<?php namespace Distilleries\Expendable\Http\Controllers\Admin\Base;

use Distilleries\Expendable\Contracts\LayoutManagerContract;
use Distilleries\Expendable\Http\Controllers\Controller;


class BaseController extends Controller {

    /**
     * @var Eloquant $model
     * Injected by the constructor
     */
    protected $layoutManager;
    protected $layout = 'expendable::admin.layout.default';

    // ------------------------------------------------------------------------------------------------

    public function __construct(LayoutManagerContract $layoutManager)
    {
        $this->layoutManager = $layoutManager;
        $this->setupLayout();
    }

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------


    protected function setupLayout()
    {
        $this->layoutManager->setupLayout($this->layout);
        $this->setupStateProvider();
        $this->initStaticPart();


    }

    // ------------------------------------------------------------------------------------------------

    protected function setupStateProvider()
    {
        $interfaces = class_implements($this);
        $this->layoutManager->initInterfaces($interfaces, get_class($this));

    }

    // ------------------------------------------------------------------------------------------------

    protected function initStaticPart()
    {
        $this->layoutManager->initStaticPart(function ($layoutManager)
        {

            $menu_top  = $layoutManager->getView()->make('expendable::admin.menu.top');
            $menu_left = $layoutManager->getView()->make('expendable::admin.menu.left');


            $layoutManager->add([
                'state.menu' => $layoutManager->getStateProvider()->getRenderStateMenu(),
                'menu_top'   => $menu_top,
                'menu_left'  => $menu_left
            ]);
        });
    }
}