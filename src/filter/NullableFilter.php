<?php
namespace zimtis\arrayvalidation\filter;

use zimtis\arrayvalidation\filter\Filter;

/**
 *
 * @author ZimTis
 *        
 * @since 0.0.6 added
 */
class NullableFilter extends Filter
{

    private $nullable;

    public function __construct($nullable)
    {
        $this->nullable = $nullable;
    }

    public function validate($value)
    {
        if ($this->nullable) {
            if (! is_null($value)) {
                parent::validate($value);
            }
        } else {
            parent::validate($value);
        }
    }
}