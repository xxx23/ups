<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>合作學習</title>

<link rel="StyleSheet" href="{ $webroot }script/nlstree/nlsctxmenu.css" type="text/css" />
<link rel="StyleSheet" href="{ $webroot }script/nlstree/nlstree.css" type="text/css" />
<script language="javascript" src="{ $webroot }script/nlstree/nlstree.js"></script>
<script language="javascript" src="{ $webroot }script/nlstree/nlsctxmenu.js"></script>
<script language="javascript" src="{ $webroot }script/nlstree/nlstreeext_ctx.js"></script>
<script language="javascript" src="{ $webroot }script/nlstree/nlstreeext_sel.js"></script>
<script language="javascript" src="{ $webroot }script/nlstree/nlsconnection.js"></script>
<script language="javascript" src="{ $webroot }script/nlstree/reorder.js"></script>
<script language="javascript" src="{ $webroot }script/nlstree/nlstreeext_dd.js"></script>
<script language="javascript" src="{ $webroot }script/nlstree/nlstreeext_state.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{literal}
<script type="text/javascript">
var tree = new NlsTree("tree1");
function init(hw_no,key, pid){
{/literal}
	tree.opt.mntState = true;
	tree.opt.selRow = true;
	tree.opt.sort = "desc" ;
	tree.opt.editable = true ;
	tree.opt.icAsSel = false;
	tree.add(1, 0, "合作學習選單", "./stu_usage.php?homework_no="+hw_no, "", true);
    	tree.add(2, 1, "分組資訊", "", "", true);
	tree.add(3, 1, "討論資訊", "", "", false);
	tree.add(11,1, "成果資訊", "", "", false);
    	tree.add(4, 1, "評分資訊", "", "", false);
	tree.add(19,1, "參考資訊", "", "", false);
	tree.add(14,1, "題目資訊", "", "", false);
    
	tree.add(5, 2, "分組報名", "./sign_up_form.php?homework_no="+hw_no+"&key="+key, "", false);
	tree.add(6, 2, "專案題目與組員資料", "{ $webroot }Collaborative_Learning/student/stu_group_infos.php?homework_no="+hw_no, "", false);
	
	tree.add(7, 3, "分組討論區", "{ $webroot }Discuss_Area/showDiscussAreaList.php?behavior=student&showType=Group&hw_no=0", "", false);
	tree.add(15, 3, "線上聊天室", "../../../../Chat_Room/index.php?pid="+pid, "", false);
	
	tree.add(9, 4, "組內評分", "{ $webroot }Collaborative_Learning/student/intra_group_score.php?homework_no="+hw_no+"&key="+key, "", false);
	tree.add(10,4, "組間互評", "{ $webroot }Collaborative_Learning/student/inter_group_score.php?homework_no="+hw_no+"&key="+key, "", false);
	
	tree.add(12,11, "成果發表", "{ $webroot }Collaborative_Learning/student/result.php?homework_no="+hw_no+"&key="+key, "", false);
	tree.add(13,2, "任務分配", "{ $webroot }Collaborative_Learning/student/stu_task.php?homework_no="+hw_no+"&key="+key, "", false);
	
	tree.add(21,19, "資源分享", "{ $webroot }Collaborative_Learning/student/relative.php?homework_no="+hw_no+"&key="+key, "", false);
	tree.add(16,19, "檢視分享資訊", "{ $webroot }Collaborative_Learning/relative_show.php?homework_no="+hw_no, "", false);
	
	tree.add(18,11, "檢視各組成果", "{ $webroot }Collaborative_Learning/result_show.php?homework_no="+hw_no+"&key="+key, "", false);
	
	tree.add(20,14, "作業題目屬性", "./question_view.php?homework_no="+hw_no+"&key="+key, "", false);
	tree.setNodeTarget(15,"_blank");
	tree.opt.trg = "textbook";
	tree.setNodeTarget(8, "_blank");
{literal}
}
</script>
{/literal}
</head>

<body>
<script>
  init('{$HW_NO}','{$Key}', '{$pid}');
  //tree.treeOnNodeChange=onNodeChange;
  //tree.renderAttributes();
</script>
<div id="contents">
  <div id="message" style="float:left; width:110px;height:700px;">
	<div><a href="stu_main_page.php"><img src="{$tpl_path}/images/icon/list.gif" />合作學習列表</a></div>
	<div><script>tree.render();</script></div>	
  </div>
</div>

<div id="content" style="float:right; width:65%;">
  <iframe id="textbook" name="textbook" frameborder="0" onload="ResizeIframe(this);" src="./stu_usage.php?homework_no={$HW_NO}"></iframe>
  <!--<p class="al-left"><a href="./tea_usage.php?homework_no={$homework_no}"><img src="{$tpl_path}/images/icon/return.gif" />返回專案首頁</a></p>-->
</div>
<!--<div id="contents" style="width:100%;">
	<div id="nav" style="float:left;width:20%;height:100%;border:1px outset red;">
	a
   	    <div class="area_title" id ="message_title"> </div>
		<div class="area" id="message"><script>tree.render();</script></div>
    </div>
	<div id="content" style="width:100%;border:1px outset red;">
	b
		<iframe id="textbook" name="textbook" frameborder="no" style="" src="http://www.google.com"></iframe>
	</div>
</div>-->
</body>
</html>
