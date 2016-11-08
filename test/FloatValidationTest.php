<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\Validator;
use zimtis\arrayvalidation\Validation;

class FloatValidationTest extends TestCase
{

    /**
     *
     * @var Validator
     */
    private $validator;

    private $minSchema = "minSchema";

    private $maxSchema = "maxSchema";

    /**
     * @before
     */
    public function setupValidator()
    {
        $this->validator = new Validator();
        $this->validator->addValidation(new Validation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'minFloatSchema.json'), $this->minSchema);
        $this->validator->addValidation(new Validation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'maxFloatSchema.json'), $this->maxSchema);
        $this->assertNotNull($this->validator);
    }

    public function testMinSchema()
    {
        $a = array(
            'name' => 5.0
        );
        
        $this->validator->validate($a, $this->minSchema);
    }

    /**
     * @expectedException \Exception
     */
    public function testToShort()
    {
        $a = array(
            'name' => 4.0
        );
        
        $this->validator->validate($a, $this->minSchema);
    }

    public function testMaxSchema()
    {
        $a = array(
            'name' => 5.0
        );
        
        $this->validator->validate($a, $this->maxSchema);
    }

    /**
     * @expectedException \Exception
     */
    public function testToLong()
    {
        $a = array(
            'name' => 5.1
        );
        
        $this->validator->validate($a, $this->maxSchema);
    }
}