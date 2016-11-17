<?php
namespace zimtis\arrayvalidation\filter\attributeFilter;

use zimtis\arrayvalidation\filter\Filter;

class ArrayLengthFilter extends Filter
{

    private $length;

    public function __construct($length)
    {
        $this->length = $length;
    }

    public function validate($value)
    {
        if (count($value) != $this->length) {
            throw new \Exception(sprintf('must be of size %d, %d found', $this->length, count($value)));
        }
        
        parent::validate($value);
    }
}