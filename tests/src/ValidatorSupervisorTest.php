<?php
namespace Phpeel\BananaValidator\Tests;

use Phpeel\BananaValidator\Enums\ValidationError;
use Phpeel\BananaValidator\Enums\Validator;
use Phpeel\BananaValidator\ValidatorSupervisor;

class ValidatorSupervisorTest extends \PHPUnit_Framework_TestCase
{
    public function providerGetEnumFullName()
    {
        $base_namespace = "Phpeel\\BananaValidator\\Enums\\";
        
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
