<?php
namespace zimtis\arrayvalidation\filter;

/**
 *
 * @author ZimTis
 *        
 * @since 0.0.6 added
 */
class Filter
{

    /**
     *
     * @var Filter
     */
    private $filter = null;

    public function addFilter(Filter $filter)
    {
        if (is_null($this->filter)) {
            $this->filter = $filter;
        } else {
            $this->filter->addFilter($filter);
        }
    }

    /**
     * Value to validate
     *
     * @param mixed $value            
     */
    public function validate($value)
    {
        if (! is_null($this->filter)) {
            $this->filter->validate($value);
        }
    }

    public function getFilter()
    {
        return $this->filter;
    }
}