<?php
namespace zimtis\arrayvalidation\filter\attributeFilter;

use zimtis\arrayvalidation\filter\Filter;
use zimtis\arrayvalidation\validations\KeyValidation;
use zimtis\arrayvalidation\Properties;
use zimtis\arrayvalidation\CallableBox;
use zimtis\arrayvalidation\model\CallableResult;

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
            // otherwhise, use below code
            $result = call_user_func($callable->getCallable(), $value, $arguments);

            if ($result instanceof CallableResult) {
                if (! $result->getResult()) {
                    throw new \Exception(sprintf('%s , Callable returnes false, %s', $this->keyValidator->getFullName(), $result->getErrorString()));
                }
            } else {
                throw new \Exception(sprintf('%s , Callable must return a CallableResult', $this->keyValidator->getFullName()));
            }
        }

        parent::validate($value);
    }
}