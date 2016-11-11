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
class NumberMaxFilter extends Filter
{

    /**
     *
     * @var number
     */
    private $max;

    /**
     *
     * @param number $max            
     */
    public function __construct($max)
    {
        $this->max = $max;
    }

    public function validate($value)
    {
        if ($value > $this->max) {
            throw new \Exception(sprintf($this->getErrorString($value), $this->max, $value));
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
        
        return sprintf('Must be smaller ot equal %s, %s found', $type, $type);
    }
}