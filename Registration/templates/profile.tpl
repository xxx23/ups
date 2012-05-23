<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../themes/IE2/css/font_style.css" rel="stylesheet" type="text/css" />
<title>填寫個人基本資料</title>	  
<link href="css/register.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../script/menu.js"></script>	

<script type="text/javascript" src="script/jQuery/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="script/jQuery/js/jquery-ui-1.7.1.custom.min.js"></script>
<link type="text/css" href="script/jQuery/css/ui-lightness/jquery-ui-1.7.1.custom.css" rel="Stylesheet" />
<script type="text/javascript" src="script/jQuery/development-bundle/ui/i18n/ui.datepicker-zh-TW.js"></script>
<script type="text/javascript">
  var jQuery=$;
</script>

<style type="text/css">
{literal}
.mytable th{
	font-size:10pt;
	text-align: center;

	border-width: 1px;
        border-top-style: solid;
        border-right-style: solid;
        border-bottom-style: solid;
        border-left-style: solid;

        border-top-color: gray;
        border-right-color: gray;
        border-bottom-color: gray;
        border-left-color: gray;

}
.mytable td{
	font-size:10pt;
	text-align: left;

	border-width: 1px;
        border-top-style: solid;
        border-right-style: solid;
        border-bottom-style: solid;
        border-left-style: solid;

        border-top-color: gray;
        border-right-color: gray;
        border-bottom-color: gray;
        border-left-color: gray;

}
{/literal}
</style> 
<script>
{literal}

     jQuery(document).ready(function(){
	jQuery('#txtbornDate').datepicker({
			 inline: true,
			 changeMonth: true,
			 changeYear: true 
	});
    jQuery("#txtID");
    jQuery(""
    });


     function showpicker(){
	jQuery('#txtbornDate').focus();
     }


{/literal}
</script>
<!--為了要避免與prototype.js發生衝突,必須要alias jQuery以及將prototype.js放在jQuery之後-->
<script type="text/javascript" src="../script/prototype.js"></script>
<script type="text/javascript" src="script/passwordstrength.js"></script>
<script type="text/javascript">
<!--
{literal}
var MAX_SELECTION = 10;
var suggestMenu;
var addrQuery;
var serverAddress="validateProfile.php";
var showErrors = true; 
var cache = new Array();

function init()
{
	suggestMenu = new Menu('suggestMenu','selAddr', 'choose_addr', "son", "soff" );
	addrQuery ="";
}
/*function setFocus()    
{
	$('txtName').focus();
}*/	
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
	//$('txtAddr').value = suggestMenu.get_content(id);
	Element.hide('selAddr');
	//queryAddr();
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
	//alert(fieldID);
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

function disableEnterKey(e){
	if(e.keyCode == Event.KEY_TAB || e.keyCode == Event.RETURN || e.keyCode== 13)
		return false;
	else
		return true;	 	
}  

//重新assign頁面時保留目前scroll bar位置
function setPosCookies (){
var scrollX, scrollY;

  // 儲存Scrollbar的位置 (x, y)
  if (document.all){
    if (!document.documentElement.scrollLeft)
      scrollX = document.body.scrollLeft;
    else
      scrollX = document.documentElement.scrollLeft;
    if (!document.documentElement.scrollTop)
      scrollY = document.body.scrollTop;
    else
      scrollY = document.documentElement.scrollTop;
  }else{
    scrollX = window.pageXOffset;
    scrollY = window.pageYOffset;
  }

  // 設定 Cookie, 名稱為頁面 http://yyyy/XXXX.php => 取XXXX用
  var url = document.location.href;
  var x_name = url.substring(url.lastIndexOf('/')+1, url.lastIndexOf('.')) + "scrollX";
  var y_name = url.substring(url.lastIndexOf('/')+1, url.lastIndexOf('.')) + "scrollY";
  setCookie(x_name, scrollX);
  setCookie(y_name, scrollY);
}

function setCookie(c_name,value,expiredays){
  // 不指定expire date, 則離開browser, cookie即失效
  var exdate = new Date();
  exdate.setDate(exdate.getDate()+expiredays);
  document.cookie = c_name+ "=" +escape(value)+
    ((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}

function getCookie(c_name){
  if (document.cookie.length>0){
    c_start=document.cookie.indexOf(c_name + "=");
    if (c_start!=-1){
      c_start=c_start + c_name.length+1;
      c_end=document.cookie.indexOf(";",c_start);
      if (c_end==-1) { c_end=document.cookie.length;}
      return unescape(document.cookie.substring(c_start,c_end));
    }
  }
  return "";
}

function checkCookie(){
  // 取得 Cookie => (x, y)座標
  var url = document.location.href;
  var x_name = url.substring(url.lastIndexOf('/')+1, url.lastIndexOf('.')) + "scrollX";
  var y_name = url.substring(url.lastIndexOf('/')+1, url.lastIndexOf('.')) + "scrollY";
  var x = getCookie(x_name);
  var y = getCookie(y_name);
  if (y == null || y == "") { y = 0;}
  if (x == null || x == "") { x = 0;}
  window.scrollTo(0, y)
}

window.onscroll = setPosCookies;
window.onkeypress = setPosCookies;
window.onclick = setPosCookies;



//reassign page
function checkSelect(obj){	
	var   myForm=document.forms['frmRegistration'];  	
	myForm.action='profile.php';  
	myForm.method='POST'; 
        myForm.submit();  
        if (obj.value !=-1 ){
            document.getElementById(obj.id+'Failed').style.display='none';
        }
        return;
}


{/literal}
-->
</script>


</head>

<body bgcolor="#ffffff" onLoad="checkCookie();init();">
<p align="center"><img src="../images/registration/step2.jpg" width="475" height="119"></p>
<table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
   <td width="23"><img src="../images/registration/spacer.gif" width="23" height="1" border="0" alt=""></td>
  <td width="899"><img src="../images/registration/spacer.gif" width="607" height="1" border="0" alt=""></td>
  <td width="10"><img src="../images/registration/spacer.gif" width="7" height="1" border="0" alt=""></td>
   <td width="22"><img src="../images/registration/spacer.gif" width="22" height="1" border="0" alt=""></td>
   <td width="4"><img src="../images/registration/spacer.gif" width="4" height="1" border="0" alt=""></td>
  </tr>
  <tr>
   <td width="23" background="images/registration/001_r2_c4.jpg"><img name="n001_r2_c2" src="../images/registration/001_r2_c2.jpg" width="23" height="36" border="0" alt=""></td>
   <td colspan="2" width="100%" background="../images/registration/001_r2_c4.jpg"><img name="n001_r2_c3" src="../images/registration/003_r2_c3.jpg" width="607" height="36" border="0" alt=""></td>
   <td><img name="n001_r2_c5" src="../images/registration/001_r2_c5.jpg" width="22" height="36" border="0" alt=""></td>
   <td><img name="n001_r2_c6" src="../images/registration/001_r2_c6.jpg" width="4" height="36" border="0" alt=""></td>
  </tr>
  <tr>
   <td width="23" background="../images/registration/001_r3_c2.jpg">&nbsp;</td>
   <td colspan="2"><center>

  <!-- form -->
  <form name="frmRegistration" method="post" action="validateProfile.php?validationType=php" onKeyPress=" return disableEnterKey(event);" >
<table class="mytable" >
 
<!--*姓名 -->
 <tr>
     <th width="200">
 	*姓名
     </th>
     <td>
	 <input id="txtName" name="txtName" type="text" onBlur="validate(this.value, this.id);" value="{$valueOfName}" />
	 <span id="txtNameFailed" class="{$txtNameFailed}" >此欄空白</span>      
     </td>
</tr>



<!--*身分 -->
  <tr>
     <th>
        *身分
     </th>
     <td>
		{if $role_type == 3}{* 學生 *} 
			<select id="selRole" name="selRole" onLoad="checkSelect(this);" onChange="checkSelect(this);" length="30">
				<option value="-1" {if $selRole eq -1} selected {/if}>請選擇</option>
				<option value="0" {if $selRole eq 0} selected {/if}>一般民眾</option>
				<option value="1" {if $selRole eq 1} selected {/if}>國民中小學教師</option>
				<option value="2" {if $selRole eq 2} selected {/if}>高中職教師</option>
				<option value="3" {if $selRole eq 3} selected {/if}>大專院校學生</option>
				<option value="4" {if $selRole eq 4} selected {/if}>大專院校教師</option>
			</select> 
		{/if}
		{if $role_type == 1}{* 教師 *} 
			<select id="selRole" name="selRole" onLoad="checkSelect(this);" onChange="checkSelect(this);" length="30">
				<option value="-1" {if $selRole eq -1} selected {/if}>請選擇</option>
				<option value="4" {if $selRole eq 4} selected {/if}>大專院校教師</option>
				<option value="5" {if $selRole eq 5} selected {/if}>數位機會中心輔導團隊講師</option>
                <option value="6" {if $selRole eq 6} selected {/if}>縣市政府研習課程老師</option>
                <option value="7" {if $selRole eq 7} selected {/if}>其他(教育部承辦人)</option>
			</select> 
		{/if}
		
            {if $selRole eq -1 }<span id="selRoleFailed" ><font color="red">請選擇</font></span>{/if}
		
     </td>
  </tr>	

<!--職稱-->
{if $selRole == 1 || $selRole == 2}
  <tr>
     <th>
        *職稱
     </th>
     <td>
	    <select id="title" name="title"  onLoad="checkSelect(this);" onChange="checkSelect(this);" length="30">
	       <option value="-1"{if $title eq -1} selected {/if}>請選擇</option>
	       <option value="0" {if $title eq 0} selected {/if}>一般教師</option>
	       <option value="1" {if $title eq 1} selected {/if}>主任</option>
	       <option value="2" {if $title eq 2} selected {/if}>校長</option>
            </select>
            {if $title eq -1 }<span id="titleFailed" ><font color="red">請選擇</font></span>{/if}
     </td>
  </tr>	
{/if}

<!--暱稱 -->
 <tr>
    <th>
        暱稱
    </th>
    <td>
        <input id="txtNickname" name="txtNickname" type="text"  value="{$valueOfNickname}" />      
    </td>
</tr>



<!-- *身份證或護照號碼-->
  <tr>
     <th>*身分證字號/護照號碼</th>
     <td>
          <input type="radio" id = "idorpas1" name="idorpas" value = "0" {if $idorpas eq 0} checked {/if}  onclick="checkSelect(this);">身分證
	  <input type="radio" id = "idorpas2" name="idorpas" value = "1" {if $idorpas eq 1} checked {/if}  onclick="checkSelect(this)";>護照號碼
	  <!--要是身份證顯示-->	
	  {if $idorpas == 0}
	  <input id="txtID" name="txtID" type="text" onBlur="validate(this.value, this.id);" value="{$valueOfID}" />
          <span id="txtIDFailed" class="{$txtIDFailed}" >格式錯誤或此欄空白</span>     
	  <!--要是護照號碼顯示-->
	  {elseif $idorpas == 1}	
	  <input id="txtpassport" name="txtpassport" type="text" onBlur="validate(this.value, this.id);" value="{$valueOfpassport}" />
          <span id="txtpassportFailed" class="{$txtpassportFailed}" >格式錯誤或此欄空白</span>   
	  {/if}
      <div align="center"><font color="red">(身分證字號乃作為個人身分識別用，包括教師研習時數登記，<br/>請勿使用他人之身分證字號，以免觸法。)</font></div>
     </td>	
  </tr>


<!-- *教師證號 --> 
{if $selRole == 1 || $selRole == 2}
 <tr>
     <th>
 	 教師證字號
     </th>
     <td>
	 <input id="txtTeachDoc" name="txtTeachDoc" type="text" onBlur="validate(this.value, this.id);" value="{$valueOfTeachDoc}" />
	 <span id="txtTeachDocFailed" class="{$txtTeachDocFailed}" ><!--此欄空白--></span>      
     </td>
</tr>
{/if}



<!--*性別 --> 
<tr>
    <th>*性別</th>
	  <td>
	    <input id="selGender_male" name="selGender" type="radio"  value="1" {if $valueOfGender eq 1}checked{/if} />男
	    <input id="selGender_female" name="selGender" type="radio"  value="0" {if $valueOfGender eq 0}checked{/if} />女
	 </td>
</tr>


<!--*身分別 -->
{if $selRole == 0}
<tr>
    <th>
        *身分別
    </th>
    <td> &nbsp;(請勾選較為符合您的身分之選項)<br>
         <input type="radio" name="familysite" onClick="checkSelect(this);" {if $familysite eq 0} checked {/if} value = "0">臺灣閩南人&nbsp;
         <input type="radio" name="familysite" onClick="checkSelect(this);" {if $familysite eq 1} checked {/if} value = "1">臺灣客家人&nbsp;
         <input type="radio" name="familysite" onClick="checkSelect(this);" {if $familysite eq 2} checked {/if} value = "2">臺灣原住民&nbsp;
         <input type="radio" name="familysite" onClick="checkSelect(this);" {if $familysite eq 3} checked {/if} value = "3">新住民&nbsp;
         <input type="radio" name="familysite" onClick="checkSelect(this);" {if $familysite eq 4} checked {/if} value = "4">大陸各省市&nbsp;<br>
         <input type="radio" name="familysite" onClick="checkSelect(this);" {if $familysite eq 5} checked {/if} value = "5">其他國家&nbsp;&nbsp;
	 {if $familysite eq 5}
	 <input type="text"  name="txtfamilysite" value="{$txtfamilysite}" size="8">&nbsp;(請填上國名 ex 新加坡)
	 {/if}
    </td>
</tr>


<!-- *出生年-->
  <tr>
    	<th>
	     *出生年
	</th> 
	<td>
	西元
	    <select id="selBirthYear" name="selBirthYear" onLoad="checkSelect(this);" onChange="checkSelect(this);">
	    {html_options values=$selBirthYear_ids output=$selBirthYear_names selected=$selBirthYear}
 	    </select>     
	年
        {if $selBirthYear eq -1 }<span id="selBirthYearFailed" ><font color="red">請選擇</font></span>{/if}
	</td>
  </tr>
{/if}


<!--*連絡電話 -->
  <tr>
    <th>*聯絡電話</th>
	  <td>
	    <input id="txtTel" name="txtTel" type="text" onBlur="validate(this.value, this.id);" value="{$valueOfTel}" />&nbsp;例:02-27225777-2321 
	    <span id="txtTelFailed" class="{$txtTelFailed}" >此欄空白或格式錯誤</span>
      </td>



  </tr>
<!--*電子信箱 -->
  <tr>
    <th>*電子信箱</br><font color="red">請您務必填寫正確信箱，<br>否則無法收到帳號開通信件。</font></th>
	  <td>
	    <input id="txtEmail" name="txtEmail" type="text" onBlur="validate(this.value, this.id);" value="{$valueOfEmail}" size="52"/>
	     <br><font color="red">（為了避免認證信件被阻擋，建議不要使用免費信箱，例如：Yahoo／Hotmail信箱）</font>     
	    <span id="txtEmailFailed" class="{$txtEmailFailed}" >格式錯誤或此欄空白</span></td>	
  </tr>


<!--郵遞區號-->
  <tr>
    <th>郵遞區號</th>
	  <td>
	    <input id="txtZoneCd" name="txtZoneCd" type="text" onBlur="validate(this.value, this.id);" value="{$valueOfZoneCd}" size="8"/>
	    <!--<span id="txtZoneCdFailed" class="{$txtZoneCdFailed}" >此欄空白</span> -->     </td>		
  </tr>


<!-- 通訊地址-->
<tr>
    <th>
    	通訊地址
    </th>
    <td>
       <div>	
	  <input id="txtAddr" name="txtAddr" autocomplete="off" type="text" value="{$valueOfAddr}" size="52" onBlur="validate(this.value, this.id);"/>
	      <span id="loadingGif" style="display:none;"><img src="{$loadingGif}"></span>        </div>
	  <div id="selAddr" style="display:none;">
       </div>
     </td>
  </tr>

<!-- 所在縣市 -->
  <tr>
       <th>
       	   *所在縣市
       </th>
       <td>
	    <select id="selCity" name="selCity" onLoad="checkSelect(this);" onChange="checkSelect(this);">
	    {html_options values=$selCity_ids output=$selCity_names selected=$selCity}
 	    </select>
        {if $selCity eq -1 }<span id="selCityFailed" ><font color="red">請選擇</font></span>{/if}
       </td>
  </tr>

<!--*數位機會中心-->
{if $selCity!= 0 && ( $selRole == 0 || $selRole == 5) }
  <tr>
       <th>
       	   *鄰近數位機會中心
       </th>
       <td>
	    <select id="selDoc" name="selDoc" onLoad="checkSelect(this);" onChange="checkSelect(this);">
	    {html_options values=$selDoc_ids output=$selDoc_names selected=$selDoc}
 	    </select>     
        {if $selDoc eq -1 }<span id="selDocFailed" ><font color="red">請選擇</font></span>{/if}
       </td>
  </tr>
{/if}


<!--*各級學校-->
<!--有選擇角色及是所選擇的角色不等於一般民眾-->
{if $selRole != -1 &&  $selRole != 0 && $selRole != 5 && $selRole != 6 && $selRole != 7}
  {if $selRole == 3 || $selRole == 4}
      {assign var=selSchlevel value=5}	    
   <tr style="display:none">
       <th style="display:none">
       	   *各級學校
       </th>
       <td style="display:none">
	    <select style="display:none" id="selSchlevel" name="selSchlevel" onLoad="checkSelect(this);" onChange="checkSelect(this);">

  {else}
   <tr>
       <th>
       	   *各級學校
       </th>
       <td>
	    <select id="selSchlevel" name="selSchlevel" onLoad="checkSelect(this);" onChange="checkSelect(this);">

  {/if}	
	    {html_options values=$selSchlevel_ids output=$selSchlevel_names selected=$selSchlevel}
 	    </select>    
        {if $selSchlevel eq -1 }<span id="selSchlevelFailed" ><font color="red">請選擇</font></span>{/if}
       </td>
  </tr>
  <!--選擇所在縣市以及選擇各級學校-->
  {if $selCity != 0 && $selSchlevel != 0}
    <!--學校名稱-->
      <tr>
	   <th>
		{if $selRole  eq 1 ||  $selRole  eq 2 ||  $selRole  eq 4 }
		 *服務學校
		{else}
                 *就讀學校
		{/if}
	   </th>
	   <td>
		<select id="selSchname" name="selSchname" onLoad="checkSelect(this);" onChange="checkSelect(this);">
		{html_options values=$selSchname_ids output=$selSchname_names selected=$selSchname}
		</select>     
        {if $selSchname eq -1 }<span id="selSchnameFailed" ><font color="red">請選擇</font></span>{/if}
	   </td>
      </tr>
    <!--當各級學校已經選擇了其他學校-->
   {if $selSchname == -2 }
   <!--其他學校-->
	<tr>
	   <th>
		  *其他學校
	     </th>
	     <td>
		  <input id="txtOthersch" name="txtOthersch" type="text" onBlur="validate(this.value, this.id);" value="{$valueOfOthersch}" />
		  <span id="txtOtherschFailed" class="{$txtOtherschFailed}" >此欄空白</span>     	 
		  {if $selSchlevel == 1}
		      <span>例:台北市立教育國民小學</span>
		  {elseif  $selSchlevel == 2}
		      <span>例:南投縣立國民中學</span>
		  {elseif  $selSchlevel == 3 || $selSchlevel == 4}
		      <span>例:國立苗栗高級中學、國立彰化高級商業職業學校</span>
		  {else $selSchlevel == 5}
		      <span>例:東海大學、國立屏東科技大學</span>
		  {/if}
	     </td>
	</tr>
    {/if}
  {/if}
{/if}


<!--.職業 -->
<!-- 當職業選擇一般民眾時，才顯示此項目 -->
{if $selRole eq 0}
  <tr>	
      <th>
	*職業
      </th>
      <td>
	  <INPUT Type=RADIO Name="job" {if $job eq 0}  checked {/if} VALUE="0">工&nbsp;
	  <INPUT Type=RADIO Name="job" {if $job eq 1}  checked {/if} VALUE="1">商&nbsp;
	  <INPUT Type=RADIO Name="job" {if $job eq 2}  checked {/if} VALUE="2">農&nbsp;
	  <INPUT Type=RADIO Name="job" {if $job eq 3}  checked {/if} VALUE="3">林&nbsp;
	  <INPUT Type=RADIO Name="job" {if $job eq 4}  checked {/if} VALUE="4">魚&nbsp;
	  <INPUT Type=RADIO Name="job" {if $job eq 5}  checked {/if} VALUE="5">牧&nbsp;
	  <INPUT Type=RADIO Name="job" {if $job eq 6}  checked {/if} VALUE="6">教育&nbsp;
	  <INPUT Type=RADIO Name="job" {if $job eq 7}  checked {/if} VALUE="7">軍人&nbsp;<br>
	  <INPUT Type=RADIO Name="job" {if $job eq 8}  checked {/if} VALUE="8">公職&nbsp;
	  <INPUT Type=RADIO Name="job" {if $job eq 9}  checked {/if} VALUE="9">管家&nbsp;
	  <INPUT Type=RADIO Name="job" {if $job eq 10} checked {/if} VALUE="10">服務&nbsp;
	  <INPUT Type=RADIO Name="job" {if $job eq 11} checked {/if} VALUE="11">其他&nbsp;
      </td>		
  </tr>
{/if}


<!--所屬單位 -->
<!-- 當身分選擇一般民眾時，則自行填寫 -->

{if $selRole eq  0}
<tr>	
     <th>
	所屬單位
     </th>
     <td>
        <input id="txtOrganization" name="txtOrganization" type="text" onBlur="validate(this.value, this.id);" value="{$valueOfOrganization}" />
     </td>
  </tr>
{/if}



<!--個人學歷-->
{if $selRole != 3}
  <tr>
      <th>
	 學歷
     </th>

  <td>
  <!--當身分選擇一般民眾時,全部可選-->
  &nbsp;（請勾選與本身學歷相當程度選項）<br>
 	  {if $selRole eq  0}
	      <INPUT Type=RADIO Name="degree" VALUE="0" {if $degree eq 0} checked {/if}>自修&nbsp;
	      <INPUT Type=RADIO Name="degree" VALUE="1" {if $degree eq 1} checked {/if}>國中小學&nbsp;
	  {/if}
	  <!--當身分選擇教師及學生時,只有底下可選-->
	      <INPUT Type=RADIO Name="degree" VALUE="2" {if $degree eq 2} checked {/if}>高中職&nbsp;
	      <INPUT Type=RADIO Name="degree" VALUE="3" {if $degree eq 3} checked {/if}>專科學校&nbsp;
	      <INPUT Type=RADIO Name="degree" VALUE="4" {if $degree eq 4} checked {/if}>大學&nbsp;
	      <INPUT Type=RADIO Name="degree" VALUE="5" {if $degree eq 5} checked {/if}>研究所以上&nbsp;
      </td>
  </tr>
{/if}

<!--有興趣課程類別-->

    <tr>
      <th>
      請勾選您有興趣的課程類別
      </th>
      <td>							 
	    <INPUT Type="checkbox" Name="interest[0]" VALUE="1" {if $valueOfInterest0 eq 1} checked {/if} >電腦入門課程&nbsp;<br>
	    <INPUT Type="checkbox" Name="interest[1]" VALUE="1" {if $valueOfInterest1 eq 1} checked {/if}>資訊技能課程&nbsp;<br>
	    <INPUT Type="checkbox" Name="interest[2]" VALUE="1" {if $valueOfInterest2 eq 1} checked {/if}>資訊融入教學課程&nbsp;<br>
	    <INPUT Type="checkbox" Name="interest[3]" VALUE="1" {if $valueOfInterest3 eq 1} checked {/if}>資訊倫理課程&nbsp;<br>
	    <INPUT Type="checkbox" Name="interest[4]" VALUE="1" {if $valueOfInterest4 eq 1} checked {/if}>資訊安全課程&nbsp;<br>
	    <INPUT Type="checkbox" Name="interest[5]" VALUE="1" {if $valueOfInterest5 eq 1} checked {/if}   onClick="checkSelect(this);">其他&nbsp;
	   <!--
	    {if $valueOfInterest5 eq 1}
	       <INPUT Type="text" Name="txtInterest" value="{$valueOftxtinterest}">
	       <font color='red'>勾選其他,本欄為必填</font>
	    {/if}
	    -->
     </td>
  </tr>

<!-- 23.是否接收最新消息通知-->
  <tr>
       <th>
       	  是否接收最新消息通知
       </th>
       <td>
       	   <INPUT Type=RADIO Name="recnews" VALUE="1" {if $recnews eq 1} CHECKED {/if}>同意&nbsp;&nbsp;
       	   <INPUT Type=RADIO Name="recnews" VALUE="0" {if $recnews eq 0} CHECKED {/if}>不同意
      </td>
  </tr>




  </table>
  <!-- 按鈕-->

  <div class="al-left">
  <span class="txtSmall"><font color='red'>注意：所有的*號欄位都填了嗎？</font></span>
  <input type="submit" name="submitbutton" value="確定送出"/>
  <br><br><br></div>
</form>
   </center></td>
   <td colspan="2" background="../images/registration/001_r3_c5.jpg"><img name="n001_r3_c6" src="../images/registration/001_r3_c6.jpg" width="4" height="7" border="0" alt=""></td>
  </tr>
  <tr>
   <td width="23"><img name="n001_r5_c2" src="../images/registration/001_r5_c2.jpg" width="23" height="21" border="0" alt=""></td>
   <td colspan="2"  background="../images/registration/001_r5_c4.jpg"><img name="n001_r5_c4" src="../images/registration/001_r5_c4.jpg" width="7" height="21" border="0" alt=""></td>
   <td><img name="n001_r5_c5" src="../images/registration/001_r5_c5.jpg" width="22" height="21" border="0" alt=""></td>
   <td><img name="n001_r5_c6" src="../images/registration/001_r5_c6.jpg" width="4" height="21" border="0" alt=""></td>
  </tr>
</table>
</body>
</html>
