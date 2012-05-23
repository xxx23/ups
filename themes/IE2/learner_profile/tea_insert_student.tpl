<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>無標題文件</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<link href="../Registration/css/register.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../script/prototype.js"></script>
<script type="text/javascript" src="../script/menu.js"></script>

<script language="JavaScript" type="text/JavaScript">
<!--
{literal}
var serverAddress="query_student.php";
var cur_id;
var MAX_SELECTION = 10;
var suggest_id, suggest_name;
var tmpQuery;

function init()
{
	//suggest_id = new Menu('suggest_id','login_id_sel', 'choose', "son", "soff" );
	//suggest_name = new Menu('suggest_name','personal_name_sel', 'choose', "son", "soff" );
	tmpQuery ="";
}

function showFormat(){
	var div = document.getElementById('format');
	if(div.style.display == "")
		div.style.display = "none";
	else
		div.style.display = "";	
}

function display(option){
	document.getElementById("inner_contentA").style.display="none";
	document.getElementById("inner_contentB").style.display="none";

	if(option == 1){
		document.getElementById("inner_contentA").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabA";
	}
	else if(option == 2){
		document.getElementById("inner_contentB").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabB";
	}
}

function check(obj){

	var id = document.getElementById('login_id');
	var name = document.getElementById('personal_name');
	//alert(id);
	if( id.value == '' || name.value == '' ){
		alert("請填妥帳號姓名");
		return false;
	}
	else{
		return true;
	}
}
	
function choose(id)
{
	var tmpStr;
	if(cur_id=='personal_name'){
		tmpStr = suggest_name.get_content(id);
	}else if(cur_id='login_id'){
		tmpStr = suggest_id.get_content(id);
	}
	
	var tmpArray = tmpStr.split("-");
	if(tmpArray.length > 1){
		document.getElementById('login_id').value = tmpArray[0];
		document.getElementById('personal_name').value = tmpArray[1];
	}else{
		document.getElementById('login_id').value = tmpStr;
	}
	//$('txtAddr').value = suggestMenu.get_content(id);
	//Element.hide('selAddr');
	document.getElementById(cur_id+"_sel").style.display='none';
	//queryAddr();
	suggest_id = null;
	suggest_name = null;
	tmpQuery ="";	
}


function showResult(req){

	if(cur_id == 'login_id'){
		suggest_id = new Menu('suggest_id','login_id_sel', 'choose', "son", "soff" );
		if(req.responseText.length > 0){
			var addList = req.responseText.split('\n').without('\r','\n','');
			document.getElementById(cur_id+"_load").style.display="none";
			//Element.hide('loadingGif');
			if(addList.length == 0)	return;
			document.getElementById(cur_id+'_sel').style.display="";
			suggest_id.clear();
			for(var w=0; w < Math.min(addList.length, MAX_SELECTION); w++){
					suggest_id.add_item(addList[w]);
			}
			suggest_id.highlight(0);
		}
		setTimeout("document.getElementById(cur_id+'_load').style.display='none';", 10000);	
	
	}else if(cur_id == 'personal_name'){	
		suggest_name = new Menu('suggest_name','personal_name_sel', 'choose', "son", "soff" );
		if(req.responseText.length > 0){
			var addList = req.responseText.split('\n').without('\r','\n','');
			document.getElementById(cur_id+"_load").style.display="none";
			//Element.hide('loadingGif');
			if(addList.length == 0)	return;
			document.getElementById(cur_id+'_sel').style.display="";
			suggest_name.clear();
			for(var w=0; w < Math.min(addList.length, MAX_SELECTION); w++){
					suggest_name.add_item(addList[w]);
			}
			suggest_name.highlight(0);
		}
		setTimeout("document.getElementById(cur_id+'_load').style.display='none';", 10000);	
	}
	
	tmpQuery = '';	
}

