<?php
namespace Phpingguo\BananaValidator;

/**
 * フレームワークでバリデーションエラー時にスローされる例外を表すクラスです。
 * 
 * @final [継承禁止クラス]
 * @author hiroki sugawara
 */
final class ValidationErrorException extends \RuntimeException
{
    // ---------------------------------------------------------------------------------------------
    // private fields
    // ---------------------------------------------------------------------------------------------
    private $error_lists = [];
    
    // ---------------------------------------------------------------------------------------------
    // constructor / destructor
    // ---------------------------------------------------------------------------------------------
    /**
     * ValidationErrorException クラスの新しいインスタンスを初期化します。
     *
     * @param Array $error_lists [初期値=array()] バリデーションのエラーの配列
     */
    public function __construct(array $error_lists = [])
    {
        parent::__construct('Validation error Occurred.');
        $this->setErrorLists($error_lists);
    }
    
    // ---------------------------------------------------------------------------------------------
    // public member methods
    // ---------------------------------------------------------------------------------------------
    /**
     * 発生したバリデーションエラー情報を保持する配列を取得します。
     * 
     * @return Array 発生したバリデーションエラー情報を保持する配列
     */
    public function getErrorLists()
    {
        return $this->error_lists;
    }
    
    // ---------------------------------------------------------------------------------------------
    // private member methods
    // ---------------------------------------------------------------------------------------------
    /**
     * 発生したバリデーションエラー情報を保持する配列を設定します。
     * 
     * @param array $list 発生したバリデーションエラー情報を保持する配列
     */
    private function setErrorLists(array $list)
    {
        $this->error_lists = $list;
    }
}
