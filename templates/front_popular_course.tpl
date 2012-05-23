<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>熱門課程排行前10名</title>
<link href="css/table.css" rel="stylesheet" type="text/css" />
<link href="themes/IE2/css/content.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="./css/jquery/jquery-ui-1.7.2.custom_1.css" rel="stylesheet" />
<script type="text/javascript" src="./script/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="./script/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript">
{literal}
$(document).ready(function()
{
    $("#tabs").tabs();
});

function new_window( url )
{
    window.open(url,"windows","menubar=0,width=510,location=0,scrollbars=1,resizable=1");
}

{/literal}
</script>

</head>
<body background="#FFF" {if $select_success eq 1} onload="alert('選課成功，請至我的課程進入課程觀看教材');" {/if}>
<h1>熱門課程</h1>
<div class="describe">此處僅列出課程名稱，欲觀看有對外公開之課程內容，請按左上方訪客進入。</div>
<div id="tabs">
<ul>
    <li><a href="#fragment-1">總排名</a></li>
    <li><a href="#fragment-2">一般民眾</a></li>
    <li><a href="#fragment-3">中小學教師</a></li>
    <li><a href="#fragment-5">大專院校師生</a></li>
</ul>
    <div id="fragment-1">
    <table class="datatable" style="width:90%">
    <tr>
    	<th style="text-align:center">排行</th>
    	<th style="text-align:center">課程名稱</th>
    	<th style="text-align:center">修課人數</th>
        {if $role_cd == 3}<th style="text-align:center">選課</th>{/if}
    </tr>
    	{assign var="count" value=1}
    	{foreach from=$popular_course item=dep}
    <tr>
    	<td style="text-align:center">{$count++}</td>
    	{if $role_cd == 4}
            {if $dep.guest_allowed == 1}
    	        <td><font color="#07679F">{$dep.begin_course_name}</font></td>
            {else}
                <td><font color="#07679F">{$dep.begin_course_name}</font></td>
            {/if}
    	{elseif $role_cd == NULL}
            <td><font color="#07679F">{$dep.begin_course_name}</font></td>
        {else}
            {if $dep.course_cd == NULL}
            <td><font color="#07679F">{$dep.begin_course_name}</font></td>
            {else}
    	    <td><font color="#07679F">{$dep.begin_course_name}</font></td>
            {/if}
    	{/if}
    	<td style="text-align:center">{$dep.people_number}</td>
        {if $role_cd == 3}
        <td style="text-align: center">{$dep.select}</td>
        {/if}
      </tr>
    	{/foreach}
    </table>
    </div>
    <div id="fragment-2">
    <table class="datatable"style="width:90%">
    <tr>
    	<th style="text-align:center">排行</th>
    	<th style="text-align:center">課程名稱</th>
    	<th style="text-align:center">修課人數</th>
        {if $role_cd == 3}<th style="text-align:center">選課</th>{/if}
    </tr>
    	{assign var="count" value=1}
    	{foreach from=$normal_course item=dep}
    <tr>
    	<td style="text-align:center"><a align="center">{$count++}</td>
    	{if $role_cd == 4}
            {if $dep.guest_allowed == 1}
    	        <td><font color="#07679F">{$dep.begin_course_name}</font></td>
            {else}
                <td><font color="#07679F">{$dep.begin_course_name}</font></td>
            {/if}
    	{elseif $role_cd == NULL}
            <td><font color="#07679F">{$dep.begin_course_name}</font></td>
    	{else}
            {if $dep.course_cd == NULL}
            <td><font color="#07679F">{$dep.begin_course_name}</font></td>
            {else}
    	    <td><font color="#07679F">{$dep.begin_course_name}</font></td>
            {/if}
    	{/if}
    	<td style="text-align:center">{$dep.people_number}</td>
        {if $role_cd == 3}
        <td style="text-align:center">{$dep.select}</td>
        {/if}
   	  </tr>
    	{/foreach}
    </table>
    </div>
    <div id="fragment-3">
    <table class="datatable"style="width:90%">
    <tr>
    	<th style="text-align:center" style="text-align:center">排行</th>
    	<th style="text-align:center">課程名稱</th>
    	<th style="text-align:center">修課人數</th>
        {if $role_cd == 3}<th style="text-align:center">選課</th>{/if}
    </tr>
    	{assign var="count" value=1}
    	{foreach from=$elementary_course item=dep}
    <tr>
    	<td style="text-align:center">{$count++}</td>
    	{if $role_cd == 4}
            {if $dep.guest_allowed == 1}
    	        <td><font color="#07679F">{$dep.begin_course_name}</font></td>
            {else}
                <td><font color="#07679F">{$dep.begin_course_name}</font></td>
            {/if}
    	{elseif $role_cd == NULL}
            <td><font color="#07679F">{$dep.begin_course_name}</font></td>
    	{else}
            {if $dep.course_cd == NULL}
                <td><font color="#07679F">{$dep.begin_course_name}</font></td>
            {else}
    	        <td><font color="#07679F">{$dep.begin_course_name}</font></td>
            {/if}
    	{/if}
    	<td style="text-align:center">{$dep.people_number}</td>
        {if $role_cd == 3}
        <td style="text-align:center">{$dep.select}</td>
        {/if}
   	  </tr>
    	{/foreach}
    </table>
    </div>
    <div id="fragment-5">
    <table class="datatable"style="width:90%">
    <tr>
    	<th style="text-align:center">排行</th>
    	<th style="text-align:center">課程名稱</th>
    	<th style="text-align:center">修課人數</th>
        {if $role_cd == 3}<th style="text-align:center">選課</th>{/if}
    </tr>
    	{assign var="count" value=1}
    	{foreach from=$college_course item=dep}
    <tr>
    	<td style="text-align:center">{$count++}</td>
    	{if $role_cd == 4}
            {if $dep.guest_allowed == 1}
    	        <td><font color="#07679F">{$dep.begin_course_name}</font></td>
            {else}
                <td><font color="#07679F">{$dep.begin_course_name}</font></td>
            {/if}
    	{elseif $role_cd == NULL}
            <td><font color="#07679F">{$dep.begin_course_name}</font></td>
    	{else}
            {if $dep.course_cd == NULL}
                <td><font color="#07679F">{$dep.begin_course_name}</font></td>
            {else} 
    	        <td><font color="#07679F">{$dep.begin_course_name}</font></td>
            {/if}
    	{/if}
    	<td style="text-align:center">{$dep.people_number}</td>
        {if $role_cd == 3}
        <td style="text-align: center">{$dep.select}</td>
        {/if}
   	  </tr>
    	{/foreach}
    </table>
    </div>
</div>
</body>
</html>
