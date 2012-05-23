<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>課程大綱</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<script src="{$webroot}script/default.js"></script>
<script src="{$webroot}script/prototype.js" type="text/javascript" ></script>
<script language="javascript" type="text/javascript" src="{$webroot}script/tiny_mce_new/tiny_mce.js"></script>
<script type="text/javascript" src="{$webroot}script/editor_simple.js"></script>

<script language="JavaScript" type="text/JavaScript">
<!--
{literal}

tinyMCE.init({
	mode:"textareas",
	theme: "simple",
	content_css:"tinymce_content.css",
	plugins:"table, searchreplace, media",
	language:"zh_tw_utf8"
});

//initTunyMCE();
var serverAddress = 'update_textarea.php';
var tmpContent; //暫存 用

function submitTextArea(divNode, delTextNode){

	var node_id = divNode.id;
	var content;

	var tmpNode = divNode.getElementsByTagName('textarea')[0].firstChild;
	
	//alert(tmpNode.parentNode.innerHTML);
	
	//if( tmpNode != null){
		//content = tmpNode.nodeValue;
		tinyMCE.execCommand('mceFocus', false, 'content'+node_id); 
		//tinyMCE.getInstanceById('content'+node_id);
		content = tinyMCE.getContent();     	
		tinyMCE.execCommand('mceRemoveControl', false, 'content'+node_id);			
		
//	}
	//else{
		//content = '';	
	//}	
	tmpContent = content;			
	
	//alert(tmpContent);
	
	
	
	var parms = 'target='+node_id+'&content='+encodeURIComponent(content);//content;//encodeURIComponent(content);
	if(delTextNode != null)
		delTextNode.removeNode(true);		//刪除textNode
	var ajaxQ = new Ajax.Request(serverAddress,
								 {method:'post',
								  postBody: parms,
								  onComplete: updateDiv
								 });		
}

function closeTextArea(node, content){
	if(confirm("你剛剛所編寫的資料，將不會寫入，你確定放棄嗎？")){
		while(node.firstChild) node.removeChild(node.firstChild);
		//建立div內的內容	
		//node.appendChild(document.createTextNode(divContent));
		//node.appendChild(document.createTextNode(content));
		node.innerHTML = content;
	}
}

function updateDiv(res){
	//var response = res.responseText;
	//alert(response);
	var responseXML = res.responseXML;
	var xmlDoc = responseXML.documentElement;
	var divId = xmlDoc.getElementsByTagName('id')[0].firstChild.nodeValue;
	//var divContent = xmlDoc.getElementsByTagName('content')[0].firstChild.nodeValue;
	//取得div
	var node = document.getElementById(divId);
	//清除div內的東西
	while(node.firstChild) node.removeChild(node.firstChild);
	//建立div內的內容	
	//node.appendChild(document.createTextNode(divContent));
	//var tmpC= tmpContent.innerHTML;
	//node.appendChild(document.createTextNode(tmpContent.innerHTML));	
	node.innerHTML = tmpContent;
}



function createTextArea(obj, div_name){
	var textNode ,content;
	if(obj.firstChild != null){
		//textNode = obj.firstChild; //先取得div裡的textNode
		//content = textNode.nodeValue; //暫存舊的資料			
		//content = textNode.nodeValue; 	
		content = obj.innerHTML;
		//obj.innerHTML = "";
		while(obj.firstChild) obj.removeChild(obj.firstChild);
		//alert(obj.innerHTML);
		//textNode.nodeValue = ""; //第一節點內容設空
		//textNode.innerHTML = "";
	}
	else{	
		content = '';
	}
	
	//tmpContent = ;
	var node = document.createElement('div');
	node.setAttribute('id', 'node-' + div_name);
	var textAreaNode = document.createElement('textarea');
	textAreaNode.setAttribute("id", "content"+div_name);	
	textAreaNode.setAttribute("value", content);	
	textAreaNode.setAttribute("cols", 70);
	textAreaNode.setAttribute("rows", 20);
	var brNode = document.createElement('br');
	
	var buttonNode = document.createElement('input');
	buttonNode.setAttribute('type','button');
	buttonNode.setAttribute('className','btn');
	buttonNode.setAttribute('value','確定修改');
	buttonNode.onclick = function(){submitTextArea(node, textNode);};
	var cancelNode = document.createElement('input');
	cancelNode.setAttribute('type','button');
	cancelNode.setAttribute('className','btn');
	cancelNode.setAttribute('value','放棄修改');
	cancelNode.onclick = function(){closeTextArea(obj, content);};	
	
	node.appendChild(brNode);
	node.appendChild(textAreaNode);
	node.appendChild(brNode);	
	node.appendChild(buttonNode);
	node.appendChild(cancelNode);	
	obj.appendChild(node);
	
	tinyMCE.execCommand('mceAddControl', false, 'content'+div_name);
	//tinyMCE.setContent(content);
//tinyMCE.updateContent(this.id);
}

function checkFirstClick(obj){
	if(obj.getElementsByTagName('textarea').length != 0)
		return false;
	else
		return true;	
}

