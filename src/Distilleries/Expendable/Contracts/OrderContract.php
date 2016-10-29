<?php

namespace Distilleries\Expendable\Contracts;

interface OrderContract
{
    /**
     * Return the label displayed in the order page.
     *
     * @return string
     */
    public function orderLabel();

    /**
     * Return the field name to save the model order (e.g. `order`).
     *
     * @return string
     */
    public function orderFieldName();
}
