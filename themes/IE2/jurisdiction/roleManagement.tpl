<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>角色管理</title>
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />

</head>
<body>
  <h1>角色權限管理</h1>
  <font color="red">管理者以及教務管理者不可進行權限管理</font>
  <div class="fl-rgt"><a href="newRole.php">新增角色</a></div> 
  {if $roleNum > 0} 
<table class="datatable">
  <tr>
    <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>角色編號</th>
    <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>角色名稱</th>
    <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/></th>
    <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/></th>
    <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/></th>
  </tr>
  {section name=counter loop=$roleList}
  <tr>
    <td align="left">{$roleList[counter].role_cd}</td>
    <td>{$roleList[counter].role_name}</td>
    
    {if $roleList[counter].role_cd == 0 || $roleList[counter].role_cd == 6}
        <td>權限管理 </td>
    {else}
    	<td><a href="modifyRoleJurisdiction.php?role_cd={$roleList[counter].role_cd}">權限管理</a> </td>
    {/if}
    <td><a href="modifyRole.php?role_cd={$roleList[counter].role_cd}">修改</a> </td>
    <td><a href="deleteRole.php?role_cd={$roleList[counter].role_cd}" onClick="return confirm('確定要刪除此角色嗎?')">刪除</a> </td>
  </tr>
  {/section}
</table>
{/if}
</body>
</html>
