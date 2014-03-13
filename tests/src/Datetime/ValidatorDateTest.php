<?php
namespace Phpingguo\BananaValidator\Tests\DateTime;

use Phpingguo\BananaValidator\DateTime\Date;
use Phpingguo\BananaValidator\Enums\ValidationError;
use Phpingguo\BananaValidator\Options;
use Phpingguo\BananaValidator\ValidationErrorException;

class ValidatorDateTest extends \PHPUnit_Framework_TestCase
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
            [ '2000-01-01', true, [], null ],
            [ '2000/01/01', true, [], null ],
            [ '20000101', true, [], null ],
            [ '2000-01-01', false, [ 'min' => '20050101', 'max' => '20061231' ], [ ValidationError::MIN ] ],
            [ '2000/01/01', false, [ 'min' => '20050101', 'max' => '20061231' ], [ ValidationError::MIN ] ],
            [ '20000101', false, [ 'min' => '20050101', 'max' => '20061231' ], [ ValidationError::MIN ] ],
            [ '2005-02-01', true, [ 'min' => '20050101', 'max' => '20061231' ], null ],
            [ '2005/02/01', true, [ 'min' => '20050101', 'max' => '20061231' ], null ],
            [ '20050201', true, [ 'min' => '20050101', 'max' => '20061231' ], null ],
            [ '2010-01-01', false, [ 'min' => '20050101', 'max' => '20061231' ], [ ValidationError::MAX ] ],
            [ '2010/01/01', false, [ 'min' => '20050101', 'max' => '20061231' ], [ ValidationError::MAX ] ],
            [ '20100101', false, [ 'min' => '20050101', 'max' => '20061231' ], [ ValidationError::MAX ] ],
            [ '1999-01-01', false, [], [ ValidationError::FORMAT, ValidationError::MIN ] ],
            [ '1999/01/01', false, [], [ ValidationError::FORMAT, ValidationError::MIN ] ],
            [ '19990101', false, [], [ ValidationError::FORMAT, ValidationError::MIN ] ],
            [ '10000-01-01', false, [], [ ValidationError::FORMAT ] ],
            [ '10000/01/01', false, [], [ ValidationError::FORMAT ] ],
            [ '100000101', false, [], [ ValidationError::FORMAT ] ],
            [ '9999-13-01', false, [], [ ValidationError::FORMAT ] ],
            [ '9999/13/01', false, [], [ ValidationError::FORMAT ] ],
            [ '99991301', false, [], [ ValidationError::FORMAT ] ],
            [ '00:00:00', false, [], [ ValidationError::FORMAT ] ],
            [ '00:00', false, [], [ ValidationError::FORMAT ] ],
            [ '000000', false, [], [ ValidationError::FORMAT ] ],
            [ '0000', false, [], [ ValidationError::FORMAT ] ],
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
            [ new \stdClass(), false, [], [ ValidationError::INVALID ] ],
        ];
    }
    
    /**
     * @depends testInitOptions
     * @dataProvider providerValidate
     */
    public function testValidate($value, $expected, $options, $exception, $init)
    {
        try {
            $this->assertSame($expected, (new Date())->validate($value, $init($options)));
        } catch (ValidationErrorException $e) {
            $this->assertSame($exception, $e->getErrorLists());
        }
    }
}
