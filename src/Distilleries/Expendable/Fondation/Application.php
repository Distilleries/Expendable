<?php

namespace Distilleries\Expendable\Fondation;


use Distilleries\Expendable\ExpendableRoutingServiceProvider;
use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{


    /**
     * Register all of the base service providers.
     *
     * @return void
     */
    protected function registerBaseServiceProviders()
    {
        parent::registerBaseServiceProviders();
        $this->register(new ExpendableRoutingServiceProvider($this));
    }


    /**
     * Override default application storage path.
     *
     * @return mixed
     */
    public function storagePath()
    {
        $path = env('STORAGE_PATH', $this->basePath.DIRECTORY_SEPARATOR.'storage');

        return $this->storagePath ?: $path;
    }
}