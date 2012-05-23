<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改專案屬性頁面</title> 

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../script/calendar.js"></script>
{literal}
<script type="text/javascript">
	function select_score_type(option){
		if(option == 2)
		    document.getElementById("personal_rate").style.display = "";
		else
			document.getElementById("personal_rate").style.display = "none";
	}
	function loading(option){
		if(option)
			alert("true");
		else
			alert("false");
	}
	
	function Score_opt(){
		if(document.getElementById("score_slt").value == 2)
			document.getElementById("personal_rate").style.display = "";
		var tmp = document.getElementsByName("score_type")[0];
		//alert(tmp.selectedIndex);
		tmp.onchange = function(){ select_score_type(tmp.selectedIndex);};
	}
	
</script>
{/literal}
</head>

<body id="tabB" onload="Score_opt();">
{foreach from = $project_data item = element name=contentloop}
<form name="form" method="post" action="./modify_project_data.php" onsubmit="return temp(this);">
  <h1>修改合作學習專案設定</h1><span class="imp">{$status}</span>
  <p><strong>所有含<span class='required'>*</span>的欄位為必填</strong>    </p>
  <fieldset>
  <legend>合作學習 基本資料 </legend>
  <table class='form'>
    <tr>
      <th> <span class='required'>*</span> 合作學習專案目標： </th>
      <td><input type='text' name="project_goal" value='{$element.project_goal}' size="60" /></td>
    </tr>
    <tr>
      <th><span class='required'></span> 備註：</th>
      <td><textarea name="comment" cols="60" rows="5">{$element.comment}</textarea></td>
    </tr>
    <tr>
      <th>參考資料：</th>
      <td><textarea name="ref_doc" cols="60" rows="5">{$element.ref_doc}</textarea></td>
    </tr>
  </table>
  </fieldset>
	
  <fieldset>
  <legend>題目相關資訊 </legend>
  <table class="form">
    <tr>
      <th><span class='required'>*</span>學生是否可以自定題目?</th>
      <td>{html_options name=self_subject options=$subject_opt selected=$subject_slt} </td>
    </tr>
  </table>
  
  </fieldset>
    
  <fieldset>
  <legend>分組相關資訊 </legend>
  <table class='form'>
    <tr>
      <th><span class='required'>*</span>學生最慢分組時間：</th>
		  
      <td><input type="text" id="sign_up_due_date" name="sign_up_due_date" value="{$element.due_date}" /></td>
		<th>  <script language=javascript type="text/javascript"><!--
			  var myDate=new dateSelector();
			  myDate.year;
			  myDate.inputName='sign_up_due_date';  
			  myDate.display();
			--></script>	  </th>
    </tr>
    <!--<tr>
        <td>預計分成&nbsp;<input type="text" name="group_member" size="1" value="{$element.group_member}"/>&nbsp;組</td>
      </tr>-->
    <tr>
      <th>每組人數：</th>
      <td>每組&nbsp;
        <input type="text" name="group_member" size="1" value="{$element.group_member}"/>
      &nbsp;人(自動分組時用)</td>
    </tr>
  </table>
  </fieldset>
  <fieldset>
  <legend>成績相關資訊</legend>
  <table class='form'>
    <tr>
  	  <th><span class='required'>*</span>請選擇記分方式：
	  	  <!--<select name="score_type" id="score_type" onchange="select_score_type(this.selectedIndex);">
				<option value="0" selected="{$option}">以個人計分</option>
				<option value="1" {$option}>以組別計分</option>
				<option value="2">以組別與個人加權計分</option>
			</select>--></th>
      <td>{html_options name=score_type options=$score_opt selected=$score_slt} </td>
    </tr>
    <input type="hidden" id="score_slt" value="{$score_slt}" />
    <tr id="personal_rate" style="display:none">
  	  <th><span class='required'>*</span>請輸入學生分數所佔的比例：</th>
      <td><input type="text" name="person_rate" size="1" value="{$element.person_rate}" />
        % &nbsp;&nbsp;
  	    <br />
      (example: 合作學習總分 = 個人分數 x <span class="imp">60%</span> + 組別分數 x 40%)</td>
    </tr>
  </table>
  </fieldset>
  <!--<p class="intro">下ㄧ步： 請按下<span class="imp">"完成並進入編輯專案題目"</span>來編輯本合作學習的專案題目內容。</p>-->
  <p class="intro">結束： 請按下<span class="imp">"完成編輯"</span>完成本合作學習的新增。</p>
  <div class="buttons"><a href="./tea_usage.php?homework_no={$element.homework_no}">放棄編輯</a>
    <input type="hidden" name="homework_no" value="{$element.homework_no}" />
    <input type="hidden" name="modify" value="modify" />
    <input type="submit" class="btn" value="完成修改" />
    <!--<input type="submit" class="btn" value="完成並進入編輯專案題目" 
	  onclick="window.open('./new_project_content.php','_self')" />-->
    <input type="reset" class="btn" value="清除資料" />
  </div>
</form>
{/foreach}
</html>
