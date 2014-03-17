<?php
namespace Phpingguo\BananaValidator;

use Phpingguo\ApricotLib\Common\String as CString;

/**
 * バリデーションライブラリを統括管理するクラスです。
 * 
 * @final [継承禁止クラス]
 * @author hiroki sugawara
 */
final class ValidatorSupervisor
{
    // ---------------------------------------------------------------------------------------------
    // const fields
    // ---------------------------------------------------------------------------------------------
    const ENUM_VALIDATION_ERROR = 'ValidationError';
    const ENUM_VALIDATOR        = 'Validator';

    // ---------------------------------------------------------------------------------------------
    // public static methods
    // ---------------------------------------------------------------------------------------------
    /**
     * バリデーションライブラリのルートディレクトリのファイルパスを取得します。
     * 
     * @return String バリデーションライブラリのルートディレクトリのファイルパス
     */
    public static function getBasePath()
    {
        return CString::unionDirectoryPath(__DIR__, '..');
    }

    /**
     * バリデーションライブラリの設定ファイルがあるディレクトリのファイルパスを取得します。
     * 
     * @return String バリデーションライブラリの設定ファイルがあるディレクトリのファイルパス
     */
    public static function getConfigPath()
    {
        return CString::unionDirectoryPath(static::getBasePath(), 'config');
    }

    /**
     * 列挙型クラスの名前空間付きの完全修飾名を取得します。
     * 
     * @param String $enum_name 完全修飾名を取得する列挙型クラスの名前
     * 
     * @throws \InvalidArgumentException 有効な列挙型クラスではなかった場合
     * @return String 列挙型クラスの名前空間付きの完全修飾名
     */
    public static function getEnumFullName($enum_name)
    {
        return CString::getEnumFullName("Phpingguo\\BananaValidator\\Enums\\", $enum_name);
    }
}
