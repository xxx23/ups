<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body onLoad="Element.hide(loading);">
	<link rel="STYLESHEET" type="text/css" href="../css/dhtmlXTree.css">
	<script  src="./script/dhtmlXCommon.js"></script>
	<script  src="./script/dhtmlXTree.js"></script>
	<script  src="../script/prototype.js"></script>	
	<div id="loading" style="background-color:#990033;color:#FFFFFF; width:10px;height:30px;">處理中...</div>
	<table>
		<tr>
			<td>
				<div id="treeboxbox_tree" style="width:250; height:600;background-color:#f5f5f5;border :1px solid Silver;; overflow:auto;"/>
			</td>
			<td rowspan="0" style="padding-left:25" valign="top">
				<div id="content" />
			</td>
		</tr>
	</table>
	{literal}
	<script>	
	function tonclick(id){
		//alert("Item "+tree.getItemText(id)+" was selected");
		$('content').innerHTML = "這是" + tree.getItemText(id) + "的教材";
	};
	function tondblclick(id){
		//alert("Item "+tree.getItemText(id)+" was doubleclicked");
		//$('content').innerHTML = "Item "+tree.getItemText(id)+" was doubleclicked";
	};			
	function tondrag(id,id2){
		return confirm("你要移動節點 "+tree.getItemText(id)+" 到 "+tree.getItemText(id2)+"?");
	};
	function tonopen(id,mode){
		//return confirm("Do you want to "+(mode>0?"close":"open")+" node "+tree.getItemText(id)+"?");
	};
	function toncheck(id,state){
		//alert("Item "+tree.getItemText(id)+" was " +((state)?"checked":"unchecked"));
		//$('content').innerHTML = "Item "+tree.getItemText(id)+" was " +((state)?"checked":"unchecked");
	};
	tree=new dhtmlXTreeObject("treeboxbox_tree","100%","100%",0);
	tree.setImagePath("./images/");
	//tree.enableCheckBoxes(1);
	tree.enableDragAndDrop(1);
	//tree.setOnOpenHandler(tonopen);
	tree.setOnClickHandler(tonclick);
	//tree.setOnCheckHandler(toncheck);
	//tree.setOnDblClickHandler(tondblclick);
	tree.setDragHandler(tondrag);			
	tree.loadXML("tree3.xml");			
	</script>
	{/literal}
</body>
</html>
