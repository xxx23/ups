<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>合作學習屬性設定頁面</title> 
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
{literal}
<script type="text/javascript" src="../script/calendar.js"></script>
<script type="text/javascript">
	function select_score_type(option){
		if(option == 2)
		    document.getElementById("personal_rate").style.display = "";
		else
			document.getElementById("personal_rate").style.display = "none";
	}
	function finish_editing(option){
		if(option == 1)	//完成編輯
			document.getElementById("finish_option").value = "finish";
		else	//繼續編輯下ㄧ題
			document.getElementById("finish_option").value = "continue";
	}
</script>
{/literal}
</head>
<body class="ifr" id="tabB">

<form name="form" method="post" action="./new_project.php">
  <h1>新增合作學習專案設定</h1>
  <p><strong>所有含<span class='required'>*</span>的欄位為必填</strong>    </p>
  <fieldset>
  <legend>合作學習 基本資料 </legend>
  <table width="90%" class='form'>
    <tr>
      <th> <span class='required'>*</span> 合作學習專案目標： </th>
      <td><input type='text' name="project_goal" value='' size="60" /></td>
    </tr>
    <tr>
      <th width="30%"><span class='required'></span> 備註：</th>
      <td><textarea name="comment" cols="60" rows="5"></textarea></td>
    </tr>
    <tr>
      <th width="30%">輸入參考資料：</th>
      <td><textarea name="ref_doc" cols="60" rows="5"></textarea></td>
    </tr>
  </table>
  </fieldset>
	
  <fieldset>
  <legend>題目相關資訊 </legend>
  <table width="90%" class="form">
    <tr>
      <th width="30%">  <span class='required'>*</span>學生是否可以自定題目?
&nbsp;</th>
      <td><select name="subject_type" onchange="select_score_type(this.selectedIndex);">
		  <option value="0">不允許</option>
		  <option value="1">允許</option>
	  </select>
&nbsp;</td>
    </tr>
  </table>
  </fieldset>
	
  <fieldset>
  <legend>分組相關資訊 </legend>
  <table width="90%" class='form'>
    <tr>
      <th width="30%"><span class='required'>*</span>學生最慢分組時間：	  </th>
      <td><input type="text" id="sign_up_due_date" name="sign_up_due_date" />
	  <script language=javascript>
			  var myDate=new dateSelector();
			  myDate.year;
			  myDate.inputName='sign_up_due_date';   
			  myDate.display();
			</script>	  
	  </td>
    </tr>
    <!--<tr>
        <td>預計&nbsp;<input type="text" name="group_member" size="1"/>&nbsp;組</td>
      </tr>-->
    <tr>
      <th width="30%">每組人數：</th>
      <td>每組&nbsp;
        <input type="text" name="group_member" size="1"/>
      &nbsp;人 (自動分組時用)</td>
    </tr>
  </table>
  </fieldset>
  <fieldset>
  <legend>成績相關資訊</legend>
  <table width="90%" class='form'>
    <tr>
  	  <th width="30%"><span class='required'>*</span>請選擇記分方式：  	  </th>
      <td><select name="score_type" onchange="select_score_type(this.selectedIndex);">
        <option value="0">以組別計分</option>
        <option value="1">以個人計分</option>
        <option value="2">以組別與個人加權計分</option>
      </select></td>
    </tr>
    <tr id="personal_rate" style="display:none">
  	  <th width="30%"><span class='required'>*</span>請輸入學生分數所佔的比例：</th>
      <td><input type="text" name="person_rate" size="1" />
        % &nbsp;&nbsp;<br />
  	  (example: 合作學習總分 = 個人分數 x <span class="imp">60%</span> + 組別分數 x 40%)</td>
    </tr>
  </table>
  </fieldset>
  <p class="intro">下一步： 請按下<span class="imp">"完成並進入編輯專案題目"</span>來編輯本合作學習的專案題目內容。</p>
  <p class="intro">結束： 請按下<span class="imp">"完成編輯"</span>完成本合作學習的新增。</p>
  <div class="buttons"><a href="./tea_project_list.php">放棄編輯</a>
    <input type="hidden" id="finish_option" name="finish_option" value="" />
    <input type="submit" class="btn" value="完成編輯" 
	  onclick="finish_editing(1);" />
    <input type="submit" class="btn" value="完成並進入編輯專案題目" 
	  onclick="finish_editing(2);" />
    <input type="reset" class="btn" value="清除資料" />
  </div>
</form>
</html>
