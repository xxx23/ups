<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>權限管理</title>
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>系統選單管理</h1>
<div class="fl-rgt">
{if $menu_level == 1}<a href="jurisdictionManagement.php?menu_level=0">回上一層</a>
{elseif $menu_level == 2}<a href="jurisdictionManagement.php?menu_level=1&menu_id={$parent_menu_id}">回上一層</a>{/if}
{if $menu_level == 0}<a href="newJurisdiction.php?menu_level={$menu_level}">新增權限</a>
{elseif $menu_level <= 2}<a href="newJurisdiction.php?menu_level={$menu_level}&parent_menu_id={$menu_id}">新增權限</a>{/if}
</div>
{if $jurisdictionNum > 0}
<table class="datatable">
  <tr>
    <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>排序</th>
    <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>編號</th>
    <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>層級</th>
    <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>名稱</th>
    <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>選單連結</th>
    <th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>使用</th>
  </tr>
  {section name=counter loop=$jurisdictionList}
  <tr>
    <td>{$jurisdictionList[counter].sort_id}</td>
    <td align="left">{$jurisdictionList[counter].menu_id}</td>
    <td>{$jurisdictionList[counter].menu_level}</td>
    <td>{$jurisdictionList[counter].menu_name}</td>
    <td>{$jurisdictionList[counter].menu_link}</td>
    <td>{$jurisdictionList[counter].menu_state}</td>
  </tr>
  <tr>
    <td colspan="5"> <p class="al-left">
        <a href="modify_jurisdiction_sequence.php?option=move_up&menu_id={$jurisdictionList[counter].menu_id}&menu_level={$jurisdictionList[counter].menu_level}">上移</a>
        <a href="modify_jurisdiction_sequence.php?option=move_down&menu_id={$jurisdictionList[counter].menu_id}&menu_level={$jurisdictionList[counter].menu_level}">下移</a>
    {if $jurisdictionList[counter].menu_level < 2} 
    <a href="jurisdictionManagement.php?menu_level={$jurisdictionList[counter].menu_level+1}&menu_id={$jurisdictionList[counter].menu_id}">子權限管理</a>
    <!--<a href="newJurisdiction.php?parent_menu_id={$jurisdictionList[counter].menu_id}&menu_level={$jurisdictionList[counter].menu_level+1}">新增子權限</a>--> {/if} 
        <a href="modifyJurisdiction.php?menu_id={$jurisdictionList[counter].menu_id}&menu_level={$jurisdictionList[counter].menu_level}">修改</a> </a> 
        <a href="deleteJurisdiction.php?menu_id={$jurisdictionList[counter].menu_id}" onClick="return confirm('確定要刪除此權限以及所有的子權限嗎?')">刪除</a> </p></td>
  </tr>
  {/section}
</table>
{else}
<p style="text-align:center;">目前無任何權限</p>
{/if}
</body>
</html>
