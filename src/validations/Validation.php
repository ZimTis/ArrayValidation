<?php
namespace zimtis\arrayvalidation\validations;

/**
 * Responsable for validating one key schema
 *
 * @author ZimTis
 *        
 * @since 0.0.6 added
 *       
 */
abstract class Validation
{

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @param string $name            
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    public abstract function validate($value);

    /**
     *
     * @param string $name            
     * @return \zimtis\arrayvalidation\validations\Validation
     */
    public function setName($name)
    {
        $this->name;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}