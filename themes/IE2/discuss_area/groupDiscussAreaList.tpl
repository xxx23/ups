<html>
<head>
<title>討論區一覽</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
{literal}
<script type="text/javascript">
var selected = false;
function check(selected, type) 
{
	switch (type) 
	{
	case 1:
			if(selected) 
			{
				return confirm('這將會刪除你所選的所有討論區!!');
			}
	case 2:
			if(selected) 
			{
				return true;
			}
	case 3:
			if(selected) 
			{
				//return alert('討論區資料將輸出到 /教材目錄/misc/backup.tar.gz\n可由 教材製作->上傳檔案 處下載');
				return true;
			}
	default:
			return false;
	}

	return false;
}

</script>
{/literal}
</head>
<body>
<h1>教師社群討論區列表</h1>
<form name="handle" action="groupDiscussAreaListAction.php" method="post">
  <table class="datatable">
    <tr>
      <th>選取</th>
      <th>教師社群討論區名稱</th>
      <th>教師社群討論區主旨</th>
      {if $isModifyOn == 1}
        {if $isCourseMaster == 1}
      <th>修改</th>
        {/if}

      {/if}
    </tr>
    <!---------------------討論區列表------------------------->
    {section name=counter loop=$discussAreaList}
    <tr class="{cycle values=",tr2"}">
      <td><input type="checkbox" name="discuss_cd_{counter}" value="{$discussAreaList[counter].discuss_cd}" onBlur="selected=(selected || this.checked);"></td>
      <td><!--<a href="showArticleList.php" onClick="intoDiscussArea({$discussAreaList[counter].discuss_cd})">{$discussAreaList[counter].discuss_name}</a>-->
        <a href="groupDiscussAreaList_intoArticleList.php?behavior={$behavior}&discuss_cd={$discussAreaList[counter].discuss_cd}">{$discussAreaList[counter].discuss_name}</a> </td>
      <td>{$discussAreaList[counter].discuss_title}</td>
{if $isCourseMaster == 1}
      {if $isModifyOn == 1 && $discussAreaList[counter].isOneDiscussAreaModifyOn == 1}
      <td><a href="modifyGroupDiscussArea.php?behavior={$behavior}&discuss_cd={$discussAreaList[counter].discuss_cd}"><img src="{$tpl_path}/images/icon/edit.gif"></a></td>
      {elseif $isModifyOn == 1}
	  <td>&nbsp;</td>
	  {/if}
      {* delete by carlcarl
      <td> {if $discussAreaList[counter].subscribe == 1} <img src="{$tpl_path}/images/icon/open.gif">{else}<img src="{$tpl_path}/images/icon/close.gif">
        
        {/if} </td>*}
{/if}
    </tr>
    {/section}
    <!-------------------------------------------------------->
  </table>
{if $isCourseMaster == 1}
  <img src="{$imagePath}arrow_ltr.gif" border="0" width="38" height="22" alt="選擇的動作" >
{/if}
  <input type="hidden" name="behavior" value="{$behavior}">
  <input type="hidden" name="discussAreaNum" value="{$discussAreaNum}">
{if $isCourseMaster == 1}
  {if $isDeleteOn == 1}
  <input type="submit" name="submit" value="刪除教師社群討論區" onClick="check(selected, 1);" class="btn">
  {/if}
{/if}
{if $isBackupOn == 1}
    <input type="submit" name="submit" value="輸出備份" onClick="check(selected, 3);" class="btn">
{/if}

</form>

</body>
</html>
