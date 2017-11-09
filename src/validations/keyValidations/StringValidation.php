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
use zimtis\arrayvalidation\filter\attributeFilter\OneOfFilter;

/**
 * Validates a String
 *
 * @author ZimTis
 *
 * @since 0.0.1 added
 * @since 0.0.6 rewritten
 * @since 0.0.8 add oneOf
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
        if (!is_null($this->getOption(Properties::ONE_OF()))) {
            $this->addFilter(new OneOfFilter($this->getOption(Properties::ONE_OF())));
        } else {
            if (!is_null($this->getOption(Properties::MIN_LENGTH()))) {
                $this->addFilter(new StringMinLengthFilter($this->getOption(Properties::MIN_LENGTH())));
            }

            if (!is_null($this->getOption(Properties::MAX_LENGTH()))) {
                $this->addFilter(new StringMaxLengthFilter($this->getOption(Properties::MAX_LENGTH())));
            }

            if (!is_null($this->getOption(Properties::LENGTH()))) {
                $this->addFilter(new StringLengthFilter($this->getOption(Properties::LENGTH())));
            }

            if (!is_null($this->getOption(Properties::START_WIDTH()))) {
                $this->addFilter(new StringStartsWithFilter($this->getOption(Properties::START_WIDTH())));
            }

            if (!is_null($this->getOption(Properties::END_WITH()))) {
                $this->addFilter(new StringEndsWithFilter($this->getOption(Properties::END_WITH())));
            }

            $this->addFilter(new StringTrimmedFilter($this->getOption(Properties::TRIMMED())));
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
        $this->checkForExclusivity(array(
            Properties::LENGTH
        ), array(
            Properties::MAX_LENGTH,
            Properties::MIN_LENGTH
        ));

        $this->checkForExclusivity(array(
            Properties::ONE_OF
        ), array(
            Properties::LENGTH,
            Properties::MIN_LENGTH,
            Properties::MAX_LENGTH,
            Properties::START_WIDTH,
            Properties::END_WITH,
            Properties::TRIMMED
        ));

        $this->checkForInt(Properties::MIN_LENGTH);
        $this->checkForInt(Properties::MAX_LENGTH);
        $this->checkForInt(Properties::LENGTH);
        $this->checkForBoolean(Properties::TRIMMED);
        $this->checkForString(Properties::START_WIDTH);
        $this->checkForString(Properties::END_WITH);
        $this->checkForArray(Properties::ONE_OF);

        if (!is_null($this->getOption(Properties::ONE_OF()))) {
            foreach ($this->getOption(Properties::ONE_OF()) as $string) {
                if (!is_string($string)) {
                    trigger_error(sprintf('%s must contain strings, %s found', Properties::ONE_OF, gettype($string)),
                        E_USER_ERROR);
                }
            }
        }

        if (!is_null($this->getOption(Properties::MAX_LENGTH())) && !is_null($this->getOption(Properties::MIN_LENGTH()))) {
            if ($this->getOption(Properties::MAX_LENGTH()) < $this->getOption(Properties::MIN_LENGTH())) {
                trigger_error(Properties::MAX_LENGTH . ' must be bigger than ' . Properties::MIN_LENGTH, E_USER_ERROR);
            }
        }

        // check if starts with and end with violates trim
        if ($this->getOption(Properties::TRIMMED())) {

            if (!is_null($this->getOption(Properties::START_WIDTH())) && ltrim($this->getOption(Properties::START_WIDTH())) !== $this->getOption(Properties::START_WIDTH())) {
                trigger_error(sprintf('%s, \'%s\', is in violation with %s', Properties::START_WIDTH,
                    $this->getOption(Properties::START_WIDTH()), Properties::TRIMMED));
            }

            if (!is_null($this->getOption(Properties::END_WITH())) && rtrim($this->getOption(Properties::END_WITH())) !== $this->getOption(Properties::END_WITH())) {
                trigger_error(sprintf('%s, \'%s\', is in violation with %s', Properties::END_WITH,
                    $this->getOption(Properties::END_WITH()), Properties::TRIMMED));
            }
        }

        // check that start with or end with are not empty< strings, with length of 0

        if (!is_null($this->getOption(Properties::START_WIDTH())) && strlen($this->getOption(Properties::START_WIDTH())) === 0) {
            trigger_error(sprintf('%s - %s can not be an empty string', $this->getFullName(), Properties::START_WIDTH),
                E_USER_ERROR);
        }

        if (!is_null($this->getOption(Properties::END_WITH())) && strlen($this->getOption(Properties::END_WITH())) === 0) {
            trigger_error(sprintf('%s - %s can not be an empty string', $this->getFullName(), Properties::END_WITH),
                E_USER_ERROR);
        }

        if ((!is_null($this->getOption(Properties::END_WITH())) || !is_null($this->getOption(Properties::START_WIDTH())))
            && (!is_null($this->getOption(Properties::MAX_LENGTH())) || !is_null($this->getOption(Properties::LENGTH())))) {
            $min = $this->getMinLength();
            if (!is_null($min)) {

                if (!is_null($this->getOption(Properties::LENGTH())) && $min > $this->getOption(Properties::LENGTH())) {
                    trigger_error(sprintf('minimal length calculated with %s and %s, %d, is bigger than %s, %d',
                        Properties::START_WIDTH, Properties::END_WITH, $min, Properties::LENGTH,
                        $this->getOption(Properties::LENGTH())), E_USER_ERROR);
                }
                if(!is_null($this->getOption(Properties::MAX_LENGTH())) && $min > $this->getOption(Properties::MAX_LENGTH())){
                    trigger_error(sprintf('minimal length calculated with %s and %s, %d, is bigger than %s, %d',
                        Properties::START_WIDTH, Properties::END_WITH, $min, Properties::MAX_LENGTH,
                        $this->getOption(Properties::MAX_LENGTH())), E_USER_ERROR);
                }
            } else {
                throw new \Exception('internal error');
            }
        }
    }

    public function getMinLength()
    {
        if (!is_null($this->getOption(Properties::START_WIDTH())) && !is_null($this->getOption(Properties::END_WITH()))) {
            $start = $this->getOption(Properties::START_WIDTH());
            $end = $this->getOption(Properties::END_WITH());

            $count = strlen($start) + strlen($end);

            for ($i = 0; $i < strlen($start); $i++) {
                if (strlen($end) < $i + 1) {
                    break;
                }
                $s = substr($start, strlen($start) - ($i + 1), 1);
                $e = substr($end, $i, 1);

                if ($s === $e) {
                    $count--;
                } else {
                    break;
                }
            }

            return $count;

        } elseif (!is_null($this->getOption(Properties::START_WIDTH()))) {
            return strlen($this->getOption(Properties::START_WIDTH()));
        } elseif (!is_null($this->getOption(Properties::END_WITH()))) {
            return strlen($this->getOption(Properties::END_WITH()));
        }

        return null;
    }
}