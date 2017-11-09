<?php

namespace zimtis\arrayvalidation\filter;

use zimtis\arrayvalidation\validations\Validation;

class ArrayFilter extends Filter
{

    /**
     *
     * @var Validation
     */
    private $keyValidation;

    private $name;

    public function __construct(Validation $keyValidation, $name)
    {
        $this->keyValidation = $keyValidation;
        $this->name = $name;
    }

    public function validate($value)
    {
        foreach ($value as $item) {
            $this->keyValidation->validate(array(
                $this->name => $item
            ));
        }
    }
}