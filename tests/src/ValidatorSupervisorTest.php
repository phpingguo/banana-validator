<?php
namespace Phpingguo\BananaValidator\Tests;

use Phpingguo\BananaValidator\Enums\ValidationError;
use Phpingguo\BananaValidator\Enums\Validator;
use Phpingguo\BananaValidator\ValidatorSupervisor;

class ValidatorSupervisorTest extends \PHPUnit_Framework_TestCase
{
    public function providerGetEnumFullName()
    {
        $base_namespace = "Phpingguo\\BananaValidator\\Enums\\";
        
        return [
            [ ValidatorSupervisor::ENUM_VALIDATION_ERROR, ValidationError::INVALID, "{$base_namespace}ValidationError" ],
            [ ValidatorSupervisor::ENUM_VALIDATOR, Validator::TEXT, "{$base_namespace}Validator" ],
        ];
    }
    
    /**
     * @dataProvider providerGetEnumFullName
     */
    public function testGetEnumFullName($enum_name, $enum_value, $expected)
    {
        $actual = ValidatorSupervisor::getEnumFullName($enum_name);
        
        $this->assertSame($expected, $actual);
        $this->assertInstanceOf($expected, new $actual($enum_value));
    }
}
