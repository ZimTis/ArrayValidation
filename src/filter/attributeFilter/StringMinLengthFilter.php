<?php
namespace zimtis\arrayvalidation\filter\attributeFilter;

use zimtis\arrayvalidation\filter\Filter;

/**
 *
 * @author ZimTis
 *        
 * @since 0.0.6 added
 *       
 */
class StringMinLengthFilter extends Filter
{

    /**
     *
     * @var int
     */
    private $minLength;

    /**
     *
     * @param int $minLength            
     */
    public function __construct($minLength)
    {
        $this->minLength = $minLength;
    }

    public function validate($value)
    {
        if (strlen($value) < $this->minLength) {
            throw new \Exception(sprintf('size must be bigger or equal %d, %d found', $this->minLength, strlen($value)));
        }
        
        parent::validate($value);
    }
}