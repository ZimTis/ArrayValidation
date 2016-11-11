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
class StringTypeFilter extends TypeFilter
{

    public function validate($value)
    {
        if (! is_string($value)) {
            $this->throwException(Types::STRING, $value);
        }
        parent::validate($value);
    }
}