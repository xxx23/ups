<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title> 
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
</script>
{/literal}
</head>
<body id="tabB">
<h1>合作學習題目內容</h1>
  <fieldset>
  <legend>基本資訊</legend>
  <table class='form'>
    <tr>
      <td><li><font color="#003366"><u>作業題目</u>：</font></li><br />
	  <p>{$question}</p></td>
    </tr>
    <tr>
      <td><li><font color="#003366"><u>合作學習專案目標</u></font>：</li><br /> 
	  <p>{$project_goal}</p></td>
    </tr>
    <tr>
      <td><li><font color="#003366"><u>備註</u></font>：</li><br />
	  <p>{$comment}</p></td>
    </tr>
    <tr>
      <td><li><font color="#003366"><u>老師的參考資料</u></font>：</li><br />
	  <p>{$ref_doc}</p></td>
    </tr>
    <tr>
  	  <td><li><font color="#003366"><u>計分方式</u></font>：</li><br />
		<p>
			{if $score_type == 0}
				以個人計分
			{elseif $score_type == 1}
			    以組別計分
			{elseif $score_type == 2}
				合作學習總分 = 個人分數 x&nbsp;<span class="imp">{$person_rate}%</span> + 組別分數 x <span class="imp">&nbsp;{$group_rate}%</span>
			{/if}		  </p>	  </td>
    </tr>
  </table>
  </fieldset>
  <fieldset>
  <legend>其它資訊 </legend>
  <table class='form'>
    <tr>
      <td><li><font color="#003366"><u>學生最慢分組時間</u></font>：</li><span class="imp">{$due_date}	23:59:59	</span></td>
    </tr>
    <tr>
  	  <td><li><font color="#003366"><u>專案結束時間</u></font>：</li><span class="imp">{$d_dueday}</span></td>
    </tr>
  </table>
  </fieldset>
    </div>
<p class="al-left"><a href="javascript:history.back();"><img src="{$tpl_path}/images/icon/return.gif" />回上頁</a></p>

</html>
