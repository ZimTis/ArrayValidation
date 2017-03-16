<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\validations\keyValidations\ArrayValidation;

class ArrayValidationTest extends TestCase
{

    private $baseOptions;

    public function setUp()
    {
        $this->baseOptions = array(
            'item' => array(
                'type' => 'string'
            )
        );
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testNegativeLength()
    {
        $this->baseOptions['length'] = - 1;
        new ArrayValidation('name', $this->baseOptions);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testLengthZero()
    {
        $this->baseOptions['length'] = 0;
        new ArrayValidation('name', $this->baseOptions);
    }

    public function testLengthPositive()
    {
        $this->baseOptions['length'] = 1;
        new ArrayValidation('name', $this->baseOptions);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testMinLengthNegative()
    {
        $this->baseOptions['minLength'] = - 1;
        new ArrayValidation('name', $this->baseOptions);
    }

    public function testMinLengthZero()
    {
        $this->baseOptions['minLength'] = 0;
        new ArrayValidation('name', $this->baseOptions);
    }

    public function testMinLengthPositive()
    {
        $this->baseOptions['minLength'] = 1;
        new ArrayValidation('name', $this->baseOptions);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testMaxLengthNegative()
    {
        $this->baseOptions['maxLength'] = - 1;
        new ArrayValidation('name', $this->baseOptions);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testMaxLengthZero()
    {
        $this->baseOptions['maxLength'] = 0;
        new ArrayValidation('name', $this->baseOptions);
    }

    public function testMaxLengthPositive()
    {
        $this->baseOptions['maxLength'] = 1;
        new ArrayValidation('name', $this->baseOptions);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testLengthWithMinLength()
    {
        $this->baseOptions['length'] = 1;
        $this->baseOptions['minLength'] = 1;
        new ArrayValidation('name', $this->baseOptions);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testLengthWithMaxLength()
    {
        $this->baseOptions['length'] = 1;
        $this->baseOptions['maxLength'] = 1;
        new ArrayValidation('name', $this->baseOptions);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testLengthWithMaxAndMinLength()
    {
        $this->baseOptions['length'] = 1;
        $this->baseOptions['maxLength'] = 2;
        $this->baseOptions['minLength'] = 1;
        new ArrayValidation('name', $this->baseOptions);
    }
}