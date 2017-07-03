<?php namespace Distilleries\Expendable\Http\Datatables\User;

use Distilleries\Expendable\Http\Datatables\BaseDatatable;
use Distilleries\Expendable\Helpers\StaticLabel;
use Distilleries\Expendable\Helpers\UserUtils;
use Distilleries\Expendable\Models\Role;

class UserDatatable extends BaseDatatable {

    public function build()
    {
        $this->add('id');
        $this->add('email');
        $this->addDefaultAction('expendable::admin.user.datatable.action');
    }

    public function applyFilters()
    {
        parent::applyFilters();
        if (UserUtils::isNotSuperAdmin())
        {
            $super_admin = Role::where('initials', '=', '@sa')->get()->last();

            if (!empty($super_admin))
            {
                $this->model = $this->model->where('role_id', '!=', $super_admin->id);
            }
        }

    }

    public function filters()
    {
        $this->form->add('status', 'choice', [
            'choices'     => StaticLabel::status(),
            'empty_value' => '-',
            'validation'  => 'required',
            'label'       => trans('expendable::datatable.status')
        ]);

    }
}