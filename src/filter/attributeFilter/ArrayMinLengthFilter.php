<?php
namespace zimtis\arrayvalidation\filter\attributeFilter;

use zimtis\arrayvalidation\filter\Filter;

class ArrayMinLengthFilter extends Filter
{

    private $minLength;

    public function __construct($minLength)
    {
        $this->minLength = $minLength;
    }

    public function validate(array $value)
    {
        if (count($value) < $this->minLength) {
            throw new \Exception(sprintf('size must be bigger or equal %d, %d found', $this->minLength, count($value)));
        }
        
        parent::validate($value);
    }
}