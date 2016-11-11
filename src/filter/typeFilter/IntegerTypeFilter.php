<?php
namespace zimtis\arrayvalidation\filter\typeFilter;

use zimtis\arrayvalidation\filter\Filter;
use zimtis\arrayvalidation\Types;

/**
 *
 * @author ZimTis
 *        
 * @since 0.0.6 added
 */
class IntegerTypeFilter extends TypeFilter
{

    public function validate($value)
    {
        if (! is_int($value)) {
            $this->throwException(Types::INTEGER, $value);
        }
        parent::validate($value);
    }
}