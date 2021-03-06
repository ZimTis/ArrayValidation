<?php

namespace zimtis\arrayvalidation\validations;

use zimtis\arrayvalidation\validations\Validation;
use zimtis\arrayvalidation\filter\Filter;
use zimtis\arrayvalidation\Properties;
use zimtis\arrayvalidation\exceptions\ValidationException;
use zimtis\arrayvalidation\filter\NullableFilter;
use zimtis\arrayvalidation\Types;
use zimtis\arrayvalidation\filter\attributeFilter\CallableFilter;
use zimtis\arrayvalidation\CallableBox;

/**
 * Validates a primitive value like string, int etc.
 *
 * @author ZimTis
 *
 * @since 0.0.1 added
 * @since 0.0.6 rewritten
 * @since 0.0.9 add support for callable filter
 *
 */
abstract class KeyValidation extends Validation
{

    /**
     *
     * @var array
     */
    private $options;

    /**
     *
     * @var Filter
     */
    private $filterChain;

    /**
     *
     * arguments that will be passed to a callable, if there is a callable specified
     *
     * @var array
     */
    private $callableArguments;

    /**
     *
     * @param string $name
     * @param array $options
     */
    public function __construct($name, array $options)
    {
        parent::__construct($name);
        $this->options = $options;

        $this->checkForBoolean(Properties::REQUIRED);
        $this->checkForBoolean(Properties::NULLABLE, true);

        $this->addFilter(new NullableFilter($this->options[Properties::NULLABLE]));

        $this->checkForString(Properties::CALL_ABLE);
        $this->options[Properties::CALL_ABLE] = is_null($this->options[Properties::CALL_ABLE]) ? null : new CallableBox($this->options[Properties::CALL_ABLE]);

        $this->checkOptions();
        $this->buildFilterChain();
        $this->addFilter(new CallableFilter($this));
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\validations\Validation::validate()
     */
    public function validate($value)
    {
        if ($this->options[Properties::REQUIRED] && !key_exists($this->getName(), $value)) {
            throw new ValidationException($this->getFullName() . ' needs to be set', $this->getName());
        }

        try {
            if (key_exists($this->getName(), $value)) {
                $this->filterChain->validate($value[$this->getName()]);
            }
        } catch (\Exception $e) {
            throw new ValidationException($this->getFullName() . ' ' . $e->getMessage(), $this->getName());
        }
    }

    /**
     * get every option
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * get a single option by name
     *
     * @param Properties $option
     * @return mixed
     */
    public function getOption(Properties $option)
    {
        return $this->options[$option->getValue()];
    }

    /**
     *
     * @param Filter $filter
     */
    protected function addFilter(Filter $filter)
    {
        if (is_null($this->filterChain)) {
            $this->filterChain = $filter;
        } else {
            $this->filterChain->addFilter($filter);
        }
    }

    /**
     * builds the filter chain according to the options
     */
    protected abstract function buildFilterChain();

    /**
     * check the options if everything is in order
     */
    protected abstract function checkOptions();

    /**
     *
     * @param string $option
     * @param boolean $default
     * @param boolean $required
     */
    protected function checkForBoolean($option, $default = false, $required = false)
    {
        $this->checkForType($option, $required, $default, Types::BOOLEAN());
    }

    protected function checkForArray($option, $default = null, $required = false)
    {
        $this->checkForType($option, $required, $default, Types::ARRY());
    }

    /**
     * This function checks, if the options don't contain options from $a and $b
     *
     * @param array $a
     * @param array $b
     */
    protected function checkForExclusivity(array $a, array $b)
    {
        $array_intersect = array_intersect(array_keys($this->options), $a);

        if (count($array_intersect) > 0) {
            if (count(array_intersect(array_keys($this->options), $b)) > 0) {
                trigger_error($this->getFullName() . ' - ' . join(', ', $a) . ' can\'t be paired with ' . join(' ,', $b),
                    E_USER_ERROR);
            }
        }
    }

    /**
     *
     * @param $option
     * @param boolean $required
     * @param int|null $default
     * @internal param string $options
     */
    protected function checkForInt($option, $required = false, $default = null)
    {
        $this->checkForType($option, $required, $default, Types::INTEGER());
    }

    /**
     *
     * @param string $option
     * @param boolean $required
     * @param int|float|null $default
     */
    protected function checkForIntOrFloat($option, $required = false, $default = null)
    {
        $this->checkForType($option, $required, $default, Types::NUMBER());
    }

    /**
     *
     * @param string $option
     * @param boolean $required
     * @param string|null $default
     */
    protected function checkForString($option, $required = false, $default = null)
    {
        $this->checkForType($option, $required, $default, Types::STRING());
    }

    private function checkForType($option, $required, $default, Types $type)
    {
        if (key_exists($option, $this->getOptions())) {

            switch ($type) {
                case Types::BOOLEAN:
                    if (!is_bool($this->options[$option])) {
                        $this->triggerTypeCheckError($option, $type);
                    }
                    break;
                case Types::INTEGER:
                    if (!is_int($this->options[$option])) {
                        $this->triggerTypeCheckError($option, $type);
                    }
                    break;
                case Types::STRING:
                    if (!is_string($this->options[$option])) {
                        $this->triggerTypeCheckError($option, $type);
                    }
                    break;
                case Types::NUMBER:
                    if (!is_int($this->options[$option]) && !is_float($this->options[$option])) {
                        $this->triggerTypeCheckError($option, 'integer or float');
                    }
                    break;
                case Types::ARRY:
                    if (!is_array($this->options[$option])) {
                        $this->triggerTypeCheckError($option, $type);
                    }
                    break;
                default:
                    trigger_error('type ' . $type . ' unknown', E_USER_ERROR);
            }
        } else {
            if ($required) {
                trigger_error($option . ' needs to be set', E_USER_ERROR);
            } else {
                $this->options[$option] = $default;
            }
        }
    }

    private function triggerTypeCheckError($option, $expected)
    {
        trigger_error(sprintf('%s must be %s, %s found', $option, $expected, gettype($this->options[$option])),
            E_USER_ERROR);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\validations\Validation::getKeyValidationByName()
     * @return null
     */
    public function getKeyValidationByName($route)
    {
        return null;
    }

    /**
     *
     * @return array
     */
    public function getCallableArguments()
    {
        return $this->callableArguments;
    }

    /**
     *
     * @param array $arguments
     */
    public function setCallableArguments(array $arguments)
    {
        $this->callableArguments = $arguments;
    }

    public function setCallable(\Closure $function)
    {
        $this->options[Properties::CALL_ABLE] = new CallableBox($function);
    }

    private function getFilter()
    {
        return $this->filterChain;
    }
}