<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="{$tpl_path}/css/content_course.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/font_style_course.css" rel="stylesheet" type="text/css" />

<script src="{$webroot}script/jquery-1.3.2.min.js" type="text/javascript"></script>
<title>申請開課帳號管理</title>


<script language="javascript" type="text/javascript">
	var script_url = "{$base_url}";
	var verify_url = 'apply_begincourse_account_verify.php'; 
	var default_url_param = {$default_url_param_json} ; 
{literal}
	
function gen_url_param() {
	var param_str = "?1=1"; 
	for(var i in default_url_param ) {
		param_str += "&" + i + "=" +  encodeURIComponent(default_url_param[i]) ;
	}
	return param_str ;	
}

function jump_page_by_param(){
	default_url_param[$(this).attr('id')] = $(this).val(); 
	location =  script_url + gen_url_param() ; 
}

function verify_account(no) {
	default_url_param['no'] = no ;
	location = verify_url + gen_url_param() ;  
}


$(document).ready( function (){
	$("#list_type").change( jump_page_by_param ); 
	$("#category").change( jump_page_by_param ) ;
	$("#page").change( jump_page_by_param ) ;
});

{/literal}
</script>
</head>
<body>
<h1>開課帳號列表</h1>
<div align="center">
	
	帳號狀態：
	<select name="list_type" id="list_type">
		<option value="0" {if $list_type==0}selected{/if}>尚未審核</option>
		<option value="1" {if $list_type==1}selected{/if}>已通過</option>
		<option value="-1" {if $list_type==-1}selected{/if}>不通過</option>
	</select>
	&nbsp;&nbsp; 
	開課單位身份：
	<select name="category" id="category">
		{html_options options=$category.options selected=$category.selected}
	</select>	
	
	
	&nbsp;&nbsp; 
{if !empty($pageOptions.page_ids) }	
	頁數：
	<select name="page" id="page">
	{html_options values=$pageOptions.page_ids output=$pageOptions.page_names selected=$pageOptions.page_sel}
	</select>
{/if} 


</div>
<hr/>

<br/>

<div id='account_list'>
	<table class="datatable" width="90%" border="1" align="center">
		<caption>{$page_title}</caption>
		<tr>
			<th>開課帳號</th>
			<th>開課單位</th>
			<th>聯絡人(E-mail)</th>
			<th>電話</th>
	{if $default_url_param.list_type == 0}
			<th>審核狀況</th>
    {/if}
            <th>申請日期</th>
		</tr>
{foreach from=$account_data item=row}
		<tr>
			<td>{$row.account}</td>
			<td>{$row.org_title}</td>
			<td><a href="mailto:{$row.email}">{$row.undertaker}</a></td>
			<td>{$row.tel}</td>
	{if $default_url_param.list_type == 0}			
			<td><input type="button" value="審核" onClick="verify_account({$row.no})"/></td>
	{/if}
            <td>{$row.apply_date}</td>
		</tr>
{foreachelse}
		<tr>
			<td colspan="6" style="text-align:center">
				目前尚無資料
			</td>
		</tr>
{/foreach}

	</table>
</div>


</body>
</html>
