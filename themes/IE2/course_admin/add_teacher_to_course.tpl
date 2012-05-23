{config_load file='common.lang'}

{config_load file='course_admin/add_teacher_to_course.lang'} 

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>{#add_teacher_to_course#}</title>

<link href="{$tpl_path}/css/table_news.css" rel="stylesheet" type="text/css">
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="{$webroot}script/jquery-1.3.2.min.js"></script>

<script language="javascript" type="text/javascript">
{literal}
    function updateTeacherList()
    {
{/literal}
        $url = './add_teacher_to_course.php?begin_course_cd={$begin_course_cd}';
        $url = $url + '&' + 'search=' + $('#search_type').val();
        $url = $url + '&' + 'value=' + $('#search_value').val();
        $('#teacher_list').load($url +  ' #teacher_cd');
{literal}
    }
{/literal}
{literal}
    function showInput()
    {
        $type = $('#search_type').val();
        if($type == 'all')
        {
            $('#search_value').hide();
        }
        else
        {
            $('#search_value').show();
        }
    }
{/literal}
</script>

</head>



<body class="ifr" >

<!-- 標題 -->

<h1>{#course_data#}</h1>

<!-- 內容說明 -->

<div>

<br />

{if $attribute == 1}

{#instruction#}<br />

	<font color="#FF0000">{#instr_first#}</font><br />

	<font color="#FF0000">{#instr_second#}</font><br />

	<font color="#FF0000">{#instr_caution#}</font><br />

	<br />

{/if}

{if $attribute == 0}

	<div class="searchbar" style="margin-left:50px;width:85%;" ><strong><font color="#003399" align="center">{#course_success#}</font></strong></div><br />

{/if}

</div>

<!--功能部分 -->

<div class="searchbar" style="margin-left:50px;width:85%;padding:20px;" ><table class="datatable" style="width:80%;margin-left:25px;">

<tr >

	<th width="30%" height="30">{#course_name#}</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$begin_course_name}</td>

</tr>

<tr>

	<th height="30">{#course_unit#}</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$begin_unit_cd}</td>

</tr>

<tr>

	<th height="30">{#inner_code#}</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$inner_course_cd}</td>

</tr>

<tr>

	<th height="30">{#course_nature#}</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$property_name}</td>

<tr>

{if $attribute == 0} <!-- 表示是自學式的課程 -->

<tr>

	<th height="30">{#deadline#}</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$month}</td>

</tr>

<!--

<tr>

	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>課程時數</th><td>{$take_hour}小時</td>

</tr>

-->

<tr>

	<th height="30">{#auth_hour#}</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$certify}{#hour#}</td>

</tr>

<!--

<tr>

	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>學習費用</th><td>{$charge}元</td>

</tr>

-->

<tr>

	<th height="30">{#standard#}</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$criteria_total}分</td>

</tr>

<tr>

	<th height="30">{#study_hour#}</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$criteria_content_hour}</td>

</tr>

{/if}

{if $attribute == 1} <!-- 表示是教導式的課程 -->

<tr>

	<th height="30">{#course_start_date#}</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$d_course_begin}</td>

</tr>

<tr>

	<th height="30">{#course_end_date#}</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$d_course_end}</td>

</tr>

<tr>

	<th height="30">{#course_public_date#}</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$d_public_day}</td>

</tr>

<tr>

	<th height="30">{#choose_course_start_date#}</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$d_select_begin}</td>

</tr>

<tr>

	<th height="30">{#choose_course_end_date#}</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$d_select_end}</td>

</tr>

<tr>

	<th height="30">{#course_belong_year#}</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$course_year}</td>

</tr>

<tr>

	<th height="30">{#course_belong_semester#}</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$course_session}</td>

</tr>

{/if}
</table></div>

<hr width="100%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;">

<form action="./begin_course_mail.php" method="get">

<h2>{#teacher#}</h2>

<table class="datatable">

<input type="hidden" name="begin_course_cd" value="{$begin_course_cd}" />

<tr>

	<th><div align="center">{#member_code#}</div></th>

	<th><div align="center">{#account#}</div></th>

	<th><div align="center">{#teacher_name#}</div></th>

	<th><div align="center">{#main_filler#}</div></th>

	<th><div align="center">{#drop#}</div></th>

</tr>

{foreach from=$teacher_data item=teacher}

<tr>

	<input type="hidden" name="personal_id[]" value="{$teacher.personal_id}" />

	<td><div align="center">{$teacher.personal_id}</div></td>

	<td><div align="center">{$teacher.login_id}</div></td>

	<td><div align="center">{$teacher.personal_name}</div></td>

	<td><div align="center">{$teacher.course_master}</div></td>

	<td><div align="center"><a href="./add_teacher_to_course.php?action=deleteTeacher&teacher_cd={$teacher.personal_id}&course_cd={$course_cd}&begin_course_cd={$begin_course_cd}">刪除</a></div></td>

</tr>

{/foreach}

<tr>

	<td colspan="5">

	<p class="al-left"> <input type="submit" value="{#send_notice_letter#}" /></p>

	</td>

</tr>

</table>

</form>

<div class="intro">

  <ol>

    <li><div id="message" style="color:#0000FF">{$message}</div></li>

    <li><div id="err_message" style="color:#FF0000;">{$err_message}</div></li>

  </ol>

</div>

<form method="post" action="add_teacher_to_course.php?action=addTeacher">

<input type="hidden" name="course_cd" value="{$course_cd}" />

<input type="hidden" name="begin_course_cd" value="{$begin_course_cd}" />

<h2>{#add_teacher#}</h2>

<div id='search_div'>
<select name='search_type' id='search_type' onchange="showInput();">
    <option value='all'>搜尋全部(預設)</option>
    <option value='name'>搜尋姓名</option>
    <option value='account'>搜尋帳號</option>
</select>
{*<input type='radio' name='search_type' value='name' checked="checked" /> 搜尋全部(預設) <br />
<input type='radio' name='search_type' value='name' /> 搜尋姓名 <br />
<input type='radio' name='search_type' value='account' /> 搜尋帳號 <br />
*}
<input type='text' name='search_value' id='search_value' value='' style='display:none;'/>
<input type='button' name='submit_search' value='搜尋' onclick="updateTeacherList();" />
</div>
{#choice#}<br />

    <div id='teacher_list'>
        <select name="teacher_cd" id="teacher_cd">

        {html_options values=$teacher_ids selected=$teacher_id output=$teacher_names}

        </select>
    </div>
    <br />

{#main_filler_semi#}

	{html_radios name="course_master" values=$course_master_ids checked=$course_master_id output=$course_master_names separator=" "}

	<br />

	<input type="submit" value="{#send#}">

</form>

</body>

</html>

