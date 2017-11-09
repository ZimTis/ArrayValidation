<?php

namespace zimtis\arrayvalidation\validations\keyValidations;

use zimtis\arrayvalidation\validations\KeyValidation;
use zimtis\arrayvalidation\filter\typeFilter\ArrayTypeFilter;
use zimtis\arrayvalidation\ValidationBuilder;
use zimtis\arrayvalidation\Properties;
use zimtis\arrayvalidation\filter\ArrayFilter;
use zimtis\arrayvalidation\filter\attributeFilter\ArrayMaxLengthFilter;
use zimtis\arrayvalidation\filter\attributeFilter\ArrayMinLengthFilter;
use zimtis\arrayvalidation\filter\attributeFilter\ArrayLengthFilter;
use zimtis\arrayvalidation\validations\Validation;

/**
 * Class ArrayValidation
 * @package zimtis\arrayvalidation\validations\keyValidations
 *
 * @since 0.0.95 add support for nested items
 */
class ArrayValidation extends KeyValidation
{

    protected function buildFilterChain()
    {
        $this->addFilter(new ArrayTypeFilter());

        /**
         * @var Validation
         */
        $validation = null;

        if (key_exists(Properties::TYPE, $this->getOption(Properties::ITEM()))) {
            $validation = ValidationBuilder::buildKeyValidation($this->getOption(Properties::ITEM()), $this->getName());
        } else {
            $validation = ValidationBuilder::buildValidation($this->getOption(Properties::ITEM()),
                $this->getName());
        }

        if (!is_null($this->getOption(Properties::MAX_LENGTH()))) {
            $this->addFilter(new ArrayMaxLengthFilter($this->getOption(Properties::MAX_LENGTH())));
        }

        if (!is_null($this->getOption(Properties::MIN_LENGTH()))) {
            $this->addFilter(new ArrayMinLengthFilter($this->getOption(Properties::MIN_LENGTH())));
        }

        if (!is_null($this->getOption(Properties::LENGTH()))) {
            $this->addFilter(new ArrayLengthFilter($this->getOption(Properties::LENGTH())));
        }

        $this->addFilter(new ArrayFilter($validation, $this->getName()));
    }

    protected function checkOptions()
    {
        $this->checkForExclusivity(array(
            Properties::LENGTH
        ), array(
            Properties::MAX_LENGTH,
            Properties::MIN_LENGTH
        ));

        $this->checkForArray(Properties::ITEM, null, true);

        $this->checkForInt(Properties::MAX_LENGTH);
        $this->checkForInt(Properties::MIN_LENGTH);
        $this->checkForInt(Properties::LENGTH);

        if (!is_null($this->getOption(Properties::MAX_LENGTH())) && !is_null($this->getOption(Properties::MIN_LENGTH()))) {
            if ($this->getOption(Properties::MAX_LENGTH()) <= $this->getOption(Properties::MIN_LENGTH())) {
                trigger_error(sprintf('%s:%s must be bigger than %s:%s', $this->getFullName(), Properties::MAX_LENGTH,
                    $this->getFullName(), Properties::MIN_LENGTH), E_USER_ERROR);
            }
        }

        if (!is_null($this->getOption(Properties::LENGTH()))) {
            if ($this->getOption(Properties::LENGTH()) < 1) {
                trigger_error(sprintf('%s:%s must be bigger than 0, %d found', $this->getName(), Properties::LENGTH,
                    $this->getOption(Properties::LENGTH())), E_USER_ERROR);
            }
        }

        if (!is_null($this->getOption(Properties::MIN_LENGTH()))) {
            if ($this->getOption(Properties::MIN_LENGTH()) < 0) {
                trigger_error(sprintf('%s:%s can not be negative', $this->getFullName(), Properties::MIN_LENGTH),
                    E_USER_ERROR);
            }
        }

        if (!is_null($this->getOption(Properties::MAX_LENGTH())) && $this->getOption(Properties::MAX_LENGTH()) <= 0) {
            trigger_error(sprintf('%s:%s must be bigger than 0', $this->getFullName(), Properties::MAX_LENGTH),
                E_USER_ERROR);
        }
    }
}