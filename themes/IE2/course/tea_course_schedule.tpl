<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>課程大綱</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<script src="{$webroot}script/prototype.js" type="text/javascript" ></script>
<script src="{$webroot}script/calendar.js" type="text/javascript" ></script>
<script src="{$tpl_path}/script/course/tea_course_schedule.js" type="text/javascript"></script>
</head>

<body onmousemove="moveit();" onmouseup="stopdrag();">
<div id="information">tpl_path:{$tpl_path}</div>
<h1>編輯課程進度表</h1>
<p class="intro">
說明：<br/>
按下<span class="imp">新增一筆資料</span>的按鈕可以<strong>新增一筆資料</strong>。<br/>
按下<span class="imp">修改計算單位</span>的按鈕可以<strong>修改計算單位</strong>。<br/>
</p>
<!-- 標題 -->
<h1>{$course_name}的課程進度表</h1>
<input type="button" id="new_button" class="btn" onclick="showDataInputArea('newInputArea');" value="新增一筆資料" />
<input type="button" class="btn" onclick="showUnitArea('unitArea');" value="修改計算單位" />
<!-- 計算單位 -->
<div id="unitArea" style="display:none;" class="form">
<select name="unit" id="courseUnitSelect" onchange="changeCourseUnit(this);">
{html_options values=$unit_ids selected=$unit_id output=$unit_names}
</select>
</div>

<!--課程進度 -->
<table id="course_schedule" class="datatable">
<thead>
<tr>
	<th id="courseUnit">期數({$schedule_unit})</th>
	<th>日期</th>
	<th>內容</th>
	<th>上課方式</th>
	<th>授課教師</th>
	<th>教學活動</th>
	<th>修改</th>
	<th>刪除</th>	
</tr>
</thead>
<tbody>
{foreach from=$schedule_data item=schedule}
<tr class="{cycle values='tr2, '}">
	<td>{$schedule.schedule_index}</td>
	<td>{$schedule.course_schedule_day}</td>
	<td>{$schedule.subject}</td>
	<td>{$schedule.course_type}</td>
	<td>{$schedule.teacher_name}</td>
	<td>{$schedule.course_activity}</td>
	<td><div  onclick="modifyThisRow(this);" style="cursor:pointer;"><img src="{$tpl_path}/images/icon/edit.gif" /></div></td>
	<td><div  onclick="deleteThisRow(this);" style="cursor:pointer;"><img src="{$tpl_path}/images/icon/delete.gif" /></div></td>	
</tr>
{/foreach}
</tbody>
</table>

<!-- 編輯區域 -->
<div class="form" id="newInputArea" style="background-color:#FFFFFF;border:5px solid white;display:none;position:absolute;width:350px;">
<form>
<table class="datatable">
<tr>
	<th><div style="cursor:move;width:100%;height:100%;" onmousedown="init();"></div></th>
</tr>
<tr>
	<td>
	<span class='required'>*</span>選擇插入點：
	<select name="position" id="positionSelect">
	{html_options values=$position_ids selected=$position_id output=$position_names}
	</select>	</td>
</tr>
<tr>
	<td>
	<span class='required'>*</span>日期：
	<input type="text" name="e_date" />
	<script language=javascript type="text/javascript">
	<!--
	  var myDate=new dateSelector();
	  myDate.year;
	  myDate.inputName='e_date';  
	  myDate.display();
	-->
	</script>	</td>
</tr>
<tr>
	<td>
	課程內容：	  <textarea name="textarea"></textarea>
	</td>
	</tr>
<tr>
  <td>上課方式： <input type="text" name="course_type" /> </td>
</tr>
<tr>
  <td>	授課教師： <select name="teach_teacher">{html_options values=$teach_teacher_ids selected=$teach_teacher_id output=$teach_teacher_names}</select> </td>
</tr>
<tr>
  <td>	教學活動： <textarea name="course_activity" ></textarea>
</td>
</tr>
</table>
<div class="buttons">
	<input type="button" class="btn" value="放棄編輯" onclick="cancelEdit('newInputArea');" />
	<input type="button" class="btn" value="確定送出" onclick="submitInputArea('newInputArea');" />
</div>	
</form>
</div>
<!-- hint-->
<div id="hint" class="form" style="display:none;position:absolute;"></div>




<!-- 編輯區域 -->
<div class="form" id="modifyInputArea" style="background-color:#FFFFFF;border:5px solid white;position:absolute;width:350px;display:none;">
<form>
<table width="100%" class="datatable">
<tr>
	<th><div style="cursor:move;width:100%;height:100%;" onmousedown="init();"></div></th>
    </tr>
<tr>
	<td>
	<input type="text" name="position" disabled="disabled" />	</td>
    </tr>
<tr>
	<td>
	<span class='required'>*</span>日期：
	<input type="text" name="m_date" value="{$data}"/>
	<script language=javascript type="text/javascript">
	<!--
	  var myDate=new dateSelector();
	  myDate.year;
	  myDate.inputName='m_date';  
	  myDate.display();
	-->
	</script>	</td>
    </tr>
<tr>
	<td>
	課程內容：
	<textarea name="subject" ></textarea>	  </td>
	</tr>
<tr>
  <td>	上課方式： <input type="text" name="course_type" /></td>
  </tr>
<tr>
  <td>授課教師： 
	  <select name="teach_teacher">
	    {html_options values=$teach_teacher_ids selected=$teach_teacher_id output=$teach_teacher_names}
	    </select>	  </td>
  </tr>
<tr>
  <td>教學活動： 
	    <textarea name="course_activity" ></textarea></td>
  </tr>
</table>
<div class="buttons">
	<input type="button" class="btn" value="放棄編輯" onclick="cancelEdit('modifyInputArea');" />
	<input type="button" class="btn" value="確定送出" onclick="modify('modifyInputArea');" />
</div>	
</form>
</div>
</body>
</html>
