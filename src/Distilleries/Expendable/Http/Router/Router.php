<?php
/**
 * Created by PhpStorm.
 * User: mfrancois
 * Date: 17/09/2016
 * Time: 16:46
 */

namespace Distilleries\Expendable\Http\Router;

use Illuminate\Support\Arr;

class Router extends \Illuminate\Routing\Router
{


    /**
     * Register an array of controllers with wildcard routing.
     *
     * @param  array  $controllers
     * @return void
     *
     */
    public function controllers(array $controllers)
    {
        foreach ($controllers as $uri => $controller) {
            $this->controller($uri, $controller);
        }
    }
    /**
     * Route a controller to a URI with wildcard routing.
     *
     * @param  string  $uri
     * @param  string  $controller
     * @param  array  $names
     * @return void
     *
     */
    public function controller($uri, $controller, $names = [])
    {
        $prepended = $controller;
        // First, we will check to see if a controller prefix has been registered in
        // the route group. If it has, we will need to prefix it before trying to
        // reflect into the class instance and pull out the method for routing.
        if (!empty($this->groupStack)) {
            $prepended = $this->prependGroupUses($controller);
        }
        $routable = (new ControllerInspector)
            ->getRoutable($prepended, $uri);
        // When a controller is routed using this method, we use Reflection to parse
        // out all of the routable methods for the controller, then register each
        // route explicitly for the developers, so reverse routing is possible.
        foreach ($routable as $method => $routes) {
            foreach ($routes as $route) {
                $this->registerInspected($route, $controller, $method, $names);
            }
        }
        $this->addFallthroughRoute($controller, $uri);
    }

    /**
     * Prepend the last group uses onto the use clause.
     *
     * @param  string  $uses
     * @return string
     */
    protected function prependGroupUses($uses)
    {
        $group = last($this->groupStack);

        return isset($group['namespace']) ? $group['namespace'].'\\'.$uses : $uses;
    }

    
    /**
     * Register an inspected controller route.
     *
     * @param  array   $route
     * @param  string  $controller
     * @param  string  $method
     * @param  array  $names
     * @return void
     *
     */
    protected function registerInspected($route, $controller, $method, &$names)
    {
        $action = ['uses' => $controller.'@'.$method];
        // If a given controller method has been named, we will assign the name to the
        // controller action array, which provides for a short-cut to method naming
        // so you don't have to define an individual route for these controllers.
        $action['as'] = Arr::get($names, $method);
        $this->{$route['verb']}($route['uri'], $action);
    }
    /**
     * Add a fallthrough route for a controller.
     *
     * @param  string  $controller
     * @param  string  $uri
     * @return void
     *
     */
    protected function addFallthroughRoute($controller, $uri)
    {
        $missing = $this->any($uri.'/{_missing}', $controller.'@missingMethod');
        $missing->where('_missing', '(.*)');
    }
    
}