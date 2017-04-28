<?php
namespace zimtis\arrayvalidation\filter\attributeFilter;

use zimtis\arrayvalidation\filter\Filter;
use zimtis\arrayvalidation\validations\KeyValidation;
use zimtis\arrayvalidation\Properties;
use zimtis\arrayvalidation\CallableBox;

/**
 *
 * @author ZimTis
 *
 * @since 0.0.9 added
 */
class CallableFilter extends Filter
{

    /**
     *
     * @var KeyValidation
     */
    private $keyValidator;

    public function __construct(KeyValidation $keyValidation)
    {
        $this->keyValidator = $keyValidation;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\filter\Filter::validate()
     */
    public function validate($value)
    {
        // call the callable from the keyvalidation and check the result
        /**
         *
         * @var CallableBox $callable
         */
        $callable = $this->keyValidator->getOption(Properties::CAL_ABLE);
        $arguments = $this->keyValidator->getCallableArguments();
        $arguments = is_null($arguments) || ! is_array($arguments) ? array() : $arguments;
        if ($callable instanceof CallableBox) {

            // if callable is a string, resolve the string, eather as a static call to a functio or a non static call to a functio of a class
            // if call to a function, static function, or using the closure, user below code
            // $result = call_user_func($callable, $value, $arguments);

            // otherwhise, use below code
            $result = call_user_func($callable->getCallable(), $value, $arguments);
            if (! is_bool($result)) {
                throw new \Exception(sprintf('%s , Callable must return a boolean', $this->keyValidator->getFullName()));
            }
            if (! $result) {
                throw new \Exception(sprintf('%s , Callable returnes false', $this->keyValidator->getFullName()));
            }
        }

        parent::validate($value);
    }
}