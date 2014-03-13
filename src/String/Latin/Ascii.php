<?php
namespace Phpingguo\BananaValidator\String\Latin;

use Phpingguo\BananaValidator\String\StringFormat;

/**
 * アスキーコードを検証するクラスです。
 * 
 * @final [継承禁止クラス]
 * @author hiroki sugawara
 */
final class Ascii extends StringFormat
{
    /**
     * Ascii クラスの新しいインスタンスを初期化します。
     */
    public function __construct()
    {
        parent::__construct('[\x21-\x7E]');
        
        $this->setAllowNumeric(true);
    }
}
