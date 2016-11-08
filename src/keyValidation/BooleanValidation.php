<?php
namespace zimtis\arrayvalidation\keyValidation;

use zimtis\arrayvalidation\Options;

class BooleanValidation extends KeyValidation
{

    public function __construct($options, $name)
    {
        parent::__construct($options, $name);
        
        if (! is_null($this->getOption(Options::DEFAULT_O))) {
            $this->validateDefault();
        }
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\keyValidation\KeyValidation::validate()
     */
    public function validate(array &$values)
    {
        parent::validate($values);
        if (key_exists($this->getName(), $values)) {
            $this->validateLength($values[$this->getName()]);
        }
    }

    /**
     * this functions cheks the size of a value, if the vaöue is outside of the aproved, throw an exception
     *
     * @param int $value            
     */
    private function validateLength($value)
    {}

    /**
     * This function cheks, if the default value fits the specifications of the value
     */
    private function validateDefault()
    {
        if (key_exists(Options::DEFAULT_O, $this->getOptions()) && ! is_null($this->getOption(Options::DEFAULT_O))) {
            try {
                $this->validateLength($this->getOption(Options::DEFAULT_O));
            } catch (\Exception $e) {
                throw new \Exception('Default value does not fit');
            }
        }
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\keyValidation\KeyValidation::checkType()
     */
    protected function checkType($value)
    {
        if (! is_bool($value)) {
            throw new \Exception($this->getName() . ' needs to be integer');
        }
    }
}