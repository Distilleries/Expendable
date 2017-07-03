<?php namespace Distilleries\Expendable\Http\Controllers\Frontend;

use Distilleries\Expendable\Http\Controllers\Frontend\Base\BaseController;

class AssetController extends BaseController {

    public function getIndex($path = '')
    {

        $directory   = explode('/', $path);
        $directory   = reset($directory);
        $white_liste = config('expendable.folder_whitelist');
        if (in_array($directory, $white_liste))
        {
            $path = storage_path($path);
            $filesystem = app('files');
            if ($filesystem->isFile($path))
            {
                $mimetype = mime_content_type($path);
                if (@is_array(getimagesize($path)))
                {
                    return response()->make($filesystem->get($path), 200, array('content-type' => $mimetype));
                } else
                {
                    $name = explode('/', $path);
                    $name = end($name);

                    return response()->download($path, $name, array('content-type' => $mimetype));
                }
            }
        }


        return abort(404);
    }
}