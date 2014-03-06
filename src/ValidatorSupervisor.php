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
}
