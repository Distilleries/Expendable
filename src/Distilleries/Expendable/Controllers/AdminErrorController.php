<?php


namespace Distilleries\Expendable\Controllers;

use \View, \Exception, \Response;

class AdminErrorController extends AdminBaseController {


    protected $layout = 'admin.layout.error';
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
} 