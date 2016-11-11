<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\filter\typeFilter\IntegerTypeFilter;

class IntegerTypeFilterTest extends TestCase
{

    /**
     *
     * @var IntegerTypeFilter
     */
    private $filter;

    /**
     * @before
     */
    public function setupTest()
    {
        $this->filter = new IntegerTypeFilter();
    }

    /**
     * @expectedException \Exception
     */
    public function testStringCorrect()
    {
        $this->filter->validate('String');
    }

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

    /**
     * @expectedException \Exception
     */
    public function testStringFilterWithBoolean()
    {
        $this->filter->validate(true);
    }
}