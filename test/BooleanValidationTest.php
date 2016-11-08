<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\Validator;
use zimtis\arrayvalidation\Validation;

class BooleanValidationtest extends TestCase
{

    /**
     *
     * @var Validator
     */
    private $validator;

    private $minSchema = "minSchema";

    private $booleanDefault = "default";

    /**
     * @before
     */
    public function setupValidator()
    {
        $this->validator = new Validator();
        $this->validator->addValidation(new Validation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'booleanSchema.json'), $this->minSchema);
        $this->validator->addValidation(new Validation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'booleanDefaultSchema.json'), $this->booleanDefault);
        $this->assertNotNull($this->validator);
    }

    public function testBoolean()
    {
        $a = array(
            'name' => true
        );
        
        $this->validator->validate($a, $this->minSchema);
    }

    public function testBooleanDefault()
    {
        $a = array();
        
        $this->validator->validate($a, $this->booleanDefault);
        
        $this->assertEquals(false, $a['name']);
    }
}