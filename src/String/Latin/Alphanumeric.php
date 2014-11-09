<?php
namespace Phpeel\BananaValidator\String\Latin;

use Phpeel\BananaValidator\String\StringFormat;

/**
 * ラテンアルファベットとアラビア数字を検証するクラスです。
 * 
 * @final [継承禁止クラス]
 * @author hiroki sugawara
 */
final class Alphanumeric extends StringFormat
{
    /**
     * Alphanumeric クラスの新しいインスタンスを初期化します。
     */
    public function __construct()
    {
        parent::__construct('[a-zA-Z0-9]');
        
        $this->setAllowNumeric(true);
    }
}
