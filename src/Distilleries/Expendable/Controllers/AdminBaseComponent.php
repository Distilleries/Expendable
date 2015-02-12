<?php


namespace Distilleries\Expendable\Controllers;


use Distilleries\Expendable\Contracts\DatatableStateContract;
use Distilleries\Expendable\Contracts\ExportStateContract;
use Distilleries\Expendable\Contracts\FormStateContract;
use Distilleries\Expendable\States\DatatableStateTrait;
use Distilleries\Expendable\States\ExportStateTrait;
use Distilleries\Expendable\States\FormStateTrait;
use \Input, \Redirect, \FormBuilder;

class AdminBaseComponent extends AdminModelBaseController implements FormStateContract, DatatableStateContract, ExportStateContract {

    use FormStateTrait;
    use ExportStateTrait;
    use DatatableStateTrait;

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function getIndex()
    {
        return $this->getIndexDatatable();
    }

} 