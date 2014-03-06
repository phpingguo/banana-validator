<?php
namespace Phpingguo\BananaValidator\String\Latin;

use Phpingguo\BananaValidator\String\StringFormat;

/**
 * 大文字のラテンアルファベットを検証するクラスです。
 * 
 * @final [継承禁止クラス]
 * @author hiroki sugawara
 */
final class UpperAlphabet extends StringFormat
{
    /**
     * UpperAlphabet クラスの新しいインスタンスを初期化します。
     */
    public function __construct()
    {
        parent::__construct('[A-Z]');
    }
}
