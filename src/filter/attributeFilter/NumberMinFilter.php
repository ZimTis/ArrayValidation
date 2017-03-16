<?php
namespace zimtis\arrayvalidation\filter\attributeFilter;

use zimtis\arrayvalidation\filter\Filter;
use zimtis\arrayvalidation\Types;

/**
 *
 * @author ZimTis
 *        
 * @since 0.0.6 added
 */
class NumberMinFilter extends Filter
{

    /**
     *
     * @var number
     */
    private $min;

    /**
     *
     * @param number $min            
     */
    public function __construct($min)
    {
        $this->min = $min;
    }

    public function validate($value)
    {
        if ($value < $this->min) {
            throw new \Exception(sprintf($this->getErrorString($value), $this->min, $value));
        }
        
        parent::validate($value);
    }

    private function getErrorString($type)
    {
        switch (gettype($type)) {
            case Types::INTEGER:
                $type = '%d';
                break;
            case Types::DOUBLE:
                $type = '%f';
                break;
        }
        
        return sprintf('must be bigger ot equal %s, %s found', $type, $type);
    }
}