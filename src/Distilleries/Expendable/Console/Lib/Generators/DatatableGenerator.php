<?php  namespace Distilleries\Expendable\Console\Lib\Generators;

class DatatableGenerator extends Generator
{

    /**
     * Prepare template for single add field
     *
     * @param      $field
     * @param bool $isLast
     * @return string
     */
    protected function prepareAdd($field, $isLast = false)
    {
        $field = trim($field);
        $textArr = [
            "            ->add('",
            $field,
            "',null",
            ",_('".ucfirst($field)."')",
            ")",
            ($isLast) ? "" : "\n"
        ];

        return join('', $textArr);
    }
}
