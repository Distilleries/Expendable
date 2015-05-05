<?php namespace Distilleries\Expendable\States;

use \FormBuilder;
use Illuminate\Http\Request;

trait FormStateTrait {

    /**
     * @var \Kris\LaravelFormBuilder\Form $form
     * Injected by the constructor
     */
    protected $form;


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function getEdit($id = '')
    {
        $model = (!empty($id)) ? $this->model->withoutTranslation()->findOrFail($id) : $this->model;
        $form  = FormBuilder::create(get_class($this->form), [
            'model' => $model
        ]);

        $form_content = view('form-builder::form.components.formgenerator.full', [
            'form' => $form
        ]);

        $this->layoutManager->add([
            'content' => view('expendable::admin.form.state.form', [
                'form' => $form_content
            ])
        ]);

        return $this->layoutManager->render();
    }

    // ------------------------------------------------------------------------------------------------

    public function getTranslation($iso, $id)
    {

        $id_element = $this->model->hasBeenTranslated($this->model->getTable(), $id);
        if (!empty($id_element)) {
            return redirect()->to(action($this->getControllerNameForAction() . '@getEdit', $id_element));
        }

        $model = (!empty($id)) ? $this->model->withoutTranslation()->findOrFail($id) : $this->model;
        $form  = FormBuilder::create(get_class($this->form), [
            'model' => $model
        ])
            ->remove('id')
            ->add('translation_iso', 'hidden', ['default_value' => $iso])
            ->add('translation_id_source', 'hidden', ['default_value' => $id]);

        $form_content = view('form-builder::form.components.formgenerator.full', [
            'form' => $form
        ]);

        $this->layoutManager->add([
            'content' => view('expendable::admin.form.state.form', [
                'form' => $form_content
            ])
        ]);

        return $this->layoutManager->render();
    }

    // ------------------------------------------------------------------------------------------------

    public function postTranslation(Request $request)
    {


        $form = FormBuilder::create(get_class($this->form), [
            'model' => $this->model
        ]);


        if ($form->hasError()) {
            return $form->validateAndRedirectBack();
        }

        $result = $this->beforeSave();

        if ($result != null) {
            return $result;
        }

        $result = $this->save($this->dataToSave($request), $request);
        $this->saveTranslation($request);

        if ($result != null) {
            return $result;
        }

        return redirect()->to(action($this->getControllerNameForAction() . '@getIndex'));
    }

    // ------------------------------------------------------------------------------------------------

    public function postEdit(Request $request)
    {
        $form = FormBuilder::create(get_class($this->form), [
            'model' => $this->model
        ]);


        if ($form->hasError()) {
            return $form->validateAndRedirectBack();
        }

        $result = $this->beforeSave();

        if ($result != null) {
            return $result;
        }

        $result = $this->save($this->dataToSave($request), $request);

        if ($result != null) {
            return $result;
        }

        return redirect()->to(action($this->getControllerNameForAction() . '@getIndex'));

    }

    // ------------------------------------------------------------------------------------------------

    protected function dataToSave(Request $request)
    {
        return $request->only($this->model->getFillable());
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

    protected function save($data, Request $request)
    {

        $primary = $request->get($this->model->getKeyName());
        if (empty($primary)) {
            $this->model = $this->model->create($data);
        } else {
            $this->model = $this->model->find($primary);
            $this->model->update($data);
        }

        return $this->afterSave();
    }

    // ------------------------------------------------------------------------------------------------

    protected function saveTranslation(Request $request)
    {

        $this->model->setTranslation($this->model->getKey(), $this->model->getTable(), $request->get('translation_id_source'), $request->get('translation_iso'));
    }


    // ------------------------------------------------------------------------------------------------

    public function getView($id)
    {
        $model = (!empty($id)) ? $this->model->findOrFail($id) : $this->model;
        $form  = FormBuilder::create(get_class($this->form), [
            'model' => $model
        ]);

        $form_content = view('form-builder::form.components.formgenerator.info', [
            'form'  => $form,
            'id'    => $id,
            'route' => $this->getControllerNameForAction() . '@',
        ]);

        $this->layoutManager->add([
            'content' => view('expendable::admin.form.state.form', [
                'form' => $form_content
            ])
        ]);

        return $this->layoutManager->render();

    }

    // ------------------------------------------------------------------------------------------------

    protected function getControllerNameForAction()
    {

        $action = explode('@', \Route::currentRouteAction());

        return '\\' . $action[0];
    }
}