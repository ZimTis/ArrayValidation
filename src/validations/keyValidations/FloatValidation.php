<?php
namespace zimtis\arrayvalidation\validations\keyValidations;

use zimtis\arrayvalidation\validations\KeyValidation;
use zimtis\arrayvalidation\filter\typeFilter\FloatTypeFilter;
use zimtis\arrayvalidation\Properties;
use zimtis\arrayvalidation\filter\attributeFilter\NumberMaxFilter;
use zimtis\arrayvalidation\filter\attributeFilter\NumberMinFilter;

/**
 *
 * @author ZimTis
 *
 * @since 0.0.6 added
 */
class FloatValidation extends KeyValidation {

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\validations\KeyValidation::buildFilterChain()
     */
    protected function buildFilterChain(){
        $this->addFilter(new FloatTypeFilter());
        if (!is_null($this->getOption(Properties::MIN))) {
            $this->addFilter(new NumberMinFilter($this->getOption(Properties::MIN)));
        }

        if (!is_null($this->getOption(Properties::MAX))) {
            $this->addFilter(new NumberMaxFilter($this->getOption(Properties::MAX)));
        }
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\validations\KeyValidation::checkOptions()
     */
    protected function checkOptions(){
        $this->checkForIntOrFloat(Properties::MIN);
        $this->checkForIntOrFloat(Properties::MAX);

        if (!is_null($this->getOption(Properties::MAX)) && !is_null($this->getOptions(Properties::MIN))) {
            if ($this->getOption(Properties::MAX) < $this->getOption(Properties::MIN)) {
                trigger_error(Properties::MAX . ' must be bigger than ' . Properties::MIN, E_USER_ERROR);
            }
        }
    }
}