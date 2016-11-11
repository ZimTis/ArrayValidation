<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\filter\typeFilter\BooleanFilter;

class BooleanTypeFilterTest extends TestCase
{

    /**
     *
     * @var BooleanFilter
     */
    private $filter;

    /**
     * @before
     */
    public function setupTest()
    {
        $this->filter = new BooleanFilter();
    }

    /**
     * @expectedException \Exception
     */
    public function testStringCorrect()
    {
        $this->filter->validate('String');
    }

    /**
     * @expectedException \Exception
     */
    public function testStringFilterWithInteger()
    {
        $this->filter->validate(1);
    }

    /**
     * @expectedException \Exception
     */
    public function testStringFilterWithFloat()
    {
        $this->filter->validate(1.1);
    }

    public function testStringFilterWithBoolean()
    {
        $this->filter->validate(true);
    }
}