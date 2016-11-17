<?php
namespace zimtis\arrayvalidation\validations\keyValidations;

use zimtis\arrayvalidation\validations\KeyValidation;
use zimtis\arrayvalidation\filter\typeFilter\ArrayTypeFilter;
use zimtis\arrayvalidation\ValidationBuilder;
use zimtis\arrayvalidation\Options;
use zimtis\arrayvalidation\filter\ArrayFilter;
use zimtis\arrayvalidation\filter\attributeFilter\ArrayMaxLengthFilter;
use zimtis\arrayvalidation\filter\attributeFilter\ArrayMinLengthFilter;
use zimtis\arrayvalidation\filter\attributeFilter\ArrayLengthFilter;

class ArrayValidation extends KeyValidation
{

    protected function buildFilterChain()
    {
        $this->addFilter(new ArrayTypeFilter());
        $s = ValidationBuilder::buildKeyValidation($this->getOption(Options::ITEM), $this->getName());
        if (! is_null($this->getOption(Options::MAX_LENGTH))) {
            $this->addFilter(new ArrayMaxLengthFilter($this->getOption(Options::MAX_LENGTH)));
        }
        
        if (! is_null($this->getOption(Options::MIN_LENGTH))) {
            $this->addFilter(new ArrayMinLengthFilter($this->getOption(Options::MIN_LENGTH)));
        }
        
        if (! is_null($this->getOption(Options::LENGTH))) {
            $this->addFilter(new ArrayLengthFilter($this->getOption(Options::LENGTH)));
        }
        
        $this->addFilter(new ArrayFilter($s, $this->getName()));
    }

    protected function checkOptions()
    {
        $this->checkForExclusivity(array(
            Options::LENGTH
        ), array(
            Options::MAX_LENGTH,
            Options::MIN_LENGTH
        ));
        
        $this->checkForArray(Options::ITEM, NULL, true);
        // TODO Auto-generated method stub
        
        $this->checkForInt(Options::MAX_LENGTH);
        $this->checkForInt(Options::MIN_LENGTH);
        $this->checkForInt(Options::LENGTH);
        
        if (! is_null($this->getOption(Options::MAX_LENGTH)) && ! is_null($this->getOption(Options::MIN_LENGTH))) {
            if ($this->getOption(Options::MAX_LENGTH) < $this->getOption(Options::MIN_LENGTH)) {
                trigger_error(Options::MAX_LENGTH . ' must be bigger than ' . Options::MIN_LENGTH, E_USER_ERROR);
            }
        }
    }
}