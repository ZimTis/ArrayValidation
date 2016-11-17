<?php
namespace zimtis\arrayvalidation\filter\attributeFilter;

use zimtis\arrayvalidation\filter\Filter;

class ArrayMaxLengthFilter extends Filter
{

    private $maxLength;

    public function __construct($maxLength)
    {
        $this->maxLength = $maxLength;
    }

    public function validate(array $value)
    {
        if (count($value) > $this->maxLength) {
            throw new \Exception(sprintf('size must be smaller or equal %d, %d found', $this->maxLength, count($value)));
        }
        
        parent::validate($value);
    }
}