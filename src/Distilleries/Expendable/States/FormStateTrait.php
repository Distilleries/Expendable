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
    protected function isTranslatableModel()
    {
        return method_exists($this->model, 'withoutTranslation');
    }

    protected function findAutoDetectTranslation($id, $orfail = true)
    {
        if ($orfail) {
            if ($this->isTranslatableModel()) {
                return $this->model->withoutTranslation()->findOrFail($id);
            } else {
                return $this->model->findOrFail($id);
            }
        } else {
            if ($this->isTranslatableModel()) {
                return $this->model->withoutTranslation()->find($id);
            } else {
                return $this->model->find($id);
            }
        }

        return null;

    }

    // ------------------------------------------------------------------------------------------------

    public function getEdit($id = '')
    {
        $model = (!empty($id) || $id === "0") ? $this->findAutoDetectTranslation($id) : $this->model;
        $form  = FormBuilder::create(get_class($this->form), [
            'model' => $model
        ]);


        if ($this->isTranslatableModel()) {
            $local_overide = $this->model->getIso($model->getTable(), $model->id);
            if (!empty($local_overide)) {
                $form->add('local_override', 'hidden', ['default_value' => $local_overide]);
            }
        }

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

        $id_element = $this->model->hasBeenTranslated($this->model->getTable(), $id, $iso);
        if (!empty($id_element)) {
            return redirect()->to(action($this->getControllerNameForAction().'@getEdit', $id_element));
        }

        $model = (!empty($id) || $id === "0") ? $this->model->withoutTranslation()->findOrFail($id) : $this->model;
        $form  = FormBuilder::create(get_class($this->form), [
            'model' => $model
        ])
            ->remove('id')
            ->add('translation_iso', 'hidden', ['default_value' => $iso])
            ->add('translation_id_source', 'hidden', ['default_value' => $id])
            ->add('local_override', 'hidden', ['default_value' => $iso]);

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

        if ($this->isTranslatableModel()) {
            $this->saveTranslation($request->get('translation_iso'), $request->get('translation_id_source'));
        }

        if ($result != null) {
            return $result;
        }

        return redirect()->to(action($this->getControllerNameForAction().'@getIndex'));
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


        if ($this->isTranslatableModel() && !$this->model->hasTranslation($this->model->getTable(), $this->model->getKey())) {
            $this->saveTranslation(app()->getLocale());
        }

        if ($result != null) {
            return $result;
        }

        return redirect()->to(action($this->getControllerNameForAction().'@getIndex'));

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
        if ($primary !== "0" && empty($primary)) {
            $this->model = $this->model->create($data);
        } else {
            $this->model = $this->findAutoDetectTranslation($primary, false);
            $this->model->update($data);
        }

        return $this->afterSave();
    }

    // ------------------------------------------------------------------------------------------------

    protected function saveTranslation($translation_iso, $translation_id_source = 0)
    {
        $this->model->setTranslation($this->model->getKey(), $this->model->getTable(), $translation_id_source, $translation_iso);
    }


    // ------------------------------------------------------------------------------------------------

    public function getView($id)
    {

        $model = (!empty($id) || $id === "0") ? $this->findAutoDetectTranslation($id) : $this->model;
        $form  = FormBuilder::create(get_class($this->form), [
            'model' => $model
        ]);

        $form_content = view('form-builder::form.components.formgenerator.info', [
            'form'  => $form,
            'id'    => $id,
            'route' => $this->getControllerNameForAction().'@',
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

        return '\\'.$action[0];
    }
}