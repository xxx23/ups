<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<script type="text/javascript" src="{$webroot}script/prototype.js"></script>
<script type="text/javascript" src="{$webroot}script/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/assignment/main.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/assignment/upload.js"></script>
<script type="text/javascript" src="{$tpl_path}/script/assignment/delete.js"></script>
<script type="text/javascript" src="{$webroot}script/calendar.js"></script>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />


</head>
<body>

<!--<p class="address">目前所在位置: <a href="../Personal_Page/"></a><a href="#">課程首頁</a> &gt;&gt; <a href="#">學習活動</a> &gt;&gt; <a href="tea_view.php">作業列表</a> &gt;&gt; 編輯作業解答</p>
-->
<h1>編輯作業解答</h1>
<form enctype="multipart/form-data" method="POST" action="tea_answer.php">
  <input type="hidden" name="option" value="create">
  <input type="hidden" name="homework_no" value="{$homework_no}"/>

  <table class="datatable">
      {if $ans_type != ''}<tr id="cur_answer"><th colspan="4">作業題目檔案： <a href="{$webroot}library/redirect_file.php?file_name={$file_path}">{$answer}</a>
        <input class="btn" type="button" value="刪除檔案" onClick="delete_answer('{$file_path}', '{$homework_no}', 'cur_answer');"/></th>
  </tr>
        {/if}
  <tr>
    <td colspan="4"><input type="radio" name="a_type" value="0" {$a_type0}/>
      上傳檔案作為作業解答
      <input class="btn" type="file" size="30" name="a_file"/></td></tr>
  <tr>
    <td colspan="4"><input type="radio" name="a_type" value="1" {$a_type1}/>
      於本平台編輯作業解答</td>
  </tr>
  <tr>
    <td colspan="4"><textarea name="content" cols="80" rows="15">{if $ans_type == ''}{$answer}{/if}</textarea>
    </td>
  </tr>
  {if $rel_file != ''}
  <tr>
    <th colspan="4">解答相關檔案：</th>
  </tr>
  {foreach from=$file_data item=file}
  <tr id="rel{$file.name}">
    <td><a href="{$webroot}library/redirect_file.php?file_name={$file.path}">{$file.name}</a></td>
    <td><input class="btn" type="button" value="刪除檔案" onClick="delete_rel_file('{$file.path}', '{$homework_no}', 'rel{$file.name}');"/></td>
  </tr>
  {/foreach}
  {/if}
  <tr>
    <th>上傳解答相關檔案：</th>
    <td colspan="3"><input class="btn" type="file" size="30" name="rel_file[]"/></td>
  </tr>
  <tr id="upload">
    <td>&nbsp;</td>
    <td colspan="3"><input class="btn" type="button" onClick="addInput();" value="增加檔案個數"/></td>
  </tr>
  <tr>
    <th>是否公佈解答：</th>
    <td colspan="3"><input type="radio" name="pub" value="1" {$pub1}>
      是
      </input>
      <input type="radio" name="pub" value="0" {$pub0}>
      否
      </input>
    </td>
  </tr>
  <tr>
    <th>解答公佈時間：</th>
    <td colspan="3"><input type="text" id="ans_date" name="ans_date" value="{$ans_date}" readonly/>
      <script type="text/javascript" language=javascript><!--
	    var ans_date=new dateSelector();
	    ans_date.inputName='ans_date';
	    ans_date.display();
	    --></script>
    </td>
  </tr>
  </table>
  
  <p class="al-left">
    <input class="btn" type="reset" value="清除資料"/>
    <input class="btn" type="submit" value="確定送出"/>
    <br /><br />
    <a href="tea_view.php"><img src="{$tpl_path}/images/icon/return.gif" /> 返回線上作業列表</a></p>
</form>
</body>
</html>
