<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
{if $action == "new"}
<title>新增權限</title>
{else if  $action == "modify"}
<title>修改權限</title>
{/if}

{literal}
<script language="JavaScript" type="text/javascript">

	function checkData()
	{	
		if(document.getElementById('menu_name').value != "" && document.getElementById('menu_link').value != "")
		{
			document.getElementById('submitButton').disabled = false;
			//FORM_PostNews.submit.disabled = true;
		}
		else
		{
			document.getElementById('submitButton').disabled = true;
			//FORM_PostNews.submit.disabled = false;
		}
	}
	
	function disableSubmit()
	{
		FORM_Post.submitButton.disabled = true;
	}
</script>
{/literal}
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>權限管理 - {if $action == "new"}新增權限{else if  $action == "modify"}修改權限{/if}</h1>
{if $action == "new"}
<form name="FORM_Post" method="POST" action="newJurisdictionSave.php">
{else if  $action == "modify"}
<form name="FORM_Post" method="POST" action="modifyJurisdictionSave.php">
  {/if}
  <table class="datatable">
    <tr> {if $show_menu_id == 1}
      <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>選單編號</th>
      {/if}
      <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>選單層級</th>
      <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>選單名稱</th>
      <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>選單連結</th>
      <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>使用狀況</th>
    </tr>
    <tr> {if $show_menu_id == 1}
      <td align="left">{$menu_id}</td>
      {/if}
      <td align="center">{$menu_level}</td>
      <td><input name="menu_name" type="text" maxlength="50" onKeyUp="checkData()" value="{$menu_name}"></td>
      <td><input name="menu_link" type="text" maxlength="100" onKeyUp="checkData()" value="{$menu_link}"></td>
      <td><select name="menu_state" onChange="checkData()">
          <option value="y" {if $menu_state == 'y'}selected{/if}>使用</option>
          <option value="n" {if $menu_state == 'n'}selected{/if}>不使用</option>
        </select>      </td>
    </tr>
  </table>
  <input type="hidden" name="parent_menu_id" value="{$parent_menu_id}">
  <input name="menu_id" type="hidden" value="{$menu_id}">
  <input type="hidden" name="menu_level" value="{$menu_level}">
  {if $action == "new"}
  <input type="submit" value="新增" name="submitButton" disabled>
  {else if $action == "modify"}
  <input type="submit" value="修改" name="submitButton" disabled>
  {/if}
  <input type="reset"  value="清除" onClick="disableSubmit()">
</form>
<p class="al-left">
  <input type="button" value="回上一頁" onClick="location.href='jurisdictionManagement.php'">
</p>
</body>
</html>
