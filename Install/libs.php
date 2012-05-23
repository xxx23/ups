<?php 

global $PATHS; 
global $HOME_PATH ; //from config.php 
global $DO_EXEC ; 

$DO_EXEC = true ; 
$DEBUG_MODE = false ; 
$PATHS = array('/usr/local/bin/', '/usr/local/php/bin/', '/usr/bin/', '/bin/');

$MYSQL_DEFAULT_SCHEMA = $HOME_PATH."Install/Schema/schema_all.sql";
$MYSQL_DEFAULT_DATA = $HOME_PATH."Install/Schema/data_all.sql";


function debug_exec($cmd)
{
    global $DO_EXEC, $DEBUG_MODE ; 

    if($DO_EXEC) {
        exec($cmd, $output);
        if($DEBUG_MODE) {
            print($output);
        }
    }
}

function get_utility_path($utility_name, $path) {

	$exe_path = "";
	
	// check if path is array , it can pass as string
	if( empty($path) )
		return $utility_name;
		
		
	if( !is_array($path) && is_string($path)){
		$target_path = array($path);
	}else 	
		$target_path = $path ; 
		
	foreach($target_path as $item_path) { 
		if(is_executable($item_path.$utility_name) ) {
			$exe_path = $item_path.$utility_name; 
			break;
		}
	}
	
	// if not found the utility in path 
	if(	empty($exe_path) )
		$exe_path = $utility_name;
	
	return $exe_path;
}
?>
