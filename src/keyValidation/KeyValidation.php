<?php
namespace zimtis\arrayvalidation\keyValidation;

use zimtis\arrayvalidation\Options;
use zimtis\arrayvalidation\Types;

/**
 *
 * @author ZimTis
 *        
 */
abstract class KeyValidation
{

    /**
     *
     * @var array
     */
    private $options;

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @param array $options            
     * @param string $name            
     */
    public function __construct(array $options, $name)
    {
        $this->options = $options;
        $this->name = $name;
        
        $this->checkForExclusivity(array(
            Options::FORBIDDEN
        ), array(
            Options::REQUIRED
        ));
        $this->checkForBoolean(Options::REQUIRED);
        $this->checkForBoolean(Options::FORBIDDEN);
        $this->checkDefault();
        
        // TODO check if default can be set e.g. if default fits the rules set by the schema
    }

    /**
     * Checks if a given option is a string
     *
     * @param string $key
     *            name of the option
     * @param boolean $required
     *            is the key required, default is false
     * @param array $enum
     *            possible values this string can have, default every value is possible
     */
    protected function checkForString($key, $required = false, array $enum = array())
    {}

    /**
     * Checks if a given option is a boolean
     *
     * @param string $key            
     * @param boolean $required            
     */
    protected function checkForBoolean($key, $default = false, $required = false)
    {
        $e = $this->checkForRequired($key, $required);
        
        if ($e && ! is_bool($this->options[$key])) {
            throw new \Exception($key . ' must be boolean');
        }
        
        $this->options[$key] = ! $e ? $default : $this->options[$key];
    }

    /**
     *
     * Checks if a given option is a int
     *
     * @param string $key            
     * @param int $default            
     * @param string $required            
     * @param int $min            
     * @param int $max            
     * @throws \Exception
     */
    protected function checkForInt($key, $default = null, $required = false, $min = null, $max = null)
    {
        $e = $this->checkForRequired($key, $required);
        
        if ($e && ! is_int($this->options[$key])) {
            throw new \Exception($key . ' must be int');
        }
        
        $value = $e ? $this->options[$key] : NULL;
        
        if (! is_null($min)) {
            if ($value < $min) {
                throw new \Exception($key . ' must be greater or equal ' . $min);
            }
        }
        
        if (! is_null($max)) {
            if ($value > $max) {
                throw new \Exception($key . ' must be smaller or equal ' . $max);
            }
        }
        
        $this->options[$key] = ! $e ? $default : $value;
    }

    protected function checkForFloat($key, $default = null, $required = false)
    {
        $e = $this->checkForRequired($key, $required);
        if ($e && ! is_float($this->options[$key])) {
            throw new \Exception($key . ' must be float');
        }
        
        $value = $e ? $this->options[$key] : NULL;
        
        $this->options[$key] = ! $e ? $default : $value;
    }

    /**
     * This functionc checks, if the options dont contain options from $a and $b
     *
     * @param array $a            
     * @param array $b            
     */
    protected function checkForExclusivity(array $a, array $b)
    {
        $intersec = array_intersect(array_keys($this->options), $a);
        
        if (count($intersec) > 0) {
            if (count(array_intersect(array_keys($this->options), $b)) > 0) {
                throw new \Exception(join(', ', $a) . ' cant be paired with ' . join(' ,', $b));
            }
        }
    }

    /**
     * This method checks if $small is realy smaller than $big
     *
     * @param string $small            
     * @param string $big            
     */
    protected function checkIfOptionIsSmaller($small, $big)
    {
        if ($this->options[$small] >= $this->options[$big]) {
            throw new \Exception($small . ' must be smaller than ' . $big);
        }
    }

    /**
     *
     * @param string $key            
     * @param boolean $required            
     * @return boolean true if the key exist, false if not
     * @throws \Exception
     */
    private function checkForRequired($key, $required)
    {
        if (! key_exists($key, $this->options) && $required) {
            throw new \Exception($key . ' must be set');
        }
        
        return key_exists($key, $this->options);
    }

    /**
     *
     * @return the array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     *
     * @return the string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $key            
     * @return mixed
     */
    public function getOption($key)
    {
        return key_exists($key, $this->options) ? $this->options[$key] : NULL;
    }

    /**
     *
     * @param array $values            
     */
    public function validate(array &$values)
    {
        if (! key_exists($this->getName(), $values) && $this->getOption(Options::REQUIRED)) {
            throw new \Exception($this->getName() . ' needs to be set');
        } elseif (key_exists($this->getName(), $values) && $this->getOption(Options::FORBIDDEN)) {
            throw new \Exception($this->getName() . ' must not be set');
        }
        
        if (key_exists($this->getName(), $values)) {
            $this->checkType($values[$this->name]);
            $this->prepareValue($values);
        } else {
            $this->setDefault($values);
        }
    }

    /**
     * This function checks the type of the validated value
     *
     * @param mixed $value            
     */
    protected abstract function checkType($value);

    /**
     * this function sets the defrault value, if there is a default value to set
     *
     * @param array $values            
     */
    private function setDefault(array &$values)
    {
        if (key_exists(Options::DEFAULT_O, $this->getOptions())) {
            $values[$this->getName()] = $this->getOption(Options::DEFAULT_O);
        }
    }

    /**
     * This function prepares the validated value for further use, e.g.
     * trims it if the trim option is set to true
     *
     * @param array $values            
     */
    protected function prepareValue(array &$values)
    {}

    private function checkDefault()
    {
        if (key_exists(Options::DEFAULT_O, $this->options)) {
            switch ($this->options[Options::TYPE]) {
                case Types::STR:
                case Types::STRING:
                    if (! is_null($this->options[Options::DEFAULT_O]) && ! is_string($this->options[Options::DEFAULT_O])) {
                        $this->throwDefaultException("string");
                    }
                    break;
                case Types::INT:
                case Types::INTEGER:
                    if (! is_null($this->options[Options::DEFAULT_O]) && ! is_int($this->options[Options::DEFAULT_O])) {
                        $this->throwDefaultException("integer");
                    }
                    break;
                case Types::FLOAT:
                    if (! is_null($this->options[Options::DEFAULT_O]) && ! is_float($this->options[Options::DEFAULT_O])) {
                        $this->throwDefaultException("float");
                    }
                    break;
                case Types::BOOLEAN:
                    if (! is_null($this->options[Options::DEFAULT_O]) && ! is_bool($this->options[Options::DEFAULT_O])) {
                        $this->throwDefaultException("float");
                    }
                    break;
            }
        }
    }

    /**
     * This function throws the exception if default is not of the correct type
     *
     * @param string $type            
     */
    private function throwDefaultException($type)
    {
        throw new \Exception(Options::DEFAULT_O . ' must ether be NULL or ' . $type);
    }

    /**
     * This sets a option
     *
     * @param string $option            
     * @param mixed $value            
     */
    protected function setOption($option, $value)
    {
        $this->options[$option] = $value;
    }
}