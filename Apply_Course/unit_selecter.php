<?php
	//Function:列出所有單位供選擇
	//File Name:unit_selector.php
	//Modify Date:20090818
	// Modyfy By: q110185

		
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH."config.php");
	//require_once($RELEATED_PATH."session.php");
	
	$thisPage = 'unit_selecter.php';
	$DEBUG = 1;
	$tpl = new Smarty();
	
	//取得所有單位資料 以department作index
	$sql = "SELECT a.unit_cd, a.unit_name, a.department 
			FROM lrtunit_basic_ a 
			WHERE 1 
			ORDER BY a.department ASC";
	
	$result = db_query($sql);
	$unit_tree = array();
	$unit_cnt = 0;
	if($result->numRows()){
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{    
			$index = "".$row['department'];
			$unit_tree[$index][]=$row;
			$unit_cnt++;
		}
	}
	
	//-----for test---------
	//	echo "<div><pre>\n";
	//	var_dump($unit_tree);
	//	echo "</pre></div>\n";
	//-----------------------
	
	//建立結構
	$contentStr = '<ul id="example" class="filetree">';
	$contentStr .='<li><span class="file" onClick ="transferToOpener(\'begin_unit_name\',\'最上層\',\'-1\')">最上層</span></li>';
	if(!empty($unit_tree)){
		foreach($unit_tree['-1'] as $treenode)
		{
            $unit_name = htmlspecialchars($treenode['unit_name']);

			if( count($unit_tree["".$treenode['unit_cd']])>0){
				$contentStr .= '<li class="closed"><span class="folder" onClick ="transferToOpener(\'begin_unit_name\',\''.$unit_name.'\',\''.$treenode['unit_cd'].'\')">'.$unit_name.'</span>';
				$contentStr .= traversal($treenode,$unit_tree);
				$contentStr .= '</li>';
			}else{
				$contentStr.= '<li><span class="file" onClick ="transferToOpener(\'begin_unit_name\',\''.$unit_name.'\',\''.$treenode['unit_cd'].'\')">'.$unit_name.'</span></li>';
			}
		}
	}
	$contentStr .= '</ul>';
	
	//show出
	$tpl->assign("content",$contentStr);
	assignTemplate($tpl, "/course_admin/unit_selecter.tpl");

	function traversal($node,$unit_table)
	{
		$tempStr ='<ul>';
		foreach($unit_table["".$node['unit_cd']] as $treenode)
		{
            $unit_name = htmlspecialchars($treenode['unit_name']);

			if(count($unit_table["".$treenode['unit_cd']])>0)
			{
				$tempStr.='<li class="closed"><span class="folder" onClick ="transferToOpener(\'begin_unit_name\',\''.$unit_name.'\',\''.$treenode['unit_cd'].'\')">'.$unit_name.'</span>';
				$tempStr.= traversal($treenode,$unit_table);
				$tempStr.= '</li>';
			}
			else
				$tempStr .='<li><span class="file" onClick ="transferToOpener(\'begin_unit_name\',\''.$unit_name.'\',\''.$treenode['unit_cd'].'\')">'.$unit_name.'</span></li>';
		}
		$tempStr .= '</ul>';

		return $tempStr;
	}
	
?>

