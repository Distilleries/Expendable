<?php namespace Distilleries\Expendable\Http\Middleware;

use Closure;
use Distilleries\Expendable\Helpers\Security;
use Illuminate\Http\Request;

class XSS

{

    public function handle(Request $request, Closure $next)
    {

        $input = $request->all();

        array_walk_recursive($input, function (&$input) {

            $input = (new Security)->xss_clean($input);

        });

        $request->merge($input);

        return $next($request);

    }

}