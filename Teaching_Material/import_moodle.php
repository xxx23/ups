<?php
	/*author: lunsrot
	 * date: 2008/03/07
	 */
	require_once("../config.php");
	require_once("../session.php");

	require_once("../library/unzip.php");
	require_once("lib/textbook_mgt_func.inc");

	checkMenu("/Teaching_Material/import_moodle.php");

	$input = $_POST;
	if(empty($input['option']))
		$input['option'] = "view";
	call_user_func($input['option'], $input);

	//template
	function view($input){
		$tpl = new Smarty;
		assignTemplate($tpl, "/teaching_material/import_moodle.tpl");
	}

	//function
	function import($input){
		$teacher_cd = getTeacherId();
		$n = db_getOne("SELECT COUNT(*) FROM `course_content` WHERE teacher_cd=$teacher_cd AND content_name='$input[material_name]';");
		if($n != 0){
			well_print("教材名稱重複");
			exit;
		}

		db_query("INSERT INTO `course_content` (content_name, teacher_cd, difficulty, content_type, is_public)
			VALUES
			('$input[material_name]', $teacher_cd, '0', '0', '0');");
		$content_cd = db_getOne("SELECT content_cd FROM `course_content` WHERE content_name='$input[material_name]' AND teacher_cd=$teacher_cd;");
		$parent = insert_class_content($content_cd, 0, $input['material_name'], -1);

		$path = unrar_file($input['material_name']);
		$name = $path . "moodle.xml";
		if(!file_exists($name)){
			well_print("檔案有誤");
			exit;
		}
		$dom = new DOMDocument();
		$dom->load($name);
		$s_list = $dom->getElementsByTagName("SECTION");
		$modules = $dom->getElementsByTagName("MODULES")->item(0);
		//for each section in tag <SECTIONS>
		//每一次迴圈是匯入一個章節
		//這裡的程式碼寫的很爛，望有學弟能幫忙改得好看一點
		for($i = 1 ; $i < $s_list->length ; $i++){
			$tmp = $s_list->item($i);
			$number = get_number($tmp->childNodes);
			$title = trim(strip_tags(get_title($tmp->childNodes)));

			if($number == -1){
				well_print("why $i");
				continue;
			}

			//產生放教材index.html的資料夾
			$new_path = $path . "第" . $i . "週_" . $title;
			createPath($new_path);

			//將教材資料寫入資料庫中
			insert_class_content($content_cd, $parent, "第" . $i . "週_" . $title, 0);

			//需同時改變index的最外層，並將html, head, body, ul等標籤寫入，然後再取得ul的物件，
			//暫時不知如何以函式實作
			$index = new DOMDocument();

			$html = $index->createElement("HTML");
			$index->appendChild($html);

			$head = $index->createElement("HEAD");
			$html->appendChild($head);

			$body = $index->createElement("BODY");
			$html->appendChild($body);
			$ul = $index->createElement("UL");

			if(($mods = has_MODS($tmp->childNodes)) != false){
				$resource = return_resources($mods, $modules);
				for($j = 0 ; $j < count($resource) ; $j++){
					$li = $index->createElement("LI");
					$ul->appendChild($li);
					if($resource[$j]['type'] == 1){
						$a = $index->createElement("A", $resource[$j]['name']);
						$a->setAttribute("href", $resource[$j]['content']);
						$li->appendChild($a);
					}else if($resource[$j]['type'] == 2){
						$a = $index->createElement("A", $resource[$j]['name']);
						$a->setAttribute("href", "../course_files/" . $resource[$j]['content']);
						$li->appendChild($a);
					}else{
						$li->appendChild($index->createTextNode($resource[$j]['content']));
					}
				}
				$body->appendChild($ul);
			}
			$index->saveHTMLFile($new_path . "/index.html");
		}
	   
		header("location:./import_done.php?option=moodle");
	}

	//library
	//將上傳的壓縮檔解開至教師的個人資料夾底下，並回傳資料夾位置(包括資料夾名稱)
	//這裡打錯字了，應為zip
	function unrar_file($fname){
		global $DATA_FILE_PATH, $PERSONAL_PATH;
		$pid = getTeacherId();
		$path = $PERSONAL_PATH . $pid . "/";
		$name = $_FILES['material']['name'];
		if(file_exists($path . $name))
			unlink($path . $name);
		createPath($DATA_FILE_PATH . $pid . "/textbook/" . $fname);
		FILE_upload($_FILES['material']['tmp_name'], $path, $name);
		unzip("$path$name", "$DATA_FILE_PATH$pid/textbook/$fname/");
		unlink($path . $name);
		return "$DATA_FILE_PATH$pid/textbook/$fname/";
	}

	//library
	//先假設<NUMBER>處於第四個Child node，若以後有問題再修改
	//參數：<SECTION>的child node list，type是DOMNodeList
	//從<SECTION>中回傳<NUMBER>的值
	function get_number($list){
		$t = $list->item(3);
		$i = $t->nodeValue;
		if(empty($i))
			return -1;
		return $i;
	}

	//library
	//先假設<SUMMERY>處於第六個Child node，若以後有問題再修改
	//參數：<SECTION>的child node list，type是DOMNodeList
	//從<SECTION>中回傳<SUMMARY>的值
	function get_title($list){
		$t = $list->item(5);
		return $t->nodeValue;
	}

	//library
	function has_MODS($list){
		for($i = 0 ; $i < $list->length ; $i++)
			if($list->item($i)->nodeName == "MODS")
				return $list->item($i);
		return false;
	}

	//library
	function return_resources($node, $modules){
		$output = array();
		$mod_list = $node->childNodes;
		for($i = 0 ; $i < $mod_list->length ; $i++){
			$tmp = $mod_list->item($i);
			if($tmp->nodeName != "MOD")
				continue;
			$instance = get_instance($tmp->childNodes);
			$element = get_resourse($instance, $modules);
			if($element['type'] != -1)
				array_push($output, $element);
		}
		return $output;
	}

	//library
	function get_instance($list){
		$t = $list->item(5);
		return $t->nodeValue;
	}

	//library
	//type 1: link, 2: file, 3:text
	function get_resourse($instance, $modules){
		$list = $modules->childNodes;
		$output = array();
		for($i = 0 ; $i < $list->length ; $i++){
			$tmp = $list->item($i);
			if($tmp->nodeName != "MOD" || $instance != $tmp->childNodes->item(1)->nodeValue)
				continue;
			$mod_list = $tmp->childNodes;
			$output['name'] = $mod_list->item(5)->nodeValue;
			if($mod_list->item(7)->nodeValue == "text"){
				$output['type'] = 3;
				$output['content'] = $mod_list->item(13)->nodeValue;
			}else if(is_hyperlink($mod_list->item(9)->nodeValue)){
				$output['type'] = 1;
				$output['content'] = $mod_list->item(9)->nodeValue;
			}else{
				$output['type'] = 2;
				$output['content'] = $mod_list->item(9)->nodeValue;
			}
			return $output;
		}
		$output['type'] = -1;
		return $output;
	}

	//library
	function is_hyperlink($string){
		if(ereg(".*http:\/\/.*", $string))
			return true;
		return false;
	}

	//library
	function insert_class_content($content_cd, $parent, $value, $index){
		$menu_id = get_max_menu_id();
		$seq = ret_new_textbook_seq($parent, $content_cd);
		db_query("insert into `class_content` (content_cd, menu_id, menu_parentid, caption, file_name, seq) values ($content_cd, '$menu_id', '$parent', '$value', '$value', $seq);");
		if($index == -1){
			db_query("update `class_content` set url='tea_start.php?content_cd=$content_cd', exp='1', icon='' where menu_id='$menu_id';");
		}else{
			db_query("update `class_content` set url='tea_textbook_content.php?content_cd=$content_cd&menu_id=$menu_id', exp='0', icon='/script/nlstree/img/folder.gif' where menu_id='$menu_id';");
		}
		return $menu_id; 
	}
?>
