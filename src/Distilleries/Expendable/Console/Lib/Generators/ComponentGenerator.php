<?php  namespace Distilleries\Expendable\Console\Lib\Generators;

class ComponentGenerator extends Generator {


    public function getClassModel($model)
    {
        $model = preg_split('/\//i', $model);
        $model = last($model);
        $model = preg_replace('/\.php/i', '', $model);

        return '\\' . $model;

    }

    public function getTrait($states)
    {
        $result = '';

        foreach ($states as $state)
        {
            $state = preg_replace('/Contracts/i', 'States', $state);
            $state = preg_replace('/Contract/i', 'Trait', $state);
            $result .= 'use ' . $state . ';' . "\n";
        }

        return $result;

    }

    public function getImplementation($states)
    {
        $result = 'implements ' . join(', ', $states);

        return $result;

    }

    /**
     * @param string $name
     * @return object
     */
    public function getClassInfo($name)
    {
        $fullNamespacedPath = explode('/', $name);
        array_shift($fullNamespacedPath);
        $className = array_pop($fullNamespacedPath);

        return (object) [
            'namespace' => trim(preg_replace('/controllers/', '', join('\\', $fullNamespacedPath)), '\\'),
            'className' => $className
        ];
    }
}
