<?php namespace Distilleries\Expendable\Models;

class Permission extends BaseModel {

    protected $fillable = [
        'id',
        'role_id',
        'service_id'
    ];


    public function role()
    {
        return $this->hasOne('Distilleries\Expendable\Models\Role');
    }

    public function service()
    {
        return $this->belongsTo('Distilleries\Expendable\Models\Service');
    }

    public function getArea()
    {
        $roles    = Role::all();
        $services = Service::orderBy('action')->get();
        $services = $services->toArray();

        $groupedServices = [];

        foreach ($services as $service)
        {
            $actions = preg_split('/@/', $service['action']);

            if (count($actions) >= 2)
            {
                $groupedServices[$actions[0]][] = [
                    'id'      => $service['id'],
                    'libelle' => $actions[1]
                ];
            }

        }

        $result = [];
        foreach ($roles as $role)
        {
            $result[] = [
                'libelle' => $role->libelle,
                'id'      => $role->id,
                'choices' => $groupedServices
            ];
        }

        return $result;
    }

    public function getAreaSelected()
    {
        $roles  = Role::get();
        $result = [];

        foreach ($roles as $role)
        {
            if (empty($result[$role->id]))
            {
                $result[$role->id] = [];
            }

            foreach ($role->permissions as $permission)
            {
                $result[$role->id][] = $permission->service_id;
            }
        }

        return $result;
    }
}