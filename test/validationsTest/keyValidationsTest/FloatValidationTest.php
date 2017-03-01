<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\validations\keyValidations\FloatValidation;

class FloatValidationTest extends TestCase
{

    public function testMinSmallerThanMax()
    {
        new FloatValidation('name', array(
            'min' => 0,
            'max' => 1
        ));
    }

    public function testMinEqualMax()
    {
        new FloatValidation('name', array(
            'min' => 1,
            'max' => 1
        ));
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testMinBiggerThanMax()
    {
        new FloatValidation('name', array(
            'min' => 1,
            'max' => 0
        ));
    }

    public function testMinNegative()
    {
        new FloatValidation('name', array(
            'min' => - 1
        ));
    }

    public function testMinZero()
    {
        new FloatValidation('name', array(
            'min' => 0
        ));
    }

    public function testMinPositive()
    {
        new FloatValidation('name', array(
            'min' => 1
        ));
    }

    public function testMinAsInteger()
    {
        new FloatValidation('name', array(
            'min' => 1
        ));
    }

    public function testMinAsFloat()
    {
        new FloatValidation('name', array(
            'min' => 1.1
        ));
    }

    public function testMaxNegative()
    {
        new FloatValidation('name', array(
            'max' => - 1
        ));
    }

    public function testMaxPositive()
    {
        new FloatValidation('name', array(
            'max' => 1
        ));
    }

    public function testMaxZero()
    {
        new FloatValidation('name', array(
            'max' => 0
        ));
    }

    public function testMaxAsInteger()
    {
        new FloatValidation('name', array(
            'max' => 2
        ));
    }

    public function testMaxAsFloat()
    {
        new FloatValidation('name', array(
            'max' => 2.2
        ));
    }

    public function testOneOfCorrect()
    {
        new FloatValidation('name', array(
            'oneOf' => array(
                1.2,
                1
            )
        ));
    }

    public function testOneOfOverride()
    {
        $f = new FloatValidation('name', array(
            'oneOf' => array(
                1.2,
                1
            ),
            'min' => 5.5
        ));
        $f->validate(array(
            'name' => 1.2
        ));
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testOneOfNotArray()
    {
        new FloatValidation('name', array(
            'oneOf' => 5
        ));
    }

    public function testOneOfInteger()
    {
        new FloatValidation('name', array(
            'oneOf' => array(
                1
            )
        ));
    }

    public function testOneOfFloat()
    {
        new FloatValidation('name', array(
            'oneOf' => array(
                1.2
            )
        ));
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testOneOfNotIntegerOrFloat()
    {
        new FloatValidation('name', array(
            'oneOf' => array(
                1.2,
                1,
                'S'
            )
        ));
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testOneOfEmptyArray()
    {
        new FloatValidation('name', array(
            'oneOf' => array()
        ));
    }
}