<?php
namespace zimtis\arrayvalidation\validations;

use zimtis\arrayvalidation\validations\Validation;

/**
 * Validates a nestes schema.
 * aka a multitude of primitve values and other nested schemas
 *
 * @author ZimTis
 *        
 * @since 0.0.6
 */
class NestesValidation extends Validation
{

    /**
     *
     * @var array every Validation this NestesValidation has
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
            }
        }
    }
}