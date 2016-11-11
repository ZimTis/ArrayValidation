<?php
namespace zimtis\arrayvalidation\validations\keyValidations;

use zimtis\arrayvalidation\validations\KeyValidation;
use zimtis\arrayvalidation\filter\typeFilter\BooleanFilter;

/**
 *
 * @author ZimTis
 *        
 * @since 0.0.6
 */
class BooleanValidation extends KeyValidation
{

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\validations\KeyValidation::buildFilterChain()
     */
    protected function buildFilterChain()
    {
        $this->addFilter(new BooleanFilter());
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\validations\KeyValidation::checkOptions()
     */
    protected function checkOptions()
    {}
}