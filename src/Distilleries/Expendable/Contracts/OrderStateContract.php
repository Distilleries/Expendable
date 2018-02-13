<?php

namespace Distilleries\Expendable\Contracts;

use Illuminate\Http\Request;

interface OrderStateContract
{
    /**
     * Return default ordering page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function getOrder();

    /**
     * Save rows order.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postOrder(Request $request);
}
