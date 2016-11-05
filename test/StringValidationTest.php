<?php
use PHPUnit\Framework\TestCase;
use zimtis\arrayvalidation\Validator;
use zimtis\arrayvalidation\Validation;

class StringValidationTest extends TestCase
{

    /**
     *
     * @var Validator
     */
    private $validator;

    private $minMaxTrimSchema = "minMaxTrim";

    private $minMaxNoTrimSchema = "minMaxNoTrim";

    /**
     * @before
     */
    public function setupValidator()
    {
        $this->validator = new Validator();
        $this->validator->addValidation(new Validation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'stringMinMax.json'), $this->minMaxTrimSchema);
        $this->validator->addValidation(new Validation('test' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR . 'stringMinMaxNoTrim.json'), $this->minMaxNoTrimSchema);
        $this->assertNotNull($this->validator);
    }

    /**
     * The string is the correct length
     */
    public function testMinLengthWithTrimCorrect()
    {
        $a = array(
            "name" => "aaaaa"
        );
        $b = array(
            "name" => " aaaaa"
        );
        $c = array(
            "name" => "aaaaa "
        );
        
        $this->validator->validate($a, $this->minMaxTrimSchema);
        $this->validator->validate($b, $this->minMaxTrimSchema);
        $this->validator->validate($c, $this->minMaxTrimSchema);
        
        $this->assertEquals("aaaaa", $a['name']);
        $this->assertEquals("aaaaa", $b['name']);
        $this->assertEquals("aaaaa", $c['name']);
    }

    /**
     * The tested String is to short, becouse the string gets trimmed
     *
     * @expectedException \Exception
     */
    public function testMinLengthWithTrimIncorrectLeadingWhiteSpace()
    {
        // $this->expectException(get_class(new \Exception()));
        $a = array(
            "name" => " aaaa"
        );
        
        $this->validator->validate($a, $this->minMaxTrimSchema);
    }

    /**
     * The tested String is to short, becouse the string gets trimmed
     *
     * @expectedException \Exception
     */
    public function testMinLengthWithTrimIncorrectTrailingWhiteSpace()
    {
        // $this->expectException(get_class(new \Exception()));
        $a = array(
            "name" => "aaaa "
        );
        
        $this->validator->validate($a, $this->minMaxTrimSchema);
    }

    /**
     * The tested String is to short, becouse the string gets trimmed
     *
     * @expectedException \Exception
     */
    public function testMinLengthWithTrimIncorrect()
    {
        // $this->expectException(get_class(new \Exception()));
        $a = array(
            "name" => "aaaa"
        );
        
        $this->validator->validate($a, $this->minMaxTrimSchema);
    }

    public function testMaxLengthWithTrimCorrect()
    {
        $a = array(
            "name" => "aaaaaa"
        );
        $this->validator->validate($a, $this->minMaxTrimSchema);
        $this->assertEquals("aaaaaa", $a['name']);
        
        $a = array(
            "name" => " aaaaaa"
        );
        $this->validator->validate($a, $this->minMaxTrimSchema);
        $this->assertEquals("aaaaaa", $a['name']);
        
        $a = array(
            "name" => "aaaaaa "
        );
        $this->validator->validate($a, $this->minMaxTrimSchema);
        $this->assertEquals("aaaaaa", $a['name']);
    }

    /**
     * The tested String is to long
     *
     * @expectedException \Exception
     */
    public function testMaxLengthWithTrimIncorrect()
    {
        $a = array(
            "name" => "aaaaaaa"
        );
        
        $this->validator->validate($a, $this->minMaxTrimSchema);
    }

    public function testMinLengthNoTrimCorrec()
    {
        $a = array(
            "name" => " aaaa"
        );
        
        $this->validator->validate($a, $this->minMaxNoTrimSchema);
        $this->assertEquals(" aaaa", $a['name']);
        
        $a = array(
            "name" => "aaaa "
        );
        
        $this->validator->validate($a, $this->minMaxNoTrimSchema);
        $this->assertEquals("aaaa ", $a['name']);
        
        $a = array(
            "name" => "aaaaa"
        );
        
        $this->validator->validate($a, $this->minMaxNoTrimSchema);
        $this->assertEquals("aaaaa", $a['name']);
    }
}