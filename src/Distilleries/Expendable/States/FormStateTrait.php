<?php


namespace Distilleries\Expendable\States;

use \View, \FormBuilder, \Input, \Redirect;

trait FormStateTrait {

    /**
     * @var EloquentDatatable $datatable
     * Injected by the constructor
     */
    protected $form;


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function getEdit($id = '')
    {
        $model = (!empty($id)) ? $this->model->findOrFail($id) : $this->model;
        $form  = FormBuilder::create(get_class($this->form), [
            'model' => $model
        ]);


        $form_content = View::make('expendable::admin.form.components.formgenerator.full', [
            'form' => $form
        ]);
        $content      = View::make('expendable::admin.form.state.form', [

        ]);

        $this->addToLayout($form_content, 'form');
        $this->addToLayout($content, 'content');

    }

    // ------------------------------------------------------------------------------------------------

    public function postEdit()
    {
        $form = FormBuilder::create(get_class($this->form), [
            'model' => $this->model
        ]);


        if ($form->hasError())
        {
            return $form->validateAndRedirectBack();
        }

        $result = $this->beforeSave();

        if ($result != null)
        {
            return $result;
        }

        $result = $this->save($this->dataToSave());

        if ($result != null)
        {
            return $result;
        }

        return Redirect::to(action(get_class($this) . '@getIndex'));

    }

    // ------------------------------------------------------------------------------------------------

    protected function dataToSave()
    {
        return Input::only($this->model->getFillable());
    }

    // ------------------------------------------------------------------------------------------------

    protected function beforeSave()
    {
        return null;
    }

    // ------------------------------------------------------------------------------------------------

    protected function afterSave()
    {
        return null;
    }


    // ------------------------------------------------------------------------------------------------

    protected function save($data)
    {

        if (!empty($result))
        {
            return $result;
        }

        $primary = Input::get($this->model->getKeyName());
        if (empty($primary))
        {
            $this->model = $this->model->create($data);
        } else
        {
            $this->model = $this->model->find($primary);
            $this->model->update($data);
        }

        $result = $this->afterSave();

        if (!empty($result))
        {
            return $result;
        }

        return null;

    }


    // ------------------------------------------------------------------------------------------------

    public function getView($id)
    {
        $model = (!empty($id)) ? $this->model->findOrFail($id) : $this->model;
        $form  = FormBuilder::create(get_class($this->form), [
            'model' => $model
        ]);


        $action       = explode('@', \Route::currentRouteAction());
        $form_content = View::make('expendable::admin.form.components.formgenerator.info', [
            'form'  => $form,
            'id'    => $id,
            'route' => !empty($action) ? $action[0] . '@' : '',
        ]);
        $content      = View::make('expendable::admin.form.state.form', [

        ]);

        $this->addToLayout($form_content, 'form');
        $this->addToLayout($content, 'content');

    }


} 