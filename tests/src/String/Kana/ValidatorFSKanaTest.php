<?php
namespace Phpingguo\BananaValidator\Tests\String\Kana;

use Phpingguo\BananaValidator\Enums\ValidationError;
use Phpingguo\BananaValidator\Options;
use Phpingguo\BananaValidator\String\Kana\FullSizeKana;
use Phpingguo\BananaValidator\ValidationErrorException;

class ValidatorFSKanaTest extends \PHPUnit_Framework_TestCase
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
            [ 'z', false, [], [ ValidationError::FORMAT ] ],
            [ 'A', false, [], [ ValidationError::FORMAT ] ],
            [ 'Z', false, [], [ ValidationError::FORMAT ] ],
            [ 'abc', false, [], [ ValidationError::FORMAT ] ],
            [ 'xyz', false, [], [ ValidationError::FORMAT ] ],
            [ 'ABC', false, [], [ ValidationError::FORMAT ] ],
            [ 'XYZ', false, [], [ ValidationError::FORMAT ] ],
            [ '!"#$%&\'()=~|-^\\[]{}/?_*:;+`@,.<>', false, [], [ ValidationError::FORMAT ] ],
            [ '1a', false, [], [ ValidationError::FORMAT ] ],
            [ 'a1', false, [], [ ValidationError::FORMAT ] ],
            [ '1Z', false, [], [ ValidationError::FORMAT ] ],
            [ 'Z1', false, [], [ ValidationError::FORMAT ] ],
            [ 'ひらがな', false, [], [ ValidationError::FORMAT ] ],
            [ 'ひらがな1', false, [], [ ValidationError::FORMAT ] ],
            [ '1ひらがな', false, [], [ ValidationError::FORMAT ] ],
            [ '漢字', false, [], [ ValidationError::FORMAT ] ],
            [ '漢字1', false, [], [ ValidationError::FORMAT ] ],
            [ '1漢字', false, [], [ ValidationError::FORMAT ] ],
            [ 'ｶﾀｶﾅ', false, [], [ ValidationError::FORMAT ] ],
            [ 'ｶﾀｶﾅ1', false, [], [ ValidationError::FORMAT ] ],
            [ '1ｶﾀｶﾅ', false, [], [ ValidationError::FORMAT ] ],
            [ 'カタカナ', true, [], null ],
            [ 'カタカナ1', false, [], [ ValidationError::FORMAT ] ],
            [ '1カタカナ', false, [], [ ValidationError::FORMAT ] ],
            [ 'abcひらがな', false, [], [ ValidationError::FORMAT ] ],
            [ 'abc漢字', false, [], [ ValidationError::FORMAT ] ],
            [ 'abcｶﾀｶﾅ', false, [], [ ValidationError::FORMAT ] ],
            [ 'abcカタカナ', false, [], [ ValidationError::FORMAT ] ],
            [ 'ひらがなabc', false, [], [ ValidationError::FORMAT ] ],
            [ 'ひらがな漢字', false, [], [ ValidationError::FORMAT ] ],
            [ 'ひらがなｶﾀｶﾅ', false, [], [ ValidationError::FORMAT ] ],
            [ 'ひらがなカタカナ', false, [], [ ValidationError::FORMAT ] ],
            [ '漢字abc', false, [], [ ValidationError::FORMAT ] ],
            [ '漢字ひらがな', false, [], [ ValidationError::FORMAT ] ],
            [ '漢字ｶﾀｶﾅ', false, [], [ ValidationError::FORMAT ] ],
            [ '漢字カタカナ', false, [], [ ValidationError::FORMAT ] ],
            [ 'カタカナabc', false, [], [ ValidationError::FORMAT ] ],
            [ 'カタカナひらがな', false, [], [ ValidationError::FORMAT ] ],
            [ 'カタカナ漢字', false, [], [ ValidationError::FORMAT ] ],
            [ 'カタカナｶﾀｶﾅ', false, [], [ ValidationError::FORMAT ] ],
            [ 'abc', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'a b c', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'a　b　c', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'ABC', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
            [ 'A B C', false, [ 'whitespace' ], [ ValidationError::FORMAT ] ],
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
            [ 'カタカナ', true, [ 'whitespace' ], null ],
            [ 'カ タ カ ナ', true, [ 'whitespace' ], null ],
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
            [ false, false, [], [ ValidationError::INVALID ] ],
            [ [], false, [], [ ValidationError::INVALID ] ],
        ];
    }
    
    /**
     * @depends testInitOptions
     * @dataProvider providerValidate
     */
    public function testValidate($value, $expected, $options, $exception, $init)
    {
        try {
            $this->assertSame($expected, (new FullSizeKana())->validate($value, $init($options)));
        } catch (ValidationErrorException $e) {
            $this->assertSame($exception, $e->getErrorLists());
        }
    }
}
