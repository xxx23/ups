{config_load file='common.lang'}
{config_load file='learner_profile/user_profile.lang'}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>{#view_id#}</title>
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" / -->

<script src="../script/calendar.js" type="text/javascript" ></script>

<script type="text/javascript" src="{$tpl_path}/script/jQuery/js/jquery-1.3.2.min.js"></script>
<link type="text/css" href="{$tpl_path}/script/jQuery/css/ui-lightness/jquery-ui-1.7.1.custom.css" rel="Stylesheet"/>
<script type="text/javascriPt" src="{$tpl_path}/script/jQuery/js/jquery-ui-1.7.1.custom.min.js"></script>
<!--<script type="text/javascript" src="{$tpl_path}/script/jQuery/development-bundle/ui/i18n/ui.datepicker-zh-TW.js"/>-->

<!--****************modify by q110185****************************-->
<!--為了要避免與prototype.js發生衝突,必須要alias jQuery以及將prototype.js放在jQuery之後-->
<script type="text/javascript" src="../script/prototype.js"></script>
<script type="text/javascript" src="script/passwordstrength.js"></script>
<!--****************q110185 modify end****************************-->
<script language="JavaScript" type="text/JavaScript">
{if $top_page_reload == 1}
    //window.parent.location="{$webroot}/Personal_Page/index.php";
    parent.window.document.getElementById('userImage').src="{$webroot}{$userProfile.photo}?q="+Math.random();
{/if}

{literal}
//驗證表單欄位

  function chkform(){
	
	var personal_name = document.getElementsByName('personal_name')[0].value;
	var tel = document.getElementsByName('tel')[0].value;
	var mail = document.getElementsByName('email')[0].value;
	var msg = '';
	var error;
	if(trim(personal_name) == ""){
	  {/literal}
	  msg += "{#name_can_not_null#}\n";
	  {literal}  
	  error = 1;
	}
	if(trim(tel) == ""){
	  {/literal}
	  msg += "{#telephone_num_cant_null#}\n";
	  {literal}  
	  error = 1;
	}
	if(trim(mail) == ""){	
	  {/literal}
	  msg += "Email{#cant_null#}\n";
	  {literal}
	  error = 1;
	}
	else{
	 if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(trim(mail)))){
	  {/literal}
	  msg += "Email{#form_not_correct#}\n";
	  {literal}
	  error = 1;
	  }
	}
        if(error == 1)
	   alert(msg);
	else
	   document.getElementsByName('personal_basic')[0].submit();

  }

{/literal}
<!--****************modify by q110185****************************-->
<!--
{literal}
var MAX_SELECTION = 10;
var suggestMenu;
var addrQuery;
var serverAddress="validateUserProfile.php";
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
	var   myForm=document.forms['frmModifyProfile']; {/literal}
	myForm.action='user_profile.php?action=sel{$personal_id_tag2}';
{literal}	
	myForm.method='POST';  
       myForm.submit();   
        return;
}
function chkID_Sex(){
 	document.getElementsByName('frmModifyProfile')[0].submit();
}

{/literal}
-->

<!--****************q110185 modify end****************************-->


</script>
</head>

<body class="ifr">

