<?php
use PHPUnit\Framework\TestCase;
use zimtis\test\TestUtil;
use zimtis\arrayvalidation\Validator;

class ValidatorDevelopTest extends TestCase
{

    public function setUp()
    {
        // delete all ser files
        if (file_exists(TestUtil::getPathAndFileNameOfDevelopModeTestSchema('test.json.ser'))) {
            unlink(TestUtil::getPathAndFileNameOfDevelopModeTestSchema('test.json.ser'));
        }
    }

    public function testSerFileWrittenNotInDevelopMode()
    {
        $validator = new Validator();
        $validator->addSchemaValidation(TestUtil::getPathAndFileNameOfDevelopModeTestSchema('test.json'));
        
        $this->assertFileExists(TestUtil::getPathAndFileNameOfDevelopModeTestSchema('test.json.ser'));
    }

    public function testSerFileNotWrittenInDevelopMode()
    {
        $validator = new Validator(true);
        $validator->addSchemaValidation(TestUtil::getPathAndFileNameOfDevelopModeTestSchema('test.json'));
        
        $this->assertFileNotExists(TestUtil::getPathAndFileNameOfDevelopModeTestSchema('test.json.ser'));
    }
}