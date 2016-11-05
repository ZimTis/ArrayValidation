<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\Validator;
use zimtis\arrayvalidation\Validation;

class ReadSchemaTest extends TestCase
{

    public function testInstantiation()
    {
        $validation = new Validator();
        $this->assertNotNull($validation);
    }

    public function testAddValidation()
    {
        $validator = new Validator();
        
        // are ther 0 validations after initialising
        $this->assertEquals(0, count($validator->getValidations()));
        
        $validator->addValidation(new Validation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'correctString.json'), "string");
        // is a validation added
        $this->assertEquals(1, count($validator->getValidations()));
        $validations = $validator->getValidations();
        // is the added validation of type validation
        $this->assertInstanceOf('zimtis\arrayvalidation\Validation', $validations['string']);
    }

    public function testGetValidationByName()
    {
        $validator = new Validator();
        
        $validator->addValidation(new Validation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'correctString.json'), "string");
        
        $validation = $validator->getValidationByName("string");
        $this->assertNotNull($validation);
        $this->assertInstanceOf('zimtis\arrayvalidation\Validation', $validation);
    }
}