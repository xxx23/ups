<HTML>
<head>
<title>各項排名</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<script type="text/javascript" src="{$webroot}script/default.js"></script>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{literal}


<script type="text/javascript">
function mailselect()
{
    var check = document.getElementsByName("pid[]");
    var mail = document.getElementsByName("mail[]");
    var num = check.length;
    var maillist = "";
    for(i = 0 ; i < num ; i++){
      if(check[i].checked && mail[i].value != "")
         maillist += mail[i].value + ",";
    }
    if(maillist == "")
      alert("您尚未選取任何學生");
    else
      document.location.replace("mailto:"+maillist);
}													


function Check() {
	if ( FORM.showNum != null && FORM.showNum.value <= 0 ) {
			alert("筆數輸入錯誤!");
			return false;
	}
	return true;
}

function Check2() {
	if ( nologin.days.value <= 0 ) {
			alert("天數輸入錯誤!");
			return false;
	}
	return true;
}

function changeInputType()
{
	var rank_type = document.all.rank_type;
	
	var DIV_dayNum = document.all.DIV_dayNum;
	var DIV_showNum = document.all.DIV_showNum;
	var DIV_order = document.all.DIV_order;
	
	if(rank_type.value == 'NotLoginCourse')
	{
		DIV_dayNum.style.display = "block";
		DIV_showNum.style.display = "none";
		DIV_order.style.display = "none";
		
	}
	else
	{
		DIV_dayNum.style.display = "none";
		DIV_showNum.style.display = "block";
		DIV_order.style.display = "block";
	}
}

</script>

{/literal}

</head>
<body>

<center>

<div class="form">

<FORM ACTION="{$currentPage}" METHOD="POST" name="FORM">

<fieldset>
<legend>學生課程使用排行榜</legend>

<div align="left">

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;類型：
<SELECT NAME="rank_type" onChange="changeInputType()">
<OPTION VALUE="LoginCourse" {if $rank_type=='LoginCourse'}Selected{/if} {if $rank_type=='DEFAULT'}Selected{/if}>課程登入次數 排行
<OPTION VALUE="NotLoginCourse" {if $rank_type=='NotLoginCourse'}Selected{/if}>查詢n天未登入課程學生
<OPTION VALUE="LoginCourseTime" {if $rank_type=='LoginCourseTime'}Selected{/if}>課程使用時數 排行
<OPTION VALUE="DisscussAreaPost" {if $rank_type=='DisscussAreaPost'}Selected{/if}>討論區發表文章次數 排行
<!--<OPTION VALUE="OnlineTalk" {if $rank_type=='OnlineTalk'}Selected{/if}>聊天次數 排行-->
<OPTION VALUE="ReadText" {if $rank_type=='ReadText'}Selected{/if}>學生瀏覽教材次數 排行
<OPTION VALUE="ReadTextTime" {if $rank_type=='ReadTextTime'}Selected{/if}>學生瀏覽教材總時數 排行
</SELECT>
<BR>

<div id="DIV_dayNum" style="display:{if $isShowDayNum==1}block{else}none{/if}">
天數：<INPUT TYPE=TEXT MAXLENGTH=4 SIZE=4 NAME="dayNum" VALUE="{$dayNum}">
<BR>
</div>

<div id="DIV_showNum" style="display:{if $isShowShowNum==1}block{else}none{/if}">
顯示筆數：<INPUT TYPE=TEXT MAXLENGTH=4 SIZE=4 NAME="showNum" VALUE="{$showNum}">
</div>

<div id="DIV_order" style="display:{if $isShowOrder==1}block{else}none{/if}">
<INPUT TYPE=RADIO NAME="order" VALUE="top" {if $order=='top'}CHECKED{/if}{if $order=='DEFAULT'}CHECKED{/if}>從高到低
<INPUT TYPE=RADIO NAME="order" VALUE="buttom" {if $order=='buttom'}CHECKED{/if}>從低到高
</div>

<INPUT TYPE=SUBMIT VALUE=OK class="btn" OnClick="return Check();">

</div>

<input name="action" type="hidden" value="showRank">
</FORM>

</fieldset>


</div>

<!-- iframe src="{$content}" scrolling="auto" frameborder="0" height="100%" width="100%"-->
<!-- 搜尋結果 -->
<div>

<center>

{if $dataNum > 0}
<form name="studentCourseUseRank">
<table class="datatable">
<tr>
	<th><input type="checkbox" name="" onclick="clickAll('studentCourseUseRank',this);"></th>
	<th>排名</th>
	<th>姓名</th>
	<th>{$rankTypeName}</th>
</tr>
{section name=counter loop=$dataList}
<tr class="{cycle values=",tr2"}">
	<td align><input type="checkbox" name="pid[]" value="{$user.personal_id}"/></td>
	<td align="center">{$dataList[counter].rank}</td>
	<td>{$dataList[counter].name}<input type="hidden" name="mail[]" value="{$dataList[counter].email | strip:'&nbsp';}"></td>
	<td>{$dataList[counter].data}</td>
</tr>
{/section}
</table>

</form>
<input type="button"  class="btn" value="群組寄信" name="sendmail" onclick="mailselect();" />
{/if}

</div>
</center>

<!--
<HR>
查詢超過 n天未登入學生列表<BR>
<FORM ACTION=NoLoginQuery.php METHOD=POST name=nologin>
天數：<INPUT TYPE=TEXT MAXLENGTH=4 SIZE=4 NAME=days VALUE=5><BR>
<INPUT TYPE=SUBMIT VALUE=OK OnClick="return Check2();">
</FORM>
<BR>

-->




</body>
