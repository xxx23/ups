<?php

/**
 * 　MVC Model的 View 的介面
 * @author wewe0901
 */
interface UPS_View_Interface{
    function load();
    function display($template);
    function assign($key,$value);
}
//END OF Interface.php