function keySelect(id ,e){

	if(id=='login_id'){
	
		if(e.keyCode == Event.KEY_TAB || e.keyCode == Event.RETURN || e.keyCode== 13){
			var sel = suggest_id.get_current_content();
			if(sel!='')
				document.getElementById(id).value = sel;
		}else if(e.keyCode == 38){
			suggest_id.sel_prev();
		}else if(e.keyCode == 40){
			suggest_id.sel_next();
		}
	
	}else if(id=='personal_name'){
	
		if(e.keyCode == Event.KEY_TAB || e.keyCode == Event.RETURN || e.keyCode== 13){
			var sel = suggest_name.get_current_content();
			if(sel!='')
				document.getElementById(id).value = sel;
		}else if(e.keyCode == 38){
			suggest_name.sel_prev();
		}else if(e.keyCode == 40){
			suggest_name.sel_next();
		}	
	
	}	
}

function query(id , e)
{
	var user_input = $F(id);
	cur_id = id;
	if(user_input.length > 0 && tmpQuery != user_input){
		tmpQuery = user_input;
		var parms = 'action='+cur_id+'&prefix='+encodeURIComponent(user_input);

		
		var ajaxQ = new Ajax.Request(serverAddress,
									 {method:'get',
									  parameters: parms,
									  onComplete: showResult
									 });
		//Element.show('loadingGif');
		document.getElementById(cur_id+"_load").style.display='';
	}
}

{/literal}
-->
</script>
</head>

<body onload="init();" class="{$body_tab}">
<!--
<p class="address">目前所在位置: <a href="#">首頁</a> &gt;&gt; <a href="#">課程</a> &gt;&gt; <a href="#">學生管理</a> &gt;&gt; <a href="#">新增學生(檔案匯入)</a></p>
-->
<div class="tab">
	<ul id="tabnav">
		<li class="tabA" onClick="display(1)">匯入學生</li>			
		<li class="tabB" onClick="display(2)">新增單筆資料</li>	
	</ul>
</div>

<!-- 標題 -->

<div id="inner_contentA" {$style_display_A}>
<!-- 內容說明 -->

	<p class="intro">
	說明：<br />
	1. 檔案上傳請<span class="imp">符合格式</span>。<input type="button" class="btn" onClick="showFormat();" value="按此看格式" /><br />
	2. 新增的學生帳號，<span class="imp">密碼</span>預設跟<span class="imp">帳號</span><strong>相同</strong>。<br />
	<!--
    3. <span class="imp">本系統已與教務系統完全整合，教師無需再手動匯入</span>
    -->
    3. 身份別請用數字代表，如下：<br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0:一般民眾<br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1:國中小教師<br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2:高中職教師<br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3:大專院校學生<br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4:大專院校教師<br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5:數位機會中心輔導團隊講師<br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;6:縣市政府研習課程老師<br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;7:其它<br/>
    4. 身份別可寫在檔案內，亦可使用下拉式選單選擇。<span class="imp">兩者同時存在時，會以檔案內的身份別為主。</span><br>
    5. 若學生帳號已存在，選取身份別並不能更改學生的身份。<br/>
    6. 匯入檔案格式的副檔名以.txt (純文字)檔為主。<br>
	</p>
	<div id="format" style="display:none;" class="from">
	<input type="button" class="btn" onClick="showFormat();" value="關閉" /><br />
	請記得帳號、姓名與身份別之間用<span class="imp"> , </span>隔開 <br />
	結尾用<span class="imp">#</span>
		<div style="width:50%">
		<table class="datatable">
		<tr><th>帳號,</th><th>姓名,</th><th>身份別</th></tr>
		<tr><td>student1 ,</td><td>學生1,</td><td>0#</td></tr>
		<tr><td>student2 ,</td><td>學生2,</td><td>0#</td></tr>
		<tr><td>.</td><td>.</td><td>.</td></tr>
		<tr><td>.</td><td>.</td><td>.</td></tr>
		<tr><td>.</td><td>.</td><td>.</td></tr>
		<tr><td>studentN ,</td><td>學生N,</td><td>0#</td></tr>
		</table>
		</div>
	</div>

	<h1>新增學生(檔案匯入)</h1>	
	<!--功能部分 -->
	<form method="post" action="./tea_insert_student.php?action=doupload" enctype="multipart/form-data">
	<table class="datatable">
	<tr>
		<th>正修/旁聽</th>
		<td>
			<select name="status_student">
				<option value="0">旁聽生</option>
				<option value="1" selected>正修生</option>
			</select>
		</td>		
	</tr>
	<tr>
		<th>上傳匯入檔</th>
		<td><input type="file" name="upload_file" class="btn" /></td>
	</tr>
    <tr>
    <th>學生身份別</th>
    <td>
    <select id="student_dist" name="student_dist">
    <option value="-1">請選擇</option>
    <option value="0">一般民眾</option>
    <option value="1">國中小教師</option>
    <option value="2">高中職教師</option>
    <option value="3">大專院校學生</option>
    <option value="4">大專院校教師</option>
    <option value="5">數位機會中心輔導團隊講師</option>
    <option value="6">縣市政府研習課程老師</option>
    <option value="7">其它</option>
    </select>
    </td>
    </tr>
	</table>
	<br />
	<input type="submit" class="btn" name="submitButton" value="確定匯入" />
	</form>
	
	<div style="width:80%;">  <!-- 限制大小 -->
	<table class="datatable">
	<caption>新增成功的帳號</caption>
	<tr>
		<th>帳號</th>
		<th>姓名</th>
	
	</tr>
	{foreach from=$success item=success}
	<tr class="{cycle values="tr2,"}" >
		<td>{$success.id}</td>
		<td>{$success.name}</td>
	</tr>
	{/foreach}
	</table>
	
	<br/>
	
	<table class="datatable">
	<caption>新增<span class="imp">失敗</span>的帳號</caption>
	<tr >
		<th>帳號</th>
		<th>姓名</th>
		<th>匯入失敗原因</th>	
	</tr>
	{foreach from=$failed item=failed}
	<tr class="{cycle values="tr2,"}" >
		<td>{$failed.id}</td>
		<td>{$failed.name}</td>	
		<td>{$failed.reason}</td>	
	</tr>
	{/foreach}
	</table>
	</div>
