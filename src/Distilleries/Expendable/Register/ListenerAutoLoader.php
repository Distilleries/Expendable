<?php


namespace Distilleries\Expendable\Register;

use \File;

class ListenerAutoLoader {

    protected $loaded     = [];
    protected $haveToLoad = [];

    // ------------------------------------------------------------------------------------------------


    public function __construct(array $haveToLoad)
    {
        $this->haveToLoad = $haveToLoad;
    }


    // ------------------------------------------------------------------------------------------------

    public function getHaveToLoad()
    {
        return $this->haveToLoad;
    }


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function load()
    {


        foreach ($this->getHaveToLoad() as $element)
        {
            $this->fileLoading($element);
        }

    }


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------


    protected function fileLoading($file)
    {
        if (class_exists($file, true))
        {
            $listener = new $file();

            if (is_subclass_of($listener, 'Distilleries\Expendable\Contracts\ListenerContract'))
            {
                $listener->listen();
                $this->loaded = $listener;
            }

        }
    }

} 