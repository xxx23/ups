<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>統計報表</title>
    <link type="text/css" href="{$tpl_path}/css/font_style.css" rel="stylesheet" />
    <link type="text/css" href="{$tpl_path}/css/layout.css" rel="stylesheet" />
    <link type="text/css" href="{$tpl_path}/css/statistics/people.css" rel="stylesheet" />
    <link type="text/css" href="../css/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
    <script type="text/javascript" src="../script/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="../script/jquery-ui-1.7.2.custom.min.js"></script>
{literal}
    <script type="text/javascript">
{/literal}
var id={$id};
var loc = new Array(30);
{literal}
        $(function(){
            $('#container').tabs();
            change_graph_type = function(eventObject){
                var basename = 'course_graph_gen.php?style=1&id=' + id;
                var option = ''
                if($('#type_0').attr("checked")){
                    option += "&type[]=0";
                }
                if($('#type_1').attr("checked")){
                    option += "&type[]=1";
                }
                if($('#type_2').attr("checked")){
                    option += "&type[]=2";
                }
                if($('#type_3').attr("checked")){
                    option += "&type[]=3";
                }
                if($('#type_4').attr("checked")){
                    option += "&type[]=4";
                }
                if (option.length > 0) {
                    $('#role_img_div img').attr({src:basename+option});
                    return true;
                } else {
                    eventObject.target.checked = true;
                    alert('無資料');
                    return false;
                }
            }
            $('#type_0').change(change_graph_type);
            $('#type_1').change(change_graph_type);
            $('#type_2').change(change_graph_type);
            $('#type_3').change(change_graph_type);
            $('#type_4').change(change_graph_type);
			change_graph_location = function(eventObject){
                var basename = 'course_graph_gen.php?style=2&id=' + id;
                var option = ''
                {/literal}
			{foreach from=$location_list key=locid item=name}
if($('#location_{$locid}').attr("checked"))
	option += "&location[]={$locid}";
			{/foreach}
			{literal}
                if (option.length > 0) {
                    $('#location_img_div img').attr({src:basename+option});
                    return true;
                } else {
                    eventObject.target.checked = true;
                    alert('無資料');
                    return false;
                }
            }
			{/literal}
{foreach from=$location_list key=locid item=name}
    $('#location_{$locid}').change(change_graph_location);
{/foreach}
			{literal}
			});
{/literal}
    </script>
</head>
<body>
<div id="container">
<ul>
    <li><a href="#role_div"><span>依身分</span></a></li>
    <li><a href="#location_div"><span>依縣市</span></a></li>
</ul>
<div id="role_div">
    <div id="role_img_div">
        <img src="course_graph_gen.php?id={$id}&style=1&type[]=0&type[]=1&type[]=2&type[]=3&type[]=4" />
    </div>
    <form method="get">
    <label><input type="checkbox" name="type[]" value="0" id="type_0" checked="checked"/>一般民眾</label>
    <label><input type="checkbox" name="type[]" value="1" id="type_1" checked="checked"/>國民中小學教師</label>
    <label><input type="checkbox" name="type[]" value="2" id="type_2" checked="checked"/>高中職教師</label>
    <label><input type="checkbox" name="type[]" value="3" id="type_3" checked="checked"/>大專院校教師</label>
    <label><input type="checkbox" name="type[]" value="4" id="type_4" checked="checked"/>大專院校學生</label>
    </form>
</div>
<div id="location_div">
    <div id="location_img_div">
        <img src="course_graph_gen.php?id={$id}&style=2{foreach from=$location_list key=id item=name}&location[]={$id}{/foreach}" />
    </div>
    <form method="get">
{foreach from=$location_list key=id item=name}
    <label><input type="checkbox" name="location[]" value="{$id|escape}" id="location_{$id|escape}" checked="checked">{$name}</lable>
{/foreach}
   </form>
</div>
</div>
<a href="people.php">回查詢報表</a>
</body>
</html>
