<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新增合作學習project題目內容</title> 
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
{literal}
<script language="javascript" type="text/javascript" src="{$webroot}script/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$webroot}script/tiny_mce/usable_proprities.js"></script>
<script type="text/javascript">
	function choose(option){
		if(option == 1)
			document.getElementById("group_num").disabled = "disabled";
		else
			document.getElementById("group_num").disabled = "";
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
<body id="tabB">

<h1>新增合作學習 專案題目內容</h1>
<p class="intro">本專案隸屬於<span class="imp">"{$homework_name}"&nbsp;</span>作業</p>
<form name="" method="post" action="./new_project_content.php">
  <fieldset>
  <legend>專案內容資訊</legend>
  <table width="90%" class="form">
    <tr>
  	  <th width="30%" rowspan="2"><span class='required'>*</span>選擇本專案題目的組數,最多允許幾組?</th>
      <td>&nbsp;&nbsp;&nbsp;
          <input type="radio" value="" name="group_num_type" onclick="choose(1);" />
        不限制</td>
    </tr>
    <tr>
	  <td>&nbsp;&nbsp;&nbsp;
          <input type="radio" value="" name="group_num_type" onclick="choose(2);" />
        請輸入組數：
        <input type="text" name="group_num" id="group_num" disabled="disabled" size="1" value="" />
        &nbsp;組</td>
    </tr>
    <tr>
  	  <th width="30%"><span class='required'>*</span>請輸入專案題目：&nbsp;</th>
      <td><textarea name="project_content" cols="70" rows="20" id="projcet_content"></textarea></td>
    </tr>
  </table>
  </fieldset>
	
  <div class="buttons"><!--<a href="./tea_project_list.php">放棄編輯</a>-->
    <input type="hidden" id="finish_option" name="finish_option" value="" />
    <input type="hidden" id="homework_no" name="homework_no" value="{$homework_no}" />
    <input type="hidden" id="new_flag" name="new_flag" value="{$new_flag}" />
    <input type="submit" class="btn" value="完成編輯" onclick="finish_editing(1);"/>
    <input type="submit" class="btn" value="繼續編輯下ㄧ題" onclick="finish_editing(2);" />
    <input name="clear" type="reset" class="btn" value="清除資料" />
  </div>
</form>
<br />
</body>
</html>
