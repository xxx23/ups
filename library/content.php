<?php

	//從開課編號拿到對應的教材編號
	function get_Content_cd($begin_course_cd) {
		$get_content_cd = "SELECT content_cd FROM class_content_current "
		." WHERE begin_course_cd= $begin_course_cd" ; 
		$result = db_query($get_content_cd);
		if($result->numRows() == 1) {
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			return $row['content_cd'];
		}else {
			return 0;
		}
	}
	
	//拿到教材所屬的老師ID
	function get_Teacher_id($content_cd) {
		$get_personal_id = "SELECT teacher_cd FROM course_content "
		." WHERE content_cd=$content_cd" ; 
		$result = db_query($get_personal_id);
		if($result->numRows() == 1) {
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			return $row['teacher_cd'];
		}else {
			return 0;
		}
	}

	//同步隨選視訊的symbolic link  
	//ex: /Data_File/vedio/content_name -> Streaming/personal_id/content_id 
	function sync_content_mediaStreaming_link($teacher_id)
	{
		global $DATA_FILE_PATH, $MEDIA_FILE_PATH;
		
	  	if($teacher_id == 0) 
			return ;

		//找出資料庫有的對應
		$get_teacher_contents = "SELECT content_name , content_cd FROM course_content where teacher_cd=".$teacher_id ; 
		$result = db_query($get_teacher_contents);
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$dir_links[ $row['content_name'] ] = $row['content_cd'];	
		}
		
		// get symbol links 
		$vedio_symbol_path = $DATA_FILE_PATH . $teacher_id . '/video/' ; 
		createPath($vedio_symbol_path);// make sure path exists 
	
		//全砍光
		if( is_dir($vedio_symbol_path) ) {
			$d = dir($vedio_symbol_path);
			while (false !== ($entry = $d->read())) {
				if(is_link($vedio_symbol_path.$entry)){
					unlink($vedio_symbol_path.$entry);
				}
			}
			$d->close();
		}
		
		//重建新的
		if( !empty($dir_links) ) {
		foreach($dir_links as $ln_name => $tar_dir) {
		  	$target_path = $MEDIA_FILE_PATH . $teacher_id . '/';
			$target_file = $target_path . $tar_dir ; 
            if( !file_exists($target_path) && is_writeable($target_path) ) {
                $old_mask = umask(0);
                mkdir($target_file, 775);
                umask($old_mask);
			}
			symlink($target_path, $vedio_symbol_path.$ln_name) ; 
			}
		}
		
	}
	
?>
