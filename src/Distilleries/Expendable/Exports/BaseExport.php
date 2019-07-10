<?php
namespace Distilleries\Expendable\Exports;

use Carbon\Carbon;
use Distilleries\Expendable\Contracts\ExportContract;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BaseExport implements FromQuery, WithHeadings, ExportContract
{
    use Exportable;

    /**
     * @var \Distilleries\Expendable\Models\BaseModel
     */
    private $model;

    /**
     * @var Carbon
     */
    private $start;

    /**
     * @var Carbon
     */
    private $end;

    public function __construct($model, $data)
    {
        $this->setModel($model);
        $this->setRange($data);
    }

    public function export($fileName)
    {
        return $this->download($fileName);
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return $this->model->betweenCreate($this->start, $this->end);
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

    /**
     * @param array $data
     * @return $this
     */
    public function setRange($data)
    {
        foreach ($data['range'] as $key => $date)
        {
            Carbon::parse($date);
            $this->$key = Carbon::parse($date);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function headings(): array
    {
        return \Illuminate\Support\Facades\Schema::getColumnListing($this->model->getTable());
    }
}