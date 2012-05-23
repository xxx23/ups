<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>統計報表</title>
    <link type="text/css" href="{$tpl_path}/css/font_style_course.css" rel="stylesheet" />
    <link type="text/css" href="{$tpl_path}/css/layout.css" rel="stylesheet" />
    <link type="text/css" href="{$tpl_path}/css/table.css" rel="stylesheet" />
    <link type="text/css" href="{$tpl_path}/css/statistics/people.css" rel="stylesheet" />
    <link type="text/css" href="{$tpl_path}/css/content_course.css" rel="stylesheet" />
    <script type="text/javascript" src="../script/jquery-1.3.2.min.js"></script>
    <link type="text/css" href="../css/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="../script/jquery-ui-1.7.2.custom.min.js"></script>
    <script type="text/javascript">
		var WEBROOT = '{$webroot}';

{literal}
		var DATEPICKER_SETTING = {dateFormat: 'yy-mm-dd' ,changeMonth: true , changeYear: true, showOn: 'button', buttonImage: WEBROOT + 'images/calendar.gif'}; 

	$(function(){
            function update_course() { 
                var class_kind = $('#class_kind').val(); 
                var date_course_begin = $('#date_course_begin').val(); 
                var date_course_end = $('#date_course_end').val(); 

                //alert(date_course_begin);
                //alert(date_course_end) ; 
                $.getJSON( 'stat_course_fetch.php',
                { class_kind: class_kind ,date_course_begin:date_course_begin, date_course_end:date_course_end  },
                function(ret){
                    //alert(class_kind) ;
                    var text = '<option value="-1">不限</option>';
                    for (var key in ret)
                        text += '<option value="' + key + '">' + ret[key] + '</option>';
                    $('#class_choose').html(text);
                } ) ; // end getJson 
 
            };
			

            function update_docs() {
                var type_location = $('#type_location').val();
                //alert(type_location);
                $.getJSON('stat_doc_fetch.php',
                    { type_location: type_location },
                    function(ret) {
                        var text = '<option value="-1">不限</option>';
                        for(var key in ret )
                            text += '<option value="' + key + '">' + ret[key] + '</option>';
                        $('#type_doc').html(text);
                    }
                );

            }; //end update_docs

            $('#date_begin').datepicker(DATEPICKER_SETTING);
            $('#date_end').datepicker(DATEPICKER_SETTING);
            //$('#date_course_begin').datepicker(DATEPICKER_SETTING);
            //$('#date_course_end').datepicker(DATEPICKER_SETTING);
            //$('#date_course_begin').change( update_course ); 
            //$('#date_course_end').change( update_course ); 
            $('#class_kind').change( update_course ); 
            $('#type_location').change( update_docs ) ; 
        
        });
        
        $(document).ready(
            function(){
				
				$('.title').click(expand_div) ; 
				$('.content').hide();
				$('.content').css('padding-left', '20px');
				$('.expandable').css('border', '2px solid #CDE');
				$('.expandable').css('cursor', 'hand');
				$('.title').css('border', '2px solid  #ACD');
				$('.title').css('height', '50px');				
				$('#type_location').change(type_location_lock) ; 
				
            }
        );
		
		function type_location_lock () {
			
			if( $(this).val() != -1  ) {
				$('#orderbycitygov').attr('disabled','disabled');
				$('#orderbycourse').attr('checked','checked');
			}else {
				$('#orderbycitygov').removeAttr('disabled');
			}			
		}
		
		//click expandable > title  , show or hide .expandable > .content
		function expand_div() {
			if( $(this).next('.content').css('display') != 'none'){
				$(this).next('.content').hide();
			}else {
				$(this).parent().parent().find('.content').hide(); 
				$(this).next('.content').show(); 
			}	
		}

    </script>

{/literal}
</head>

<body>

  <h1>資教組 - 查詢報表</h1>
  <div class="describe">請輸入查詢條件，可選擇多項。選填日期請點選輸入視窗，有輔助選擇器。</div>
    <div class="searchbar" style="width:93%;margin-left:30px;">
        


