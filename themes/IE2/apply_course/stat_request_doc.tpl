<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{#statistical_report#}</title>
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
                                        var LANG_NO_LIMIT = '不限';
{literal}
		var DATEPICKER_SETTING = {dateFormat: 'yy-mm-dd' ,changeMonth: true , changeYear: true, showOn: 'button', buttonImage: WEBROOT + 'images/calendar.gif'}; 

	$(function(){
            function update_course() { 
                var class_kind = $('#class_kind').val(); 
                var date_course_begin = $('#date_course_begin').val(); 
                var date_course_end = $('#date_course_end').val(); 

                //alert(date_course_begin);
                //alert(date_course_end) ; 
                $.getJSON( '?controller=LearningDataStat&action=ajaxGetCoursesJSON',
                { class_kind: class_kind },
                function(ret){
                    var text = '<option value="-1">'+ LANG_NO_LIMIT +'</option>';

                    for (var key in ret)
                        text += '<option value="' + ret[key].begin_course_cd + '">' +  ret[key].begin_course_name + '</option>';
                    $('#class_choose').html(text);
                } ) ; // end getJson 
 
            };
            function update_doc() { 
                var city_cd = $('#city_cd').val(); 
              
                //alert(date_course_begin);
                //alert(date_course_end) ; 
                $.getJSON( '?controller=LearningDataStat&action=ajaxGetDocJSON',
                { city_cd :city_cd },
                function(ret){
                    var text = '<option value="-1">'+ LANG_NO_LIMIT +'</option>';

                    for (var key in ret)
                        text += '<option value="' + ret[key].doc_cd + '">' +  ret[key].doc + '</option>';
                    $('#doc_cd').html(text);
                } ) ; // end getJson 
 
            };
            

            $('#date_begin').datepicker(DATEPICKER_SETTING);
            $('#date_end').datepicker(DATEPICKER_SETTING);
            $('#class_kind').change( update_course ); 
            $('#city_cd').change( update_doc ); 
            $("#export").click(function(){
                $("form").append('<input type="hidden" name="export" value ="1"/>');
                $("form").submit();
                $("input[name=export]").remove();
            });
            $("table#course_stat > tbody").hide();
            $("table#student_stat> tbody").hide();
            $("#course_stat_btn").click(function(){
                if($("table#course_stat > tbody").css('display')=='none' )
                    $("table#course_stat> tbody").show();
                else
                    $("table#course_stat > tbody").hide();
            });
        $("#student_stat_btn").click(function(){
                if($("table#student_stat> tbody").css('display')=='none' )
                    $("table#student_stat > tbody").show();
                else
                    $("table#student_stat > tbody").hide();
            });
        
        });
    {/literal}
    </script>

</head>

<body>

  <h1>輔導團-查詢報表</h1>
    <div class="describe">請輸入查詢條件，可選擇多項。選填日期請點選輸入視窗，有輔助選擇器。</div>
    <div class="searchbar" style="width:93%;margin-left:30px;">

<form id="query" action="" method="POST">
<div id="cond" style="text-align:left; clear:both;">

        <div id="class_kind_div">
            <p align="left">
                課程性質：
                <select name= "class_kind" id="class_kind"> 
                    <option value="-1" >不限</option>
                {foreach from=$course_properties key=id item=property}
                  <option value="{$property.property_cd|escape}" {if $class_kind eq $property.property_cd} selected{/if} >{$property.property_name|escape}</option>
                {/foreach}
                </select>

                請選擇符合條件課程：<select name="class_choose" id="class_choose">
                     <option value="-1" >不限</option>
                {foreach from=$class_list key=id item=class}
                    <option value="{$class.begin_course_cd|escape}"{if $class_choose eq $class.begin_course_cd} selected="selected"{/if}>{$class.begin_course_name|escape}</option>
                {/foreach}
                </select> &nbsp;&nbsp
                
            </p>
        </div>
        <div id="date">
            <p><label>依修課人員修課期間範圍：</label>
                <input id="date_begin" name="date_begin" value="{$date_begin|escape}" /> ～
                <input id="date_end" name="date_end" value="{$date_end|escape}" />(空白為不限)<br/>
				(搜尋該範圍內，正在修課之人員，未選擇則不依此條件搜尋)
            </p>
       </div>   
       <div id="personal">
           
           <div><label>依據縣市:</label>
            <select id="city_cd" name="city_cd">
                    <option value="-1" >不限</option>
                        {foreach from=$cityList key="id" item="city"}
                                <option value="{$id|escape}"{if $city_cd eq $id} selected="selected"{/if}>{$city|escape}</option>
                        {/foreach}
            </select> 
            <label>所屬DOC</label>
            <select id="doc_cd" name="doc_cd">
                    <option value="-1" >不限</option>
                        {foreach from=$docList  item="doc"}
                                <option value="{$doc.doc_cd|escape}"{if $doc_cd eq $doc.doc_cd} selected="selected"{/if}>{$doc.doc|escape}</option>
                        {/foreach}
            </select> 
            </div>
        
         

	   
        <p> <input type="submit" value="送出查詢" /> </p >
    </div>
    </div>
</form>
</div>
</div>
<div style="width:95%; margin:0 auto;">
    {if !empty($results) }<div align="right"><button id="export">匯出成excel</button></div>{/if}

<table class =" datatable" id ="course_stat">
    <thead>
        <tr>
            <th colspan="7">總計<button id="course_stat_btn">展開/收合</button></th>
        </tr>
        {foreach from=$statisticsHead  item="h"}
        <th >{$h}</th>
        {/foreach}
        </tr>
        <tr>
    </thead>
    <tbody>
        <tr>
        {foreach from=$statistics item="col"}        
                <td>{$col}</td>    
        {foreachelse}
        <tr><td colspan="7" >無資料</td></tr>
        {/foreach}
        </tr>
    </tbody>
</table>

<hr/>
<table class =" datatable" id ="student_stat" >
    <thead>
        <tr>
            <th colspan="11">DOC課程統計<button id="student_stat_btn">展開/收合</button></th>
        </tr>
        <tr>
        {foreach from=$header key="id" item="h"}
        <th class="{$id}">{$h}</th>
        {/foreach}</tr>
        <tr>
    </thead>
    <tbody>
        {foreach from=$results  item="data"}
        <tr>
            {foreach from=$data item="col"}
                <td>{$col}</td>
            {/foreach}
        </tr>
        {foreachelse}
        <tr><td colspan="11" >無資料</td></tr>
        {/foreach}
    </tbody>
</table>
</div>
</body>
</html>
