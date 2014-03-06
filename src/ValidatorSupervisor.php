<?php
namespace Phpingguo\BananaValidator;

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
        return realpath(__DIR__) . DIRECTORY_SEPARATOR . '..';
    }

    /**
     * バリデーションライブラリの設定ファイルがあるディレクトリのファイルパスを取得します。
     * 
     * @return String バリデーションライブラリの設定ファイルがあるディレクトリのファイルパス
     */
    public static function getConfigPath()
    {
        return static::getBasePath() . DIRECTORY_SEPARATOR . 'config';
    }
}
