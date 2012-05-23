{config_load file='common.lang'}
{config_load file='examine/set_publish.lang'} 
<html>
<meta http-equiv="Cache-Control" content="no-cache,no-store,must-revalidate,max-age=0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<script type="text/javascript" src="{$webroot}script/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="{$webroot}script/jquery-ui-1.7.2.custom.min.js"></script>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<link href="{$webroot}css/jquery/jquery-ui-1.7.2.custom_1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
{literal}
$(document).ready(function(){
    $("#pub_date").datepicker({dateFormat:'yy-mm-dd',
                                         monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                                         monthNamesShort:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                                         changeMonth:true,
                                         changeYear:true
                                         });
    $("#start_date").datepicker({dateFormat:'yy-mm-dd',
                                         monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                                         monthNamesShort:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                                         changeMonth:true,
                                         changeYear:true
                                         });
    $("#stop_date").datepicker({dateFormat:'yy-mm-dd',
                                         monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                                         monthNamesShort:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                                         changeMonth:true,
                                         changeYear:true
                                         });
    });
{/literal}
</script>

<head/>

<body>
<h1>{#set_publish#}</h1>
<table class="datatable">
	<tr>
		<th>{#current_status#}{$state}</th>
	</tr>
	<tr>
		<td>{$time}</td>
	</tr>
</table>
<form method="post" action="set_publish.php?test_no={$test_no}">
<table class="datatable">
	<tr>
		<th>{#exam_name#}</th><th>{#publish_time#}</th>
	</tr>
	<tr>
		<td>{$name}</td>
		<td>
			<input type="text" id="pub_date" name="pub_date" size="10" value="{$pub_date}" readonly/>
			<select name="pub_hour">
				{html_options values=$pub_hour output=$phour_list selected=$pnow_hour}
			</select>&nbsp;{#hour#}&nbsp;
			<select name="pub_minute">
				{html_options values=$pub_minute output=$pminute_list selected=$pnow_minute} 
			</select>&nbsp;{#minute#}&nbsp;		</td>
	</tr>
	<tr>
		<th>{#exam_start_time#}</th><th>{#exam_end_time#}</th>
	</tr>
	<tr>
		<td>
			<input type="text" id="start_date" name="start_date" size="10" value="{$start_date}" readonly/>
			<select name="start_hour">
				{html_options values=$start_hour output=$shour_list selected=$snow_hour}
			</select>&nbsp;{#hour#}&nbsp;
			<select name="start_minute">
				{html_options values=$start_minute output=$sminute_list selected=$snow_minute}
			</select>&nbsp;{#minute#}&nbsp;		</td>
		<td>
			<input type="text" id="stop_date" name="stop_date" size="10" value="{$stop_date}" readonly/>
			<select name="stop_hour">
				{html_options values=$stop_hour output=$dhour_list selected=$dnow_hour}
			</select>&nbsp;{#hour#}&nbsp;
			<select name="stop_minute">
				{html_options values=$stop_minute output=$dminute_list selected=$dnow_minute}
			</select>&nbsp;{#minute#}&nbsp;		</td>
	</tr>
</table>
<p class="al-left"><input type="hidden" name="option" value="modify"/>
<input type="hidden" name="test_no" value="{$test_no}"/>
<input type="reset" class="btn" value="{#reset#}"/>
<input type="submit" class="btn" value="{#submit#}"/></p>
</form>
<p class="al-left"><a href="tea_view.php"><img src="{$tpl_path}/images/icon/return.gif" />{#bact_to_exam_list#}</a></p>
</body>

</html>
