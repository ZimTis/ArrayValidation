<?php
namespace zimtis\arrayvalidation\filter\typeFilter;

use zimtis\arrayvalidation\filter\typeFilter\TypeFilter;
use zimtis\arrayvalidation\Types;

/**
 *
 * @author ZimTis
 *        
 * @since 0.0.6 added
 */
class BooleanFilter extends TypeFilter
{

    public function validate($value)
    {
        if (! is_bool($value)) {
            $this->throwException(Types::BOOLEAN, $value);
        }
        parent::validate($value);
    }
}