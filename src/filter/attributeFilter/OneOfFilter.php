<?php
namespace zimtis\arrayvalidation\filter\attributeFilter;

use zimtis\arrayvalidation\filter\Filter;

/**
 *
 * @author ZimTis
 *
 * @since 0.0.8 added
 */
class OneOfFilter extends Filter
{

    /**
     *
     * @var array
     */
    private $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function validate($value)
    {
        if (! in_array($value, $this->values, TRUE)) {
            throw new \Exception(sprintf('must contain one of "%s" , %s(%s) found', join(', ', array_map(array(
                $this,
                'callback'
            ), $this->values)), $value, gettype($value)));
        }
        parent::validate($value);
    }

    private function callback($value)
    {
        return sprintf('%s(%s)', $value, gettype($value));
    }
}