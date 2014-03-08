<?php
namespace Phpingguo\BananaValidator\Tests\String\Latin;

use Phpingguo\BananaValidator\Enums\ValidationError;
use Phpingguo\BananaValidator\Options;
use Phpingguo\BananaValidator\String\Latin\UpperAlphabet;
use Phpingguo\BananaValidator\ValidationErrorException;

class ValidatorUAlphabetTest extends \PHPUnit_Framework_TestCase
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
            [ 'a', false, [], [ ValidationError::FORMAT ] ],
            [ 'A', true, [], null ],
            [ 'abc', false, [], [ ValidationError::FORMAT ] ],
            [ 'ABC', true, [], null ],
            [ 'a b c', false, [], [ ValidationError::FORMAT ] ],
            [ 'X Y Z', false, [], [ ValidationError::FORMAT ] ],
            [ 'ひらがな', false, [], [ ValidationError::FORMAT ] ],
            [ '漢字', false, [], [ ValidationError::FORMAT ] ],
            [ 'ｶﾀｶﾅ', false, [], [ ValidationError::FORMAT ] ],
            [ 'カタカナ', false, [], [ ValidationError::FORMAT ] ],
            [ '!"#$%&\'()=~|-^\\[]{}/?_*:;+`@,.<>', false, [], [ ValidationError::FORMAT ] ],
            [ '1a', false, [], [ ValidationError::FORMAT ] ],
            [ '1Z', false, [], [ ValidationError::FORMAT ] ],
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
            [ 'abc', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'a b c', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'a　b　c', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
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
            [ 0, false, [ 'nullable' ], [ ValidationError::FORMAT ] ],
            [ 0.0, false, [ 'nullable' ], [ ValidationError::FORMAT ] ],
            [ '0', false, [ 'nullable' ], [ ValidationError::FORMAT ] ],
            [ null, false, [ 'nullable' ], null ],
            [ '', false, [ 'nullable' ], null ],
            [ false, false, [ 'nullable' ], null ],
            [ [], false, [ 'nullable' ], null ],
            [ 0, false, [], [ ValidationError::FORMAT ] ],
            [ 0.0, false, [], [ ValidationError::FORMAT ] ],
            [ '0', false, [], [ ValidationError::FORMAT ] ],
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
            $this->assertSame($expected, (new UpperAlphabet())->validate($value, $init($options)));
        } catch (ValidationErrorException $e) {
            $this->assertSame($exception, $e->getErrorLists());
        }
    }
}
