<?php
namespace Phpingguo\BananaValidator\Tests\String\Latin;

use Phpingguo\BananaValidator\Enums\ValidationError;
use Phpingguo\BananaValidator\Options;
use Phpingguo\BananaValidator\String\Other\MailAddress;
use Phpingguo\BananaValidator\ValidationErrorException;

class ValidatorMailAddressTest extends \PHPUnit_Framework_TestCase
{
    public function testInitOptions()
    {
        return function ($option_list) {
            $options = Options::getInstance(true);
            
            foreach ($option_list as $key => $value) {
                $options = is_numeric($key) ? $options->$value() : $options->$key($value);
            }
            
            return $options;
        };
    }
    
    public function providerValidate()
    {
        return [
            [ 'abcedf@xyz.com', true, [], null ],
            [ 'abc.edf.ghi@xyz.com', true, [], null ],
            [ 'ab-ced-fghi@xyz.com', true, [], null ],
            [ '_abcedfghi_@xyz.com', true, [], null ],
            [ '"ab..cd..ef"@xyz.com', true, [], null ],
            [ '"ab[cd]ef"@xyz.com', true, [], null ],
            [ '.@xyz.com', false, [], '\RuntimeException' ],
            [ '.a@xyz.com', false, [], '\RuntimeException' ],
            [ '.abc@xyz.com', false, [], '\RuntimeException' ],
            [ 'a.@xyz.com', false, [], '\RuntimeException' ],
            [ 'abc.@xyz.com', false, [], '\RuntimeException' ],
            [ 'ab..cd..ef@xyz.com', false, [], '\RuntimeException' ],
            [ 'abc...def@xyz.com', false, [], '\RuntimeException' ],
            [ 'abc....def@xyz.com', false, [], '\RuntimeException' ],
            [ '.ab..cd..ef.@xyz.com', false, [], '\RuntimeException' ],
            [ 'a[bcde]f@xyz.com', false, [], '\RuntimeException' ],
            [ 'a', false, [], [ ValidationError::FORMAT ] ],
            [ 'A', false, [], [ ValidationError::FORMAT ] ],
            [ 'abc', false, [ 'notPreg' => '/xyz/' ], [ ValidationError::FORMAT ] ],
            [ 'a b c', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ '', false, [ 'nullable' ], null ],
            [ null, false, [ 'nullable' ], null ],
            [ false, false, [ 'nullable' ], null ],
            [ [], false, [ 'nullable' ], null ],
            [ 'あいうえお', false, [], [ ValidationError::FORMAT ] ],
            [ 'ｱｲｳｴｵ', false, [], [ ValidationError::FORMAT ] ],
            [ 'アイウエオ', false, [], [ ValidationError::FORMAT ] ],
            [ 'a0', false, [], [ ValidationError::FORMAT ] ],
            [ 'abc', false, [ 'preg' => '/xyz/' ], [ ValidationError::FORMAT ] ],
            [ 0, false, [], [ ValidationError::FORMAT ] ],
            [ 0.0, false, [], [ ValidationError::FORMAT ] ],
            [ '0', false, [], [ ValidationError::FORMAT ] ],
            [ '0.0', false, [], [ ValidationError::FORMAT ] ],
            [ null, true, [], [ ValidationError::INVALID ] ],
            [ '', true, [], [ ValidationError::INVALID ] ],
            [ true, false, [], [ ValidationError::FORMAT ] ],
            [ false, false, [], [ ValidationError::INVALID ] ],
            [ [], false, [], [ ValidationError::INVALID ] ],
            [ new \stdClass(), true, [], [ ValidationError::INVALID ] ],
        ];
    }
    
    /**
     * @depends testInitOptions
     * @dataProvider providerValidate
     */
    public function testValidate($value, $expected, $options, $exception, $init)
    {
        is_string($exception) && $this->setExpectedException($exception);
        
        try {
            $this->assertSame($expected, (new MailAddress())->validate($value, $init($options)));
        } catch (ValidationErrorException $e) {
            $this->assertSame($exception, $e->getErrorLists());
        }
    }
}
