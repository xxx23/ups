<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<link href="{$tpl_path}/css/content_course.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/font_style_course.css" rel="stylesheet" type="text/css" />
<title>審核課程</title>
</head>
<body>
<h1>審核課程</h1>

<div>
<table class="datatable">
<tr>
	<th>課程性質</th>
	<td>
	{section name=counter loop=$total_course_property}
		{if $course_property eq $total_course_property[counter].property_cd}
			{$total_course_property[counter].property_name}
		{/if}
	{/section}
	</td>
</tr>
<tr>
	<th width="300">本課程是否傳送高師大申請研習時數</th>
	<td>
	{if $deliver eq 1} 是 {/if} 
	{if $deliver eq 0} 否 {/if} 
	</td>
</tr>
<tr>
	<th width="300">本課程是否開放給訪客閱讀</th>
	<td>
	{if $guest_allowed eq 1} 是 {/if}
	{if $guest_allowed eq 0} 否{/if}
	</td>
</tr>
{if $deliver == 1}
<tr>
	<th>依據文號</th>
	<td>
		{$article_number}
	</td>
</tr>
<tr>
	<th>課程研習對象階段</th>
	<td> 
        {if $check_stage1} 高中 {/if}>
        {if $check_stage2} 高職 {/if}>
        {if $check_stage3} 國中 {/if}>
        {if $check_stage4} 國小 {/if}>
    </td>
</tr>
<tr>
	<th>課程研習對象身分</th>
	<td>
	{if $career_stage eq "無"} 無{/if}>
	{if $career_stage eq "校長"} 校長 {/if}>
	{if $career_stage eq "主任"} 主任 {/if}>
	{if $career_stage eq "一般教師"} 一般教師 {/if}>
	</select>
	</td>
</tr>
{/if}
<tr>
	<th>課程名稱</th>
	<td>{$begin_course_name}</td>
</tr>
<tr>
	<th>課程編號</th>
	<td>{$inner_course_cd}
</tr>
{if $attribute == 1}
<tr>
        <th>課程時數</th>
	<td>{$take_hour}</td>
</tr>
{/if}
{if $deliver eq 1}
<tr>
    <th>認証時數</th>
	<td>{$certify}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="preview_content.php?begin_course_cd={$begin_course_cd}" target="_blank">預覽教材是否符合時數</a>
	</td>			
</tr> 
{/if}

{if $attribute == 1}
<tr>
    <th>教材是否試閱</th>
	<td>
	{if $is_preview == 1}
		是
	{else}
		否
	{/if}
	</td>				
</tr>
{/if}
<tr>
	<th>課程類別</th>
	<td>
	{section name=counter loop=$total_course_unit}
		{if $upper_course_type eq $total_course_unit[counter].unit_cd}
			{$total_course_unit[counter].unit_name}
		{/if}
	{/section}
	</td>
</tr>
<tr>
	<th>課程子類別</th>
	<td>
	{section name=counter loop=$total_course_subunit}
		{if $begin_unit_cd eq $total_course_subunit[counter].unit_cd}
			{$total_course_subunit[counter].unit_name}
		{/if}
	{/section}
	</td>
</tr>
<tr>
	<th>修課期限</th>
	<td>
		{if $course_duration eq 1} 1個月 {/if}
		{if $course_duration eq 2} 2個月 {/if}
		{if $course_duration eq 3} 3個月 {/if}
		{if $course_duration eq 4} 4個月 {/if}
		{if $course_duration eq 5} 5個月 {/if}
		{if $course_duration eq 6} 6個月 {/if}
		{if $course_duration eq 7} 7個月 {/if}
		{if $course_duration eq 8} 8個月 {/if}
		{if $course_duration eq 9} 9個月 {/if}
		{if $course_duration eq 10} 10個月 {/if}
		{if $course_duration eq 11} 11個月 {/if}
		{if $course_duration eq 12} 12個月 {/if}
    </td>
</tr>

{if $attribute == 1}
<tr>
    <th>課程開始日期</th>
	<td>	{$d_course_begin} </td>
</tr>
<tr>
	<th>課程結束日期</th>	
	<td>{$d_course_end}	</td>
</tr>
<tr>
	<th>開課公開日期</th>
	<td>{$d_public_day}</td>	
</tr>
<tr>
	<th>選課開始日期</th>
	<td> {$d_select_begin}	</td>
</tr>
<tr>
	<th>選課結束日期</th>
	<td> {$d_select_end} </td>
</tr>
<tr>
	<th>開課所屬的學年</th>
	<td> {$course_year} 學年 </td>	
</tr>		
<tr>
	<th>開課所屬的學期</th>
	<td> {$course_session} 學期	</td>	
</tr>
<tr>
        <th>招收名額</th>
      <td> {$quantity} 人</td>
</tr>
<tr>
        <th>學習費用</th>
      <td> 定價 {$charge} 元
        <font color="red">*優惠價</font> {$charge_discount}元
        </td>
	</tr>
<tr>
        <th>上課縣市</th>
      <td> {$class_city}縣(市) </td>
</tr>
<tr>
        <th>上課地點</th>
      <td> {$class_place} </td>
</tr>
{/if}{** end if $attribute == 1 *}

<tr>
        <th>評量標準(總分)</th>
      <td> {if $criteria_total eq 0}無須測驗{else}{$criteria_total} {/if}</td>
</tr>

{if $attribute == 1}
<tr>
        <th>評量標準(線上成績)</th>
      <td> {$criteria_score}</td>
</tr>
<tr>
        <th>評量標準(線上成績比例)</th>
      <td> {$criteria_score_pstg} % </td>
</tr>
<tr>
        <th>評量標準(老師成績)</th>
      <td> {$criteria_tea_score} </td>	
</tr>
<tr>
        <th>評量標準(老師成績比例)</th>
      <td> {$criteria_tea_score_pstg} % </td>
</tr>
{/if}
<tr>
        <th>評量標準(觀看教材時間)</th>
      <td> {$criteria_content_hour_1} 時 {$criteria_content_hour_2} 分 </td>
</tr>
{if $attribute == 1}
<tr>
        <th>評量標準(問卷填寫)</th>
      <td> {$criteria_finish_survey} % </td>
</tr>
{/if}
<tr>
        <th>承辦人</th>
      <td> {$director_name} [ {$undertaker_title}]  </td>
</tr>
<tr>
        <th>承辦人電話</th>
      <td> 區碼: {$director_tel_area} -{$director_tel_left} # {$director_tel_ext}(分機) </td>
</tr>
<tr>
        <th>承辦人電子信箱</th>
      <td> {$director_email} </td>
</tr>
{if $attribute == 1}
<tr>
        <th>課程自動審查</th>
		<td>{if $auto_admission == 1} 是
			{else} 	否 	{/if}
		</td>
</tr>
<tr>
        <th>備註</th>
        <td>{$note}</td>
</tr>
{/if}
<tr>
        <th>教材名稱</th>
        <td>{$content_name}</td>
</tr>
<tr>
        <th>教師名稱</th>
        <td>{$teacher_name}</td>
</tr>

</table>

</div>
</body>
</html>
