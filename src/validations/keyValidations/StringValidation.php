<?php
namespace zimtis\arrayvalidation\validations\keyValidations;

use zimtis\arrayvalidation\validations\KeyValidation;
use zimtis\arrayvalidation\filter\typeFilter\StringTypeFilter;
use zimtis\arrayvalidation\Properties;
use zimtis\arrayvalidation\filter\attributeFilter\StringMinLengthFilter;
use zimtis\arrayvalidation\filter\attributeFilter\StringMaxLengthFilter;
use zimtis\arrayvalidation\filter\attributeFilter\StringLengthFilter;
use zimtis\arrayvalidation\filter\attributeFilter\StringTrimmedFilter;
use zimtis\arrayvalidation\filter\attributeFilter\StringStartsWithFilter;
use zimtis\arrayvalidation\filter\attributeFilter\StringEndsWithFilter;

/**
 * Validates a String
 *
 * @author ZimTis
 *
 * @since 0.0.1 added
 * @since 0.0.6 rewritten
 */
class StringValidation extends KeyValidation {

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\validations\KeyValidation::buildFilterChain()
     */
    protected function buildFilterChain(){
        $this->addFilter(new StringTypeFilter());

        if (!is_null($this->getOption(Properties::MIN_LENGTH))) {
            $this->addFilter(new StringMinLengthFilter($this->getOption(Properties::MIN_LENGTH)));
        }

        if (!is_null($this->getOption(Properties::MAX_LENGTH))) {
            $this->addFilter(new StringMaxLengthFilter($this->getOption(Properties::MAX_LENGTH)));
        }

        if (!is_null($this->getOption(Properties::LENGTH))) {
            $this->addFilter(new StringLengthFilter($this->getOption(Properties::LENGTH)));
        }

        if (!is_null($this->getOption(Properties::START_WITH))) {
            $this->addFilter(new StringStartsWithFilter($this->getOption(Properties::START_WITH)));
        }

        if (!is_null($this->getOption(Properties::END_WITH))) {
            $this->addFilter(new StringEndsWithFilter($this->getOption(Properties::END_WITH)));
        }

        $this->addFilter(new StringTrimmedFilter($this->getOption(Properties::TRIMMED)));
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\validations\KeyValidation::checkOptions()
     */
    protected function checkOptions(){
        $this->checkForExclusivity(array(
                                        Properties::LENGTH ), array(
                                                                Properties::MAX_LENGTH,
                                                                Properties::MIN_LENGTH ));

        $this->checkForInt(Properties::MIN_LENGTH);
        $this->checkForInt(Properties::MAX_LENGTH);
        $this->checkForInt(Properties::LENGTH);
        $this->checkForBoolean(Properties::TRIMMED);
        $this->checkForString(Properties::START_WITH);
        $this->checkForString(Properties::END_WITH);

        if (!is_null($this->getOption(Properties::MAX_LENGTH)) && !is_null($this->getOption(Properties::MIN_LENGTH))) {
            if ($this->getOption(Properties::MAX_LENGTH) < $this->getOption(Properties::MIN_LENGTH)) {
                trigger_error(Properties::MAX_LENGTH . ' must be bigger than ' . Properties::MIN_LENGTH, E_USER_ERROR);
            }
        }
    }
}