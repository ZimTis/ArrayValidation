<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\validations\NestedValidation;
use zimtis\arrayvalidation\validations\keyValidations\StringValidation;

/**
 *
 * @author ZimTis
 *
 */
class GetFullNameTest extends TestCase {

    public function testFullName(){
        $nestedA = new NestedValidation("a");
        $nestedB = new NestedValidation("b");

        $keyValidationC = new StringValidation("c", array(
                                                        "type" => "string" ));
        $keyValidationD = new StringValidation("d", array(
                                                        "type" => "string" ));

        $nestedB->addValidation($keyValidationC);
        $nestedB->addValidation($keyValidationD);
        $nestedA->addValidation($nestedB);

        $this->assertEquals('a:b:d', $keyValidationD->getFullName());
        $this->assertEquals('a:b:c', $keyValidationC->getFullName());
        $this->assertEquals('a', $nestedA->getFullName());
        $this->assertEquals('a:b', $nestedB->getFullName());
    }
}