<?php


namespace Distilleries\Expendable\Controllers;

use \View, \Exception, \Response, \File, \Config;

class AdminErrorController extends AdminBaseController {


    protected $layout = 'expendable::admin.layout.error';
    public function display(Exception $exception, $code)
    {
        $class = ($code == 404)?'page-404':'page-500';

        $content = View::make('expendable::admin.errors.default', [
            'code'    => $code,
            'class'    => $class,
            'message' => $exception->getMessage(),
        ]);


        $this->addToLayout($class.'-full-page', 'class_layout');
        $this->addToLayout($content, 'content');
        return Response::make($this->layout, $code);
    }



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


            $this->addToLayout('', 'state.menu');
            $this->addToLayout($header, 'header');
            $this->addToLayout($footer, 'footer');
        }
    }
} 