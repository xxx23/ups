<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新增電子報</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />


{literal}

<script type="text/JavaScript">


function display(option){
	document.getElementById("inner_contentA").style.display="none";
	document.getElementById("inner_contentB").style.display="none";
	document.getElementById("inner_contentC").style.display="none";

	if(option == 1){
		document.getElementById("inner_contentA").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabA";
	}
	else if(option == 2){
		//document.getElementById("inner_contentB").style.visibility = "visible";
		document.getElementById("inner_contentB").style.display = "";
		//document.getElementById("_content").style.width = "100%";
		document.getElementsByTagName("body")[0].id = "tabB";
	}
	else{
		//document.getElementById("inner_contentB").style.width = "0%";
		document.getElementById("inner_contentC").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabC";
	//alert(option);
	}
}



function pop(sUrl,sName,sFeature) 
{
	//window.name = 'rootWindow';
	window.remoteWindow = window.open(sUrl,sName,sFeature);
	window.remoteWindow.window.focus();
}


function setContentNumber(num)
{
	target = document.getElementById("contentList");
	target.innerHTML = "";
	for(i=1;i<=num;i++)
	{
	target.innerHTML = target.innerHTML + 
		"\
		標題" + i + ":<input type=\"text\" name=\"title" + i + "\" size=\"40\"><br>\
		內容" + i + ":<textarea name=\"content" + i + "\" cols=\"40\" rows=\"5\"></textarea><br /><br />\
		";
	}
}

function setReleatedLinkNumber(num)
{
	target = document.getElementById("linkList");
	
	target.innerHTML = "";
	for(i=1;i<=num;i++)
	{
	target.innerHTML = target.innerHTML + 
		"\
		連結" + i + "名稱:<input type=\"text\" name=\"releatedLinkName" + i + "\" size=\"10\" value=\"連結" + i + "\"><br />連結" + i + "網址:<input type=\"text\" name=\"releatedLink" + i + "\" size=\"40\"  value=\"http://\"><br /><br />\
		";
	}
}
</script>

{/literal}
<script language="javascript" type="text/javascript" src="{$webroot}script/tiny_mce/tiny_mce.js"></script>

{literal}
<script>
	tinyMCE.init({
		theme : "advanced",
		mode : "exact",
		elements : "web",
		plugins : "spellchecker,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,filemanager,imagemanager",
		theme_advanced_buttons1 : "fontselect,fontsizeselect",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
		content_css : "/example_data/example_full.css",
	    plugin_insertdate_dateFormat : "%Y-%m-%d",
	    plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],p[lang]",
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js",
		template_external_list_url : "example_data/example_template_list.js",
		file_browser_callback : "mcFileManager.filebrowserCallBack",
		theme_advanced_resize_horizontal : false,
		theme_advanced_resizing : true,
		apply_source_formatting : true,
		spellchecker_languages : "+English=en,Danish=da,Dutch=nl,Finnish=fi,French=fr,German=de,Italian=it,Polish=pl,Portuguese=pt,Spanish=es,Swedish=sv"
	});
</script>


<style type="text/css">
li.tabA	{cursor:pointer;}
li.tabB	{cursor:pointer;}
li.tabC	{cursor:pointer;}
</style>

{/literal}

</head>
<body>
<h1>新增電子報</h1>
<div class="tab">
	<ul id="tabnav">
		<li class="tabA" onClick="display(1)">使用內建格式</li>
		<li class="tabB" onClick="display(2)">自行編輯</li>
		<li class="tabC" onClick="display(3)">上傳檔案</li>
	</ul>
</div>

