<?php
namespace Phpingguo\BananaValidator\String\Latin;

use Phpingguo\BananaValidator\String\StringFormat;

/**
 * 小文字のラテンアルファベットを検証するクラスです。
 * 
 * @final [継承禁止クラス]
 * @author hiroki sugawara
 */
final class LowerAlphabet extends StringFormat
{
    /**
     * LowerAlphabet クラスの新しいインスタンスを初期化します。
     */
    public function __construct()
    {
        parent::__construct('[a-z]');
    }
}
