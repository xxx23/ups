<?php

require_once 'UPS/View/Interface.php';
/**
 *  UPS的view為smarty故使用Smaty實作View
 * @author wewe0901
 */
class UPS_View_SmartyView implements UPS_View_Interface
{
    /**
     *
     * @var Smarty
     */
    protected $_smarty;

    /**
     * 設定smarty使用原有UPS設定的smaty_init.php這支檔案
     *
     * @global string $HOME_PATH
     * @global string $HOMEURL
     */
    function load()
    {
        global $HOME_PATH;
        global $HOMEURL;
        //目前平台是用smarty 由於多國語系的功能所以要 include smarty_init.php
        require_once 'smarty_init.php';

        if(empty($tpl))
            throw new Exception('Error Loading Samrty Template');

        $this->_smarty = $tpl;
        $this->_smarty->assign('homeurl',$HOMEURL);
    }
    /**
     * 輸入view會用到的變術
     * @param string $key
     * @param mixed $value
     */
    function assign($key,$value)
    {
        $this->_smarty->assign($key,$value);
    }
    /**
     * 利用 輸入的template顯示
     * @param string $template
     */
    function display($template)
    {
        assignTemplate($this->_smarty,$template);
    }
}
// END OF SmartyView.php
