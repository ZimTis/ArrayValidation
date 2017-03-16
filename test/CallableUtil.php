<?php
namespace zimtis\test;

function trueFunction($value, array $parameter)
{
    return true;
}

function falseFunction($value, array $parameter)
{
    return false;
}

function nonBooleanFunction($value, array $parameter)
{
    return 'S';
}

class CallableUtil
{

    public static function trueStaticFunction($value, array $parameter)
    {
        return true;
    }

    public static function falseStaticFunction($value, array $parameter)
    {
        return false;
    }

    public static function nonBooleanStaticFunction($value, array $parameter)
    {
        return 'S';
    }

    public function trueNonStaticFunction($value, array $parameter)
    {
        return true;
    }

    public function falseNonStaticFunction($value, array $parameter)
    {
        return false;
    }

    public function nonBooleanNonStaticFunction($value, array $parameter)
    {
        return 'S';
    }
}