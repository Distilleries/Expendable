<?php namespace Distilleries\Expendable\Http\Controllers\Backend\Base;

use \Exception;

class ErrorController extends BaseController {


    protected $layout = 'expendable::admin.layout.error';
    public function display(Exception $exception, $code)
    {
        $class = ($code == 404) ? 'page-404' : 'page-500';

        $content = view('expendable::admin.errors.default', [
            'code'    => $code,
            'class'    => $class,
            'message' => $exception->getMessage(),
        ]);


        $this->layoutManager->add([
            'class_layout'=>$class.'-full-page',
            'content'=>$content,
        ]);

        return response()->make($this->layoutManager->render(), $code);
    }

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    protected function initStaticPart()
    {
        $this->layoutManager->initStaticPart();
    }
} 