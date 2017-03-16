<?php
namespace zimtis\arrayvalidation\filter\attributeFilter;

use zimtis\arrayvalidation\filter\Filter;

class StringStartsWithFilter extends Filter
{

    /**
     *
     * @var string $startString
     */
    private $startString;

    public function __construct($startsWith)
    {
        $this->startString = $startsWith;
    }

    public function validate($value)
    {
        $s = substr($value, 0, strlen($this->startString));
        if ($this->startString != $s) {
            throw new \Exception(sprintf('must start with %s, %s found', $this->startString, $s));
        }
        
        parent::validate($value);
    }
}