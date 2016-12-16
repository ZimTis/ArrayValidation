<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\Validator;

class NestedTest extends TestCase {
    /**
     *
     * @var Validator
     */
    private $validator;

    /**
     * @before
     */
    public function setUpTest(){
        $this->validator = new Validator(true);
        $this->validator->addSchemaValidation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'validNestedWithRequiredInNested.json', 'a');
    }

    /**
     * @expectedException zimtis\arrayvalidation\exceptions\ValidationException
     */
    public function testNestedWithRequired(){
        $a = array();

        $this->validator->validate('a', $a);
    }
}