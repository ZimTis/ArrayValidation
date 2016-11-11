<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\filter\typeFilter\FloatTypeFilter;

class FloatTyperFilterTest extends TestCase
{

    /**
     *
     * @var FloatTypeFilter
     */
    private $filter;

    /**
     * @before
     */
    public function setupTest()
    {
        $this->filter = new FloatTypeFilter();
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