<div class="inner_contentA" id="inner_contentA">
	<table class="datatable">
	<caption>
	請依下列步驟完成您的電子報
	</caption>
	<form method="POST" action="newEPaperSave.php">
	<input type="hidden" name="inputType" value="1">
	<!--
	<tr>
		<td width="140" valign="top">1.電子報底圖</td>
		<td width="360"><font size="2"><input type="text" name="background" value="若欲使用自訂底圖請點選<使用自訂值>並在此欄貼上路徑" size=50 maxlength=128 class=TextField ><BR><input type=radio name='bk' value='1' checked > 使用預設值 &nbsp;<input type=radio name='bk' value='2' > 使用自訂值 &nbsp;<BR>請使用絕對路徑(例: http://image.taconet.com.tw/127x45.gif)</td>
	</tr>
	-->
	<tr>
		<th width="100">1.電子報樣式</th>
		<td>
			<select name="templateNumber">
				<option value="1" selected>樣式1</option>
				<option value="2">樣式2</option>
			</select>
			
			<a href="javascript:pop('templateList.php','remoteWindow','width=550,height=400,scrollbars,resizable')">觀看樣式</a>		</td>
	</tr>
	<tr>
		<th width="100">2.本期主題</th>
		<td><textarea name="topic" cols="40" rows="5"></textarea></td>
	</tr>
	<tr>
		<th width="100">3.本期新聞數目</th>
		<td>
			<select name="contentNumber" onChange="setContentNumber(this.selectedIndex+1);">　
			<option value="1" selected>1</option>
			<option value="2" >2</option>
			<option value="3" >3</option>
			<option value="4" >4</option>
			<option value="5" >5</option>
			<option value="6" >6</option>
			<option value="7" >7</option>
			<option value="8" >8</option>
			<option value="9" >9</option>
			<option value="10" >10</option>
			</select>		</td>
	</tr>
	<tr>
		<th width="100">&nbsp;</th>
		<td><div id="contentList">
	        新聞1標題:            <input type="text" name="title1" size="30">              <br>
            新聞1內容:		    <textarea name="content1" cols="30" rows="5"></textarea>		    
            <br>
		</div>
			</td>
	</tr>
	<tr>
		<th width="100">4.相關連結數目</th>
		<td>
			<select name="releatedLinkNumber" onChange="setReleatedLinkNumber(this.selectedIndex);">　
			<option value="0" >0</option>
			<option value="1" selected>1</option>
			<option value="2" >2</option>
			<option value="3" >3</option>
			<option value="4" >4</option>
			<option value="5" >5</option>
			<option value="6" >6</option>
			<option value="7" >7</option>
			<option value="8" >8</option>
			<option value="9" >9</option>
			<option value="10" >10</option>
			</select>		</td>
	</tr>
	<tr>
		<th width="100">&nbsp;</th>
		<td>
		<div id="linkList">
			連結1名稱:
		      <input type="text" name="releatedLinkName1" size="20" value="連結1">
		      <br />
			網址:
		      <input type="text" name="releatedLink1" size="40" value="http://">
		      <br>
		</div>		</td>
	</tr>

	<tr>
		<th width="100">5.發送日期</th>
		<td>
			<input type="radio" name="if_auto" value="N">不自動發送
			<br>
			<input type="radio" name="if_auto" value="Y" checked>隨日期自動發送
			
			<select name="startYear">
			{section name=counter loop=$yearScope}
			<option value="{$yearScope[counter]}" {if $startYear == $yearScope[counter]} selected {/if}>{$yearScope[counter]}</option>
			{/section}
			</select>年
			
			<select name="startMonth">
			<option value="01" {if $startMonth == '01'} selected {/if}>1</option>
			<option value="02" {if $startMonth == '02'} selected {/if}>2</option>
			<option value="03" {if $startMonth == '03'} selected {/if}>3</option>
			<option value="04" {if $startMonth == '04'} selected {/if}>4</option>
			<option value="05" {if $startMonth == '05'} selected {/if}>5</option>
			<option value="06" {if $startMonth == '06'} selected {/if}>6</option>
			<option value="07" {if $startMonth == '07'} selected {/if}>7</option>
			<option value="08" {if $startMonth == '08'} selected {/if}>8</option>
			<option value="09" {if $startMonth == '09'} selected {/if}>9</option>
			<option value="10" {if $startMonth == '10'} selected {/if}>10</option>
			<option value="11" {if $startMonth == '11'} selected {/if}>11</option>
			<option value="12" {if $startMonth == '12'} selected {/if}>12</option>
			</select>月
			
			<select name="startDay">
			<option value="01" {if $startDay == '01'} selected {/if}>1</option>
			<option value="02" {if $startDay == '02'} selected {/if}>2</option>
			<option value="03" {if $startDay == '03'} selected {/if}>3</option>
			<option value="04" {if $startDay == '04'} selected {/if}>4</option>
			<option value="05" {if $startDay == '05'} selected {/if}>5</option>
			<option value="06" {if $startDay == '06'} selected {/if}>6</option>
			<option value="07" {if $startDay == '07'} selected {/if}>7</option>
			<option value="08" {if $startDay == '08'} selected {/if}>8</option>
			<option value="09" {if $startDay == '09'} selected {/if}>9</option>
			<option value="10" {if $startDay == '10'} selected {/if}>10</option>
			<option value="11" {if $startDay == '11'} selected {/if}>11</option>
			<option value="12" {if $startDay == '12'} selected {/if}>12</option>
			<option value="13" {if $startDay == '13'} selected {/if}>13</option>
			<option value="14" {if $startDay == '14'} selected {/if}>14</option>
			<option value="15" {if $startDay == '15'} selected {/if}>15</option>
			<option value="16" {if $startDay == '16'} selected {/if}>16</option>
			<option value="17" {if $startDay == '17'} selected {/if}>17</option>
			<option value="18" {if $startDay == '18'} selected {/if}>18</option>
			<option value="19" {if $startDay == '19'} selected {/if}>19</option>
			<option value="20" {if $startDay == '20'} selected {/if}>20</option>
			<option value="21" {if $startDay == '21'} selected {/if}>21</option>
			<option value="22" {if $startDay == '22'} selected {/if}>22</option>
			<option value="23" {if $startDay == '23'} selected {/if}>23</option>
			<option value="24" {if $startDay == '24'} selected {/if}>24</option>
			<option value="25" {if $startDay == '25'} selected {/if}>25</option>
			<option value="26" {if $startDay == '26'} selected {/if}>26</option>
			<option value="27" {if $startDay == '27'} selected {/if}>27</option>
			<option value="28" {if $startDay == '28'} selected {/if}>28</option>
			<option value="29" {if $startDay == '29'} selected {/if}>29</option>
			<option value="30" {if $startDay == '30'} selected {/if}>30</option>
			<option value="31" {if $startDay == '31'} selected {/if}>31</option>
			</select>日		</td>
	</tr>

	<tr>
		<td colspan="2"><p class="al-left">
			<input type="submit" value="確定" class="btn"> 
			<input type="reset"  value="清除" name="reset" class="btn"></p>
			<!--
			<input type="button" value="預覽" onclick="act('sea','one','fa80d6036a976d4a58185fd4f84329a4','true')">
			-->		</td>
	</tr>
	</form>
	</table>
</div>
			
<!--------------------------------------------------------------------------->
			
<div class="inner_contentB" id="inner_contentB" style="display:none;"> 

	<table class="datatable">
<caption>請依照下列步驟完成您的電子報</caption>
	<form method="POST" action="newEPaperSave.php">
	<input type="hidden" name="inputType" value="2">
	<tr>
		<th width="100">1.編輯網頁</th>
		<td>
			<textarea name="web" id="web" cols="10" rows="15"></textarea>
		</td>
	</tr>
	<tr>
		<th width="100">2.發送日期</th>
		<td>
			<input type="radio" name="if_auto" value="N">不自動發送
			<br>
			<input type="radio" name="if_auto" value="Y" checked>隨日期自動發送
			
			<select name="startYear">
			{section name=counter loop=$yearScope}
			<option value="{$yearScope[counter]}" {if $startYear == $yearScope[counter]} selected {/if}>{$yearScope[counter]}</option>
			{/section}
			</select>年
			
			<select name="startMonth">
			<option value="01" {if $startMonth == '01'} selected {/if}>1</option>
			<option value="02" {if $startMonth == '02'} selected {/if}>2</option>
			<option value="03" {if $startMonth == '03'} selected {/if}>3</option>
			<option value="04" {if $startMonth == '04'} selected {/if}>4</option>
			<option value="05" {if $startMonth == '05'} selected {/if}>5</option>
			<option value="06" {if $startMonth == '06'} selected {/if}>6</option>
			<option value="07" {if $startMonth == '07'} selected {/if}>7</option>
			<option value="08" {if $startMonth == '08'} selected {/if}>8</option>
			<option value="09" {if $startMonth == '09'} selected {/if}>9</option>
			<option value="10" {if $startMonth == '10'} selected {/if}>10</option>
			<option value="11" {if $startMonth == '11'} selected {/if}>11</option>
			<option value="12" {if $startMonth == '12'} selected {/if}>12</option>
			</select>月
			
			<select name="startDay">
			<option value="01" {if $startDay == '01'} selected {/if}>1</option>
			<option value="02" {if $startDay == '02'} selected {/if}>2</option>
			<option value="03" {if $startDay == '03'} selected {/if}>3</option>
			<option value="04" {if $startDay == '04'} selected {/if}>4</option>
			<option value="05" {if $startDay == '05'} selected {/if}>5</option>
			<option value="06" {if $startDay == '06'} selected {/if}>6</option>
			<option value="07" {if $startDay == '07'} selected {/if}>7</option>
			<option value="08" {if $startDay == '08'} selected {/if}>8</option>
			<option value="09" {if $startDay == '09'} selected {/if}>9</option>
			<option value="10" {if $startDay == '10'} selected {/if}>10</option>
			<option value="11" {if $startDay == '11'} selected {/if}>11</option>
			<option value="12" {if $startDay == '12'} selected {/if}>12</option>
			<option value="13" {if $startDay == '13'} selected {/if}>13</option>
			<option value="14" {if $startDay == '14'} selected {/if}>14</option>
			<option value="15" {if $startDay == '15'} selected {/if}>15</option>
			<option value="16" {if $startDay == '16'} selected {/if}>16</option>
			<option value="17" {if $startDay == '17'} selected {/if}>17</option>
			<option value="18" {if $startDay == '18'} selected {/if}>18</option>
			<option value="19" {if $startDay == '19'} selected {/if}>19</option>
			<option value="20" {if $startDay == '20'} selected {/if}>20</option>
			<option value="21" {if $startDay == '21'} selected {/if}>21</option>
			<option value="22" {if $startDay == '22'} selected {/if}>22</option>
			<option value="23" {if $startDay == '23'} selected {/if}>23</option>
			<option value="24" {if $startDay == '24'} selected {/if}>24</option>
			<option value="25" {if $startDay == '25'} selected {/if}>25</option>
			<option value="26" {if $startDay == '26'} selected {/if}>26</option>
			<option value="27" {if $startDay == '27'} selected {/if}>27</option>
			<option value="28" {if $startDay == '28'} selected {/if}>28</option>
			<option value="29" {if $startDay == '29'} selected {/if}>29</option>
			<option value="30" {if $startDay == '30'} selected {/if}>30</option>
			<option value="31" {if $startDay == '31'} selected {/if}>31</option>
			</select>日		</td>
	</tr>
	<tr>
		<td align="center" colspan="2"><p class="al-left">
					<input type="submit" value="確定" class="btn"> 
			<input type="reset"  value="清除" name="reset" class="btn"></p>
			<!--
			<input type="button" value="預覽" onclick="act('sea','one','fa80d6036a976d4a58185fd4f84329a4','true')">
			-->		</td>
	</tr>
	</form>
  </table>
</div>
	  
<!--------------------------------------------------------------------------->

<div class="inner_contentC" id="inner_contentC" style="display:none;">
	<table class="datatable">
<caption>請依照下列步驟完成您的電子報</caption>
	<form enctype="multipart/form-data" method="POST" action="newEPaperSave.php">
	<input type="hidden" name="inputType" value="3">
	<tr>
		<th width="100">1.選擇網頁檔案</th>
		<td><input type="file" name="file"></td>
	</tr>
	<tr>
		<th width="100">2.發送日期</th>
		<td>
			<input type="radio" name="if_auto" value="N">不自動發送
			<br>
			<input type="radio" name="if_auto" value="Y" checked>隨日期自動發送
			
			<select name="startYear">
			{section name=counter loop=$yearScope}
			<option value="{$yearScope[counter]}" {if $startYear == $yearScope[counter]} selected {/if}>{$yearScope[counter]}</option>
			{/section}
			</select>年
			
			<select name="startMonth">
			<option value="01" {if $startMonth == '01'} selected {/if}>1</option>
			<option value="02" {if $startMonth == '02'} selected {/if}>2</option>
			<option value="03" {if $startMonth == '03'} selected {/if}>3</option>
			<option value="04" {if $startMonth == '04'} selected {/if}>4</option>
			<option value="05" {if $startMonth == '05'} selected {/if}>5</option>
			<option value="06" {if $startMonth == '06'} selected {/if}>6</option>
			<option value="07" {if $startMonth == '07'} selected {/if}>7</option>
			<option value="08" {if $startMonth == '08'} selected {/if}>8</option>
			<option value="09" {if $startMonth == '09'} selected {/if}>9</option>
			<option value="10" {if $startMonth == '10'} selected {/if}>10</option>
			<option value="11" {if $startMonth == '11'} selected {/if}>11</option>
			<option value="12" {if $startMonth == '12'} selected {/if}>12</option>
			</select>月
			
			<select name="startDay">
			<option value="01" {if $startDay == '01'} selected {/if}>1</option>
			<option value="02" {if $startDay == '02'} selected {/if}>2</option>
			<option value="03" {if $startDay == '03'} selected {/if}>3</option>
			<option value="04" {if $startDay == '04'} selected {/if}>4</option>
			<option value="05" {if $startDay == '05'} selected {/if}>5</option>
			<option value="06" {if $startDay == '06'} selected {/if}>6</option>
			<option value="07" {if $startDay == '07'} selected {/if}>7</option>
			<option value="08" {if $startDay == '08'} selected {/if}>8</option>
			<option value="09" {if $startDay == '09'} selected {/if}>9</option>
			<option value="10" {if $startDay == '10'} selected {/if}>10</option>
			<option value="11" {if $startDay == '11'} selected {/if}>11</option>
			<option value="12" {if $startDay == '12'} selected {/if}>12</option>
			<option value="13" {if $startDay == '13'} selected {/if}>13</option>
			<option value="14" {if $startDay == '14'} selected {/if}>14</option>
			<option value="15" {if $startDay == '15'} selected {/if}>15</option>
			<option value="16" {if $startDay == '16'} selected {/if}>16</option>
			<option value="17" {if $startDay == '17'} selected {/if}>17</option>
			<option value="18" {if $startDay == '18'} selected {/if}>18</option>
			<option value="19" {if $startDay == '19'} selected {/if}>19</option>
			<option value="20" {if $startDay == '20'} selected {/if}>20</option>
			<option value="21" {if $startDay == '21'} selected {/if}>21</option>
			<option value="22" {if $startDay == '22'} selected {/if}>22</option>
			<option value="23" {if $startDay == '23'} selected {/if}>23</option>
			<option value="24" {if $startDay == '24'} selected {/if}>24</option>
			<option value="25" {if $startDay == '25'} selected {/if}>25</option>
			<option value="26" {if $startDay == '26'} selected {/if}>26</option>
			<option value="27" {if $startDay == '27'} selected {/if}>27</option>
			<option value="28" {if $startDay == '28'} selected {/if}>28</option>
			<option value="29" {if $startDay == '29'} selected {/if}>29</option>
			<option value="30" {if $startDay == '30'} selected {/if}>30</option>
			<option value="31" {if $startDay == '31'} selected {/if}>31</option>
			</select>日		</td>
	</tr>
	<tr>
		<td align="center" colspan="2"><p class="al-left">
			<input type="submit" value="確定" class="btn"> 
			<input type="reset"  value="清除" name="reset" class="btn"></p>
			<!--
			<input type="button" value="預覽" onclick="act('sea','one','fa80d6036a976d4a58185fd4f84329a4','true')">
			-->		</td>
	</tr>
	</form>
  </table> 
</div>	
</body>
</html>
