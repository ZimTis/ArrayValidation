<?php
namespace zimtis\arrayvalidation\filter;

use zimtis\arrayvalidation\validations\KeyValidation;

class ArrayFilter extends Filter
{

    /**
     *
     * @var KeyValidation
     */
    private $keyValidation;

    private $name;

    public function __construct(KeyValidation $keyValidation, $name)
    {
        $this->keyValidation = $keyValidation;
        $this->name = $name;
    }

    public function validate($value)
    {
        foreach ($value as $string) {
            $this->keyValidation->validate(array(
                $this->name => $string
            ));
        }
    }
}