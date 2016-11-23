<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\filter\attributeFilter\StringEndsWithFilter;
use zimtis\arrayvalidation\filter\Filter;

class StringEndsWithFilterTest extends TestCase
{

    /**
     *
     * @var Filter
     */
    private $filter;

    /**
     * @before
     */
    public function setupTest()
    {
        $this->filter = new StringEndsWithFilter("test");
    }

    public function testValidationCorrect()
    {
        $this->filter->validate("stest");
    }

    /**
     * @expectedException \Exception
     */
    public function testValidationNotCorrect1()
    {
        $this->filter->validate("es");
    }

    /**
     * @expectedException \Exception
     */
    public function testValidationNotCorrect2()
    {
        $this->filter->validate("asdteSt");
    }
}