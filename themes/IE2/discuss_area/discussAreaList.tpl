<html>
<head>
<title>討論區一覽</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
{literal}
<script language="Javascript">

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

/*
var xmlHttp = createXMLHttpRequest();
var url = "discussAreaList_intoDiscussArea.php";
var cache = new Array();
	
//建立XMLHttp物件
function createXMLHttpRequest()
{
	var xmlHttp;

	if(window.ActiveXObject)
	{
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if(window.XMLHttpRequest)
	{
		xmlHttp = new XMLHttpRequest();
	}
		
	return xmlHttp;
}

//進入討論區
function intoDiscussArea(discuss_cd)
{	
	cache.push("discuss_cd=" + discuss_cd);

	xmlHttp.open("POST", url, false);	//必須等待處理完才進入討論區
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlHttp.send( cache.shift());
}
*/
</script>
{/literal}
</head>
<body>
<h1>討論區列表</h1>
<form name="handle" action="discussAreaListAction.php" method="post">
  <table class="datatable">
    <tr>
      <th>選取</th>
      <th>討論區名稱</th>
      <th>討論區主旨</th>
      <th>種類</th>
      {if $isModifyOn == 1}
      <th>修改</th>
      {/if}
      <th>訂閱狀況</th>
    </tr>
    <!---------------------討論區列表------------------------->
    {section name=counter loop=$discussAreaList}
    <tr class="{cycle values=",tr2"}">
      <td><input type="checkbox" name="discuss_cd_{counter}" value="{$discussAreaList[counter].discuss_cd}" onBlur="selected=(selected || this.checked);"></td>
      <td><!--<a href="showArticleList.php" onClick="intoDiscussArea({$discussAreaList[counter].discuss_cd})">{$discussAreaList[counter].discuss_name}</a>-->
        <a href="discussAreaList_intoArticleList.php?behavior={$behavior}&discuss_cd={$discussAreaList[counter].discuss_cd}">{$discussAreaList[counter].discuss_name}</a> </td>
      <td>{$discussAreaList[counter].discuss_title}</td>
      <td> {if $discussAreaList[counter].discuss_type == '課程精華區'} <img src="{$tpl_path}/images/icon/discuss_good.gif" alt="課程精華區" /> {elseif $discussAreaList[counter].discuss_type == '小組討論區'} <img src="{$tpl_path}/images/icon/discuss_group.gif" alt="小組討論區" /> {else}
        <img src="{$tpl_path}/images/icon/discuss_course.gif" alt="課程討論區" />
        {/if} </td>
      {if $isModifyOn == 1 && $discussAreaList[counter].isOneDiscussAreaModifyOn == 1}
      <td><a href="modifyDiscussArea.php?behavior={$behavior}&discuss_cd={$discussAreaList[counter].discuss_cd}"><img src="{$tpl_path}/images/icon/edit.gif"></a></td>
      {elseif $isModifyOn == 1}
	  <td>&nbsp;</td>
	  {/if}
      <td> {if $discussAreaList[counter].subscribe == 1} <img src="{$tpl_path}/images/icon/open.gif">{else}<img src="{$tpl_path}/images/icon/close.gif">
        
        {/if} </td>
    </tr>
    {/section}
    <!-------------------------------------------------------->
  </table>
  <img src="{$imagePath}arrow_ltr.gif" border="0" width="38" height="22" alt="選擇的動作" >
  <input type="hidden" name="behavior" value="{$behavior}">
  <input type="hidden" name="discussAreaNum" value="{$discussAreaNum}">
  {if $isDeleteOn == 1}
  <input type="submit" name="submit" value="刪除討論區" onClick="check(selected, 1);" class="btn">
  {/if}
  {if $isSubscribeOn == 1}
  <input type="submit" name="submit" value="訂閱" onClick="check(selected, 2);" class="btn">
  <input type="submit" name="submit" value="停訂" onClick="check(selected, 2);" class="btn">
  {/if}
  {if $isBackupOn == 1}
  <input type="submit" name="submit" value="輸出備份" onClick="check(selected, 3);" class="btn">
  {/if}
</form>

<p class="intro">
圖示說明：<br>
<img src="{$tpl_path}/images/icon/open.gif">表已訂閱討論區。<img src="{$tpl_path}/images/icon/close.gif">表未訂閱。<br><img src="{$tpl_path}/images/icon/discuss_course.gif" />表課程討論區。<img src="{$tpl_path}/images/icon/discuss_group.gif">表小組討論區。<img src="{$tpl_path}/images/icon/discuss_good.gif" />表課程精華區。</p>


</body>
</html>
