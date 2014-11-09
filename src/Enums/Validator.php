<?php
namespace Phpeel\BananaValidator\Enums;

use Phpeel\ApricotLib\Type\Enum\Enum;

/**
 * バリデータの種類を示します。
 * 
 * @final [列挙型属性]
 * @author h-sugawara@m-craft.com
 */
final class Validator extends Enum
{
    /** 符号あり整数値の検証を行うことを示す */
    const INTEGER         = 'Phpeel\BananaValidator\Number\Integer';
    
    /** 符号なし整数値の検証を行うことを示す */
    const UNSIGNED_INT    = 'Phpeel\BananaValidator\Number\UnsignedInteger';
    
    /** ラテンアルファベットの検証を行うことを示す */
    const ALPHABET        = 'Phpeel\BananaValidator\String\Latin\Alphabet';
    
    /** 小文字のラテンアルファベットの検証を行うことを示す */
    const LOWER_ALPHABET  = 'Phpeel\BananaValidator\String\Latin\LowerAlphabet';
    
    /** 大文字のラテンアルファベットの検証を行うことを示す */
    const UPPER_ALPHABET  = 'Phpeel\BananaValidator\String\Latin\UpperAlphabet';
    
    /** ラテンアルファベットとアラビア数字の検証を行うことを示す */
    const ALPHANUMERIC    = 'Phpeel\BananaValidator\String\Latin\Alphanumeric';
    
    /** アスキーコード文字の検証を行うことを示す */
    const ASCII           = 'Phpeel\BananaValidator\String\Latin\Ascii';
    
    /** ひらがなの検証を行うことを示す */
    const HIRAGANA        = 'Phpeel\BananaValidator\String\Kana\Hiragana';
    
    /** 半角カタカナの検証を行うことを示す */
    const HANKAKU_KANA    = 'Phpeel\BananaValidator\String\Kana\HalfWidthKana';
    
    /** 全角カタカナの検証を行うことを示す */
    const ZENKAKU_KANA    = 'Phpeel\BananaValidator\String\Kana\FullSizeKana';
    
    /** 全角文字の検証を行うことを示す */
    const FULLSIZE_STRING = 'Phpeel\BananaValidator\String\Other\FullSizeString';
    
    /** 文字列の検証を行うことを示す */
    const TEXT            = 'Phpeel\BananaValidator\String\Other\TextString';
    
    /** メールアドレスの検証を行うことを示す */
    const MAIL_ADDRESS    = 'Phpeel\BananaValidator\String\Other\MailAddress';
    
    /** 日時の検証を行うことを示す */
    const DATETIME        = 'Phpeel\BananaValidator\DateTime\DateTime';
    
    /** 日時の検証を行うことを示す */
    const DATE            = 'Phpeel\Validator\DateTime\Date';
    
    /** 時刻の検証を行うことを示す */
    const TIME            = 'Phpeel\Validator\DateTime\Time';
}
