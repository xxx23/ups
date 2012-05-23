<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<base target="main"></base>
<script language="JavaScript" src="{$webroot}script/tools2.js"></script>
</head>

<body topmargin="0" leftmargin="0" bgcolor="#C0C0C0" text="#000000" onLoad="parent.bTool = true;">
<table cellpadding="0" cellspacing="0">
<tr>
<td>
<table border="1" cellpadding="0" cellspacing="1" height="100%">
<tr>
<td bgcolor="#C0C0C0" bordercolor="#C0C0C0" bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0"><img border="0" src="{$tpl_path}/images/assignment/toolbar.gif" width="6" height="22"></td>
<td bgcolor="#C0C0C0" bordercolor="#C0C0C0" bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0" style="font-family: sө; font-size: 9pt" nowrap>工具</td>
<td id="tool" tool="cursor" bordercolorlight="#FFFFFF" bordercolordark="#808080" bgcolor="#C0C0C0"><img border="0" src="{$tpl_path}/images/assignment/cursor.gif" width="22" height="22"></td>
<td bgcolor="#C0C0C0" bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0"></td>
<td id="tool" tool="right" bordercolorlight="#808080" bordercolordark="#FFFFFF" bgcolor="#C0C0C0"><img border="0" src="{$tpl_path}/images/assignment/right.gif" width="22" height="22"></td>
<td id="tool" tool="wrong" bordercolorlight="#808080" bordercolordark="#FFFFFF" bgcolor="#C0C0C0"><img border="0" src="{$tpl_path}/images/assignment/wrong.gif" width="22" height="22"></td>
<td id="tool" tool="quest" bordercolorlight="#808080" bordercolordark="#FFFFFF" bgcolor="#C0C0C0"><img border="0" src="{$tpl_path}/images/assignment/quest.gif" width="22" height="22"></td>
<td bgcolor="#C0C0C0" bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0"></td>
<td id="tool" tool="freehand" bordercolorlight="#808080" bordercolordark="#FFFFFF" bgcolor="#C0C0C0"><img border="0" src="{$tpl_path}/images/assignment/freehand.gif" width="22" height="22"></td>
<td id="tool" tool="line" bordercolorlight="#808080" bordercolordark="#FFFFFF" bgcolor="#C0C0C0"><img border="0" src="{$tpl_path}/images/assignment/line.gif" width="22" height="22"></td>
<td id="tool" tool="arrow" bordercolorlight="#808080" bordercolordark="#FFFFFF" bgcolor="#C0C0C0"><img border="0" src="{$tpl_path}/images/assignment/arrow.gif" width="22" height="22"></td>
<td id="tool" tool="rect" bordercolorlight="#808080" bordercolordark="#FFFFFF" bgcolor="#C0C0C0"><img border="0" src="{$tpl_path}/images/assignment/rect.gif" width="22" height="22"></td>
<td id="tool" tool="circle" bordercolorlight="#808080" bordercolordark="#FFFFFF" bgcolor="#C0C0C0"><img border="0" src="{$tpl_path}/images/assignment/circle.gif" width="22" height="22"></td>
<td id="tool" tool="rrect" bordercolorlight="#808080" bordercolordark="#FFFFFF" bgcolor="#C0C0C0"><img border="0" src="{$tpl_path}/images/assignment/roundrect.gif" width="22" height="22"></td>
<td id="tool" tool="font" bordercolorlight="#808080" bordercolordark="#FFFFFF" bgcolor="#C0C0C0"><img border="0" src="{$tpl_path}/images/assignment/font.gif" width="22" height="22"></td>
<!--<td id="tool" tool="image" bordercolorlight="#808080" bordercolordark="#FFFFFF" bgcolor="#C0C0C0"><img border="0" src="{$tpl_path}/images/assignment/image.gif" width="22" height="22" ></td>-->
<td bgcolor="#C0C0C0" bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0"></td>
</tr>
</table>
</td>
<td>
<table border="1" cellpadding="0" cellspacing="1" style="font-family: sө; font-size: 9pt">
<tr>
<td bgcolor="#C0C0C0" bordercolor="#C0C0C0" bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0"><img border="0" src="{$tpl_path}/images/assignment/toolbar.gif" width="6" height="22"></td>
<td bgcolor="#C0C0C0" bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0" style="font-family: sө; font-size: 9pt" nowrap>線條</td>
<td bgcolor="#C0C0C0" bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0" nowrap>
<select size="1" onChange="changeStrokeWeight(this.value);">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option selected value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
</select></td>
<td bgcolor="#C0C0C0" bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0" nowrap><select size="1" onChange="changeStrokeColor( this.value );">
<option value="black" style="background:black">黑色</option>
<option selected value="red" style="background:red">紅色</option>
<option value="green" style="background:green">綠色</option>
<option value="yellow" style="background:yellow">黃色</option>
<option value="gray" style="background:gray">灰色</option>
</select></td>
<td bgcolor="#C0C0C0" bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0"></td>
<td bgcolor="#C0C0C0" bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0" nowrap>填滿</td>
<td bgcolor="#C0C0C0" bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0" nowrap><select size="1" onChange="changeFilled( this.value );">
<option selected value="0">否</option>
<option value="1">是</option>
</select></td>
<td bgcolor="#C0C0C0" bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0" nowrap><select size="1" onChange="changeFillColor( this.value );">
<option selected value="black" style="background:black">黑色</option>
<option value="red" style="background:red">紅色</option>
<option value="green" style="background:green">綠色</option>
<option value="yellow" style="background:yellow">黃色</option>
<option value="gray" style="background:gray">灰色</option>
</select></td>
<td bgcolor="#C0C0C0" bordercolor="#C0C0C0" bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0"><img border="0" src="{$tpl_path}/images/assignment/toolbar.gif" width="6" height="22"></td>
<form target="_parent" id="vml_form" action="tea_correct.php" method="GET">
<td>成績<input name="vml" type="hidden"/><input name="grade" size="4" style="font-size: 9pt"></td>
<td><input type="button" value="確定送出" onClick="Tool_OnSubmit();" style="font-size: 9pt"></td>
<input type="hidden" name="option" value="grade"/>
<input type="hidden" name="pid" value="{$pid}"/>
<input type="hidden" name="homework_no" value="{$homework_no}"/>
</form>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
