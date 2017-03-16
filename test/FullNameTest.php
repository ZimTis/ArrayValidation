<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\Validator;

/**
 *
 * @author ZimTis
 *        
 */
class FullNameTest extends TestCase
{

    public function testGetFullName()
    {
        $validator = new Validator(true);
        $validator->addSchemaValidation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'validNestedWithRequiredInNested.json', 'a');
        
        $v = $validator->getSchemaValidationByName('a');
        $c = $v->getKeyValidationByName('b:c');
        $d = $v->getKeyValidationByName('a');
        
        $this->assertStringStartsNotWith(':', $c->getFullName());
        $this->assertStringStartsNotWith(':', $d->getFullName());
    }
}