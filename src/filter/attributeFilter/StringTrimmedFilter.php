<?php
namespace zimtis\arrayvalidation\filter\attributeFilter;

use zimtis\arrayvalidation\filter\Filter;
use phpDocumentor\Reflection\Types\Boolean;

/**
 *
 * @author ZimTis
 *        
 * @since 0.0.6 added
 *       
 */
class StringTrimmedFilter extends Filter
{

    /**
     *
     * @var boolean
     */
    private $trimmed;

    /**
     *
     * @param boolean $trimmed            
     */
    public function __construct($trimmed)
    {
        $this->trimmed = $trimmed;
    }

    public function validate($value)
    {
        if ($this->trimmed && $value != trim($value)) {
            throw new \Exception('must be trimmed');
        }
        
        parent::validate($value);
    }
}