function edit(id){
	var div_name = "div_" + id;	
	var obj = document.getElementById(div_name);
	if(checkFirstClick(obj))
		createTextArea(obj, id);	
}
{/literal}
//-->
</script>
</head>

<body class="ifr">

<!--<p class="address">目前所在位置: <a href="#">首頁</a> &gt;&gt; <a href="#">課程</a> &gt;&gt; <a href="#">課程說明</a> &gt;&gt; <a href="#">課程介紹</a>&gt;&gt;&gt; <a href="#">大綱</a></p>
-->
<h1>編輯課程大綱</h1>
<p class="intro">
說明：<br />
按下<span class="imp">編輯</span>的按鈕可以<strong>進行編輯</strong>。 <br />
如果輸入的空間太小，在每個輸入的地方的右下角，可以拉大輸入範圍。
<br/>上傳課程大綱檔案宜為html、htm檔(以純文字為佳)
</p>

<span>
  <form action="" method="post" enctype="multipart/form-data">
   上傳課程大綱: <input type="file" name="userfile" size=16>
     <input type="submit" value="上傳" onclick="document.getElementById('ACTION').value='upload';">
     <input type="hidden" name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" value="40960">
     <input type="hidden" name="ACTION" id="ACTION" value="">
     <input type="submit" value="刪除上傳檔案" onclick="document.getElementById('ACTION').value='del';">
     {if $msg == "upload success"}
	<span class="imp">上傳成功</span>
     {elseif $msg == "upload failed"}
	<span class="imp">上傳失敗</span>
     {elseif $msg == "del success"}
	<span class="imp">刪除成功</span>
     {elseif $msg == "del failed"}
	<span class="imp">刪除失敗</span>
     {/if}
  </form>
    
</span>
{if $info_file != ""}
<iframe onload= "ResizeIframe(this)" src="{$info_file}"  frameborder="0"  scrolling="no"></iframe>
{else}
<div class="tab">
  <ul id="tabnav">
    <li class="tabA"><a href="#future">宗旨</a></li>
    <li class="tabA"><a href="#introduction">課程簡介</a></li>
    <li class="tabA"><a href="#goal">教學目標</a></li>
    <li class="tabA"><a href="#person_mention">教授簡介</a></li>
    <li class="tabA"><a href="#course_process">課程進行方式</a></li>
	<li class="tabA"><a href="#learning_test">評量標準</a></li>
	<li class="tabA"><a href="#environment">軟硬體與介面說明</a></li>
  </ul>
</div>
<!-- 課程宗旨-->
<div class="form">
	<a name="future"></a>
	<h1>課程宗旨</h1>
	<span class="buttons">
	<input type="button" class="btn" value="編輯" onClick="edit('future');" />
	</span>		
	<br />
	<pre><div id="div_future" style="width:95%;">{$course_future}</div></pre>
</div>
<br />
<!-- 課程簡介-->

<div  class="form">
	<a name="introduction"></a>
	<h1>課程簡介</h1>
	<span class="buttons">
	<input type="button" class="btn" value="編輯" onClick="edit('introduction');" />
	</span>
	<br />
	<pre><div id="div_introduction">{$course_introduction}</div><pre>
</div>
<br />
<!-- 課程目標-->

<div  class="form">
	<a name="goal"></a>
	<h1>課程目標</h1>
	<span class="buttons">
	<input type="button" class="btn" value="編輯" onClick="edit('goal');" />	
	</span>
	<br />
	<pre><div id="div_goal">{$course_goal}</div></pre>
</div>
<br />
<!-- 教授簡介-->

<div  class="form">
	<a name="person_mention"></a>
	<h1>教授簡介</h1>
	<span class="buttons">
	<input type="button" class="btn" value="編輯" onClick="edit('person_mention');" />
	</span>
	<br />
	<pre><div id="div_person_mention">{$person_mention}</div></pre>
	</div>
<br />
<!-- 課程進行方式-->

<div  class="form">
	<a name="course_process"></a>
	<h1>課程進行方式</h1>
	<span class="buttons">
	<input type="button" class="btn" value="編輯" onClick="edit('course_process');" />
	</span>
	<br />
	<pre><div id="div_course_process">{$course_process}</div></pre>
</div>
<br />
<!-- 評量標準-->
<div  class="form">
	<a name="learning_test"></a>
	<h1>評量標準</h1>
	<span class="buttons">
	<input type="button" class="btn" value="編輯" onClick="edit('learning_test');" />
	</span>
	<br />
	<pre><div id="div_learning_test">{$learning_test}</div></pre>
</div>
<br />
<!-- 軟硬體介面說明-->
<div class="form">
	<a name="environment"></a>
	<h1>軟硬體介面說明</h1>
	<span class="buttons">
	<input type="button" class="btn" value="編輯" onClick="edit('environment');" />
	</span>	
	<br />
	<pre><div id="div_environment">{$course_environment}</div></pre>
</div>				 
<!--</table>-->
{/if}
</body>
</html>
