<?php

namespace Distilleries\Expendable\States;

use Illuminate\Http\Request;

trait OrderStateTrait
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        $rows = $this->model->orderBy($this->model->orderFieldName(), 'asc')->get();

        $this->layoutManager->add([
            'content' => view('expendable::admin.form.state.order', [
                'rows' => $rows,
            ]),
        ]);

        return $this->layoutManager->render();
    }

    /**
     * {@inheritdoc}
     */
    public function postOrder(Request $request)
    {
        $ids = $request->input('ids');

        $order = 1;
        foreach ($ids as $id) {
            $instance = $this->model->find($id);
            if (!empty($instance)) {
                $instance->{$this->model->orderFieldName()} = $order;
                $instance->save();
                $order++;
            }
        }

        return response()->json(['error' => false]);
    }
}
