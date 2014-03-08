<?php
namespace Phpingguo\BananaValidator\Tests\String\Latin;

use Phpingguo\BananaValidator\Enums\ValidationError;
use Phpingguo\BananaValidator\Options;
use Phpingguo\BananaValidator\String\Other\TextString;
use Phpingguo\BananaValidator\ValidationErrorException;

class ValidatorTStringTest extends \PHPUnit_Framework_TestCase
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
            [ 'a', true, [], null ],
            [ 'A', true, [], null ],
            [ 'abc', true, [], null ],
            [ 'ABC', true, [], null ],
            [ 'a b c', false, [], [ ValidationError::FORMAT ] ],
            [ 'X Y Z', false, [], [ ValidationError::FORMAT ] ],
            [ 'ひらがな', true, [], null ],
            [ '漢字', true, [], null ],
            [ 'ｶﾀｶﾅ', true, [], null ],
            [ 'カタカナ', true, [], null ],
            [ '!"#$%&\'()=~|-^\\[]{}/?_*:;+`@,.<>', true, [], null ],
            [ '1a', true, [], null ],
            [ '1Z', true, [], null ],
            [ '1ひらがな', true, [], null ],
            [ '1漢字', true, [], null ],
            [ '1ｶﾀｶﾅ', true, [], null ],
            [ '1カタカナ', true, [], null ],
            [ 'abcひらがな', true, [], null ],
            [ 'abc漢字', true, [], null ],
            [ 'abcｶﾀｶﾅ', true, [], null ],
            [ 'abcカタカナ', true, [], null ],
            [ 'ひらがな漢字', true, [], null ],
            [ 'ひらがなｶﾀｶﾅ', true, [], null ],
            [ 'ひらがなカタカナ', true, [], null ],
            [ '漢字ｶﾀｶﾅ', true, [], null ],
            [ '漢字カタカナ', true, [], null ],
            [ 'カタカナｶﾀｶﾅ', true, [], null ],
            [ 'abc', true, [ 'whitespace' ], null ],
            [ 'a b c', true, [ 'whitespace' ], null ],
            [ 'a　b　c', true, [ 'whitespace' ], null ],
            [ 'ABC', true, [ 'whitespace' ], null ],
            [ 'A B C', true, [ 'whitespace' ], null ],
            [ 'A　B　C', true, [ 'whitespace' ], null ],
            [ 'ひらがな', true, [ 'whitespace' ], null ],
            [ 'ひ ら が な', true, [ 'whitespace' ], null ],
            [ 'ひ　ら　が　な', true, [ 'whitespace' ], null ],
            [ '漢字', true, [ 'whitespace' ], null ],
            [ '漢 字', true, [ 'whitespace' ], null ],
            [ '漢　字', true, [ 'whitespace' ], null ],
            [ 'ｶﾀｶﾅ', true, [ 'whitespace' ], null ],
            [ 'ｶ ﾀ ｶ ﾅ', true, [ 'whitespace' ], null ],
            [ 'ｶ　ﾀ　ｶ　ﾅ', true, [ 'whitespace' ], null ],
            [ 'カタカナ', true, [ 'whitespace' ], null ],
            [ 'カ タ カ ナ', true, [ 'whitespace' ], null ],
            [ 'カ　タ　カ　ナ', true, [ 'whitespace' ], null ],
            [ 0, false, [ 'nullable' ], [ ValidationError::FORMAT ] ],
            [ 0.0, false, [ 'nullable' ], [ ValidationError::FORMAT ] ],
            [ '0', true, [ 'nullable' ], null ],
            [ null, false, [ 'nullable' ], null ],
            [ '', false, [ 'nullable' ], null ],
            [ false, false, [ 'nullable' ], null ],
            [ [], false, [ 'nullable' ], null ],
            [ 0, false, [], [ ValidationError::FORMAT ] ],
            [ 0.0, false, [], [ ValidationError::FORMAT ] ],
            [ '0', true, [], null ],
            [ null, false, [], [ ValidationError::INVALID ] ],
            [ '', false, [], [ ValidationError::INVALID ] ],
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
        try {
            $this->assertSame($expected, (new TextString())->validate($value, $init($options)));
        } catch (ValidationErrorException $e) {
            $this->assertSame($exception, $e->getErrorLists());
        }
    }
}
