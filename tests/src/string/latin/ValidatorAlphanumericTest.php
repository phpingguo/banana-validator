<?php
namespace Phpingguo\BananaValidator\Tests\String\Latin;

use Phpingguo\BananaValidator\Options;
use Phpingguo\BananaValidator\String\Latin\Alphanumeric;

class ValidatorAlphanumericTest extends \PHPUnit_Framework_TestCase
{
    public function testInitOptions()
    {
        return function ($option_list) {
            $options	= Options::getInstance(true);
            
            foreach ($option_list as $key => $value) {
                $options	= is_numeric($key) ? $options->$value() : $options->$key($value);
            }
            
            return $options;
        };
    }
    
    public function providerValidate()
    {
        return [
            [ 'a', true, [], null ],
            [ 'z', true, [], null ],
            [ 'A', true, [], null ],
            [ 'Z', true, [], null ],
            [ 'abc', true, [], null ],
            [ 'xyz', true, [], null ],
            [ 'ABC', true, [], null ],
            [ 'XYZ', true, [], null ],
            [ '!"#$%&\'()=~|-^\\[]{}/?_*:;+`@,.<>',false, [], 'ValidationErrorException' ],
            [ '1a', true, [], null ],
            [ 'a1', true, [], null ],
            [ '1Z', true, [], null ],
            [ 'Z1', true, [], null ],
            [ 'ひらがな', false, [], 'ValidationErrorException' ],
            [ 'ひらがな1', false, [], 'ValidationErrorException' ],
            [ '1ひらがな', false, [], 'ValidationErrorException' ],
            [ '漢字', false, [], 'ValidationErrorException' ],
            [ '漢字1', false, [], 'ValidationErrorException' ],
            [ '1漢字', false, [], 'ValidationErrorException' ],
            [ 'ｶﾀｶﾅ', false, [], 'ValidationErrorException' ],
            [ 'ｶﾀｶﾅ1', false, [], 'ValidationErrorException' ],
            [ '1ｶﾀｶﾅ', false, [], 'ValidationErrorException' ],
            [ 'カタカナ', false, [], 'ValidationErrorException' ],
            [ 'カタカナ1', false, [], 'ValidationErrorException' ],
            [ '1カタカナ', false, [], 'ValidationErrorException' ],
            [ 'abcひらがな', false, [], 'ValidationErrorException' ],
            [ 'abc漢字', false, [], 'ValidationErrorException' ],
            [ 'abcｶﾀｶﾅ', false, [], 'ValidationErrorException' ],
            [ 'abcカタカナ', false, [], 'ValidationErrorException' ],
            [ 'ひらがなabc', false, [], 'ValidationErrorException' ],
            [ 'ひらがな漢字', false, [], 'ValidationErrorException' ],
            [ 'ひらがなｶﾀｶﾅ', false, [], 'ValidationErrorException' ],
            [ 'ひらがなカタカナ', false, [], 'ValidationErrorException' ],
            [ '漢字abc', false, [], 'ValidationErrorException' ],
            [ '漢字ひらがな', false, [], 'ValidationErrorException' ],
            [ '漢字ｶﾀｶﾅ', false, [], 'ValidationErrorException' ],
            [ '漢字カタカナ', false, [], 'ValidationErrorException' ],
            [ 'カタカナabc', false, [], 'ValidationErrorException' ],
            [ 'カタカナひらがな', false, [], 'ValidationErrorException' ],
            [ 'カタカナ漢字', false, [], 'ValidationErrorException' ],
            [ 'カタカナｶﾀｶﾅ', false, [], 'ValidationErrorException' ],
            [ 'abc', true, [ 'whitespace' ], null ],
            [ 'a b c', true, [ 'whitespace' ], null ],
            [ 'a　b　c', true, [ 'whitespace' ], 'ValidationErrorException' ],
            [ 'ABC', true, [ 'whitespace' ], null ],
            [ 'A B C', true, [ 'whitespace' ], null ],
            [ 'A　B　C', false, [ 'whitespace' ], 'ValidationErrorException' ],
            [ 'ひらがな', false, [ 'whitespace' ], 'ValidationErrorException' ],
            [ 'ひ ら が な', false, [ 'whitespace' ], 'ValidationErrorException' ],
            [ 'ひ　ら　が　な', false, [ 'whitespace' ], 'ValidationErrorException' ],
            [ '漢字', false, [ 'whitespace' ], 'ValidationErrorException' ],
            [ '漢 字', false, [ 'whitespace' ], 'ValidationErrorException' ],
            [ '漢　字', false, [ 'whitespace' ], 'ValidationErrorException' ],
            [ 'ｶﾀｶﾅ', false, [ 'whitespace' ], 'ValidationErrorException' ],
            [ 'ｶ ﾀ ｶ ﾅ', false, [ 'whitespace' ], 'ValidationErrorException' ],
            [ 'ｶ　ﾀ　ｶ　ﾅ', false, [ 'whitespace' ], 'ValidationErrorException' ],
            [ 'カタカナ', false, [ 'whitespace' ], 'ValidationErrorException' ],
            [ 'カ タ カ ナ', false, [ 'whitespace' ], 'ValidationErrorException' ],
            [ 'カ　タ　カ　ナ', false, [ 'whitespace' ], 'ValidationErrorException' ],
            [ '', false, [ 'min' => 2, 'max' => 5 ], 'ValidationErrorException' ],
            [ 'a', false, [ 'min' => 2, 'max' => 5 ], 'ValidationErrorException' ],
            [ 'ab', true, [ 'min' => 2, 'max' => 5 ], null ],
            [ 'abc', true, [ 'min' => 2, 'max' => 5 ], null ],
            [ 'abcd', true, [ 'min' => 2, 'max' => 5 ], null ],
            [ 'abcde', true, [ 'min' => 2, 'max' => 5 ], null ],
            [ 'abcdef', false, [ 'min' => 2, 'max' => 5 ], 'ValidationErrorException' ],
            [ 0, true, [ 'nullable' ], null ],
            [ 0.0, true, [ 'nullable' ], null ],
            [ '0', true, [ 'nullable' ], null ],
            [ null, false, [ 'nullable' ], null ],
            [ '', false, [ 'nullable' ], null ],
            [ false, false, [ 'nullable' ], null ],
            [ [], false, [ 'nullable' ], null ],
            [ 0, true, [], null ],
            [ 0.0, true, [], null ],
            [ '0', true, [], null ],
            [ null, false, [], 'ValidationErrorException' ],
            [ '', false, [], 'ValidationErrorException' ],
            [ false, false, [], 'ValidationErrorException' ],
            [ [], false, [], 'ValidationErrorException' ],
        ];
    }
    
    /**
     * @depends testInitOptions
     * @dataProvider providerValidate
     */
    public function testValidate($value, $expected, $options, $exception, $init)
    {
        isset($exception) && $this->setExpectedException("Phpingguo\\BananaValidator\\" . $exception);
        
        $this->assertSame($expected, (new Alphanumeric())->validate($value, $init($options)));
    }
}
