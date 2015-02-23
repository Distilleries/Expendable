<?php namespace Distilleries\Expendable\States;

trait DatatableStateTrait {

    /**
     * @var \Distilleries\DatatableBuilder\EloquentDatatable $datatable
     * Injected by the constructor
     */
    protected $datatable;


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function getIndexDatatable()
    {
        $this->datatable->build();
        $datatable = $this->datatable->generateHtmlRender();
        $this->layoutManager->add([
            'content'=>view('expendable::admin.form.state.datatable')->with([
                'datatable' => $datatable
            ])
        ]);

        return $this->layoutManager->render();
    }

    // ------------------------------------------------------------------------------------------------

    public function getDatatable()
    {
        $this->datatable->setModel($this->model);
        $this->datatable->build();

        return $this->datatable->generateColomns();
    }
}