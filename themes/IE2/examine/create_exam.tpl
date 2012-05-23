<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Cache-Control" content="no-cache,no-store,must-revalidate,max-age=0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>select test</title>

<head>

<script type="text/javascript" src="{$webroot}script/examine/check.js"></script>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}css/form.css" rel="stylesheet" type="text/css" />
</head>

<body>

<h1>新增測驗</h1>
{if $no_content==1 }
<span class="imp">沒有選擇教材，請先至教材管理選取本課程使用的教材</span>
{elseif $attribute eq 0 && $test_cnt ge 1}
<span class="imp">本課程為自學課程，只能有一份測驗</span>
{else}
<table class="datatable">
  <form method='GET' action="create_exam.php" onSubmit="return checkSubmit(this);">
    <tr>
      <td>測驗名稱：</td><td><input name="name" type="text" id="examName" size="30"/></td>
    </tr>
    <tr>
      <td>測驗類型：</td>
	  <td>
	    <select name="type">
        {if $attribute ne 0}
          <option value="1">自我評量</option>
	    {/if}
          <option value="2">正式測驗</option>
      </select>	  </td>
	</tr>
    <tr>{if $attribute ne 0}
        <td>配分：</td><td><input name="score" type="text" size="10"/> 
      %  (註：自我評量不計入總成績的配分) </td>
        {else}
        <td>配分:</td><td>100%<input name="score" type="hidden" value=100 ></td>
        {/if}
    </tr>
	<tr>
	  <td colspan="2"><p class="al-left">
	  <input type='reset' class="btn" value='清除資料'/>
	  <input type='submit' class="btn" id="submit_button" value='確定送出'/></p>	  </td>
	</tr>
  </form>
</table>
{/if}
  <p class="al-left"><a href="tea_view.php"><img src="{$tpl_path}/images/icon/return.gif" /> 返回線上測驗列表</a></p>
</body>

</html>
