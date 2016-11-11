<?php
namespace zimtis\arrayvalidation\validations\keyValidations;

use zimtis\arrayvalidation\validations\KeyValidation;
use zimtis\arrayvalidation\filter\typeFilter\FloatTypeFilter;
use zimtis\arrayvalidation\Options;
use zimtis\arrayvalidation\filter\attributeFilter\NumberMaxFilter;
use zimtis\arrayvalidation\filter\attributeFilter\NumberMinFilter;

/**
 *
 * @author ZimTis
 *        
 * @since 0.0.6 added
 */
class FloatValidation extends KeyValidation
{

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\validations\KeyValidation::buildFilterChain()
     */
    protected function buildFilterChain()
    {
        $this->addFilter(new FloatTypeFilter());
        if (! is_null($this->getOption(Options::MIN))) {
            $this->addFilter(new NumberMinFilter($this->getOption(Options::MIN)));
        }
        
        if (! is_null($this->getOption(Options::MAX))) {
            $this->addFilter(new NumberMaxFilter($this->getOption(Options::MAX)));
        }
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\validations\KeyValidation::checkOptions()
     */
    protected function checkOptions()
    {
        $this->checkForIntOrFloat(Options::MIN);
        $this->checkForIntOrFloat(Options::MAX);
        
        if (! is_null($this->getOption(Options::MAX)) && ! is_null($this->getOptions(Options::MIN))) {
            if ($this->getOption(Options::MAX) < $this->getOption(Options::MIN)) {
                trigger_error(Options::MAX . ' must be bigger than ' . Options::MIN, E_USER_ERROR);
            }
        }
    }
}