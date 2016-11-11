<?php
namespace zimtis\arrayvalidation\filter\attributeFilter;

use zimtis\arrayvalidation\filter\Filter;

/**
 *
 * @author ZimTis
 *        
 * @since 0.0.6 added
 */
class StringMaxLengthFilter extends Filter
{

    /**
     *
     * @var int
     */
    private $maxLength;

    /**
     *
     * @param int $maxLength            
     */
    public function __construct($maxLength)
    {
        $this->maxLength = $maxLength;
    }

    public function validate($value)
    {
        if (strlen($value) > $this->maxLength) {
            throw new \Exception(sprintf('size must be smaller or equal %d, %d found', $this->maxLength, strlen($value)));
        }
        
        parent::validate($value);
    }
}