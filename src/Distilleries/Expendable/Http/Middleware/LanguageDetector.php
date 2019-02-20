<?php

namespace Distilleries\Expendable\Http\Middleware;

use Closure;
use Distilleries\Expendable\Models\Language;
use Illuminate\Contracts\Foundation\Application;

class LanguageDetector
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        preg_match_all('/(\W|^)([a-z]{2})([^a-z]|$)/six', $request->server->get('HTTP_ACCEPT_LANGUAGE'), $m, PREG_PATTERN_ORDER);

        $user_langs = $m[2];
        if (!empty($user_langs[0])) {
            $total = Language::where('iso', '=', $user_langs[0])->count();
            if ($total > 0) {
                return redirect()->to('/'.$user_langs[0]);
            }
        }

        return redirect()->to('/fr');
    }
}