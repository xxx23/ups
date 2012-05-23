<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>統計報表</title>
    <link type="text/css" href="{$tpl_path}/css/font_style.css" rel="stylesheet" />
    <link type="text/css" href="{$tpl_path}/css/layout.css" rel="stylesheet" />
    <link type="text/css" href="{$tpl_path}/css/table.css" rel="stylesheet" />
    <link type="text/css" href="{$tpl_path}/css/statistics/people.css" rel="stylesheet" />
    <link type="text/css" href="{$tpl_path}/css/content.css" rel="stylesheet" />
    <link type="text/css" href="../css/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
    <script type="text/javascript" src="../script/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../script/jquery-ui-1.7.2.custom.min.js"></script>


{literal}

    
    <script type="text/javascript">
        $(function(){
            function update_course() { 
                var class_kind = $('#class_kind').val(); 
                var date_course_begin = $('#date_course_begin').val(); 
                var date_course_end = $('#date_course_end').val(); 

                //alert(date_course_begin);
                //alert(date_course_end) ; 
                $.getJSON( 'course_fetch.php',
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
                $.getJSON('doc_fetch.php',
                    { type_location: type_location },
                    function(ret) {
                        var text = '<option value="-1">不限</option>';
                        for(var key in ret )
                            text += '<option value="' + key + '">' + ret[key] + '</option>';
                        $('#type_doc').html(text);
                    }
                );

            }; //end update_docs

            


            $('#date_begin').datepicker({ dateFormat: 'yy-mm-dd' ,changeMonth: true , changeYear: true});
            $('#date_end').datepicker({ dateFormat: 'yy-mm-dd' ,changeMonth: true , changeYear: true});
            $('#date_course_begin').datepicker({ dateFormat: 'yy-mm-dd',changeMonth: true , changeYear: true });
            $('#date_course_end').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true , changeYear: true });
            $('#date_course_begin').change( update_course ); 
            $('#date_course_end').change( update_course ); 
            $('#class_kind').change( update_course ); 
            $('#type_location').change( update_docs ) ; 
        
        });
        
        $(document).ready(
            function(){
                $(".classinfodetail").hide();
                $(".classinfo").bind("click", function(){
                    var id_arr = (this.id).split("_") ;
                    var id = id_arr[1];
                
                    if( $("#classinfodetail_"+id).css("display") !="none"){
                        $("#classinfodetail_"+id).hide(); 
                    }else {
                        var id_arr = (this.id).split("_") ;
                        var id = id_arr[1];
                        $(".classinfodetail").hide(); 
                        $("#classinfodetail_"+id).show(); 
                    }
                });

            }
        );
    
    </script>

{/literal}
</head>

<body>

  <h1>資教組 - 查詢報表</h1>
  <div class="describe">請輸入查詢條件，可選擇多項。選填日期請點選輸入視窗，有輔助選擇器。</div>
    <div class="searchbar" style="width:93%;margin-left:30px;">
        


<form id="query" action="93e29a61f7c120f13518f80dd3b577c2.php" method="GET">
<div id="cond" style="text-align:left; clear:both;">
        <div id="course_date_div">
            <p> <label>開設課程開始時間範圍：</label>
                <input id="date_course_begin" name="date_course_begin" value="{$date_course_begin|escape}" /> ～
                <input id="date_course_end" name="date_course_end" value="{$date_course_end|escape}" />
            </p>
        </div>
        <div id="class_kind_div">
            <p align="left">課程性質：
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
        <div id="class_target_member_div">
            <p align="left">開課對象：
                <select name="class_target_member" id="class_target_member"> 
                {foreach from=$course_target_memeber_list key=id item=name}
                  <option value="{$id|escape}"{if $class_target_member eq $id} selected="selected"{/if}>{$name|escape}</option>
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

        <p> <input type="submit" value="送出查詢" /> </p >
    </div>
</form>
</div>

<br/>
{if $display_download_excel}
<div style="text-align:center; margin-left:50px;">
	<input type="button" onclick="javascript:location.href='93e29a61f7c120f13518f80dd3b577c2.php?dl_excel=1&{$url_param}'" value="搜尋結果下載存為EXCEL">
</div>
{/if}
<p style="text-align:center; width:93%;">
	總通過人數/總修課人數&nbsp;&nbsp;&nbsp;{$total_stu_pass}/{$total_stu} , 總通過時數: {$total_stu_pass_certify_hour} 小時
</p>

<br/> 
<p style="width:93%;margin-left:30px;">點選課程 可展開/縮小 學員名單</p>
{if !empty($list_course) }
{foreach from=$list_course item=course name=list_course_loop}
	<table id="classinfo_{$smarty.foreach.list_course_loop.iteration}" align="center" class="datatable classinfo" style="width:93%;">
	<tr>	
		<th style="width:15%">課程名稱/認證時數</th> 
		<th style="width:45%">{$course.course_name}  ({$course.certify}hr)</th>
		<th style="width:20%">通過修課人數/ 修課人數</th>
		<th style="width:20%">{$course.course_total_pass_stu}/{$course.course_total_stu}</th>
	</tr>
	</table>
	
	<table id="classinfodetail_{$smarty.foreach.list_course_loop.iteration}" align="center" class="datatable classinfodetail" style="width:93%;">
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

{/foreach}	
{/if}
</div>

<br/>
<br/>
</body>
</html>
