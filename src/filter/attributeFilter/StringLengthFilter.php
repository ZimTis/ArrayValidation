<?php
namespace zimtis\arrayvalidation\filter\attributeFilter;

use zimtis\arrayvalidation\filter\Filter;

/**
 *
 * @author ZimTis
 *        
 * @since 0.0.6 added
 */
class StringLengthFilter extends Filter
{

    /**
     *
     * @var int
     */
    private $length;

    /**
     *
     * @param int $length            
     */
    public function __construct($length)
    {
        $this->length = $length;
    }

    public function validate($value)
    {
        if (strlen($value) != $this->length) {
            throw new \Exception(sprintf('must be of size %d, %d found', $this->length, strlen($value)));
        }
        
        parent::validate($value);
    }
}