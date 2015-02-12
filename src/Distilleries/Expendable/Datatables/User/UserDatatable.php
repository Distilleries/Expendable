<?php


namespace Distilleries\Expendable\Datatables\User;


use Distilleries\DatatableBuilder\EloquentDatatable;
use Distilleries\Expendable\Helpers\StaticLabel;
use Distilleries\Expendable\Helpers\UserUtils;

class UserDatatable extends EloquentDatatable {

    public function build()
    {
        $this->add('id');
        $this->add('email');
        $this->addDefaultAction();
    }

    public function applyFilters()
    {
        parent::applyFilters();
        if (UserUtils::isNotSuperAdmin())
        {
            $super_admin = \Role::where('initials', '=', '@sa')->get()->last();

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
            'empty_value' => _('-'),
            'validation'  => 'required',
            'label'       => _('Status')
        ]);

    }

} 