<form id="query" action="stat_request4.php" method="GET">
<div id="cond" style="text-align:left; clear:both;">
{* 已經不需要了
        <div id="course_date_div">
            <p> <label>開設課程開始時間範圍：</label>
                <input id="date_course_begin" name="date_course_begin" value="{$date_course_begin|escape}" /> ～
                <input id="date_course_end" name="date_course_end" value="{$date_course_end|escape}" />
            </p>
        </div>
*}
        <div id="class_kind_div">
            <p align="left">
                課程性質：
                <select name= "class_kind" id="class_kind"> 
                {foreach from=$course_property key=id item=name}
                  <option value="{$id|escape}"{if $class_kind eq $id} selected="selected"{/if}>{$name|escape}</option>
                {/foreach}
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;  
                請選擇符合條件課程：<select name="class_choose" id="class_choose">
                {foreach from=$class_list key=id item=name}
                    <option value="{$id|escape}"{if $class_choose eq $id} selected="selected"{/if}>{$name|escape}</option>
                {/foreach}
                </select>
            </p>
        </div>
        <div>
            <p> 
                只選取需要認證時數的課程：&nbsp;&nbsp;是&nbsp;<input name="deliver_passhour" type="radio" value="1" {if $deliver_passhour==1}checked{/if}/>  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 否(所有符合上述條件課程) <input name="deliver_passhour" type="radio" value="-1" {if $deliver_passhour==-1}checked{/if}/>
            </p>
        </div>
<br/>
        <div id="date">
            <p><label>依修課人員修課期間範圍：</label>
                <input id="date_begin" name="date_begin" value="{$date_begin|escape}" /> ～
                <input id="date_end" name="date_end" value="{$date_end|escape}" />(空白為不限)<br/>
				(搜尋該範圍內，正在修課之人員，未選擇則不依此條件搜尋)
            </p>
       </div>
		 <div id="location">
			<div><label>依修課人員所處縣市別：</label>
			<select id="type_location" name="type_location">
				{foreach from=$location_list key=id item=name}
					<option value="{$id|escape}"{if $type_location eq $id} selected="selected"{/if}>{$name|escape}</option>
				{/foreach}
			</select> &nbsp;&nbsp; 
            </div>
       </div>	   
	   
       <div id="personal">
            <div><label>依修課人員身分別：</label>
            <select id="type_personal" name="type_personal">
				{foreach from=$type_personal_list key=id item=name}
					<option value="{$id|escape}"{if $type_personal eq $id} selected="selected"{/if}>{$name|escape}</option>
				{/foreach}
            </select> &nbsp;&nbsp; 
 
            </div>
       </div>
       <div id="orderby">
            <div>
            <label>根據縣市排序：</label><input name="order_method" id="orderbycitygov" type="radio" value="1" {if $order_method ==1}checked="checked"{/if} {if $type_location > -1}disabled="disabled"{/if} />(若選取單一縣市則無法根據縣市排序。)<br/>
            <label>根據課程排序：</label><input name="order_method" id="orderbycourse" type="radio" value="2" {if $order_method ==2}checked="checked"{/if}/><br/>
            {if $session_no == 13}
             <label>防制藥物濫用9門課程查詢：</label><input name="order_method" id="order_teacher" type="radio" value="3" {if $order_method ==3}checked="checked"{/if}/>
            {/if}
            </div>
       </div>
	   
        <p> <input type="submit" value="送出查詢" /> </p >
    </div>
</form>
</div>

<br/>
{if $display_download_excel}
<div style="text-align:center; margin-left:50px;">
	<input type="button" onclick="javascript:location.href='stat_request4.php?dl_excel=1&{$url_param}'" value="搜尋結果下載存為EXCEL">
</div>
{/if}
<p style="text-align:center; width:93%;">
	總通過人數/總修課人數&nbsp;&nbsp;&nbsp;{$total_stu_pass}/{$total_stu} , 總通過時數: {$total_stu_pass_certify_hour} 小時
</p>

<br/> 
<p style="width:93%;margin-left:30px;">點選課程 可展開/縮小 學員名單</p>

