<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{if $editable == 1}<script type="text/javascript" src="{$webroot}script/prototype.js"></script>
<script type="text/javascript" src="{$webroot}script/tiny_mce_new/tiny_mce.js"></script>
<script type="text/javascript" src="{$webroot}script/editor_simple.js"></script>
<script type="text/javascript" src="{$webroot}script/course/course_intro2.js"></script>{/if}

<title>修課需知</title>
</head>

<body>
<h1>修課需知</h1>
{if $role_cd eq 3||$role_cd eq 4}
<fieldset>
<legend>課程名稱</legend>
<div id="edit_begin_course_name">{$begin_course_name}</div>
</fieldset>
<fieldset>
<legend>課程性質</legend>
<div id="edit_course_property">{$course_property}</div>
</fieldset>
<fieldset>
<legend>課程屬性</legend>
<div id="edit_attribute">{$attribute}</div>
</fieldset>
{/if}
<fieldset>
<legend>課程簡介</legend>
<div id="edit_introduction">{$introduction}</div>
{if $editable == 1}<input type="button" value="編輯" class="btn" id="_introduction"/><img id="img_introduction" src="{$tpl_path}/images/icon/proceeding.gif"/>{/if}
</fieldset>
<fieldset>
<legend>適合對象</legend>
<div id="edit_audience">{$audience}</div>
{if $editable == 1}<input type="button" value="編輯" class="btn" id="_audience"/><img id="img_audience" src="{$tpl_path}/images/icon/proceeding.gif"/>{/if}
</fieldset>
<fieldset>
<legend>課程大綱</legend>
<div id="edit_outline">{$outline}</div>
{if $editable == 1}<input type="button" value="編輯" class="btn" id="_outline"/><img id="img_outline" src="{$tpl_path}/images/icon/proceeding.gif"/>{/if}
</fieldset>
<fieldset>
<legend>課程目標</legend>
<div id="edit_goal">{$goal}</div>
{if $editable == 1}<input type="button" value="編輯" class="btn" id="_goal"/><img id="img_goal" src="{$tpl_path}/images/icon/proceeding.gif"/>{/if}
</fieldset>
<fieldset>
<legend>先備知識(或先修課程)</legend>
<div id="edit_prepare_course">{$prepare_course}</div>
{if $editable == 1}<input type="button" value="編輯" class="btn" id="_prepare_course"/><img id="img_prepare_course" src="{$tpl_path}/images/icon/proceeding.gif"/>{/if}
</fieldset>
{if $attribute == "教導"}
<fieldset>
<legend>教科書目</legend>
<div id="edit_mster_book">{$mster_book}</div>
{if $editable == 1}<input type="button" value="編輯" class="btn" id="_mster_book"/><img id="img_mster_book" src="{$tpl_path}/images/icon/proceeding.gif"/>{/if}
</fieldset>
<fieldset>
<legend>參考書目</legend>
<div id="edit_ref_book">{$ref_book}</div>
{if $editable == 1}<input type="button" value="編輯" class="btn" id="_ref_book"/><img id="img_ref_book" src="{$tpl_path}/images/icon/proceeding.gif"/>{/if}
</fieldset>
<fieldset>
<legend>參考網址</legend>
<div id="edit_ref_url">{$ref_url}</div>
{if $editable == 1}<input type="button" value="編輯" class="btn" id="_ref_url"/><img id="img_ref_url" src="{$tpl_path}/images/icon/proceeding.gif"/>{/if}
</fieldset>
{/if}
{if $role_cd eq 3 ||$role_cd eq 4}
<fieldset>
<legend>通過條件</legend>
課程測驗：{$criteria_total}<br/>
閱讀時數：{$criteria_content_hour}時{$criteria_content_minute}分<br/>
</fieldset>
{/if}
<fieldset>
<legend>備註</legend>
<div id="edit_note">{$note}</div>
{if $editable == 1}<input type="button" value="編輯" class="btn" id="_note"/><img id="img_note" src="{$tpl_path}/images/icon/proceeding.gif"/>{/if}
</fieldset>
</body>
<html>
