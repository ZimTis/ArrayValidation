<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\validations\keyValidations\IntegerValidation;
use zimtis\arrayvalidation\Properties;

class IntegerValidationTest extends TestCase
{

    private $baseProperty;

    public function setUp()
    {
        $this->baseProperty = array();
    }

    public function testMinPositive()
    {
        $this->baseProperty['min'] = 1;
        new IntegerValidation('name', $this->baseProperty);
    }

    public function testMinZero()
    {
        $this->baseProperty['min'] = 0;
        new IntegerValidation('name', $this->baseProperty);
    }

    public function testMinNegative()
    {
        $this->baseProperty['min'] = - 1;
        new IntegerValidation('name', $this->baseProperty);
    }

    public function testMaxPositive()
    {
        $this->baseProperty['max'] = 1;
        new IntegerValidation('name', $this->baseProperty);
    }

    public function testMaxZero()
    {
        $this->baseProperty['max'] = 0;
        new IntegerValidation('name', $this->baseProperty);
    }

    public function testMaxNegative()
    {
        $this->baseProperty['max'] = - 1;
        new IntegerValidation('name', $this->baseProperty);
    }

    public function testMinSmallerMax()
    {
        $this->baseProperty[Properties::MAX] = 2;
        $this->baseProperty[Properties::MIN] = 1;
        new IntegerValidation('name', $this->baseProperty);
    }

    public function testMinEqualMax()
    {
        $this->baseProperty[Properties::MAX] = 1;
        $this->baseProperty[Properties::MIN] = 1;
        new IntegerValidation('name', $this->baseProperty);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testMinBiggerMax()
    {
        $this->baseProperty[Properties::MAX] = 1;
        $this->baseProperty[Properties::MIN] = 2;
        new IntegerValidation('name', $this->baseProperty);
    }

    public function testOneOfCorrect()
    {
        $this->baseProperty[Properties::ONE_OF] = array(
            1
        );
        new IntegerValidation('name', $this->baseProperty);
    }

    public function testOneOfOverride()
    {
        $this->baseProperty[Properties::ONE_OF] = array(
            1
        );
        $this->baseProperty[Properties::MIN] = 5;
        $s = new IntegerValidation('name', $this->baseProperty);
        $s->validate(array(
            'name' => 1
        ));
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testOneOfNotArray()
    {
        $this->baseProperty[Properties::ONE_OF] = 5;

        new IntegerValidation('name', $this->baseProperty);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testOneOfEmptyArray()
    {
        $this->baseProperty[Properties::ONE_OF] = array();
        new IntegerValidation('name', $this->baseProperty);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testOneOfNotInteger()
    {
        $this->baseProperty[Properties::ONE_OF] = array(
            '1'
        );
        new IntegerValidation('name', $this->baseProperty);
    }
}