{if $order_method == 2 } {* 課程 *}

{if !empty($list_course) }
<div class="expandable" style="margin:5px 50px;">
{foreach from=$list_course item=course name=list_course_loop}
	<div class="title">
		<table class="datatable">
		<tr>	
			<th style="width:20%">課程名稱/認證時數</th> 
			<th style="width:40%">{$course.course_name}  ({$course.certify}hr)</th>
			<th style="width:25%">通過修課人數/修課人數</th>
			<th style="width:5%">{$course.course_total_pass_stu}/{$course.course_total_stu}</th>
		</tr>
		</table>
	</div>
	<div class="content">
		<table class="datatable">
		<tr class="tr2"><td style="text-align:center" colspan="4">通過認證學生 ({$course.course_total_pass_stu})</td></tr>
		{foreach from=$course.passed_stus item=value}
			<tr>
				{section loop=$value name=i start=0 loop=4}
					<td style="width:25%;">{$value[i]}</td>
				{/section}
			</tr>
		{foreachelse} 
			<tr><td style="text-align:center" colspan="4">無</td></tr>
		{/foreach}

		<tr class="tr2"><td style="text-align:center" colspan="4">未通過認證學生 ({$course.course_total_yet_pass_stu})</td></tr>
		{foreach from=$course.yet_passed_stus item=value} 
			<tr>
				{section loop=$value name=i start=0 loop=4}
					<td style="width:25%;">{$value[i]}</td>
				{/section}
			</tr>
		{foreachelse} 
			<tr><td style="text-align:center" colspan="4">無</td></tr>		
		{/foreach}
		</table>
	</div>
{/foreach}	
</div>
{/if}

{/if}{* end of order method *} 


{if $order_method == 1 } {* 根據縣市排序 *}

{foreach from=$has_stu_location key=city_cd item=location name="location_list_loop"}
<div class="expandable"  style="margin:5px 50px;">
	<div class="title">
		<table align="center" class="datatable classinfo">
			<tr>	
				<th style="width:15%"><h3>{$location.name}</h3></th> 
				<th style="width:85%">通過人數/修課人數: {$location.stu_pass}/{$location.stu}  , 總通過時數: {$location.stu_pass_certify_hour} </th>
			</tr>
		</table>
	</div>
	<div class="content">
	{foreach from=$list_course[$city_cd] item=course name=list_course_loop}
		<div class="expandable">
			<div class="title">
				<table class="datatable">
				<tr>	
					<th style="width:20%">課程名稱/認證時數</th> 
					<th style="width:40%">{$course.course_name}  ({$course.certify}hr)</th>
					<th style="width:25%">通過修課人數/修課人數</th>
					<th style="width:5%">{$course.course_total_pass_stu}/{$course.course_total_stu}</th>
				</tr>
				</table>
			</div>
			<div class="content">
				<table class="datatable">
				<tr class="tr2"><td style="text-align:center" colspan="4">通過認證學生 ({$course.course_total_pass_stu})</td></tr>
		{foreach from=$course.passed_stus item=value}
					<tr>
						{section loop=$value name=i start=0 loop=4}
							<td style="width:25%;">{$value[i]}</td>
						{/section}
					</tr>
		{foreachelse} 
					<tr><td style="text-align:center" colspan="4">無</td></tr>
		{/foreach}

				<tr class="tr2"><td style="text-align:center" colspan="4">未通過認證學生 ({$course.course_total_yet_pass_stu})</td></tr>
		{foreach from=$course.yet_passed_stus item=value} 
					<tr>
						{section loop=$value name=i start=0 loop=4}
							<td style="width:25%;">{$value[i]}</td>
						{/section}
					</tr>
		{foreachelse} 
					<tr><td style="text-align:center" colspan="4">無</td></tr>		
		{/foreach}
				</table>
			</div>
		</div>			
	{/foreach}	
	
	</div><!-- end of content -->
</div><!-- end of expandable-->
{/foreach}
{/if}{* end of order_method == 1 *} 



<br/>
</body>
</html>
