<?php

namespace Distilleries\Expendable\Controllers\Front;


use \File, \Response;

class AssetController extends \Distilleries\Expendable\Controllers\FrontBaseController {

    public function getIndex($path = '')
    {
        $directory   = explode('/', $path);
        $directory   = reset($directory);
        $white_liste = \Config::get('expendable::folder_whitelist');

        if (in_array($directory, $white_liste))
        {
            $path = storage_path($path);

            if (File::isFile($path))
            {
                $mimetype = mime_content_type($path);
                if (@is_array(getimagesize($path)))
                {
                    return Response::make(File::get($path), 200, array('content-type' => $mimetype));
                } else
                {
                    $name = explode('/', $path);
                    $name = end($name);

                    return Response::download($path, $name, array('content-type' => $mimetype));
                }
            }
        }


        return \App::abort(404);
    }
}