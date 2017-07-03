<?php namespace Distilleries\Expendable\Http\Controllers\Backend\Base;


use Distilleries\DatatableBuilder\Contracts\DatatableStateContract;
use Distilleries\Expendable\Contracts\ExportStateContract;
use Distilleries\Expendable\Contracts\ImportStateContract;
use Distilleries\Expendable\States\DatatableStateTrait;
use Distilleries\Expendable\States\ExportStateTrait;
use Distilleries\Expendable\States\FormStateTrait;
use Distilleries\Expendable\States\ImportStateTrait;
use Distilleries\FormBuilder\Contracts\FormStateContract;



class BaseComponent extends ModelBaseController implements FormStateContract, DatatableStateContract, ExportStateContract, ImportStateContract {

    use FormStateTrait;
    use ExportStateTrait;
    use DatatableStateTrait;
    use ImportStateTrait;

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function getIndex()
    {
        return $this->getIndexDatatable();
    }
}