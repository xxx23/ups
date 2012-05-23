<?php 

/*
File 相關的處理
*/

function FILE_fileType($ext)
{
	$res = 0;
	$extTmp = strtolower( substr($ext, 1) );
	
	switch($extTmp)
	{
	case 'rar':		$res = 1;	break;
	case 'doc':		$res = 2;	break;
	case 'pdf':		$res = 3;	break;
	case 'htm':		$res = 4;	break;
	case 'html':	$res = 5;	break;
	case 'txt':		$res = 6;	break;
	default:		$res = 0;	break;
	}

	return $res;
}

function FILE_upload( $src, $path, $name ) 
{
	$mode = 0755;
	$dst = $path . $name;
	
	//判斷目的地資料夾是否存在
	if( is_dir( $path )  == false)
	{	
		echo $path . " not exits<br>";
		return false;
	}
	//複製檔案到目的地
	if( copy( $src, $dst ) == false)
	{	
		echo "copy fail<br>";
		return false;
	}
	//改變檔案權限
	/*
	if( chmod( $dst, $mode) == false)
	{	
		echo "chmod fail<br>";
		return false;
	}*/
	return true;
}



function FILE_del($path , $file) {

	if( is_dir ( $path ) == false ){
		echo $path . " not exits<br>";
	}
	
	if( file_exists($path.$file) )  {
		@unlink($path.$file);
	}
	else{
		//echo $path . $file . " not this file" ; 
	} 
}

//取出檔案的副檔名 (轉成小寫)
function File_subtype($filename) {
  return strtolower( substr(strrchr($filename,'.'),1) );
}

function SureRemoveDir($dir, $DeleteMe) {
	if(!$dh = @opendir($dir)) return;
	while (($obj = readdir($dh))) {
		if($obj=='.' || $obj=='..') continue;
		if (!@unlink($dir.'/'.$obj)) SureRemoveDir($dir.'/'.$obj, true);
	}
	if ($DeleteMe){
		closedir($dh);
		@rmdir($dir);
	}
}

?>
