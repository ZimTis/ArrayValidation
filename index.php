<?php
use zimtis\arrayvalidation\Validator;

include_once 'vendor/autoload.php';

/**
 *
 * @var \zimtis\arrayvalidation\Validator $v
 */
$v = new Validator();
$v->addSchemaValidation('schema.json');

$v->validate('schema', array(
    "name" => null
));
?>