<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

{if $math == 1}
<script type="text/javascript" src="{$webroot}script/ASCIIMathML.js"></script>
<script type="text/javascript" src="{$webroot}script/ASCIIMathMLdisplay.js"></script>
{else}
<script type="text/javascript" src="{$webroot}script/tiny_mce_new/tiny_mce.js"></script>
<script type="text/javascript" src="{$webroot}script/editor_simple.js"></script>
{/if}
<script type="text/javascript" src="{$tpl_path}/script/assignment/main.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/assignment/upload.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/assignment/delete.js"></script>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1> <span class="imp">{$outdated}</span> 作業名稱：{$name} -- 作答</h1>
  <form method="POST" action="stu_assignment.php" enctype="multipart/form-data">
    <input type="hidden" name="homework_no" value="{$no}"/>
    <input type="hidden" name="option" value="update"/>
<table class="datatable">
  <tr>
     <th rowspan="2">作業答案檔案:</th>
     <td><input type="radio" name="upload" value="1" {$upload1}/>
          上傳檔案作為作業答案
      </td>
     <td><input type="file" class="btn" name="ans_file"/></td>
  </tr>
    {if $is_upload == 1}
  <tr id="cur_answer">
     <td>{$content}</td>
     <td><input type="button" class="btn" value="刪除檔案" onClick="stu_delete_file('ans', '{$file}', 'cur_answer', {$no});"/></td>
    </tr>
      {/if}
      <tr>
        <td colspan="3"><input type="radio" name="upload" value="0" {$upload0}/>
          於本平台編輯作業答案</td>
      </tr>
      <tr>
        <td colspan="3"><textarea cols="80" rows="20" name="content" {if $math==1}id="inputText" onKeyUp="math_display();"{/if}>{if $upload0 == 'checked'}{$content}{/if}</textarea>
    	<div id="outputNode"/>	</td>
      </tr>
      {if $math == 1}
      <tr><td colspan="3"><a href="{$webroot}MathML/MathTable.html" target="_blank">不會用數學方程式編輯器嗎？請點我</a></td></tr>
      {else}
      <tr><td colspan="3"><a href="stu_assignment.php?view=true&option=update&homework_no={$no}&math=1">您需要數學方程式編輯器嗎？</a></td></tr>
      {/if}
      <tr>
        <th width="25%">作業相關檔案：</th>
        <td colspan="2"><input type="file" name="rel_file[]" class="btn"/></td>
      </tr>
      <tr id="upload_file">
        <td colspan="1"></td>
        <td colspan="2"><input class="btn" type="button" onClick="stu_addInput('upload_file');" value="增加檔案個數"/></td>
      </tr>
      {foreach from=$file_data item=file}
      <tr id="rel{$file.name}">
        <td></td>
        <td><a href="{$webroot}library/redirect_file.php?file_name={$file.path}">{$file.name}</a></td>
        <td><input type="button" class="btn" value="刪除檔案" onClick="stu_delete_file('rel', '{$file.path}', 'rel{$file.name}', -1);"/></td>
      </tr>
      {/foreach}
    </table>
      <p class="al-left">
<input type="reset" class="btn" value="清除資料"/>
          <input type="submit" class="btn" value="確定送出"/>
    <br /><br />
    <a href="stu_assign_view.php"><img src="{$tpl_path}/images/icon/return.gif" /> 返回線上作業列表</a></p>

  </form>
</body>
</html>
