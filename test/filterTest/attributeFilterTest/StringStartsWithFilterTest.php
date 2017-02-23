<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\filter\Filter;
use zimtis\arrayvalidation\filter\attributeFilter\StringStartsWithFilter;

class StringStartsWithFilterTest extends TestCase {

    /**
     *
     * @var Filter
     */
    private $filter;

    /**
     * @before
     */
    public function setupTest(){
        $this->filter = new StringStartsWithFilter('test');
    }

    public function testValidation(){
        $this->filter->validate('testa');
        $this->filter->validate('test');
    }

    /**
     * @expectedException \Exception
     */
    public function testValidationNotCorrect1(){
        $this->filter->validate("Test");
    }

    /**
     * @expectedException \Exception
     */
    public function testValidationNotCorrect2(){
        $this->filter->validate("tes");
    }
}