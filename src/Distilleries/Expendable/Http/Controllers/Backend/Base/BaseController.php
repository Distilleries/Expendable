<?php namespace Distilleries\Expendable\Http\Controllers\Backend\Base;

use Distilleries\Expendable\Contracts\LayoutManagerContract;
use Distilleries\Expendable\Http\Controllers\Controller;
use Distilleries\Expendable\Models\Language;


class BaseController extends Controller {


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
        $this->layoutManager->initStaticPart(function($layoutManager)
        {

            $menu_top  = $layoutManager->getView()->make('expendable::admin.menu.top', [
                'languages'=>Language::all()
            ]);
            $menu_left = $layoutManager->getView()->make('expendable::admin.menu.left');


            $layoutManager->add([
                'state.menu' => $layoutManager->getState()->getRenderStateMenu(),
                'menu_top'   => $menu_top,
                'menu_left'  => $menu_left
            ]);
        });
    }
}