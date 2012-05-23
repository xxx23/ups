<?php
/**
 * 課程管理系統的使用者登入資訊
 * @author wewe0901
 */
class UserIdentity
{
    /**
     *使用者 編號 (唯一)
     * @var int
     */
    public $no;

    /**
     *使用者分類 0 1 2 3 a b c可以參照 UPS/Model/ApiKeyUser.php裡的定義
     * @var string
     */
    public $category;

    /**
     *
     * @param int $no
     * @param string $category
     */
   public function __construct($no,$category)
   {
       $this->no = $no;
       $this->category = $category;
   }
}
//END OF UserIdentity.php
