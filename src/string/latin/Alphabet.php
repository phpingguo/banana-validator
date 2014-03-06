<?php
namespace Phpingguo\BananaValidator\String\Latin;

use Phpingguo\BananaValidator\String\StringFormat;

/**
 * ラテンアルファベットを検証するクラスです。
 * 
 * @final [継承禁止クラス]
 * @author hiroki sugawara
 */
final class Alphabet extends StringFormat
{
    /**
     * Alphabet クラスの新しいインスタンスを初期化します。
     */
    public function __construct()
    {
        parent::__construct('[a-zA-Z]');
    }
}
