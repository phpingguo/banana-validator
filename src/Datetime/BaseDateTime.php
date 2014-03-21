<?php
namespace Phpingguo\BananaValidator\DateTime;

use Phpingguo\ApricotLib\Common\Arrays;
use Phpingguo\ApricotLib\Common\String;
use Phpingguo\BananaValidator\Enums\ValidationError;
use Phpingguo\BananaValidator\IValidator;
use Phpingguo\BananaValidator\Options;
use Phpingguo\BananaValidator\TCommonValidator;
use Phpingguo\BananaValidator\ValidationErrorException;

/**
 * 日時型の値を検証するクラスの基本機能を提供する抽象クラスです。
 *
 * @abstract
 * @author hiroki sugawara
 */
abstract class BaseDateTime implements IValidator
{
    // ---------------------------------------------------------------------------------------------
    // import trait
    // ---------------------------------------------------------------------------------------------
    use TCommonValidator;
    
    // ---------------------------------------------------------------------------------------------
    // private fields
    // ---------------------------------------------------------------------------------------------
    private $format_string = '';
    private $min_value     = 0;
    private $max_value     = 0;
    private $digit_number  = -1;
    
    // ---------------------------------------------------------------------------------------------
    // constructor / destructor
    // ---------------------------------------------------------------------------------------------
    /**
     * BaseDateTime クラスの新しいインスタンスを初期化します。
     *
     * @param String $format 日時フォーマットを表す文字列
     */
    public function __construct($format)
    {
        $this->format_string = $format;
    }
    
    // ---------------------------------------------------------------------------------------------
    // public member methods
    // ---------------------------------------------------------------------------------------------
    /**
     * @final [オーバーライド禁止]
     * @see \Phpingguo\Validator\IValidator::validate()
     */
    final public function validate(&$value, Options $options)
    {
        $error_result = $this->checkError($value, $options);
        
        if (Arrays::isValid($error_result)) {
            throw new ValidationErrorException($error_result);
        }
        
        return ($error_result !== false);
    }
    
    // ---------------------------------------------------------------------------------------------
    // private member methods
    // ---------------------------------------------------------------------------------------------
    /**
     * 検証時に許容する最小値を取得します。
     * 
     * @final [オーバーライド禁止]
     * @return Number 検証時に許容する最小値
     */
    final protected function getMinValue()
    {
        return $this->min_value;
    }
    
    /**
     * 検証時に許容する最小値を設定します。
     * 
     * @final [オーバーライド禁止]
     * @param Number $value 検証時に許容する最小値
     */
    final protected function setMinValue($value)
    {
        $this->min_value = $value;
    }
    
    /**
     * 検証時に許容する最大値を取得します。
     * 
     * @final [オーバーライド禁止]
     * @return Number 検証時に許容する最大値
     */
    final protected function getMaxValue()
    {
        return $this->max_value;
    }
    
    /**
     * 検証時に許容する最大値を設定します。
     * 
     * @final [オーバーライド禁止]
     * @param Number $value 検証時に許容する最大値
     */
    final protected function setMaxValue($value)
    {
        $this->max_value = $value;
    }

    /**
     * 検証時に許容する数値の桁数を取得します。
     * 
     * @final [オーバーライド禁止]
     * @return Integer 検証時に許容する数値の桁数
     */
    final protected function getDigitNumber()
    {
        return $this->digit_number;
    }

    /**
     * 検証時に許容する数値の桁数を設定します。
     * 
     * @final [オーバーライド禁止]
     * @param Integer $value 検証時に許容する数値の桁数
     */
    final protected function setDigitNumber($value)
    {
        $this->digit_number = $value;
    }
    
    /**
     * 指定した変数のエラーチェックを行います。
     * 
     * @param mixed $value     エラーチェック対象となる変数
     * @param Options $options エラーチェックに利用するオプションの設定
     * 
     * @return Boolean|Array 入力値が無効(null、空配列、長さ0の文字列)の場合に、nullable オプションが
     * 有効の時は false。それ以外の時はエラー理由。
     */
    private function checkError($value, Options $options)
    {
        $error_result = $this->checkNullValue($value, $options);
        
        if (Arrays::isEmpty($error_result)) {
            $this->setError($error_result, $this->checkInvalidFormat($value));
            
            if ($this->getDigitNumber() === strlen($this->getDateTimeNumber($value))) {
                $list = $this->checkOverLimitValues($value, $options);
                
                Arrays::eachWalk(
                    $list,
                    function ($error_val) use (&$error_result) {
                        $this->setError($error_result, $error_val);
                    }
                );
            }
        }
        
        return $error_result;
    }
    
    /**
     * 日時、時刻または日付が、無効なフォーマットであるかどうかを判定します。
     * 
     * @param String $value 検査対象になる日時、時刻、日付
     * 
     * @return ValidationError 無効なフォーマットであればそのエラー理由。それ以外であれば null。
     */
    private function checkInvalidFormat($value)
    {
        if (String::isNotRegexMatched($value, "/$this->format_string/", 1)) {
            return ValidationError::FORMAT();
        }
        
        return null;
    }
    
    /**
     * 日時、時刻または日付が、最小値または最大値を超えているかどうかを判定します。
     * 
     * @param String $value    検査対象になる日時、時刻、日付
     * @param Options $options 検証時に利用するオプションの設定
     * 
     * @return Array(ValidationError) 最小値および最大値を超えている場合はそのエラー理由含んだ配列。
     * それ以外であれば空配列。
     */
    private function checkOverLimitValues($value, Options $options)
    {
        $target = $this->getDateTimeNumber($value, true);
        $min    = $this->getLimitValue('getMinValue', $options);
        $max    = $this->getLimitValue('getMaxValue', $options);
        
        $result = [];
        
        Arrays::addWhen(is_null($max) || $max < $target, $result, ValidationError::MAX());
        Arrays::addWhen(is_null($min) || $target < $min, $result, ValidationError::MIN());
        
        return $result;
    }
    