</div>
<br /><br /><br /><br />
<!-- position:absolute; -->
<div id="inner_contentB" {$style_display_B} >
	<h1>新增一位學生</h1>
	<!--功能部分 -->
	<form method="post" action="./tea_insert_student.php?action=insertOne" onSubmit="return check(this);" >
	<table class="datatable">
	<tr>
		<th>正修/旁聽</th>
		<td>
			<select name="status_student">
				<option value="0">旁聽生</option>
				<option value="1" selected>正修生</option>
			</select>
		</td>		
	</tr>	
	<tr>
		<th>帳號</th>
		<td>
		<div>
		<!--<input type="text" name="login_id" id="login_id" autocomplete="off" onkeydown="query(this.id, event); keySelect(this.id, event);" />-->
		<input type="text" name="login_id" id="login_id"/>		
		<span id="login_id_load" style="display:none;">
		<img src="{$tpl_path}/images/icon/proceeding.gif"/>
		</span>				
		</div>
		<div class="datatable" id="login_id_sel" style="display:none; position:absolute;"></div>			
		</td>
	</tr>
	<tr>
		<th>姓名</th>
		<td>
		<div>
		<!--<input type="text" name="personal_name" id="personal_name" autocomplete="off" onkeydown="query(this.id, event); keySelect(this.id, event);" />-->
		<input type="text" name="personal_name" id="personal_name" />
		<span id="personal_name_load" style="display:none;">
		<img src="{$tpl_path}/images/icon/proceeding.gif"/>
		</span>				
		</div>
		<div class="datatable" id="personal_name_sel" style="display:none; position:absolute;"></div>			
		</td>
	</tr>
    <tr>
    <th>身份別</th>
    <td>
    <select id="student_dist" name="student_dist">
    <option value="-1">請選擇</option>
    <option value="0">一般民眾</option>
    <option value="1">國中小教師</option>
    <option value="2">高中職教師</option>
    <option value="3">大專院校學生</option>
    <option value="4">大專院校教師</option>
    <option value="5">數位機會中心輔導團隊講師</option>
    <option value="6">縣市政府研習課程老師</option>
    <option value="7">其它</option>
    </select>
    </td>
    </tr>	
	</table>
    <font color="red">若學生帳號已存在，選擇身份別將不能修改學生原本的身份。</font><br/>
	<input type="reset"  class="btn" value="清除資料" />
	<input type="submit" class="btn" value="確定新增" />
	</form>
	<br />
	<div class="imp">
		{$message}
	</div>				
</div>

<br /><br /><br /><br />
<br /><br /><br /><br />


</body>
</html>
