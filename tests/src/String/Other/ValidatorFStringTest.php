<?php
namespace Phpingguo\BananaValidator\Tests\String\Latin;

use Phpingguo\BananaValidator\Enums\ValidationError;
use Phpingguo\BananaValidator\Options;
use Phpingguo\BananaValidator\String\Other\FullSizeString;
use Phpingguo\BananaValidator\ValidationErrorException;

class ValidatorFStringTest extends \PHPUnit_Framework_TestCase
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
            [ 'A', false, [], [ ValidationError::FORMAT ] ],
            [ 'abc', false, [], [ ValidationError::FORMAT ] ],
            [ 'ABC', false, [], [ ValidationError::FORMAT ] ],
            [ 'a b c', false, [], [ ValidationError::FORMAT ] ],
            [ 'X Y Z', false, [], [ ValidationError::FORMAT ] ],
            [ 'ひらがな', true, [], null ],
            [ '漢字', true, [], null ],
            [ 'ｶﾀｶﾅ', false, [], [ ValidationError::FORMAT ] ],
            [ 'カタカナ', true, [], null ],
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
            [ 'ひらがな漢字', true, [], null ],
            [ 'ひらがなｶﾀｶﾅ', false, [], [ ValidationError::FORMAT ] ],
            [ 'ひらがなカタカナ', true, [], null ],
            [ '漢字ｶﾀｶﾅ', false, [], [ ValidationError::FORMAT ] ],
            [ '漢字カタカナ', true, [], null ],
            [ 'カタカナｶﾀｶﾅ', false, [], [ ValidationError::FORMAT ] ],
            [ 'abc', true, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'a b c', true, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'a　b　c', true, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'ABC', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'A B C', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'A　B　C', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'ひらがな', true, [ 'whitespace' ], null ],
            [ 'ひ ら が な', true, [ 'whitespace' ], null ],
            [ 'ひ　ら　が　な', true, [ 'whitespace' ], null ],
            [ '漢字', true, [ 'whitespace' ], null ],
            [ '漢 字', true, [ 'whitespace' ], null ],
            [ '漢　字', true, [ 'whitespace' ], null ],
            [ 'ｶﾀｶﾅ', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'ｶ ﾀ ｶ ﾅ', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'ｶ　ﾀ　ｶ　ﾅ', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'カタカナ', true, [ 'whitespace' ], null ],
            [ 'カ タ カ ナ', true, [ 'whitespace' ], null ],
            [ 'カ　タ　カ　ナ', true, [ 'whitespace' ], null ],
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
            $this->assertSame($expected, (new FullSizeString())->validate($value, $init($options)));
        } catch (ValidationErrorException $e) {
            $this->assertSame($exception, $e->getErrorLists());
        }
    }
}
