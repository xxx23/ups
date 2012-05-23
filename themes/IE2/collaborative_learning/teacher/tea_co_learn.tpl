<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>合作學習</title>

<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlstree.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlsctxmenu.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlstreeext_ctx.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlstreeext_sel.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlsconnection.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/reorder.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlstreeext_dd.js"></script>
<script language="javascript" src="{$webroot}script/nlstree/nlstreeext_state.js"></script>

<link rel="StyleSheet" href="{$webroot}script/nlstree/nlsctxmenu.css" type="text/css" />
<link rel="StyleSheet" href="{$webroot}script/nlstree/nlstree.css" type="text/css" />

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
{literal}
<script>
var tree = new NlsTree("tree1");
function init(hw_no,key, pid){
	tree.opt.mntState = true;
	tree.opt.selRow = true;
	tree.opt.editable = true ;
	tree.opt.sort = "desc" ;
	tree.opt.icAsSel = false;
	//tree.setNodeTarget(15,"_top");
	tree.add(1, 0, "合作學習選單", "./tea_usage.php?homework_no="+hw_no, "", true);
    tree.add(2, 1, "題目資訊", "", "", true);
    tree.add(3, 1, "分組資訊", "", "", false);
	tree.add(4, 1, "成果資訊", "", "", false);
	tree.add(5, 1, "討論資訊", "", "", false);
    tree.add(6, 1, "評分資訊", "", "", false);
	tree.add(7, 1, "參考資訊", "", "", false);
	
	tree.add(8, 2, "新增專案題目", "./new_project_content.php?homework_no="+hw_no+"&key="+key+"&n=1", "", false);
	tree.add(9, 2, "檢視與修改專案屬性", "./modify_project_data.php?homework_no="+hw_no+"&key="+key, "", false);
	
	tree.add(10, 3, "已分組名單", "./tea_grouped_list.php?homework_no="+hw_no+"&key="+key, "", false);
	tree.add(11, 3, "未分組名單", "./tea_un_grouped_list.php?homework_no="+hw_no, "", false);
	tree.add(12, 3, "教師分組介面", "./tea_group_mgt.php?homework_no="+hw_no+"&key="+key, "", false);
    
	tree.add(13, 4, "檢視各組成果", "../result_show.php?homework_no="+hw_no+"&key="+key, "", false);
	
	tree.add(14, 5, "分組討論區", "../../Discuss_Area/showDiscussAreaList.php?behavior=teacher&showType=Group&hw_no="+hw_no, "", false);
	tree.add(15, 5, "線上聊天室", "../../Chat_Room/index.php?pid="+pid, "", false);
	tree.add(16, 6, "以組為單位評分", "./tea_group_score.php?homework_no="+hw_no+"&key="+key, "", false);
	tree.add(17, 6, "以個人為單位評分", "./tea_person_score.php?homework_no="+hw_no+"&key="+key, "", false);
	tree.add(18, 6, "評分結果", "./tea_score_result.php?homework_no="+hw_no+"&key="+key, "", false);
	
	tree.add(19, 7, "檢視分享資訊", "../relative_show.php?homework_no="+hw_no, "", false);
	/*tree.add(20, 7, "檢視學生時程表", "", "", false);*/
	
	tree.add(21, 2, "檢視與修改專案題目", "./modify_project.php?homework_no="+hw_no+"&key="+key, "", false);
	
	tree.setNodeTarget(15,"_blank");
	/*tree.add(21, 4, "作業繳交狀況", "", "", false);*/
	tree.opt.trg = "textbook";
}
</script>
{/literal}
</head>

<body class="ifr">
<script>
  init('{$HW_NO}','{$Key}', '{$pid}');
  //tree.treeOnNodeChange=onNodeChange;
  //tree.renderAttributes();
</script>
<div id="contents">
  <div id="message" style="float:left; width:110px;height:1000px;">
    <div class="al-left"><a href="./tea_main_page.php"><img src="{$tpl_path}/images/icon/list.gif">合作學習列表</a></div>  
    <div> <script>tree.render();</script></div>
  </div></div>
  
  <div id="content" style="float:right; width:65%;">
   <iframe id="textbook" name="textbook" frameborder="0" onload="ResizeIframe(this);" src="./tea_usage.php?homework_no={$HW_NO}">
   </iframe>
<!--<p class="al-left"><a href="./tea_usage.php?homework_no={$homework_no}"><img src="{$tpl_path}/images/icon/return.gif">返回專案首頁</a></p>-->
   <!--<iframe id="textbook" name="textbook" frameborder="0" height="500" width="500" src="./tea_usage.php?homework_no={$HW_NO}">
   </iframe>-->
  </div>
</div>
</body>
</html>
