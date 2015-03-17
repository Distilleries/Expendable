<?php namespace Distilleries\Expendable\Http\Controllers\Admin\Base;

use Distilleries\Expendable\Contracts\LayoutManagerContract;
use Distilleries\Expendable\Models\BaseModel;
use Illuminate\Http\Request;

class ModelBaseController extends BaseController {

    /**
     * @var \Distilleries\Expendable\Models\BaseModel $model
     * Injected by the constructor
     */
    protected $model;


    // ------------------------------------------------------------------------------------------------

    public function __construct(BaseModel $model, LayoutManagerContract $layoutManager)
    {
        parent::__construct($layoutManager);
        $this->model = $model;
    }

    // ------------------------------------------------------------------------------------------------

    /**
     * @return \Distilleries\Expendable\Models\BaseModel
     */
    public function getModel()
    {
        return $this->model;
    }

    // ------------------------------------------------------------------------------------------------

    /**
     * @param \Distilleries\Expendable\Models\BaseModel $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function putDestroy(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput($request->all());
        }

        $data = $this->model->find($request->get('id'));
        $data->delete();

        return redirect()->to(action('\\'.get_class($this) . '@getIndex'));
    }

    // ------------------------------------------------------------------------------------------------
    public function postSearch(Request $request)
    {

        $ids = $request->get('ids');


        if (!empty($ids))
        {
            $data = $this->model->whereIn($this->model->getKeyName(), $ids)->get();

            return response()->json($data);
        }

        $term  = $request->get('term');
        $page  = $request->get('page');
        $paged = $request->get('page_limit');

        if (empty($paged))
        {
            $paged = 10;
        }

        if (empty($page))
        {
            $page = 1;
        }
        if (empty($term))
        {
            $elements = array();
            $total    = 0;
        } else
        {
            $elements = $this->model->search($term)->take($paged)->skip(($page - 1) * $paged)->get();
            $total    = $this->model->search($term)->count();

        }

        return response()->json([
            'total'    => $total,
            'elements' => $elements
        ]);

    }
}