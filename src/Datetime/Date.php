<?php
namespace Phpingguo\BananaValidator\DateTime;

/**
 * 日付型の値を検証するクラスです。
 * 
 * @final [継承禁止クラス]
 * @author hiroki sugawara
 */
final class Date extends BaseDateTime
{
    // ---------------------------------------------------------------------------------------------
    // constructor / destructor
    // ---------------------------------------------------------------------------------------------
    /**
     * Date クラスの新しいインスタンスを初期化します。
     */
    public function __construct()
    {
        parent::__construct('^[2-9]([0-9]){1,3}[\-\/]*(0[1-9]|1[0-2])[\-\/]*(0[1-9]|[1-2][0-9]|3[0-1])$');
        
        $this->setDigitNumber(8);
        $this->setMinValue(20000101);
        $this->setMaxValue(99991231);
    }
}
