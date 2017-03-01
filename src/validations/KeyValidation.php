<?php
namespace zimtis\arrayvalidation\validations;

use zimtis\arrayvalidation\validations\Validation;
use zimtis\arrayvalidation\filter\Filter;
use zimtis\arrayvalidation\Properties;
use zimtis\arrayvalidation\exceptions\ValidationException;
use zimtis\arrayvalidation\filter\NullableFilter;
use zimtis\arrayvalidation\Types;

/**
 * Validates a primitive value like string, int etc.
 *
 * @author ZimTis
 *
 * @since 0.0.1 added
 * @since 0.0.6 rewritten
 *
 */
abstract class KeyValidation extends Validation {

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
     * @param unknown $name
     */
    public function __construct($name, array $options){
        parent::__construct($name);
        $this->options = $options;

        $this->checkForBoolean(Properties::REQUIRED);
        $this->checkForBoolean(Properties::NULLABLE, true);

        $this->addFilter(new NullableFilter($this->options[Properties::NULLABLE]));
        $this->checkOptions();
        $this->buildFilterChain();
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\validations\Validation::validate()
     */
    public function validate($value){
        if ($this->options[Properties::REQUIRED] && !key_exists($this->getName(), $value)) {
            throw new ValidationException($this->getFullName() . ' needs to be set', $this->getName());
        }

        try {
            if (key_exists($this->getName(), $value)) {
                $this->filterChain->validate($value[$this->getName()]);
            }
        } catch (\Exception $e ) {
            throw new ValidationException($this->getFullName() . ' ' . $e->getMessage(), $this->getName());
        }
    }

    /**
     * get every option
     *
     * @return array
     */
    public function getOptions(){
        return $this->options;
    }

    /**
     * get a single option by name
     *
     * @param mixed $options
     */
    public function getOption($options){
        return $this->options[$options];
    }

    /**
     *
     * @param Filter $filter
     */
    protected function addFilter(Filter $filter){
        if (is_null($this->filterChain)) {
            $this->filterChain = $filter;
        } else {
            $this->filterChain->addFilter($filter);
        }
    }

    /**
     * builds the filterchain acording to the options
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
    protected function checkForBoolean($option, $default = false, $required = false){
        $this->checkForType($option, $required, $default, Types::BOOLEAN);
    }

    protected function checkForArray($option, $default = null, $required = false){
        $this->checkForType($option, $required, $default, Types::ARRY);
    }

    /**
     * This functionc checks, if the options dont contain options from $a and $b
     *
     * @param array $a
     * @param array $b
     */
    protected function checkForExclusivity(array $a, array $b){
        $intersec = array_intersect(array_keys($this->options), $a);

        if (count($intersec) > 0) {
            if (count(array_intersect(array_keys($this->options), $b)) > 0) {
                trigger_error($this->getFullName() . ' - ' . join(', ', $a) . ' cant be paired with ' . join(' ,', $b), E_USER_ERROR);
            }
        }
    }

    /**
     *
     * @param string $options
     * @param boolean $required
     * @param int|null $default
     */
    protected function checkForInt($option, $required = false, $default = null){
        $this->checkForType($option, $required, $default, Types::INTEGER);
    }

    /**
     *
     * @param string $option
     * @param boolean $required
     * @param int|float|null $default
     */
    protected function checkForIntOrFloat($option, $required = false, $default = null){
        $this->checkForType($option, $required, $default, Types::INTEGER_OR_FLOAT);
    }

    /**
     *
     * @param string $option
     * @param boolean $required
     * @param string|null $default
     */
    protected function checkForString($option, $required = false, $default = null){
        $this->checkForType($option, $required, $default, Types::STRING);
    }

    private function checkForType($option, $required, $default, $type){
        if (key_exists($option, $this->getOptions())) {

            switch ($type) {
                case Types::BOOLEAN :
                    if (!is_bool($this->options[$option])) {
                        $this->triggerTypeCheckError($option, $type);
                    }
                    break;
                case Types::INTEGER :
                    if (!is_int($this->options[$option])) {
                        $this->triggerTypeCheckError($option, $type);
                    }
                    break;
                case Types::STRING :
                    if (!is_string($this->options[$option])) {
                        $this->triggerTypeCheckError($option, $type);
                    }
                    break;
                case Types::INTEGER_OR_FLOAT :
                    if (!is_int($this->options[$option]) && !is_float($this->options[$option])) {
                        $this->triggerTypeCheckError($option, 'integer or float');
                    }
                    break;
                case Types::ARRY :
                    if (!is_array($this->options[$option])) {
                        $this->triggerTypeCheckError($option, $type);
                    }
                    break;
                default :
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

    private function triggerTypeCheckError($option, $expected){
        trigger_error(sprintf('%s must be %s, %s found', $option, $expected, gettype($this->options[$option])), E_USER_ERROR);
    }
}