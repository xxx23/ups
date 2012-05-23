<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>角色權限管理</title>
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />

</head>
<body>
<h1>{$role_name}選單權限管理</h1>
{if $jurisdictionNum > 0}
<form name="FORM_Post" method="POST" action="modifyRoleJurisdictionSave.php">
  <input type="hidden" name="role_cd" value="{$role_cd}">
  <input type="hidden" name="jurisdictionNum" value="{$jurisdictionNum}">
  
  <table border="1" class="datatable">
  <tr>
    <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>使用</th>
	  <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>編號</th>
	  <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>層級</th>
	  <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>名稱</th>
	  <th width="50%"><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>選單連結</th>
	  <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>使用</th>
  </tr>
    {section name=counter loop=$jurisdictionList}
  <tr>
    <input type="hidden" name="menu_id_{$jurisdictionList[counter].number}" value="{$jurisdictionList[counter].menu_id}"/>
    <td>
      <input type="checkbox" name="is_used_{$jurisdictionList[counter].number}" {if $jurisdictionList[counter].is_used == 'y'} checked {/if}/>	</td>
	  <td align="left">{$jurisdictionList[counter].menu_id}</td>
	  <td>{$jurisdictionList[counter].menu_level}</td>
	  <td>{$jurisdictionList[counter].menu_name}</td>
	  <td width="50%">{$jurisdictionList[counter].menu_link}</td>
	  <td>{$jurisdictionList[counter].is_used}</td>
  </tr>    {/section}
  <tr>
    <td colspan="6"><p class="al-left">  
<input type="submit" value="修改" name="submitButton">
  <input type="reset"  value="清除"></p></td>
    </tr>
  </table>

</form>
{/if}
<p class="al-left">
<input type="button" value="回上一頁" onClick="location.href='roleManagement.php'">
</p>
</body>
</html>
