<?php


namespace Distilleries\Expendable\Controllers;

use \Input, \Redirect, \Validator, \Response;
use Distilleries\Expendable\Contracts\StateDisplayerContract;
use Distilleries\Expendable\Models\BaseModel;

class AdminModelBaseController extends AdminBaseController {

    /**
     * @var \Eloquant $model
     * Injected by the constructor
     */
    protected $model;


    // ------------------------------------------------------------------------------------------------

    public function __construct(BaseModel $model, StateDisplayerContract $stateProvider)
    {
        parent::__construct($stateProvider);
        $this->model = $model;
    }

    // ------------------------------------------------------------------------------------------------

    /**
     * @return \Eloquant
     */
    public function getModel()
    {
        return $this->model;
    }

    // ------------------------------------------------------------------------------------------------

    /**
     * @param \Eloquant $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function putDestroy()
    {
        $data = $this->model->find(Input::get('id'));
        $data->delete();

        $validation = Validator::make(Input::all(), [
            'id' => 'required'
        ]);
        if ($validation->fails())
        {
            $this->hasError = true;
        }


        return Redirect::to(action(get_class($this) . '@getIndex'));
    }

    // ------------------------------------------------------------------------------------------------
    public function postSearch()
    {

        $ids = Input::get('ids');


        if (!empty($ids))
        {
            $data = $this->model->whereIn($this->model->getKeyName(), $ids)->get();

            return Response::json($data);
        }

        $term  = Input::get('term');
        $page  = Input::get('page');
        $paged = Input::get('page_limit');

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

        return Response::json([
            'total'    => $total,
            'elements' => $elements
        ]);

    }


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

} 