<!--功能部分 -->
<form action="./modify_password.php{$personal_id_tag1}" method="post">
<h1>{#id#}</h1>
<table class="datatable">
<tr>
	<td width="20%">{#id#}</td>
	<td>{$userLogin.login_id|escape}</td>
</tr>
<tr>	
	<td>{#id_start#}</td>
	<td>{$userLogin.d_loging}</td>
</tr>
<tr>	
	<td>{#status#}</td>
	<td>{$userLogin.role_name|escape}</td>
</tr>
<tr>	
	<td>{#id_use#}</td>
	<td>{if $userLogin.login_state eq 1}{#start#}{else}{#not_start#}{/if}</td>
</tr>
<tr>	
	<td>{#id_is_approv#}</td>
	<td>{if $userLogin.validated eq 1}{#approv#}{else}{#reject#}{/if}</td>
</tr>
<tr>
	<td colspan="2">
	<p class="al-left"><input type="submit" value="{#modify_psw#}" class="btn" /><p>
	</td>
</tr>

</table>
</form>

<!--****************modify by q110185****************************-->
 <!-- form -->
{if $role_cd == 2}
<form name="frmModifyProfile" method="post" action="user_profile.php?action=modifyProfile{$personal_id_tag2}" onKeyPress=" return disableEnterKey(event);" >
<h1>{#personal_profile#}</h1>
 <table class="datatable" >
    <tr>
      <td width="200"><strong>{#name#}</strong></td>
        <td> <input type="text" name="personal_name" value="{$userProfile.personal_name|escape}" id="personal_name" /></td>
    </tr>
    <tr>
      <td><strong>{#status#}</strong></td>
      <td><label>
       <select id="dist_cd" name="dist_cd">
	    {html_options values=$dist_cds output=$dist_names selected=$userProfile.dist_cd}
 	    </select>     
      </label></td>
    </tr>

    <tr>
      <td><strong>{#hypocorism#}</strong></td>
      <td><label>
        <input type="text" name="nickname" value="{$userProfile.nickname|escape}"id="textfield" />
      </label></td>
    </tr>
    <tr>
      <td><strong>{#sex#}</strong></td>
      <td> <input id="sex" name="sex" type="radio"  value="1" {if $userProfile.sex eq 1}checked{/if} />{#male#}
	    <input id="sex" name="sex" type="radio"  value="0" {if $userProfile.sex eq 0}checked{/if} />{#female#}</td>
    </tr>
    <tr>
      <td><strong>{#telephone_num#}</strong></td>
      <td><input type="text" name="tel" value="{$userProfile.tel|escape}" id="textfield2" /></td>
    </tr>
    <tr>
      <td><strong>{#e_mail#}</strong></td>
      <td><input type="text" name="email"  value="{$userProfile.email|escape}" id="email" /></td>
    </tr>
    <tr>
      <td colspan="2">
	  <span class="imp">{$modify_message}</span>
	  <div >
		<input type="button" class="btn" name="submitbutton" value="{#ok_modify#}" onClick="chkID_Sex();"/>
		</div></td>
    </tr>
  </table>
</form>
<!--****************q110185 modify end****************************-->
{else}
<form name="frmModifyProfile" method="post" action="user_profile.php?action=modifyProfile{$personal_id_tag2}" onKeyPress=" return disableEnterKey(event);" >
<h1>{#personal_profile#}</h1>
 <table class="datatable" >
    <tr>
      <td width="200"><strong>{#name#}</strong></td>
        <td> <input type="text" name="personal_name" value="{$userProfile.personal_name|escape}" id="personal_name" /></td>
    </tr>
    <tr>
      <td><strong>{#status#}</strong></td>
      <td><label>
       <select id="dist_cd" name="dist_cd" onChange="frmModifyProfile.submit();">
	    {html_options values=$dist_cds output=$dist_names selected=$userProfile.dist_cd}
 	    </select>     
      </label></td>
    </tr>
	{if $userProfile.dist_cd == 1 || $userProfile.dist_cd ==2}
    <tr>
      <td><strong>{#professional_title#}</strong></td>
      <td><label>
        <select id="title" name="title"  length="30">
	       <option value="0" {if $userProfile.title eq 0} selected {/if}>{#teacher#}</option>
	       <option value="1" {if $userProfile.title eq 1} selected {/if}>{#manager#}</option>
	       <option value="2" {if $userProfile.title eq 2} selected {/if}>{#president#}</option>
            </select> 
      </label></td>
    </tr>
	{/if}
    <tr>
      <td><strong>{#hypocorism#}</strong></td>
      <td><label>
        <input type="text" name="nickname" value="{$userProfile.nickname|escape}"id="textfield" />
      </label></td>
    </tr>
    <tr>
      <td><strong>*{#id_word_num#}/{#passport_number#}</strong></td>
      <td> 
        <input id="identify_id" type="text" name="{if $userProfile.idorpas eq 0}identify_id{else}passport{/if}" value="{if $userProfile.idorpas eq 0}{$userProfile.identify_id}{else}{$userProfile.passport}{/if}" {if $role_cd != 0 && $userProfile.identify_id != NULL && $userProfile.identify_id != '0' }readonly="readonly"{/if} />
        {if $role_cd == 0}
        <input type="radio" name="idorpas" value="0" onclick="checkSelect(this)" {if $userProfile.idorpas eq 0}checked{/if} />{#id_word#}
        <input type="radio" name="idorpas" value="1" onclick="checkSelect(this)" {if $userProfile.idorpas eq 1}checked{/if} />{#passport#}
        {else}
        <input type="hidden" name="idorpas" value="{$userProfile.idorpas}" />
        {/if}
      </td>
    </tr>
    <!--教師證號改成可以修改-->
        {if $role_cd == 0}
            <tr><td><strong>{#teacher_number#}</strong></td>
                <td><input id="teach_doc" type="text" name="teach_doc" value="{$userProfile.teach_doc|escape}" /></td></tr>
        {else}
            {if $userProfile.dist_cd == 1 || $userProfile.dist_cd ==2}
            <tr>
                <td><strong>{#teacher_number#}</strong></td>
                <td><input is="teach_doc" type="text" name="teach_doc" value="{$userProfile.teach_doc|escape}" /></td>
            </tr>
            {/if}
        {/if}
    <!--end-->

    <tr>
      <td><strong>*{#sex#}</strong></td>
      <td> <input id="sex" name="sex" type="radio"  value="1" {if $userProfile.sex eq 1}checked{/if} />{#male#}
	    <input id="sex" name="sex" type="radio"  value="0" {if $userProfile.sex eq 0}checked{/if} />{#female#}</td>
    </tr>
	{if $userProfile.dist_cd == 0}
    <tr>
      <td><strong>*{#status_leaves#}</strong></td> 
      <td>&nbsp;({#choose_status#})<br>
         <input type="radio" name="familysite" onclick="checkSelect(this);"{if $userProfile.familysite eq 0} checked {/if} value = "0"/>{#taiwan_minnan_person#}&nbsp;
         <input type="radio" name="familysite" onclick="checkSelect(this);" {if $userProfile.familysite eq 1} checked {/if} value = "1"/>{#taiwan_hakka_person#}&nbsp;
         <input type="radio" name="familysite" onclick="checkSelect(this);"{if $userProfile.familysite eq 2} checked {/if} value = "2"/>{#taiwan_indigenous_people#}&nbsp;
         <input type="radio" name="familysite" onclick="checkSelect(this);" {if $userProfile.familysite eq 3} checked {/if} value = "3"/>{#new_people#}&nbsp;
         <input type="radio" name="familysite"  onclick="checkSelect(this);"{if $userProfile.familysite eq 4} checked {/if} value = "4"/>{#chnia#}&nbsp;<br>
         <input type="radio" name="familysite" onclick="checkSelect(this);" {if $userProfile.familysite eq 5} checked {/if} value = "5"/>{#other_country#}&nbsp;&nbsp;
	 {if $userProfile.familysite eq 5}
	 <input type="text"  name="familysiteo" value="{$userProfile.familysiteo}" size="8">&nbsp;({#fill_in_country#} ex {#singapore#})
	 {/if}</td>
    </tr>
    <tr>
      <td><strong>*{#born_year#}</strong></td>
      <td>
        西元
            <select id="d_birthday" name="d_birthday" >
            {html_options values=$d_birthday_ids output=$d_birthday_names selected=$userProfile.d_birthday}
            </select>     
        年
            {if $userProfile.d_birthday eq -1 }<span id="selBirthYearFailed" ><font color="red">請選擇</font></span>{/if}

        {*<input name="d_brithday" type="text"  value="{$userProfile.d_birthday|escape}" id="d_birthday" size="16" />*}
      </td>
    </tr>
	{/if}
    <tr>
      <td><strong>*{#telephone_num#}</strong></td>
      <td><input type="text" name="tel" value="{$userProfile.tel|escape}" id="textfield2" /></td>
    </tr>
    <tr>
      <td><strong>*{#e_mail#}</strong></td>
      <td><input type="text" name="email"  value="{$userProfile.email|escape}" id="email" /></td>
    </tr>
    <tr>
      <td><strong>{#zipcode#}</strong></td>
      <td><input name="zone_cd" type="text"  value="{$userProfile.zone_cd|escape}" id="zone_cd" size="6" /></td>
    </tr>
    <tr>
      <td><strong>{#address#}</strong></td>
      <td><input name="addr" type="text"  value="{$userProfile.addr|escape}" id="addr" size="50" /></td>
    </tr>
    <tr>
      <td><strong>*{#county#}</strong></td>
      <td><label>
       <select id="city_cd" name="city_cd" onChange="checkSelect(this);">
	    {html_options values=$selCity_ids output=$selCity_names selected=$userProfile.city_cd}
 	    </select>     
      </label></td>
    </tr>
	{if $userProfile.dist_cd == 0 || $userProfile.dist_cd == 5}
    <tr>
      <td><strong>*{#near#}DOC</strong></td>
      <td><label>
        <select name="doc_cd" id="doc_cd">
		{html_options values=$selDoc_ids output=$selDoc_names selected=$userProfile.doc_cd}
        </select>
      </label></td>
    </tr>
	{/if}
	{if $userProfile.dist_cd ==1 ||$userProfile.dist_cd ==2||$userProfile.dist_cd ==3||$userProfile.dist_cd ==4 }
    <tr>
      <td><strong>*{#all_levels_school#}</strong></td>
      <td><label>
        <select name="school_type" id="school_type"onChange="checkSelect(this);">
		{html_options values=$selSchLevel_ids output=$selSchLevel_names selected=$userProfile.school_type}
        </select>
      </label></td>
    </tr>
	{/if}
	{if $showSchool ==1 }
		{if $userProfile.dist_cd ==1||$userProfile.dist_cd ==2||$userProfile.dist_cd ==4}
		<tr>
		  <td><strong>*{#server_school#}</strong></td>
		  <td><label>
			<select name="school_cd" id="school_cd">
			{html_options values=$selSchName_ids output=$selSchName_names selected=$userProfile.school_cd}
			</select>
		  </label></td>
		</tr>
		{/if}
		{if $userProfile.dist_cd ==3}
		<tr>
		  <td><strong>*{#study_schoo#}</strong></td>
		  <td><label>
			<select name="school_cd" id="school_cd">
			{html_options values=$selSchName_ids output=$selSchName_names selected=$userProfile.school_cd}
			</select>
		  </label></td>
		</tr>
		{/if}
	{/if}
	{if $userProfile.dist_cd ==0}
    <tr>
      <td><strong>*{#job#}</strong></td>
      <td><p>
        <label>
           {html_radios  name='job'  values=$job_ids selected=$userProfile.job output=$job_names}
      </p></td>
    </tr>
	
    <tr>
      <td><strong>{#belong_unit#}</strong></td>
      <td> <input id="organization" name="organization" type="text" onBlur="" value="{$userProfile.organization}" /></td>
    </tr>
    {/if}
	{if $userProfile.dist_cd ==0||$dist_cd ==1||$dist_cd ==2||$dist_cd ==4 }
	<tr>
      <td><strong>{#record_of_school#}</strong></td>
      <td> <!--當身分選擇一般民眾時,全部可選-->
  &nbsp;{#choose_record_of_school#}<br>
 	  {if $userProfile.dist_cd eq  0}
	      <INPUT Type=RADIO Name="degree" VALUE="0" {if $userProfile.degree eq 0} checked {/if}>{#study_self#}&nbsp;
	      <INPUT Type=RADIO Name="degree" VALUE="1" {if $userProfile.degree eq 1} checked {/if}>{#iddle_and_primary_school#}&nbsp;
	  {/if}
	  <!--當身分選擇教師及學生時,只有底下可選-->
	      <INPUT Type=RADIO Name="degree" VALUE="2" {if $userProfile.degree eq 2} checked {/if}>{#high_school#}&nbsp;
	      <INPUT Type=RADIO Name="degree" VALUE="3" {if $userProfile.degree eq 3} checked {/if}>{#universities_and_colleges#}&nbsp;
	      <INPUT Type=RADIO Name="degree" VALUE="4" {if $userProfile.degree eq 4} checked {/if}>{#colleges#}&nbsp;
	      <INPUT Type=RADIO Name="degree" VALUE="5" {if $userProfile.degree eq 5} checked {/if}>{#hight_then_graduate_school#}&nbsp;</td>
    </tr>
	{/if}
    <tr> 
      <td><strong>{#has_interest_class#}</strong></td>
      <td>
      	<INPUT Type="checkbox" Name="interest[0]" VALUE="1" onclick="checkSelect(this);" {if $userProfile.interest0 eq 1} checked {/if} >{#computer_easy_class#}&nbsp;<br> 
	    <INPUT Type="checkbox" Name="interest[1]" VALUE="1" onclick="checkSelect(this);" {if $userProfile.interest1 eq 1} checked {/if}>{#information_skill#}&nbsp;<br> 
	    <INPUT Type="checkbox" Name="interest[2]" VALUE="1" onclick="checkSelect(this);" {if $userProfile.interest2 eq 1} checked {/if} >{#information_add#}&nbsp;<br> 
	    <INPUT Type="checkbox" Name="interest[3]" VALUE="1" onclick="checkSelect(this);" {if $userProfile.interest3 eq 1} checked {/if}>{#information_ethics#}&nbsp;<br> 
	    <INPUT Type="checkbox" Name="interest[4]" VALUE="1" onclick="checkSelect(this);" {if $userProfile.interest4 eq 1} checked {/if} >{#information_security#}&nbsp;<br> 
	    <INPUT Type="checkbox" Name="interest[5]" VALUE="1" onclick="checkSelect(this);"{ if $userProfile.interest5 eq 1} checked {/if}>{#other#}&nbsp;
		{if $userProfile.interest5 eq 1}
	     <INPUT Type="text" Name="interestTxt" value="{$userProfile.interestTxt|escape}">
		{/if}
	    </td>
    </tr>
    <tr>
      <td><strong>{#is_receive#}</strong></td>
      <td> <INPUT Type="RADIO" Name="recnews" VALUE="1" {if $userProfile.recnews eq 1} checked {/if}>{#agree#}&nbsp;&nbsp;
       	   <INPUT Type="RADIO" Name="recnews" VALUE="0"  {if $userProfile.recnews eq 0} checked {/if} >{#disapprove#}</td>
    </tr>
    <tr>
      <td colspan="2">
	  <span class="imp">{$modify_message}</span>
	  <div >
		<input type="button" class="btn" name="submitbutton" value="{#ok_modify#}" onClick="chkID_Sex();"/>
		</div></td>
    </tr>
  </table>
</form>
{/if}


<form action="./user_profile.php?action=uploadPhoto{$personal_id_tag2}" method="post" enctype="multipart/form-data">
<h1>{#upload_personal_pic#}</h1>
<table class="datatable">
{if $userProfile.photo ne ''}
<tr>
	<td>
	<img src="{$webroot}{$userProfile.photo}?q={$img_rand}" style="width:120px; height:150px; border:1px outset black;" />
	</td>
</tr>
{/if}
<tr>
	<td>
		{#upload_photograph#}
	</td>
	<td>
		<input type="file" name="photo" /> ({#vice_file_name#}: jpg, bmp, png, gif, jpeg)	
	</td>
</tr>
<tr>
	<td colspan="2">
	<span class="imp">{$upload_message}</span>
	<p class="al-left"><font style="color:#ff0000;">{$photo_err}</font><input type="submit" value="{#upload_pic#}" class="btn" /><p>
	</td>
</tr>
</table>
</form>
</body>
</html>
