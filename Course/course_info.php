<?php
require_once("../config.php");


//對自學式課程顯示的menu_id
$show_menu_list = array('#00','#0005','#000500','#000501','#000502','#000503','#0001','#0006','#0009','#02','#0200','#0201','#0202','#0207','#03','#0300','#030000','#030001','#030002','#0302','#030200','#030201','#030203','#0303','#030300','#030301','#030302','#030303','#030304','#04','#0400','#0401','#05','#0500');
$self_elearn_menu_list_only = array('#09', '#0900', '#0901'); //自學式才有的社群分享功能選單(討論區偽裝而成的社群分享)
$show_menu_list = array_merge($show_menu_list, $self_elearn_menu_list_only);
$ASSISTENT = 2;
function role_visibility($role, $like, $lvl, $stop, $begin_course_cd,$attribute){
	global $ASSISTENT , $show_menu_list, $self_elearn_menu_list_only;
	if($lvl >= $stop)
		return ;

	if( $_SESSION['lang'] != 'zh_tw' && !empty($_SESSION['lang']) ) {//預設為中文，不是則找相對的語言
		if($role != $ASSISTENT)
			$sql = "select A.menu_id, C.menu_name, B.menu_link from `menu_role` A, `lrtmenu_` B , lrtmenu_lang C where A.menu_id=B.menu_id AND B.menu_id=C.menu_id AND C.lang='{$_SESSION['lang']}' and A.role_cd=$role and A.is_used='y' and B.menu_level=$lvl ";
		else
			$sql = "select A.menu_id, C.menu_name, B.menu_link from `menu_role` A, `lrtmenu_` B, lrtmenu_lang C where A.menu_id=B.menu_id AND B.menu_id=C.menu_id AND A.role_cd=$role and A.is_used='y' and A.begin_course_cd=$begin_course_cd and B.menu_level=$lvl ";
	}else {
		if($role != $ASSISTENT)
			$sql = "select A.menu_id, B.menu_name, B.menu_link from `menu_role` A, `lrtmenu_` B  where A.menu_id=B.menu_id and A.role_cd=$role and A.is_used='y' and B.menu_level=$lvl ";
		else
			$sql = "select A.menu_id, B.menu_name, B.menu_link from `menu_role` A, `lrtmenu_` B  where A.menu_id=B.menu_id AND A.role_cd=$role and A.is_used='y' and A.begin_course_cd=$begin_course_cd and B.menu_level=$lvl ";
	}
	
	if($like != null)
		$sql = $sql . "and B.menu_id like '" . $like . "%' ";
	$sql = $sql . "order by B.sort_id, B.menu_id;";

		
    $result = db_query($sql);
	$i = 0;
	$set = array();

    //自學式課程要過濾menus
    if($attribute == 0){
        while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
        if(in_array($row['menu_id'],$show_menu_list)) {
            $set[$i] = $row;
            $set[$i]['next'] = role_visibility($role, $row['menu_id'], $lvl+1, $stop, $begin_course_cd ,$attribute);
            $i++;
          }
        }
    }
   //教導式
    else{
        while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
			/*if( in_array($row['menu_id'], $self_elearn_menu_list_only ) ) {
				continue ; //教導式略過自學式only的menu 
            }*/
            $set[$i] = $row;
            $set[$i]['next'] = role_visibility($role, $row['menu_id'], $lvl+1, $stop, $begin_course_cd ,$attribute);
            $i++;
          }
   }
  return $set;
}

//還沒有xml檔時全部欲設為cheched
function iteration_menu($set){
    //第一層
    for($i = 0 ; $i < count($set) ; $i++){
        $set[$i]['checked'] = 1;
       //第二層
       for($j = 0 ; $j < count($set[$i]['next']) ; $j++){
          $set[$i]['next'][$j]['checked'] = 1;
         //第三層
         for($k = 0 ; $k < count($set[$i]['next'][$j]['next']) ; $k++){
             $set[$i]['next'][$j]['next'][$k]['checked'] = 1;
         }
       } 
    }
  return $set;
}

function personal_visibility($set, $id , $begin_course_cd){
	global $PERSONAL_PATH;
    $dom = new DOMDocument();
    $path = getPersonalPath($id);
	if( file_exists($path . "/{$begin_course_cd}.xml") == false){
        //第一次沒做選擇 所有menu預設全開
        $set = iteration_menu($set);
        return $set;
    }

	$dom->load($path . "/{$begin_course_cd}.xml");

	//return type: DOMNodeList
	$level_0 = $dom->getElementsByTagName("function")->item(0)->childNodes;
	$tmp = recurseMenu($set, $level_0, 0, "course", 3);
	return $tmp;
}

function recurseMenu($set, $params, $lvl, $type, $stop){
	if($lvl >= $stop)
		return ;
	$flag = true;

	$k = 0;
	while(checkNode($params->item($k), $lvl, $type) != 1 && $k < $params->length) $k++;
	if($k == $params->length)
		$flag = false;
	for($i = 0 ; $i < count($set) ; $i++){
		$set[$i]['checked'] = 0;
		if($flag == true && $params->item($k)->attributes->getNamedItem("id")->nodeValue == $set[$i]['menu_id']){
			$set[$i]['next'] = recurseMenu($set[$i]['next'], $params->item($k)->childNodes, $lvl+1, $type, $stop);
			$set[$i]['checked'] = 1;
			$k++;
			while(checkNode($params->item($k), $lvl, $type) != 1 && $k < $params->length) $k++;
			if($k == $params->length)
				$flag = false;
		}
	}

	return $set;
}

function checkNode($param, $level, $str){
	if($param->nodeType != 1)
		return 0;
	if($param->attributes->getNamedItem("level")->nodeValue != $level)
		return 0;
	if($param->attributes->getNamedItem("type")->nodeValue != $str)
		return 0;
	return 1;
}

function setSystemTool($str1, $str2){
	global $set;
	for($i = 0 ; $i < count($set) ; $i++){
		if($set[$i]['menu_name'] == $str1){
			$set[$i]['checked'] = 1;
			$set[$i]['disabled'] = 1;
			for($j = 0 ; $j < count($set[$i]['next']) ; $j++){
				if($set[$i]['next'][$j]['menu_name'] == $str2){
					$set[$i]['next'][$j]['checked'] = 1;
					$set[$i]['next'][$j]['disabled'] = 1;
					break;
				}
			}
			break;
		}
	}
}
?>
