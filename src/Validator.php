<?php
namespace zimtis\arrayvalidation;

/**
 *
 * @author ZimTis
 *        
 */
class Validator
{

    /**
     *
     * @var array
     */
    private $validations = array();

    public function __construct()
    {}

    /**
     *
     * @param Validation $validation            
     * @param unknown $name            
     * @throws \Exception
     * @return \zimtis\arrayvalidation\Validator
     */
    public function addValidation(Validation $validation, $name)
    {
        if (array_key_exists($name, $this->validations)) {
            throw new \Exception('A Validation with the name "' . $name . '" already exist.');
        } elseif (! is_string($name)) {
            throw new \Exception('The name must be a string, ' . get_class($name) . " was given.");
        }
        
        $this->validations[$name] = $validation;
        
        return $this;
    }

    /**
     * Remove a validation with a given name
     *
     * @param unknown $name            
     */
    public function removeValidation($name)
    {
        // TODO remove serialisation file
        // TODO removing of validation in private function
        unset($this->validations[$name]);
    }

    /**
     * Remove all Validations
     */
    public function removeAllValidations()
    {
        // TODO remove serialisation files
        $this->validations = array();
    }

    /**
     * This functions starts the validation process.
     * If a options is set, that changes values e.g. "trim", the array will be changed.
     *
     * @param unknown $values
     *            array you want to validate
     * @param unknown $validation
     *            name of the validation you want to validate against
     */
    public function validate(array &$values, $validation)
    {
        if (isset($this->validations[$validation])) {
            $this->validations[$validation]->validate($values);
        } else {
            throw new \Exception("No Validation with the name " . $validation . ' was found');
        }
    }
}