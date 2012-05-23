<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
{if $action == "new"}
<title>新增角色</title>
{else if  $action == "modify"}
<title>修改角色</title>
{/if}
{literal}
<script language="JavaScript" type="text/javascript">

	function checkData()
	{	
		if(document.getElementById('role_name').value != "")
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
<h1>角色權限管理-{if $action == "new"}新增角色{else if  $action == "modify"}修改角色{/if}</h1>
  {if $action == "new"}
  <form name="FORM_Post" method="POST" action="newRoleSave.php">
  {else if  $action == "modify"}
  <form name="FORM_Post" method="POST" action="modifyRoleSave.php">
    {/if}
    <table class="datatable">
      <tr>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>角色編號</th>
        <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>角色名稱</th>
      </tr>
      <tr>
        <td align="left"> {if $show_role_cd == 1}
          {$role_cd}
          {else}
          <input type="text" size="5" name="role_cd"/>
          {/if} </td>
        <td align="center"><input type="text" name="role_name" value="{$role_name}" onKeyUp="checkData()"></td>
      </tr>
      <tr>
        <td colspan="2" align="left">
        {if $show_role_cd == 1}
    <input name="role_cd" type="hidden" value="{$role_cd}">
    {/if}
    
<p class="al-left">    
    {if $action == "new"}
    <input type="submit" value="新增" name="submitButton" disabled>
    {else if $action == "modify"}
    <input type="submit" value="修改" name="submitButton" disabled>
    {/if}
    <input type="reset"  value="清除" onClick="disableSubmit()"></p>
</td>
      </tr>
    </table>
  </form>
<p class="al-left">
  <input type="button" value="回上一頁" onClick="location.href='roleManagement.php'">
</p>
</body>
</html>
