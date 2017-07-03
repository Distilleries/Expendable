<?php namespace Distilleries\Expendable\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

    protected $dontReport = [
        'Symfony\Component\HttpKernel\Exception\HttpException',
        'Symfony\Component\HttpKernel\Exception\NotFoundHttpException'
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($this->isHttpException($e))
        {
            if ($request->segment(1) == config('expendable.admin_base_uri') && !config('app.debug'))
            {
                return app('Distilleries\Expendable\Http\Controllers\Backend\Base\ErrorController')->callAction("display", [$e, $e->getStatusCode()]);
            }
        }

        return parent::render($request, $e);
    }
}