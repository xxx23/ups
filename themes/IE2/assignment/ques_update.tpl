<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新增作業</title>
{if $math == 1}
<script type="text/javascript" src="{$webroot}script/ASCIIMathML.js"></script>
<script type="text/javascript" src="{$webroot}script/ASCIIMathMLdisplay.js"></script>
{else}
<script type="text/javascript" src="{$webroot}script/tiny_mce_new/tiny_mce.js"></script>
<script type="text/javascript" src="{$webroot}script/editor_simple.js"></script>
{/if}
<script type="text/javascript" src="{$webroot}script/prototype.js"></script>
<script type="text/javascript" src="{$webroot}script/calendar.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/assignment/main.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/assignment/upload.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/assignment/delete.js"></script>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css"/>
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css"/>
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css"/>
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<h1>新增修改作業</h1>
<form enctype="multipart/form-data" method="post" action="tea_assignment.php" onSubmit="return checkSubmit(this);" name="ass_form">
  <input name="option" value="{$option}" type="hidden" />
  <table class="datatable">
    <tr>
      <th>作業名稱：</th>
      <td><input name="name" type="text" value="{$name}"/></td>
      <th>配分：</th>
      <td><input name="percentage" size="3" type="text" value="{$percent}"/>        %</td>
    </tr>
    <tr>
      <th>繳交期限：</th>
      <td>
      <input type="text" id="due_date" name="due_date" value="{$due_date}" readonly/>
      <script type="text/javascript"><!--
		var due=new dateSelector();
		due.inputName='due_date';
		due.display();
		--></script>
		</td>
      <th>作業是否可遲交：</th>
      <td><input name="due" value="1" type="radio" {$due1}/>是
        <input name="due" value="0" type="radio" {$due0}/>否</td>
    </tr>
    <tr>   
    <th>是否公佈作業：</th>
    <td><input name="pub" value="1" type="radio" {$pub1}/>      是
      <input name="pub" value="0" {$pub0} type="radio" />      否 </td>
    <th>作業類型：</th>
    <td><select name="ass_type"> <option value="0" {$is_co0}>一般作業</option>
    <option value="1" {$is_co1}>合作學習作業</option></td>
    </tr> 
    <tr>
    <th colspan="4"> 
          作業題目： </th>   
    </tr>    
    <tr> 
      <td colspan="4"><input type="radio" name="q_type" value="1" {$q_type1}/>上傳檔案作為作業題目
        <input class="btn" type="file" size="30" name="q_file"/></td>
    </tr>
    {if $q_type != ''}
	<tr id="cur_question">
      <th>作業題目檔案：    </th>
      <td colspan="1"><a href="{$webroot}library/redirect_file.php?file_name={$file_path}">{$question}</a></td>
      <td colspan="2"><input type="button" class="btn" value="刪除檔案" onClick="delete_file('{$file_path}', '{$homework_no}', 'cur_question');"/></td> 
    </tr>
{/if}
<tr>
<td colspan="4">
<input type="radio" name="q_type" value="2" {$q_type2}/>
    
          
          於本平台編輯作業題目
          
          
    </td>
    
    </tr>
    
    <tr>
    
    <td colspan="4">
    
    <textarea name="content" cols="80" rows="15" style="scroll: auto;" {if $math==1}id="inputText" onkeyup="math_display();"{/if}>{if $q_type == ''}{$question}{/if}</textarea>
    {if $math == 1}
    <div id="outputNode"/>
    <a href="{$webroot}MathML/MathTable.html" target="_blank">不會用數學式嗎？請點我</a><br/>
    	{if $option == "modify"}
    <a href="tea_assignment.php?view=true&option=modify&homework_no={$homework_no}">使用一般網頁編輯器</a>
	{else}
    <a href="tea_assignment.php">使用一般網頁編輯器</a>
    	{/if}
    {elseif $option == "modify"}
    <a href="tea_assignment.php?math=1&view=true&option=modify&homework_no={$homework_no}">您需要數學方程式編輯器嗎？</a>
    {else}
    <a href="tea_assignment.php?math=1">您需要數學方程式編輯器嗎？</a>
    {/if}
    </td>
    </tr>
    
          
          
	{if $rel_file != ''}
	  
          
          
    <tr>
    
    <th colspan="1">
    
          
          作業相關檔案：
          
          
    </th>
    
    <td colspan="3"/>
    
    </tr>
    
          
          
	  {foreach from=$file_data item=file}
	  
          
          
    <tr id="rel{$file.name}">
    
    <td>
    
    </td>
    
    <td colspan="1">
    
    <a href="{$webroot}library/redirect_file.php?file_name={$file.path}">{$file.name}</a>
    
    </td>
    
    <td colspan="2">
    
    <input type="button" class="btn" value="刪除檔案" onClick="delete_rel_file('{$file.path}', '{$homework_no}', 'rel{$file.name}');"/>
    
    </td>
    
    </tr>
    
          
          
          {/foreach}
	{/if}
	
          
          
    <tr>
    
    <th colspan="1">
    
          
          上傳作業相關檔案：
          
          
    </th>
    
    <td colspan="3">    
    <input type="file" size="30" name="rel_file[]" class="btn"/>    
    </td>   
    </tr>    
    <tr id="upload">    
    <td colspan="1">     &nbsp;    </td>   
    <td colspan="3">    
    <input class="btn" type="button" onClick="addInput();" value="增加檔案個數"/>    
    </td>
    </tr>
     </table>
    <p class="al-left">
    <input class="btn" name="submit2" type="reset" value="清除資料" />
    <input class="btn" name="reset2" type="submit" value="確定送出"/> <br /><br />
      <a href="tea_view.php"><img src="{$tpl_path}/images/icon/return.gif" /> 返回線上作業列表</a></p>

</form>
</body>
</html>
