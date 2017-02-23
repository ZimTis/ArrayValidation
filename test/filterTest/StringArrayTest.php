<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\Validator;

class StringArrayTest extends TestCase {

    /**
     *
     * @var Validator
     */
    private $validator;

    /**
     * @before
     */
    public function setupTest(){
        $this->validator = new Validator();
        $this->validator->addSchemaValidation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'stringArraySchema.json', "s");
    }

    public function testCorrect(){
        $a = array(
                "name" => array(
                                "sd",
                                "sd",
                                "sd" ) );

        $this->validator->validate("s", $a);
    }

    /**
     * @expectedException \Exception
     */
    public function testIncorrect(){
        $a = array(
                "name" => array(
                                1,
                                "sd",
                                "sd" ) );

        $this->validator->validate("s", $a);
    }
}