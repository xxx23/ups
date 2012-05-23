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
<script language="JavaScript" type="text/JavaScript">
<!--
{literal}
function showFormat(){
	var div = document.getElementById('format');
	if(div.style.display == "")
		div.style.display = "none";
	else
		div.style.display = "";	
}
{/literal}
-->
</script>
</head>

<body class="ifr">
<!-- 內容說明 -->
<p class="intro">
說明：<br />
1. 檔案上傳請<span class="imp">符合格式</span>並將檔案儲存成txt文字檔。<input type="button" class="btn" onClick="showFormat();" value="按此看格式" /><br />
2. 新增的學生帳號，<span class="imp">密碼</span>預設跟<span class="imp">帳號相同</span>。<br />
3. <span class="imp">匯入檔案時，可以在檔案第三欄直接加入身份類別，或是在頁面上下拉選單選擇，兩者若同時存在，會以檔案內的身份別為主。</span><br/>
4. 輸入的檔案請使用副檔名為 <span class="imp">txt</span>的檔案。
</p>
<div id="format" style="display:none;" class="from">
<input type="button" class="btn" onClick="showFormat();" value="關閉" /><br />
<br/>
請記得帳號、姓名與身份別之間用<span class="imp"> , </span>隔開 結尾用<span class="imp">#</span>
目前身份別一共有以下數字：<br/>
0:一般民眾 <br/>1:中小學國民教師 <br/>
2:高中職教師<br/>3:大專院校學生 <br/>4:大專院校教師<br/> 5:數位機會中心輔導團隊講師 <br/>
6:縣市政府研習課程教師<br/> 7:其它 <br/>
<br>例如：
<table border='0'>
<tr><th>帳號,</th><th>姓名,</th><th>身份別數字#</th></tr>
<tr><td>account1,</td><td>name1,</td><td>0#</td></tr>
<tr><td>account2,</td><td>name2,</td><td>0#</td></tr>
<tr><td>.</td><td>.</td><td>.</td></tr>
<tr><td>.</td><td>.</td><td>.</td></tr>
<tr><td>.</td><td>.</td><td>.</td></tr>
<tr><td>accountN,</td><td>nameN,</td><td>0#</td></tr>
</table>
</div>
<!-- 標題 -->
<h1>新增學生(檔案匯入)</h1>

<!--功能部分 -->
<form method="post" action="./adm_file_insertStudent.php?action=doupload" enctype="multipart/form-data">
<table class="datatable">
<tr>
	<th>上傳匯入檔</th>
	<td><input type="file" class="btn" name="upload_file" /></td>
</tr>
</table>
指定匯入帳號的身份別：
<select id="student_dist" name="student_dist">
<option value="-1">請選擇</option>
<option value="0">一般民眾</option>
<option value="1">國民中小學教師</option>
<option value="2">高中職教師</option>
<option value="3">大專院校學生</option>
<option value="4">大專院校教師</option>
<option value="5">數位機會中心輔導團隊講師</option>
<option value="6">縣市政府研習課程教師</option>
<option value="7">其它</option>
</select>
<br/>
<input type="submit" class="btn" name="submitButton" value="確定匯入" />
</form>
<br/>
<div style="width:50%;">  <!-- 限制大小 -->
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
<caption>新增<span class="imp">失敗</span>的帳號<br>（請確認系統中無這些帳號!或匯入的格式正確!）</caption>
<tr>
	<th>帳號</th>
	<th>姓名</th>
    <th>失敗的原因</th>
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

<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
</body>
</html>
