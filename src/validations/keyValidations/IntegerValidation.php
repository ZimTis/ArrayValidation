<?php
namespace zimtis\arrayvalidation\validations\keyValidations;

use zimtis\arrayvalidation\validations\KeyValidation;
use zimtis\arrayvalidation\filter\typeFilter\IntegerTypeFilter;
use zimtis\arrayvalidation\Properties;
use zimtis\arrayvalidation\filter\attributeFilter\NumberMinFilter;
use zimtis\arrayvalidation\filter\attributeFilter\NumberMaxFilter;
use zimtis\arrayvalidation\filter\attributeFilter\OneOfFilter;

/**
 *
 * @author ZimTis
 *        
 * @since 0.0.1 added
 * @since 0.0.6 rewritten
 * @since 0.0.8 add oneOf
 */
class IntegerValidation extends KeyValidation
{

    /**
     *
     * {@inheritdoc}
     *
     * @see \zimtis\arrayvalidation\validations\KeyValidation::buildFilterChain()
     */
    protected function buildFilterChain()
    {
        $this->addFilter(new IntegerTypeFilter());
        
        if (! is_null($this->getOption(Properties::ONE_OF()))) {
            $this->addFilter(new OneOfFilter($this->getOption(Properties::ONE_OF())));
        } else {
            if (! is_null($this->getOption(Properties::MIN()))) {
                $this->addFilter(new NumberMinFilter($this->getOption(Properties::MIN())));
            }
            
            if (! is_null($this->getOption(Properties::MAX()))) {
                $this->addFilter(new NumberMaxFilter($this->getOption(Properties::MAX())));
            }
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
        $this->checkForInt(Properties::MIN);
        $this->checkForInt(Properties::MAX);
        
        $this->checkForArray(Properties::ONE_OF);
        
        if (! is_null($this->getOption(Properties::ONE_OF()))) {
            if (count($this->getOption(Properties::ONE_OF())) == 0) {
                trigger_error(sprintf('%s must contain at least one item', Properties::ONE_OF), E_USER_ERROR);
            }
            foreach ($this->getOption(Properties::ONE_OF()) as $i) {
                if (! is_int($i)) {
                    trigger_error(sprintf('%s must contain integer, %s found', Properties::ONE_OF, gettype($i)), E_USER_ERROR);
                }
            }
        }
        
        if (! is_null($this->getOption(Properties::MAX())) && ! is_null($this->getOption(Properties::MIN()))) {
            if ($this->getOption(Properties::MAX()) < $this->getOption(Properties::MIN())) {
                trigger_error(Properties::MAX . ' must be bigger than ' . Properties::MIN, E_USER_ERROR);
            }
        }
    }
}