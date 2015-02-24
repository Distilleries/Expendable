<?php namespace Distilleries\Expendable\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if($this->isHttpException($e)){
			if ($request->segment(1) == config('expendable.admin_base_uri') and config('app.debug'))
			{
				return app('Distilleries\Expendable\Http\Controllers\Admin\Base\ErrorController')->callAction("display", [$e, $e->getStatusCode()]);
			}
		}

		return parent::render($request, $e);
	}

}
