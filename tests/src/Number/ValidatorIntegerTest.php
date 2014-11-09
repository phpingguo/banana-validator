<?php
namespace Phpeel\BananaValidator\Tests\Number;

use Phpeel\BananaValidator\Enums\ValidationError;
use Phpeel\BananaValidator\Number\Integer;
use Phpeel\BananaValidator\Options;
use Phpeel\BananaValidator\ValidationErrorException;

class ValidatorIntegerTest extends \PHPUnit_Framework_TestCase
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
            [ 1, true, [], null ],
            [ 100, true, [], null ],
            [ PHP_INT_MAX - 1, true, [], null ],
            [ PHP_INT_MAX, true, [], null ],
            [ PHP_INT_MAX + 1, false, [], [ ValidationError::FORMAT, ValidationError::MAX ] ],
            [ PHP_INT_MAX + 10, false, [], [ ValidationError::FORMAT, ValidationError::MAX ] ],
            [ -1, true, [], null ],
            [ -100, true, [], null ],
            [ ~PHP_INT_MAX + 1, true, [], null ],
            [ ~PHP_INT_MAX, true, [], null ],
            [ ~PHP_INT_MAX - 1, false, [], [ ValidationError::FORMAT, ValidationError::MIN ] ],
            [ ~PHP_INT_MAX - 10, false, [], [ ValidationError::FORMAT, ValidationError::MIN ] ],
            [ -100, false, [ 'min' => -50, 'max' => 50 ], [ ValidationError::MIN ] ],
            [ -51, false, [ 'min' => -50, 'max' => 50 ], [ ValidationError::MIN ] ],
            [ -50, true, [ 'min' => -50, 'max' => 50 ], null ],
            [ -49, true, [ 'min' => -50, 'max' => 50 ], null ],
            [ -1, true, [ 'min' => -50, 'max' => 50 ], null ],
            [ 0, true, [ 'min' => -50, 'max' => 50 ], null ],
            [ 1, true, [ 'min' => -50, 'max' => 50 ], null ],
            [ 49, true, [ 'min' => -50, 'max' => 50 ], null ],
            [ 50, true, [ 'min' => -50, 'max' => 50 ], null ],
            [ 51, false, [ 'min' => -50, 'max' => 50 ], [ ValidationError::MAX ] ],
            [ 100, false, [ 'min' => -50, 'max' => 50 ], [ ValidationError::MAX ] ],
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
            $this->assertSame($expected, (new Integer())->validate($value, $init($options)));
        } catch (ValidationErrorException $e) {
            $this->assertSame($exception, $e->getErrorLists());
        }
    }
}