    /**
     * 許容最小値または許容最大値を取得します。
     * 
     * @param String $method_name 境界値を取得するメソッドの名前
     * @param Options $options    検証時に利用するオプションの設定
     * 
     * @return Number 許容最小値または許容最大値
     */
    private function getLimitValue($method_name, Options $options)
    {
        return is_null($options->$method_name()) ? $this->$method_name() :
            $this->getDateTimeNumber($options->$method_name(), true);
    }
    
    /**
     * 日時表記の文字列を数値に変換したものを取得します。
     * 
     * @param String $datetime 数値に変換する日時表記の文字列
     * 
     * @return String|null 入力値が適切な値の場合は日時表記から変換した数値文字列。不正な場合は null。
     */
    private function getDateTimeNumber($datetime, $is_number_cast = false)
    {
        $date_pattern = '(([0-9]{2,4})[-\/]*([0-9]{1,2})[-\/]*([0-9]{1,2}))*';
        $time_pattern = '\s?(([0-9]{1,2})[:]*([0-9]{1,2})[:]*([0-9]{1,2})*)*';
        
        $exec_data = Arrays::getValue(
            [
                6  => [ 'method_name' => 'getTimeNumber', 'pattern' => $time_pattern ],
                8  => [ 'method_name' => 'getDateNumber', 'pattern' => $date_pattern ],
                14 => [ 'method_name' => 'getFullNumber', 'pattern' => "{$date_pattern}{$time_pattern}" ],
            ],
            $this->getDigitNumber()
        );
        
        $result = call_user_func([ $this, $exec_data['method_name'] ], $datetime, $exec_data['pattern']);
        
        return ($is_number_cast === true) ? floatval($result) : $result;
    }

    /**
     * 日付の数値表記を取得します。
     * 
     * @param String $datetime 日付表記の文字列
     * @param String $pattern  数値表記に変換するための正規表現文字列
     *
     * @return String|null 取得成功時はパラメータ $datetime の数値表記文字列。それ以外の時は null。
     */
    private function getDateNumber($datetime, $pattern)
    {
        return $this->getDate(
            $this->getMatched($datetime, $pattern),
            [ 'year' => 2, 'month' => 3, 'day' => 4 ]
        );
    }

    /**
     * 時刻の数値表記を取得します。
     * 
     * @param String $datetime 時刻表記の文字列
     * @param String $pattern  数値表記に変換するための正規表現文字列
     *
     * @return String パラメータ $datetime の数値表記文字列。
     */
    private function getTimeNumber($datetime, $pattern)
    {
        return $this->getTime(
            $this->getMatched($datetime, $pattern),
            [ 'hour' => 2, 'minute' => 3, 'second' => 4 ]
        );
    }

    /**
     * 日時の数値表記を取得します。
     * 
     * @param String $datetime 日時表記の文字列
     * @param String $pattern  数値表記に変換するための正規表現文字列
     *
     * @return String パラメータ $datetime の数値表記文字列。
     */
    private function getFullNumber($datetime, $pattern)
    {
        $matches = $this->getMatched($datetime, $pattern);
        $date    = $this->getDate($matches, [ 'year' => 2, 'month' => 3, 'day' => 4 ]);
        $time    = $this->getTime($matches, [ 'hour' => 6, 'minute' => 7, 'second' => 8 ]);
        
        return (is_null($date) === false) ? "{$date}{$time}" : null;
    }

    /**
     * 日付・時刻・日時のいづれかの入力文字列に正規表現検索を行い、その検索結果を取得します。
     * 
     * @param String $datetime 日付・時刻・日時表記の文字列
     * @param String $pattern  数値表記に変換するための正規表現文字列
     *
     * @return Array 正規表現検索の検索結果の配列
     */
    private function getMatched($datetime, $pattern)
    {
        preg_match("/^{$pattern}$/", $datetime, $matches);
        
        return $matches;
    }

    /**
     * 日付の数値表記文字列を取得します。
     * 
     * @param Array $matches  日付表記の文字列
     * @param Array $indexers 取得時に使用する正規表現検索の結果配列のインデックスの値
     *
     * @return String|null 日付として有効な文字列の場合はその文字列。それ以外の場合は null。
     */
    private function getDate(array $matches, array $indexers)
    {
        $year  = sprintf('%04d', Arrays::getValue($matches, $indexers['year'], 0));
        $month = sprintf('%02d', Arrays::getValue($matches, $indexers['month'], 0));
        $day   = sprintf('%02d', Arrays::getValue($matches, $indexers['day'], 0));
        
        return checkdate($month, $day, $year) ? "{$year}{$month}{$day}" : null;
    }

    /**
     * 時刻の数値表記文字列を取得します。
     * 
     * @param Array $matches  時刻表記の文字列
     * @param Array $indexers 取得時に使用する正規表現検索の結果配列のインデックスの値
     *
     * @return String 時刻の数値表記の文字列
     */
    private function getTime(array $matches, array $indexers)
    {
        $hour   = sprintf('%02d', Arrays::getValue($matches, $indexers['hour'], 0));
        $minute = sprintf('%02d', Arrays::getValue($matches, $indexers['minute'], 0));
        $second = sprintf('%02d', Arrays::getValue($matches, $indexers['second'], 0));
        
        return "{$hour}{$minute}{$second}";
    }
}
