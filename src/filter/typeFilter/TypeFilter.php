<?php
namespace zimtis\arrayvalidation\filter\typeFilter;

use zimtis\arrayvalidation\filter\Filter;

abstract class TypeFilter extends Filter
{

    protected function throwException($expected, $value)
    {
        throw new \Exception(sprintf('must be of type %s, %s found', $expected, gettype($value)));
    }
}