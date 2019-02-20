<?php
namespace Distilleries\Expendable\Imports;

use Distilleries\Expendable\Contracts\ImportContract;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BaseImport implements ToModel, WithHeadingRow, ImportContract
{
    use Importable;

    /**
     * @var \Distilleries\Expendable\Models\BaseModel
     */
    private $model;

    public function __construct($model)
    {
        $this->setModel($model);
    }

    public function importFromFile($filepath)
    {
        return $this->import($filepath);
    }

    /**
     * @inheritdoc
     */
    public function model(array $row)
    {
        $data = [];
        foreach ($this->model->getFillable() as $value)
        {
            $data[$value] = $row[$value];
        }
        return new $this->model($data);
    }

    /**
     * @param mixed $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }
}