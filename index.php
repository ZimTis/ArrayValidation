<?php
use zimtis\arrayvalidation\Validator;
use zimtis\arrayvalidation\Validation;

spl_autoload_register(function ($classname) {
    $classname = substr($classname, strlen('zimtis\\arrayvalidation\\'));
    $classname = str_replace('\\', DIRECTORY_SEPARATOR, $classname);
    include_once 'src' . DIRECTORY_SEPARATOR . $classname . '.php';
});

$toValidate = array();
$toValidate['name'] = 5;

$v = new Validator();
$v->addValidation(new Validation('schema.json'), 'schema');

$v->validate($toValidate, 'schema');
var_dump($toValidate);