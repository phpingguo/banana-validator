<?php
namespace Phpeel\BananaValidator\String\Other;

use Phpeel\BananaValidator\String\StringFormat;

/**
 * 全角文字を検証するクラスです。
 * 
 * @final [継承禁止クラス]
 * @author hiroki sugawara
 */
final class FullSizeString extends StringFormat
{
    /**
     * FullSizeString クラスの新しいインスタンスを初期化します。
     */
    public function __construct()
    {
        parent::__construct(null);
        
        $this->setAllowFullSize(true);
    }
}
