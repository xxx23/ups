<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>開課類別</title>	
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script src="../script/prototype.js" type="text/javascript"></script>
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
<link href="css/course.css" rel="stylesheet" type="text/css" />

<script>
<!--
{literal}
var MAX_SELECTION = 10;
var suggestMenu;
var addrQuery;
var serverAddress="validate_unit_basic.php";
var showErrors = true; 
var cache = new Array();
function init()
{
	suggestMenu = new Menu('suggestMenu','selAddr', 'choose_addr', "son", "soff" );
	addrQuery ="";
}
function setFocus()    
{
	$('unit_cd').focus();
}	
function choose_addr(id)
{
	var tmpStr = suggestMenu.get_content(id);
	var tmpArray = tmpStr.split("(");
	if(tmpArray.length > 1){
		$('txtAddr').value = tmpArray[0];
		$('txtZoneCd').value = tmpArray[1].slice(0,-1);
	}else{
		$('txtAddr').value = tmpStr;
	}
	Element.hide('selAddr');
}

function showResultAddr(req)
{
	if(req.responseText.length > 0){
		var addList = req.responseText.split('\n').without('\r','\n','');
		Element.hide('loadingGif');
		if(addList.length == 0)
			return;
		Element.show('selAddr');
		suggestMenu.clear();
		for(var w=0; w < Math.min(addList.length, MAX_SELECTION); w++){
				suggestMenu.add_item(addList[w]);
		}
		suggestMenu.highlight(0);
	}
	setTimeout("Element.hide('loadingGif');", 10000);
}

function readResponse(req)
{
	var response = req.responseText;
	if (response.indexOf("ERRNO") >= 0 || response.indexOf("error:") >= 0|| response.length == 0)
		throw(response.length == 0 ? "Server error." : response);
	responseXml = req.responseXML;
	xmlDoc = responseXml.documentElement;
	result = xmlDoc.getElementsByTagName("result")[0].firstChild.data;
	fieldID = xmlDoc.getElementsByTagName("fieldid")[0].firstChild.data;
	errorMsg = xmlDoc.getElementsByTagName("msg")[0].firstChild.data;
	message = $(fieldID + "Failed");
	message.className = (result == "0") ? "error" : "hidden";
	message.innerHTML = errorMsg; 
	setTimeout("validate();", 500);
}

function keySelect(e){
	if(e.keyCode == Event.KEY_TAB || e.keyCode == Event.RETURN || e.keyCode== 13){
		var sel = suggestMenu.get_current_content();
		if(sel!='')
			$('txt_Addr').value = sel;
	}else if(e.keyCode == 38){
		suggestMenu.sel_prev();
	}else if(e.keyCode == 40){
		suggestMenu.sel_next();
	}
}

function queryAddr()
{
	var user_input = $F('txt_Addr');
	if(user_input.length > 0 && addrQuery != user_input){
		addrQuery = user_input;
		var parms = 'prefix='+encodeURIComponent(user_input);
		var ajaxQ = new Ajax.Request(serverAddress,
									 {method:'get',
									  parameters: parms,
									  onComplete: showResultAddr
									 });
		Element.show('loadingGif');
	}
}

function displayError($message)
{
  if (showErrors)
  {
    showErrors = false;
    alert("Error encountered: \n" + $message);
    setTimeout("validate();", 10000);
  }
}

function validate(inputValue, fieldID)
{
	if (fieldID)
	{
	  inputValue = encodeURIComponent(inputValue);
	  fieldID = encodeURIComponent(fieldID);
	  cache.push("inputValue=" + inputValue + "&fieldID=" + fieldID);
	}
	try
	{
		if(cache.length > 0){
			var cacheEntry = cache.shift();
			var ajaxQ = new Ajax.Request(serverAddress,
										 {method:'post',
										  parameters: cacheEntry,
										  onComplete: readResponse
										 });
		}
	}
	catch (e)
	{
	  displayError(e.toString());
	}	
}
function openSelectWin()
{
	var w = window.open("unit_selecter.php","child","width=150,height=200,toolbar=0,location=0");
	w.focus();
}
{/literal}  
-->
</script>

</head>
<body class="ifr" onload="setFocus();" >
<h1>開課類別
  <br />
  <!-- form -->
</h1>
<div class="button001" style="align:right;"><a href="dep_list.php">所有開課類別</a></div><br/><div class="describe" style="margin-bottom:6px;">新增開課類別,請輸入類別名稱及所屬類別(若為最上層則填最上層即可)
<br/>
點選所屬類別，會跳出視窗顯示所有單位，點選任一單位，可新增子類別至該單位下。
</div>
<form name="frmRegistration" method="post" action="{$actionPage}">
<!-- name -->
<div class="searchbar" style="margin-left:50px;width:80%;padding:20px;"><table class="datatable">
<!--
<tr>
	<th width="30%"><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>系所編號</th>
	<td><input id="unit_cd" name="unit_cd" type="text" value="{$ValueOfUnit_cd}" onblur="validate(this.value, this.id);">			
	<div id="unit_cdFailed" class="{$unit_cdFailed}">格式錯誤或此欄空白</div>	</td>
</tr>
-->
<tr>
	<th width="30%"><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>類別名稱</th>
	<td bgcolor="#F5F5F5"><input id="unit_name" name="unit_name" type="text" value="{$ValueOfUnit_name}" onblur="validate(this.value, this.id);">	
	<div id="unit_nameFailed" class="{$unit_nameFailed}">格式錯誤或此欄空白</div>	</td>
</tr>
<!--
<tr>
	<th width="30%"><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>系所英文名稱</th>
	<td><input id="unit_abbrev" name="unit_abbrev" type="text" value="{$ValueOfUnit_abbrev}">
	<div id="unit_abbrevFailed" class="{$unit_abbrevFailed}" >格式錯誤或此欄空白</div>	</td>
</tr>
<tr>
	<th width="30%"><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>系所簡稱</th>
	<td>
	<input id="unit_e_name" name="unit_e_name" type="text" value="{$ValueOfUnit_e_name}">
	<div id="unit_e_nameFailed" class="{$unit_e_nameFailed}" >格式錯誤或此欄空白</div>	</td>	
</tr>
<tr>
	<th width="30%"><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>系所英文簡稱</th>
	<td><input id="unit_e_abbrev" name="unit_e_abbrev" type="text" value="{$ValueOfUnit_e_abbrev}">
	<div id="unit_e_abbrevFailed" class="{$unit_e_abbrevFailed}" >格式錯誤或此欄空白</div>	</td>	
</tr>
-->
<tr>
	<th width="30%"><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>所屬類別</th>
	<td bgcolor="#F5F5F5">
	<input id="begin_unit_name" name="begin_unit_name" type="text" readonly="readonly" value="{$ValueOfBegin_unit_cd}" onClick="openSelectWin()" onblur="validate(this.value, this.id);"/>
     <span id="departmentFailed" class="{$departmentFailed}">格式錯誤或此欄空白</span>
	<input id="department" name = "department" value = "-1" type="hidden">
	<!--<select name="department">
	{html_options values=$department_ids selected=$department_id output=$department_names}
	</select><div id="departmentFailed" class="{$departmentFailed}" >格式錯誤或此欄空白</div>		-->	</td>
</tr>	
</table></div>	
<p class="al-left"><input type="submit" name="submitbutton" value="確定送出" /></p>
</form>
<br/><br/><br/><br/>	
</body>
</html>
