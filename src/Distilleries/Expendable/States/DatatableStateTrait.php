<?php


namespace Distilleries\Expendable\States;

use \View;

trait DatatableStateTrait{

    /**
     * @var EloquentDatatable $datatable
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
        $content   = View::make('expendable::admin.form.state.datatable')->with([
            'datatable' => $datatable
        ]);

        $this->addToLayout($content, 'content');

    }

    // ------------------------------------------------------------------------------------------------

    public function getDatatable()
    {
        $this->datatable->setModel($this->model);
        $this->datatable->build();

        return $this->datatable->generateColomns();

    }
} 