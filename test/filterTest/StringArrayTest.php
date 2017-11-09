<?php

use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\Validator;

class StringArrayTest extends TestCase
{

    /**
     *
     * @var Validator
     */
    private $validator;

    public function setUp()
    {
        $this->validator = new Validator(true);
        $this->validator->addSchemaValidation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'stringArraySchema.json',
            "s");
        $this->validator->addSchemaValidation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'nestedItemSchema.json',
            "ss");
    }

    public function testCorrect()
    {
        $a = array(
            "name" => array(
                "sd",
                "sd",
                "sd"
            )
        );

        $this->validator->validate("s", $a);
    }

    /**
     * @expectedException \Exception
     */
    public function testIncorrect()
    {
        $a = array(
            "name" => array(
                1,
                "sd",
                "sd"
            )
        );

        $this->validator->validate("s", $a);
    }

    public function testNestedItem()
    {
        $a = array("position" => array(array('lat' => 0.0, 'lng' => 0.0)));

        $this->validator->validate('ss', $a);
    }
}