<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>觀看帳號</title>
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
<script src="myjs.js" type="text/JavaScript" ></script>
<script language="JavaScript" type="text/JavaScript">
<!--
{literal}

function changeSelect(obj, index){
    var id = obj.options[index].getAttribute("value");
	document.getElementById('role').style.display="none";
	document.getElementById('login_id').style.display="none";
	document.getElementById('personal_name').style.display="none";
	document.getElementById('state').style.display="none";
	document.getElementById('validate').style.display="none";
	if(id != 'all')
		document.getElementById(id).style.display="";
}


function doCheckAll(string){
	var nodes = document.getElementsByName(string);
	
	if(nodes.item(0).checked){
		for(var i=0; i < nodes.length ; i++)
			nodes.item(i).checked = false;
	}else{
		for(var i=0; i < nodes.length ; i++)
			nodes.item(i).checked = true;	
	}
}

function doSubmit(id, flag){
	document.getElementById('flag').value = flag;
	document.getElementById('id').value = id;
	document.myform.submit();
	/*switch(id){
		case 'state':
			
			break;
		case 'validate':
		
			break;
		default:
		
			break;	
	}*/
}


{/literal}
-->
</script>
</head>

<body>
<h1>帳號管理</h1>


	<center>
	  <table border="0" align="right" cellpadding="0" cellspacing="0" style="font-size:14px;">
        <tr>
          <td width="90" height="27" ><div class="button001" align="center"><a href="new_account.php">新增使用者</a></div></td>
          {* <td width="90" height="27" ><div class="button001" align="center"><a href="check_academic_admin.php?option=view">審核</a></div></td> *}
        </tr>
      </table>
	</center>

<form method="post" action="./adm_query_user.php?action=search">
<h2>搜尋</h2>
<table class="datatable">
<tr>
	<th width="30%"><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>搜尋依據
	</th>
	<th width="50%"><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>輸入
	</th>		
</tr>
<tr>
	<td >
	<select name="search" onChange="changeSelect(this, this.selectedIndex);">
		<option value="all" selected="selected">全部</option>
		<option value="role" >角色</option>
		<option value="login_id">帳號</option>
		<option value="personal_name">姓名</option>
		<option value="state">使用狀況</option>
		<option value="validate">是否核准</option>
	</select>
	</td>	
	<td>
	<div id="role" style="display:none;">
		<select name="role">
			{html_options values=$role_ids selected=$role_id output=$role_names}
		</select>
	</div>
	<div id="login_id" style="display:none;">
		<input type="text" name="login_id" />
	</div>
	<div id="personal_name" style="display:none;">
		<input type="text" name="personal_name" />
	</div>
	<div id="state" style="display:none;">
		<select name="state">
			<option value="1" selected="selected">使用</option>
			<option value="0">不使用</option>
		</select>
	</div>
	<div id="validate" style="display:none;">
		<select name="validate">
			<option value="0" selected="selected">不核准</option>
			<option value="1">核准</option>			
		</select>
	</div>		
	</td>
</tr>
<tr>
	<td colspan="2">
	<p class="al-left"> <input type="submit" name="送出搜尋" /></p>
	</td>
</tr>
</table>
</form>
{if $show == 1}
<form method="post" name="myform" action="./adm_query_user.php?action=modify&type={$type}&opt={$opt}&page={$page}">
<h2>搜尋結果</h2>
<table id="testTB" name="testTB" class="datatable">
<tr>
	<th style="text-align:center;vertical-align:middle;"><input type="checkbox" name="" onClick="doCheckAll('choose[]')" /></th>
	<th style="text-align:center;vertical-align:middle;" width="19%">帳號</th>
	<th style="text-align:center;vertical-align:middle;" width="10%">姓名</th>
	<th style="text-align:center;vertical-align:middle;" width="15%">角色</th>
	<th style="text-align:center;vertical-align:middle;" width="20%">帳號啟用日期</th>
	<th style="text-align:center;vertical-align:middle;" width="15%">帳號使用狀況</th>
	<th style="text-align:center;vertical-align:middle;" width="15%">帳號是否核准</th>
</tr>
{foreach from=$user item=user}
<tr class="{cycle values="tr2,"}" >
	<td><input type="checkbox" name="choose[]" value="{$user.login_id}" /></td>
	<td width="15%"><a href="user_profile.php?id={$user.personal_id}" target="_blank">{$user.login_id}</a>&nbsp;&nbsp;<a href="sudo_su.php?pid={$user.personal_id}" target="_top">(變身)</a></td>
	<td width="10%">{$user.personal_name}</td>
	<td width="15%">{$user.role_name}</td>
	<td width="20%">{$user.d_loging}</td>
	<td width="12%">{if $user.role_cd ne 0}<a href='./adm_query_user.php?action=state&login_id={$user.login_id}&state={$user.login_state}&type={$type}&opt={$opt}&page={$page}'>{$user.state}</a>{/if}</td>
	<td width="12%">{if $user.role_cd ne 0}<a href='./adm_query_user.php?action=validated&login_id={$user.login_id}&vali={$user.validated}&type={$type}&opt={$opt}&page={$page}'>{$user.vali}</a>{/if}</td>	
</tr>

{/foreach}
</table>
<center>
<input type="hidden" id="flag" name="flag" value="" />
<input type="hidden" id="id" name="id" value="" />
<input type="button" value="使用" onClick="doSubmit('state', 1)" />
<input type="button" value="不使用" onClick="doSubmit('state', 0)" />
<input type="button" value="核准" onClick="doSubmit('validate', 1)" />
<input type="button" value="不核准" onClick="doSubmit('validate', 0)" />
<input type="button" value="刪除" onClick="doSubmit('delete', 1)" />
</center>
</form>
<!--查詢結果不為0筆資料時顯示-->
  {if $numrows != 0}
    <div align="center">查詢結果{$numrows}筆&nbsp;共{$pages}頁<br>第{$page}頁<br>
    {$pageinfo}
    </div>
    
  {/if}
{/if}
<br/><br/><br/><br/><br/>
</body>
</html>
