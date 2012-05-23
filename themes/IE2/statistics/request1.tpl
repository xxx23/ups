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
                        var text = '<option value="-1">不限</option><option value="-2">全部</option>';
                        for(var key in ret )
                            text += '<option value="' + key + '">' + ret[key] + '</option>';
                        $('#type_doc').html(text);
                    }
                );

            }; //end update_docs

            


            $('#date_begin').datepicker({ dateFormat: 'yy-mm-dd' ,changeMonth: true , changeYear: true});
            $('#date_end').datepicker({ dateFormat: 'yy-mm-dd' ,changeMonth: true , changeYear: true});
            $('#date_course_begin').datepicker({ dateFormat: 'yy-mm-dd' ,changeMonth: true , changeYear: true});
            $('#date_course_end').datepicker({ dateFormat: 'yy-mm-dd' ,changeMonth: true , changeYear: true});
            $('#date_course_begin').change( update_course ); 
            $('#date_course_end').change( update_course ); 
            $('#class_kind').change( update_course ); 
            $('#type_location').change( update_docs ) ; 
        
        });

    </script>

{/literal}
</head>

<body>
  <h1>資源組-查詢報表</h1>
  <div class="describe">請輸入查詢條件，可選擇多項。選填日期請點選輸入視窗，有輔助選擇器。</div>
    <div class="searchbar" style="width:93%;margin-left:30px;">
        


<form id="query" action="c4d95e68ab901af3eaf0d9af7497d5ce.php" method="GET">
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
                <label>所處DOC：</label>
                <select id="type_doc" name="type_doc">
                {foreach from=$type_docs key=id item=name}
                    <option value="{$id|escape}"{if $type_doc eq $id} selected="selected"{/if}>{$name|escape}</option>
                {/foreach}
 
                </select>
            </div>
       </div>

        <p> <input type="submit" value="送出查詢" /> </p >
    </div>
</form>
</div>



<hr/>
{if $display_download_excel}
<div style="text-align:center; margin-left:50px;">
	<input type="button" onclick="javascript:location.href='c4d95e68ab901af3eaf0d9af7497d5ce.php?dl_excel=1&{$url_param}'" value="搜尋結果下載存為EXCEL">
</div>
{/if}

<div id="result">
    <h2>課程培訓查詢結果</h2>

<table align="center" class="datatable" style="width:93%;">
<tr>   
    <th style="width:150px;">課程培訓次數</th> 
    <td style="width:100px;">{$course_res.data1}(範圍內有多少課)</td>
    <th style="width:150px;">課程培訓時數</th>
    <td style="width:100px;">{$course_res.data2}(範圍的課有多少認證時數)</td>
</tr>
<tr>
    <th>課程培訓人次(男)</th> 
    <td>{$course_res.data3}</td>
    <th>課程培訓人次(女)</th>
    <td>{$course_res.data4}</td>
</tr>
<tr>
    <th>課程培訓人數(男)</th> 
    <td>{$course_res.data5}</td>
    <th>課程培訓人數(女)</th>
    <td>{$course_res.data6}</td>
</tr>
</table>

<hr/>

<table align="center" class="datatable" style="width:93%;">
<tr>   
    <th style="width:150px;">新住民教育訓練人(男)</th> 
    <td style="width:100px;">{$people_res.data1}</td>
    <th style="width:150px;" >新住民教育訓練人(女)</th>
    <td style="width:100px;">{$people_res.data2}</td>
</tr>
<tr>
    <th>=/=</th>
    <td>=/=</td>
    <th>婦女教育訓練人數(女)</th> 
    <td>{$people_res.data3}</td>
</tr>
<tr>
    <th>銀髮族教育訓練人數(男)</th> 
    <td>{$people_res.data4}</td>
    <th>銀髮族教育訓練人(女)</th>
    <td>{$people_res.data5}</td>
</tr>
<tr>
    <th>勞工教育訓練人數(男)</th> 
    <td>{$people_res.data6}</td>
    <th>勞工教育訓練人數(女)</th>
    <td>{$people_res.data7}</td>
</tr>
</table>

<br/>
<br/>
{if !empty($data)}
	<table align="center" class="datatable" style="width:93%;">
	<caption>課程清單</caption>
	{foreach from=$data key=key item=row}
	<tr>
		{if $key== 0 }   
			<th style="width:50px">{$row.index}</th>
			<th style="width:100px">{$row.date_course_begin}</th>
			<th style="width:200px">{$row.begin_course_name}</th>
			<th style="width:200px">{$row.certify}</th>
			<th style="width:100px">{$row.take_course_count}</th>
			<th style="width:80px">{$row.take_course_count_pass}</th>
			<th style="width:80px">{$row.course_pass_hour}</th>
		{else}
			<td style="width:50px">{$row.index}</td>
			<td style="width:100px">{$row.date_course_begin}</td>
			<td style="width:200px"><a target="_blank" href="c4d95e68ab901af3eaf0d9af7497d5ce.php?{$row.url_query_course}" title="觀看此課程狀態">{$row.begin_course_name}</a></td>
			<td style="width:200px">{$row.certify}</td>
			<td style="width:100px">{$row.take_course_count}</td>
			<td style="width:80px">{$row.take_course_count_pass}</td>
			<td style="width:80px">{$row.course_pass_hour}</td>
		{/if}
	</tr>
	{/foreach}
	</table>
{/if}
</div>

<br/>
{if !empty($stu_list)}
	<table align="center" class="datatable" style="width:93%;">
	<caption>學生列表</caption>
	{foreach from=$stu_list key=key item=row}
	<tr>
		{if $key== 0 }   
			<th style="width:50px">{$row.index}</th>
			<th style="width:150px">{$row.stu_name}</th>
			<th style="width:100px">{$row.course_begin}</th>
			<th style="width:80px">{$row.pass}</th>
		{else}
			<td style="width:50px">{$row.index}</td>
			<td style="width:150px">{$row.stu_name}</td>
			<td style="width:100px">{$row.course_begin|date_format:'%Y/%m/%d'}</td>
			<td style="width:80px">{$row.pass}</td>
		
		{/if}
	</tr>
	{/foreach}
	</table>
{/if}
<br/>
<br/>
</body>
</html>
