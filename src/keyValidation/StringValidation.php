<?php
namespace zimtis\arrayvalidation\keyValidation;

use zimtis\arrayvalidation\Options;

class StringValidation extends KeyValidation
{

    public function __construct(array $options, $key)
    {
        parent::__construct($options, $key);
        
        $this->checkForBoolean(Options::TRIM, true);
        $this->checkForExclusivity(array(
            Options::MIN_LENGTH,
            Options::MAX_LENGTH
        ), array(
            Options::LENGTH
        ));
        
        $this->checkForInt(Options::MIN_LENGTH);
        $this->checkForInt(Options::MAX_LENGTH);
        if (! is_null($this->getOption(Options::MIN_LENGTH)) && ! is_null($this->getOption(Options::MAX_LENGTH))) {
            $this->checkIfOptionIsSmaller(Options::MIN_LENGTH, Options::MAX_LENGTH);
        }
        $this->checkForInt(Options::LENGTH);
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
        $this->validateLength($values[$this->getName()]);
    }

    /**
     * This function cheks, if the default value fits the specifications of the value
     */
    private function validateDefault()
    {
        if (key_exists(Options::DEFAULT_O, $this->getOptions()) && ! is_null($this->getOption(Options::DEFAULT_O))) {
            
            $this->setOption(Options::DEFAULT_O, $this->getOption(Options::TRIM) ? trim($this->getOption(Options::DEFAULT_O)) : $this->getOption(Options::DEFAULT_O));
            
            try {
                $this->validateLength($this->getOption(Options::DEFAULT_O));
            } catch (\Exception $e) {
                throw new \Exception('Default value does not fit');
            }
        }
    }

    /**
     * This function validates the value against the length specifications
     * length, maxLength, minLength
     *
     * @param string $value            
     */
    private function validateLength($value)
    {
        if (! is_null($this->getOption(Options::MAX_LENGTH)) && strlen($value) > $this->getOption(Options::MAX_LENGTH)) {
            throw new \Exception("to longt");
        }
        
        if (! is_null($this->getOption(Options::MIN_LENGTH)) && strlen($value) < $this->getOption(Options::MIN_LENGTH)) {
            throw new \Exception("to short");
        }
        
        if (! is_null($this->getOption(Options::LENGTH)) && strlen($value) != $this->getOption(Options::LENGTH)) {
            throw new \Exception("to both");
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
        if (! is_string($value)) {
            throw new \Exception($this->getName() . ' needs to be string');
        }
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\keyValidation\KeyValidation::prepareValue()
     */
    protected function prepareValue(array &$values)
    {
        $values[$this->getName()] = $this->getOption(Options::TRIM) ? trim($values[$this->getName()]) : $values[$this->getName()];
    }
}