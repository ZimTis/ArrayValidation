<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\Validator;
use zimtis\arrayvalidation\validations\NestedValidation;
use zimtis\arrayvalidation\validations\Validation;

class SchemaReadTest extends TestCase
{

    /**
     *
     * @var Validator
     *
     */
    private $validator;

    /**
     * @before
     */
    public function setupTest()
    {
        $this->validator = new Validator(true);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testInvalidJson()
    {
        $this->validator->addSchemaValidation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'invalidJsonSchema.json');
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testJsonFileNotFound()
    {
        $this->validator->addSchemaValidation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'whereAreYou.json');
    }

    public function testExistingValidJsonFile()
    {
        $this->validator->addSchemaValidation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'validJson.json');
        
        $this->assertInstanceOf('zimtis\arrayvalidation\validations\NestedValidation', $this->validator->getSchemaValidationByName('validJson'));
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testReadSchemaWithExistingNameByFileName()
    {
        $this->validator->addSchemaValidation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'validJson.json');
        $this->validator->addSchemaValidation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'validJson.json');
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testReadSchemaWithExistingNameByManuelName()
    {
        $this->validator->addSchemaValidation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'validJson.json', 'name');
        $this->validator->addSchemaValidation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'validJson.json', 'name');
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testValidJsonWithTypeMissing()
    {
        $this->validator->addSchemaValidation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'validJsonTypeMissing.json', 'name');
    }

    /**
     * Test a json file that has a valid json and a valid validation format
     */
    public function testReadValidJsonWithValidFormat()
    {
        $this->validator->addSchemaValidation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'validJson.json');
        
        /**
         *
         * @var NestedValidation $validation
         */
        $validation = $this->validator->getSchemaValidationByName('validJson');
        
        $v = $validation->getValidations();
        
        $this->assertEquals(1, count($v));
        
        /**
         *
         * @var Validation $v
         */
        $v = $v[0];
        $this->assertInstanceOf('zimtis\arrayvalidation\validations\keyValidations\StringValidation', $v);
        $this->assertEquals('name', $v->getName());
    }

    public function testReadNestedJson()
    {
        $this->validator->addSchemaValidation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'validJsonWithNested.json');
        
        /**
         *
         * @var NestedValidation $validation
         */
        $validation = $this->validator->getSchemaValidationByName('validJsonWithNested');
        $this->assertInstanceOf('zimtis\arrayvalidation\validations\Validation', $validation);
        
        $v = $validation->getValidations();
        $this->assertEquals(2, count($v));
        
        $this->assertInstanceOf('zimtis\arrayvalidation\validations\keyValidations\StringValidation', $v[0]);
        $this->assertInstanceOf('zimtis\arrayvalidation\validations\NestedValidation', $v[1]);
        
        /**
         *
         * @var NestedValidation $nestedValidation
         */
        $nestedValidation = $v[1];
        
        $v2 = $nestedValidation->getValidations();
        
        $this->assertEquals(2, count($v2));
        
        $this->assertInstanceOf('zimtis\arrayvalidation\validations\keyValidations\FloatValidation', $v2[0]);
        $this->assertInstanceOf('zimtis\arrayvalidation\validations\keyValidations\FloatValidation', $v2[1]);
    }

    public function testReadComplexNestedJson()
    {
        $this->validator->addSchemaValidation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'validJsonWithComplexNested.json');
        
        /**
         *
         * @var NestedValidation $validation
         */
        $validation = $this->validator->getSchemaValidationByName('validJsonWithComplexNested');
        $this->assertInstanceOf('zimtis\arrayvalidation\validations\Validation', $validation);
        
        $v = $validation->getValidations();
        $this->assertEquals(2, count($v));
        
        $this->assertInstanceOf('zimtis\arrayvalidation\validations\keyValidations\StringValidation', $v[0]);
        $this->assertInstanceOf('zimtis\arrayvalidation\validations\NestedValidation', $v[1]);
        
        /**
         *
         * @var NestedValidation $nestedValidation
         */
        $nestedValidation = $v[1];
        
        $v2 = $nestedValidation->getValidations();
        
        $this->assertEquals(3, count($v2));
        
        $this->assertInstanceOf('zimtis\arrayvalidation\validations\keyValidations\FloatValidation', $v2[0]);
        $this->assertInstanceOf('zimtis\arrayvalidation\validations\keyValidations\FloatValidation', $v2[1]);
        $this->assertInstanceOf('zimtis\arrayvalidation\validations\NestedValidation', $v2[2]);
        
        /**
         *
         * @var NestedValidation $nestedNestedValidation
         */
        $nestedNestedValidation = $v2[2];
        
        $v3 = $nestedNestedValidation->getValidations();
        $this->assertEquals(2, count($v3));
        
        $this->assertInstanceOf('zimtis\arrayvalidation\validations\keyValidations\StringValidation', $v3[0]);
        $this->assertInstanceOf('zimtis\arrayvalidation\validations\keyValidations\StringValidation', $v3[1]);
    }
}