<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\validations\keyValidations\StringValidation;
use zimtis\test\CallableUtil;
use zimtis\arrayvalidation\filter\attributeFilter\CallableFilter;
use zimtis\arrayvalidation\model\CallableResult;

class CallableFilterTest extends TestCase
{

    public function testNonStaticFilterBooleanResult()
    {
        $s = new StringValidation('name', array(
            'callable' => '\zimtis\arrayvalidation\test\CallableUtil:trueNonStaticFunction'
        ));

        $filter = new CallableFilter($s);

        $filter->validate('s');
    }

    /**
     * @expectedException \Exception
     */
    public function testNonStaticFilterNoBooleanResult()
    {
        $s = new StringValidation('name', array(
            'callable' => '\zimtis\arrayvalidation\test\CallableUtil:nonBooleanNonStaticFunction'
        ));

        $filter = new CallableFilter($s);

        $filter->validate('S');
    }

    public function testStaticFilterBooleanResult()
    {
        $s = new StringValidation('name', array(
            'callable' => '\zimtis\arrayvalidation\test\CallableUtil::trueStaticFunction'
        ));

        $filter = new CallableFilter($s);

        $filter->validate('s');
    }

    /**
     * @expectedException \Exception
     */
    public function testStaticFilterNoBooleanResult()
    {
        $s = new StringValidation('name', array(
            'callable' => '\zimtis\arrayvalidation\test\CallableUtil::nonBooleanStaticFunction'
        ));

        $filter = new CallableFilter($s);

        $filter->validate('S');
    }

    public function testClosureFilterCallableResult()
    {
        $s = new StringValidation('name', array());
        $s->setCallable(function () {
            $r = new CallableResult();
            $r->setResult(true);
            return $r;
        });

        $filter = new CallableFilter($s);

        $filter->validate('s');
    }

    /**
     * @expectedException \Exception
     */
    public function testClosureFilterNoBooleanResult()
    {
        $s = new StringValidation('name', array());
        $s->setCallable(function () {
            return 'S';
        });

        $filter = new CallableFilter($s);

        $filter->validate('S');
    }

    public function testFunctionFilterBooleanResult()
    {
        $s = new StringValidation('name', array(
            'callable' => '\zimtis\arrayvalidation\test\trueFunction'
        ));

        $filter = new CallableFilter($s);

        $filter->validate('s');
    }

    /**
     * @expectedException \Exception
     */
    public function testFunctionFilterNoBooleanResult()
    {
        $s = new StringValidation('name', array(
            'callable' => '\zimtis\arrayvalidation\test\nonBooleanFunction'
        ));

        $filter = new CallableFilter($s);

        $filter->validate('S');
    }
}