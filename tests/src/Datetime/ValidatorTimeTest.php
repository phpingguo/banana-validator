<?php
namespace Phpeel\BananaValidator\Tests\DateTime;

use Phpeel\BananaValidator\DateTime\Time;
use Phpeel\BananaValidator\Enums\ValidationError;
use Phpeel\BananaValidator\Options;
use Phpeel\BananaValidator\ValidationErrorException;

class ValidatorTimeTest extends \PHPUnit_Framework_TestCase
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
            [ '2000-01-01 00:00:00', false, [], [ ValidationError::FORMAT ] ],
            [ '2000-01-01 00:00', false, [], [ ValidationError::FORMAT ] ],
            [ '2000-01-01 000000', false, [], [ ValidationError::FORMAT ] ],
            [ '2000-01-01 0000', false, [], [ ValidationError::FORMAT ] ],
            [ '2000/01/01 00:00:00', false, [], [ ValidationError::FORMAT ] ],
            [ '2000/01/01 00:00', false, [], [ ValidationError::FORMAT ] ],
            [ '2000/01/01 000000', false, [], [ ValidationError::FORMAT ] ],
            [ '2000/01/01 0000', false, [], [ ValidationError::FORMAT ] ],
            [ '20000101 00:00:00', false, [], [ ValidationError::FORMAT ] ],
            [ '20000101 00:00', false, [], [ ValidationError::FORMAT ] ],
            [ '20000101 000000', false, [], [ ValidationError::FORMAT ] ],
            [ '20000101 0000', false, [], [ ValidationError::FORMAT ] ],
            [ '2000-01-01', false, [], [ ValidationError::FORMAT ] ],
            [ '2000/01/01', false, [], [ ValidationError::FORMAT ] ],
            [ '20000101', false, [], [ ValidationError::FORMAT ] ],
            [ '00:00:00', true, [], null ],
            [ '00:00', true, [], null ],
            [ '000000', true, [], null ],
            [ '0000', true, [], null ],
            [ '00:00:00', false, [ 'min' => '110000', 'max' => '140000' ], [ ValidationError::MIN ] ],
            [ '00:00', false, [ 'min' => '110000', 'max' => '140000' ], [ ValidationError::MIN ] ],
            [ '000000', false, [ 'min' => '110000', 'max' => '140000' ], [ ValidationError::MIN ] ],
            [ '0000', false, [ 'min' => '110000', 'max' => '140000' ], [ ValidationError::MIN ] ],
            [ '12:00:00', true, [ 'min' => '110000', 'max' => '140000' ], null ],
            [ '12:00', true, [ 'min' => '110000', 'max' => '140000' ], null ],
            [ '120000', true, [ 'min' => '110000', 'max' => '140000' ], null ],
            [ '1200', true, [ 'min' => '110000', 'max' => '140000' ], null ],
            [ '17:00:00', false, [ 'min' => '110000', 'max' => '140000' ], [ ValidationError::MAX ] ],
            [ '17:00', false, [ 'min' => '110000', 'max' => '140000' ], [ ValidationError::MAX ] ],
            [ '170000', false, [ 'min' => '110000', 'max' => '140000' ], [ ValidationError::MAX ] ],
            [ '1700', false, [ 'min' => '110000', 'max' => '140000' ], [ ValidationError::MAX ] ],
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
            $this->assertSame($expected, (new Time())->validate($value, $init($options)));
        } catch (ValidationErrorException $e) {
            $this->assertSame($exception, $e->getErrorLists());
        }
    }
}
