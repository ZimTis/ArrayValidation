<?php
namespace zimtis\arrayvalidation\filter\typeFilter;

use zimtis\arrayvalidation\filter\typeFilter\TypeFilter;
use zimtis\arrayvalidation\Types;

class ArrayTypeFilter extends TypeFilter
{

    public function validate($value)
    {
        if (! is_array($value)) {
            $this->throwException(Types::ARRY, $value);
        }
        parent::validate($value);
    }
}