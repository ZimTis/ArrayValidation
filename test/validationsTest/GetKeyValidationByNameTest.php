<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\validations\NestedValidation;
use zimtis\arrayvalidation\validations\keyValidations\FloatValidation;
use zimtis\arrayvalidation\validations\keyValidations\StringValidation;
use zimtis\arrayvalidation\validations\keyValidations\BooleanValidation;

class GetKeyValidationByNameTest extends TestCase
{

    /**
     *
     * @var NestedValidation
     */
    private $root;

    public function setUp()
    {
        $this->root = new NestedValidation(null);
        $firstNested = new NestedValidation('position');
        
        $a = new FloatValidation('lat', array());
        $firstNested->addValidation($a);
        $b = new StringValidation('lng', array());
        $firstNested->addValidation($b);
        
        $secondNested = new NestedValidation('blub');
        $c = new StringValidation('name', array());
        $secondNested->addValidation($c);
        $firstNested->addValidation($secondNested);
        
        $d = new BooleanValidation('boolean', array());
        $this->root->addValidation($d);
        $this->root->addValidation($firstNested);
    }

    public function testGetKeyValidationWithCorrectRoute()
    {
        $aa = $this->root->getKeyValidationByName('position:lat');
        $bb = $this->root->getKeyValidationByName('position:lng');
        $cc = $this->root->getKeyValidationByName('position:blub:name');
        $dd = $this->root->getKeyValidationByName('boolean');
        $this->assertInstanceOf('\zimtis\arrayvalidation\validations\keyValidations\FloatValidation', $aa);
        $this->assertInstanceOf('\zimtis\arrayvalidation\validations\keyValidations\StringValidation', $bb);
        $this->assertInstanceOf('\zimtis\arrayvalidation\validations\keyValidations\StringValidation', $cc);
        $this->assertInstanceOf('\zimtis\arrayvalidation\validations\keyValidations\BooleanValidation', $dd);
    }

    /**
     * @expectedException \Exception
     */
    public function testGetKeyValidationWithIncorrectRoute()
    {
        $this->root->getKeyValidationByName('booleann');
    }

    /**
     * @expectedException \Exception
     */
    public function testGetKeyValidationWithWrongType()
    {
        $this->root->getKeyValidationByName(4);
    }

    /**
     * @expectedException \Exception
     */
    public function testTryToGetNestedValidation()
    {
        $this->root->getKeyValidationByName('position:blub');
    }
}