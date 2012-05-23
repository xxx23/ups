<?php
/*************************
 **簡易unzip function
 **若不指定解壓縮路徑 $dir , 則會解壓在zip檔的所在資料夾.
 **使用範例 : unzip('/usr/home/study/test/textbook44_scorm1.2.zip','/usr/home/study/test/book/');
 **
 **************************/

	function unzip($zipfile_loc,$dir=false){

		if($dir==false)
			$dir = substr($zipfile_loc,0,strrpos($zipfile_loc,'/')+1);

        if(!is_dir($dir))
        {
            $old_mask = umask(0);
            mkdir($dir, 775);
            umask($old_mask);
        }

		$zip = zip_open($zipfile_loc);
		while($zip_entry = zip_read($zip)) {
			$entry = zip_entry_open($zip,$zip_entry);
			$filename = zip_entry_name($zip_entry);
			$target_dir = $dir.substr($filename,0,strrpos($filename,'/'));
			$filesize = zip_entry_filesize($zip_entry);


			if (is_dir($target_dir) || mkdir($target_dir) ) {
				if ($filesize > 0) {
					$contents = zip_entry_read($zip_entry, $filesize);
					$fp = fopen($dir.$filename,'w+');
					fwrite($fp,$contents);
				}
			}
		}
	}
?>
