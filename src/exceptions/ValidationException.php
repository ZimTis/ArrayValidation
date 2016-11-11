<?php
namespace zimtis\arrayvalidation\exceptions;

/**
 *
 * @author ZimTis
 *        
 * @since 0.0.6 added
 */
class ValidationException extends \Exception
{

    /**
     *
     * @var string
     */
    private $key;

    /**
     *
     * @param string $message            
     * @param string $key            
     */
    public function __construct($message, $key)
    {
        parent::__construct($message);
        $this->key = $key;
    }

    public function getKey()
    {
        return $this->key;
    }
}