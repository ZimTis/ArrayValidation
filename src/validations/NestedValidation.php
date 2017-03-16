<?php
namespace zimtis\arrayvalidation\validations;

use zimtis\arrayvalidation\validations\Validation;

/**
 * Validates a nestes schema.
 * aka a multitude of primitve values and other nested schemas
 *
 * @author ZimTis
 *        
 * @since 0.0.6 added
 * @since 0.0.9 add support for callable filter
 */
class NestedValidation extends Validation
{

    /**
     *
     * @var array every Validation this NestedValidation has
     */
    private $validations = array();

    /**
     *
     * @param string $name            
     */
    public function __construct($name)
    {
        parent::__construct($name);
    }

    public function addValidation(Validation $validation)
    {
        $validation->setParent($this);
        array_push($this->validations, $validation);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\validations\Validation::validate()
     */
    public function validate($value)
    {
        
        /**
         *
         * @var Validation $v
         */
        foreach ($this->validations as $v) {
            if (is_null($this->getName())) {
                $v->validate($value);
            } elseif (key_exists($this->getName(), $value)) {
                $v->validate($value[$this->getName()]);
            } else {
                $v->validate(array());
            }
        }
    }

    public function getValidations()
    {
        return $this->validations;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\validations\Validation::getKeyValidationByName()
     *
     * @return NULL|KeyValidation
     */
    public function getKeyValidationByName($route)
    {
        parent::getKeyValidationByName($route);
        
        $parts = explode(':', $route);
        $first = $parts[0];
        $last = null;
        
        if (count($parts) > 1) {
            $last = implode(':', array_slice($parts, 1));
        }
        
        /**
         *
         * @var Validation $validation
         */
        foreach ($this->validations as $validation) {
            if ($validation->getName() == $first) {
                if (is_null($last) && $validation instanceof KeyValidation) {
                    return $validation;
                } else 
                    if (! is_null($last) && $validation instanceof KeyValidation) {
                        throw new \Exception(sprintf('Can\'t map route \'%s\' to a KeyValidation', $this->getFullName() . $last));
                    } else 
                        if (is_null($last) && $validation instanceof NestedValidation) {
                            throw new \Exception(sprintf('Can\'t map route \'%s\' to a KeyValidation', $this->getFullName() . ':' . $first));
                        }
                return $validation->getKeyValidationByName($last);
            }
        }
        
        throw new \Exception(sprintf('Validation with name \'%s\' not found', $first));
    }
}