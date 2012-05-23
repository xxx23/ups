<?php
/* author: lunsrot
 * data: 2007/03/20
 */
require_once("../config.php");
require_once("../session.php");

$ASSISTENT = 2;

$pid = $_SESSION['personal_id'];
$role = $_SESSION['role_cd'];
$view = $_GET['view'];

if($view == "true"){
	$tpl = new Smarty;

	$tmp = role_visibility($role, null, 0, 3);
	$set = personal_visibility($tmp ,$pid);
	//為了保證無論如何使用者都可以看到功能設定此一選項
	setSystemTool("系統工具", "功能設定");
	$tpl->assign("level_0", $set);

	assignTemplate($tpl, "/personal_page/function.tpl");
}else{
	$f = fopen("../file/personal/$pid.xml", "w");
	fwrite($f, "<function>\n");

	/*因有三層選單，對應三層迴圈*/
	$level_0 = $_GET['menu_0'];
	for($i = 0 ; $i < count($level_0) ; $i++){
		fwrite($f, "<menu level=\"0\" type=\"course\" id=\"$level_0[$i]\">\n");
		$level_1 = $_GET[ 'menu_' . $level_0[$i] ];
		for($j = 0 ; $j < count($level_1) ; $j++){
			fwrite($f, "\t<menu level=\"1\" type=\"course\" id=\"$level_1[$j]\">\n");
			$level_2 = $_GET[ 'menu_' . $level_1[$j] ];
			for($k = 0 ; $k < count($level_2) ; $k++)
				fwrite($f, "\t\t<menu level=\"2\" type=\"course\" id=\"$level_2[$k]\"/>\n");
			fwrite($f, "\t</menu>\n");
		}
		fwrite($f, "</menu>\n");
	}
	fwrite($f, "</function>");

	fclose($f);
  exec("chmod 664 ../file/personal/$pid.xml");
}

function role_visibility($role, $like, $lvl, $stop){
  global $ASSISTENT;
  if($lvl >= $stop)
    return ;

  if($role != $ASSISTENT){
    $sql = "select A.menu_id, B.menu_name 
      from `menu_role` A, `lrtmenu_` B
      where A.menu_id=B.menu_id
      and A.role_cd=$role 
      and B.menu_level=$lvl ";
    if($like != null)
	$sql = $sql . "and B.menu_id like '" . $like . "%' ";
    $sql = $sql . "order by B.menu_id;";

    $result = db_query($sql);
    $i = 0;
    $set = array();
    while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
      $set[$i] = $row;
      $set[$i]['next'] = role_visibility($role, $row['menu_id'], $lvl+1, $stop);
      $i++;
    }
  }
  else{
  }

  return $set;
}

function personal_visibility($set, $id){
  $dom = new DOMDocument();
  if( file_exists("../file/personal/$id.xml") == false)
    return $set;
  $dom->load("../file/personal/$id.xml");

  //return type: DOMNodeList
  $level_0 = $dom->getElementsByTagName("function")->item(0)->childNodes;
  $tmp = recurseMenu($set, $level_0, 0, "course", 3);
  return $tmp;
}

function recurseMenu($set, $params, $lvl, $type, $stop){
  if($lvl >= $stop)
    return ;

  $k = 0;
  while(checkNode($params->item($k), $lvl, $type) != 1 && $k < $params->length) $k++;
  for($i = 0 ; $i < count($set) ; $i++){
    $set[$i]['checked'] = 0;
    if($params->item($k)->attributes->getNamedItem("id")->nodeValue == $set[$i]['menu_id']){
      $set[$i]['next'] = recurseMenu($set[$i]['next'], $params->item($k)->childNodes, $lvl+1, $type, $stop);
      $set[$i]['checked'] = 1;
      $k++;
      while(checkNode($params->item($k), $lvl, "course") != 1 && $k < $params->length) $k++;
      if($k == $params->length)
	$k = $k-2;
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
      for($j = 0 ; $j < count($set[$i]['next']) ; $j++){
	if($set[$i]['next'][$j]['menu_name'] == $str2){
	  $set[$i]['next'][$j]['checked'] = 1;
	  break;
	}
      }
      break;
    }
  }
}
?>
