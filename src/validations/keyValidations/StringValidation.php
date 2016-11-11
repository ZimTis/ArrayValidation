<?php
namespace zimtis\arrayvalidation\validations\keyValidations;

use zimtis\arrayvalidation\validations\KeyValidation;
use zimtis\arrayvalidation\filter\typeFilter\StringTypeFilter;
use zimtis\arrayvalidation\Options;
use zimtis\arrayvalidation\filter\attributeFilter\StringMinLengthFilter;
use zimtis\arrayvalidation\filter\attributeFilter\StringMaxLengthFilter;
use zimtis\arrayvalidation\filter\attributeFilter\StringLengthFilter;
use zimtis\arrayvalidation\filter\attributeFilter\StringTrimmedFilter;

/**
 * Validates a String
 *
 * @author ZimTis
 *        
 * @since 0.0.1 added
 * @since 0.0.6 rewritten
 */
class StringValidation extends KeyValidation
{

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\validations\KeyValidation::buildFilterChain()
     */
    protected function buildFilterChain()
    {
        $this->addFilter(new StringTypeFilter());
        
        if (! is_null($this->getOption(Options::MIN_LENGTH))) {
            $this->addFilter(new StringMinLengthFilter($this->getOption(Options::MIN_LENGTH)));
        }
        
        if (! is_null($this->getOption(Options::MAX_LENGTH))) {
            $this->addFilter(new StringMaxLengthFilter($this->getOption(Options::MAX_LENGTH)));
        }
        
        if (! is_null($this->getOption(Options::LENGTH))) {
            $this->addFilter(new StringLengthFilter($this->getOption(Options::LENGTH)));
        }
        
        $this->addFilter(new StringTrimmedFilter($this->getOption(Options::TRIMMED)));
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\validations\KeyValidation::checkOptions()
     */
    protected function checkOptions()
    {
        $this->checkForExclusivity(array(
            Options::LENGTH
        ), array(
            Options::MAX_LENGTH,
            Options::MIN_LENGTH
        ));
        
        $this->checkForInt(Options::MIN_LENGTH);
        $this->checkForInt(Options::MAX_LENGTH);
        $this->checkForInt(Options::LENGTH);
        $this->checkForBoolean(Options::TRIMMED);
        
        if (! is_null($this->getOption(Options::MAX_LENGTH)) && ! is_null($this->getOption(Options::MIN_LENGTH))) {
            if ($this->getOption(Options::MAX_LENGTH) < $this->getOption(Options::MIN_LENGTH)) {
                trigger_error(Options::MAX_LENGTH . ' must be bigger than ' . Options::MIN_LENGTH, E_USER_ERROR);
            }
        }
    }
}