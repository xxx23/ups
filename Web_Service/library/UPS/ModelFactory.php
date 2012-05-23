<?php
/**
 * Description of ModelFactory
 *
 * @author wewe0901
 */
class UPS_ModelFactory {
    protected static $_modelRepository= array();

    public static function createModel($modelName)
    {
        if(!isset(self::$_modelRepository[$modelName]))
        {
            $className = 'UPS_Model_'.$modelName;
            $classFile = 'UPS/Model/'.$modelName.'.php';
            
            if (!class_exists($className)) {
                    require_once  $classFile;
            }

            self::$_modelRepository[$modelName] = new $className();
        }
        return self::$_modelRepository[$modelName];
    }
    
}

?>
