<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\filter\attributeFilter\OneOfFilter;

class OneOfFilterTest extends TestCase
{

    public function testStringOneOfWithContainingString()
    {
        $f = new OneOfFilter(array(
            'S',
            'D'
        ));
        $f->validate('D');
        $f->validate('S');
    }

    /**
     * @expectedException \Exception
     */
    public function testStringOneOfWithoutContainingString()
    {
        $f = new OneOfFilter(array(
            'S',
            'D'
        ));
        $f->validate('Y');
    }

    /**
     * @expectedException \Exception
     */
    public function testStringOneOfWithCaseSensitivity()
    {
        $f = new OneOfFilter(array(
            'S',
            'D'
        ));
        $f->validate('d');
    }

    /**
     * @expectedException \Exception
     */
    public function testStringOneOfWithMismatchedType()
    {
        $f = new OneOfFilter(array(
            'S',
            '1'
        ));
        $f->validate(1);
    }

    public function testIntegerOneOf()
    {
        $f = new OneOfFilter(array(
            1,
            2
        ));

        $f->validate(1);
    }

    /**
     * @expectedException \Exception
     */
    public function testIntegerOneOfNotContaining()
    {
        $f = new OneOfFilter(array(
            1,
            2
        ));
        $f->validate(3);
    }

    /**
     * @expectedException \Exception
     */
    public function testIntegerOneOfTypeMismatch()
    {
        $f = new OneOfFilter(array(
            1,
            2
        ));
        $f->validate('1');
    }
}