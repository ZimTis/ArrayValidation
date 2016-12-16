<?php
namespace zimtis\arrayvalidation\filter\attributeFilter;

use zimtis\arrayvalidation\filter\Filter;

class StringEndsWithFilter extends Filter {
    private $endString;

    public function __construct($endString){
        $this->endString = $endString;
    }

    public function validate($value){
        $s = substr($value, -strlen($this->endString));
        if ($this->endString != $s) {
            throw new \Exception(sprintf('must end with %s, %s found', $this->endString, $s));
        }
        parent::validate($value);
    }
}