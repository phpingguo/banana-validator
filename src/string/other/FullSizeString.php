<?php
namespace Phpingguo\BananaValidator\String\Other;

use Phpingguo\BananaValidator\String\StringFormat;

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
