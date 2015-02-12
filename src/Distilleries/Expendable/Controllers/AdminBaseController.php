<?php


namespace Distilleries\Expendable\Controllers;

use \File, \Config, \View, \Input, \Redirect, \Validator;
use Distilleries\Expendable\Contracts\StateDisplayerContract;
use Distilleries\Expendable\Models\BaseModel;

class AdminBaseController extends BaseController {

    /**
     * @var Eloquant $model
     * Injected by the constructor
     */
    protected $stateProvider;
    protected $layout = 'expendable::admin.layout.default';

    // ------------------------------------------------------------------------------------------------

    public function __construct(StateDisplayerContract $stateProvider)
    {
        $this->stateProvider = $stateProvider;
    }



    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------


    protected function setupLayout()
    {
        parent::setupLayout();
        $this->setupStateProvider();
        $this->initStaticPart();

    }

    // ------------------------------------------------------------------------------------------------

    protected function setupStateProvider()
    {
        $interfaces = class_implements($this);

        foreach ($interfaces as $interface)
        {
            if (strpos($interface, 'StateContract') !== false)
            {
                $this->stateProvider->setState($interface);
            }
        }

        $this->stateProvider->setClass(get_class($this));

    }


    // ------------------------------------------------------------------------------------------------


    protected function initStaticPart()
    {
        if (!is_null($this->layout))
        {
            $asstets = json_decode(File::get(Config::get('expendable::config_file_assets')));
            $header = View::make('expendable::admin.part.header')->with([
                'version' => $asstets->version,
                'title'   => ''
            ]);

            $menu_top  = View::make('expendable::admin.menu.top')->with([
            ]);
            $menu_left = View::make('expendable::admin.menu.left')->with([
            ]);
            $footer    = View::make('expendable::admin.part.footer')->with([
                'version' => $asstets->version,
                'title'   => ''
            ]);


            $this->addToLayout($this->stateProvider->getRenderStateMenu(), 'state.menu');
            $this->addToLayout($header, 'header');
            $this->addToLayout($menu_top, 'menu_top');
            $this->addToLayout($menu_left, 'menu_left');
            $this->addToLayout($footer, 'footer');
        }
    }


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

} 