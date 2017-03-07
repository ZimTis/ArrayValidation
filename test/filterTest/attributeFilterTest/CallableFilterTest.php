<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\validations\keyValidations\StringValidation;
use zimtis\test\CallableUtil;
use zimtis\arrayvalidation\filter\attributeFilter\CallableFilter;

class CallableFilterTest extends TestCase {

    public function testNonStaticFilterBooleanResult(){
        $s = new StringValidation('name', array(
                                                'callable' => '\zimtis\test\CallableUtil:trueNonStaticFunction' ));

        $filter = new CallableFilter($s);

        $filter->validate('s');
    }

    /**
     * @expectedException \Exception
     */
    public function testNonStaticFilterNoBooleanResult(){
        $s = new StringValidation('name', array(
                                                'callable' => '\zimtis\test\CallableUtil:nonBooleanNonStaticFunction' ));

        $filter = new CallableFilter($s);

        $filter->validate('S');
    }

    public function testStaticFilterBooleanResult(){
        $s = new StringValidation('name', array(
                                                'callable' => '\zimtis\test\CallableUtil::trueStaticFunction' ));

        $filter = new CallableFilter($s);

        $filter->validate('s');
    }

    /**
     * @expectedException \Exception
     */
    public function testStaticFilterNoBooleanResult(){
        $s = new StringValidation('name', array(
                                                'callable' => '\zimtis\test\CallableUtil::nonBooleanStaticFunction' ));

        $filter = new CallableFilter($s);

        $filter->validate('S');
    }

    public function testClosureFilterBooleanResult(){
        $s = new StringValidation('name', array());
        $s->setCallable(function (){
            return true;
        });

        $filter = new CallableFilter($s);

        $filter->validate('s');
    }

    /**
     * @expectedException \Exception
     */
    public function testClosureFilterNoBooleanResult(){
        $s = new StringValidation('name', array());
        $s->setCallable(function (){
            return 'S';
        });

        $filter = new CallableFilter($s);

        $filter->validate('S');
    }

    public function testFunctionFilterBooleanResult(){
        $s = new StringValidation('name', array(
                                                'callable' => '\zimtis\test\trueFunction' ));

        $filter = new CallableFilter($s);

        $filter->validate('s');
    }

    /**
     * @expectedException \Exception
     */
    public function testFunctionFilterNoBooleanResult(){
        $s = new StringValidation('name', array(
                                                'callable' => '\zimtis\test\nonBooleanFunction' ));

        $filter = new CallableFilter($s);

        $filter->validate('S');
    }
}