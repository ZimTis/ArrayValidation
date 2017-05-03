<?php
namespace zimtis\test;

use zimtis\arrayvalidation\model\CallableResult;

function trueFunction($value, array $parameter)
{
    $r = new CallableResult();
    $r->setResult(true);
    return $r;
}

function falseFunction($value, array $parameter)
{
    $r = new CallableResult();
    $r->setResult(false);
    return $r;
}

function nonBooleanFunction($value, array $parameter)
{
    return 'S';
}

class CallableUtil
{

    public static function trueStaticFunction($value, array $parameter)
    {
        $r = new CallableResult();
        $r->setResult(true);
        return $r;
    }

    public static function falseStaticFunction($value, array $parameter)
    {
        $r = new CallableResult();
        $r->setResult(false);
        return $r;
    }

    public static function nonBooleanStaticFunction($value, array $parameter)
    {
        return 'S';
    }

    public function trueNonStaticFunction($value, array $parameter)
    {
        $r = new CallableResult();
        $r->setResult(true);
        return $r;
    }

    public function falseNonStaticFunction($value, array $parameter)
    {
        $r = new CallableResult();
        $r->setResult(false);
        return $r;
    }

    public function nonBooleanNonStaticFunction($value, array $parameter)
    {
        return 'S';
    }
}