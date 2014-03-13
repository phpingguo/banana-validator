<?php
namespace Phpingguo\BananaValidator\Tests\String\Latin;

use Phpingguo\BananaValidator\Enums\ValidationError;
use Phpingguo\BananaValidator\Options;
use Phpingguo\BananaValidator\String\Latin\Ascii;
use Phpingguo\BananaValidator\ValidationErrorException;

class ValidatorAsciiTest extends \PHPUnit_Framework_TestCase
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
            [ 'ひらがな', false, [], [ ValidationError::FORMAT ] ],
            [ '漢字', false, [], [ ValidationError::FORMAT ] ],
            [ 'ｶﾀｶﾅ', false, [], [ ValidationError::FORMAT ] ],
            [ 'カタカナ', false, [], [ ValidationError::FORMAT ] ],
            [ '!"#$%&\'()=~|-^\\[]{}/?_*:;+`@,.<>', true, [], null ],
            [ '1a', true, [], null ],
            [ '1Z', true, [], null ],
            [ '1ひらがな', false, [], [ ValidationError::FORMAT ] ],
            [ '1漢字', false, [], [ ValidationError::FORMAT ] ],
            [ '1ｶﾀｶﾅ', false, [], [ ValidationError::FORMAT ] ],
            [ '1カタカナ', false, [], [ ValidationError::FORMAT ] ],
            [ 'abcひらがな', false, [], [ ValidationError::FORMAT ] ],
            [ 'abc漢字', false, [], [ ValidationError::FORMAT ] ],
            [ 'abcｶﾀｶﾅ', false, [], [ ValidationError::FORMAT ] ],
            [ 'abcカタカナ', false, [], [ ValidationError::FORMAT ] ],
            [ 'ひらがな漢字', false, [], [ ValidationError::FORMAT ] ],
            [ 'ひらがなｶﾀｶﾅ', false, [], [ ValidationError::FORMAT ] ],
            [ 'ひらがなカタカナ', false, [], [ ValidationError::FORMAT ] ],
            [ '漢字ｶﾀｶﾅ', false, [], [ ValidationError::FORMAT ] ],
            [ '漢字カタカナ', false, [], [ ValidationError::FORMAT ] ],
            [ 'カタカナｶﾀｶﾅ', false, [], [ ValidationError::FORMAT ] ],
            [ 'abc', true, [ 'whitespace' ], null ],
            [ 'a b c', true, [ 'whitespace' ], null ],
            [ 'a　b　c', true, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'ABC', true, [ 'whitespace' ], null ],
            [ 'A B C', true, [ 'whitespace' ], null ],
            [ 'A　B　C', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'ひらがな', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'ひ ら が な', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'ひ　ら　が　な', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ '漢字', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ '漢 字', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ '漢　字', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'ｶﾀｶﾅ', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'ｶ ﾀ ｶ ﾅ', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'ｶ　ﾀ　ｶ　ﾅ', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'カタカナ', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'カ タ カ ナ', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'カ　タ　カ　ナ', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ '', false, [ 'min' => 2, 'max' => 5 ], [ ValidationError::INVALID ] ],
            [ 'a', false, [ 'min' => 2, 'max' => 5 ], [ ValidationError::MIN ] ],
            [ 'ab', true, [ 'min' => 2, 'max' => 5 ], null ],
            [ 'abc', true, [ 'min' => 2, 'max' => 5 ], null ],
            [ 'abcd', true, [ 'min' => 2, 'max' => 5 ], null ],
            [ 'abcde', true, [ 'min' => 2, 'max' => 5 ], null ],
            [ 'abcdef', false, [ 'min' => 2, 'max' => 5 ], [ ValidationError::MAX ] ],
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
            [ null, false, [], [ ValidationError::INVALID ] ],
            [ '', false, [], [ ValidationError::INVALID ] ],
            [ true, true, [], null ],
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
            $this->assertSame($expected, (new Ascii())->validate($value, $init($options)));
        } catch (ValidationErrorException $e) {
            $this->assertSame($exception, $e->getErrorLists());
        }
    }
}
