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
            $('#date_begin').datepicker({ dateFormat: 'yy-mm-dd' });
            $('#date_end').datepicker({ dateFormat: 'yy-mm-dd' });
            $('#date_enable').click(function(){$('#date_div').toggle(200);update_show_choose();});
            $('#type_enable').click(function(){$('#type_div').toggle(200);update_show_choose();});
            $('#name_enable').click(function(){$('#name_div').toggle(200)});
            $('#kind_enable').click(function(){$('#kind_div').toggle(200)});
            $('#class_enable').click(function(){$('#class_choose_frame').toggle(200);update_show_choose();});
            $('#location_enable').click(function(){$('#type_location_div').toggle(200);update_show_choose();});
            $('#type').change(function(){
                var type = $('#type').val();
                if(type != '-1'){
                    if (type != '0') {
                        $('#type_detail_div').hide(200);
                        $('#type_doc_div').hide(200);
                    } else {
                        $('#type_detail_div').show(200);
                        $('#type_doc_div').show(200);
                    }
                    if (type != '1' && type != '2') {
                        $('#type_title_div').hide(200);
                    } else {
                        $('#type_title_div').show(200);
                    }
                }else{
                    $('#type_doc_div').show(200);
                    $('#type_detail_div').hide(200);
                }
            });
            $('#type_enable').change(function(){
                var type_enable = $('#type_enable').attr('checked');
                if(!type_enable){
                    $('#type_doc_div').show(200);
                }
            });
            $('#class').change(function(){
                var class_ = $('#class').val();
                if(class_ != '1'){
                    $('#class_kind_div').hide();
                }else{
                    $('#class_kind_div').show(200);
                }
                if(class_ != '2'){
                    $('#class_for_div').hide();
                }else{
                    $('#class_for_div').show(200);
                }
            });
            check_DOC = function() {
                var type = $('#type').val();
                var type_location = $('#type_location').val();
                if (type != '0' || type_location == '-1')
                    return;
                $.getJSON(
                    'doc_fetch.php',
                    {
                        type_location: type_location
                    },
                    function(ret) {
                        var text = '<option value="-1">不限</option>'
                        for (var i = 0; i < ret.length; ++i)
                            text += '<option value="' + ret[i][0] + '">' + ret[i][1] + '</option>';
                        $('#type_doc').html(text);
                    }
                );
            };
            check_CLASS_KIND = function() {
                var class_kind = $('#class_kind').val();
                var _class = $('#class').val();
                if(_class != 1)
                {
                    class_kind = -1;
                }
                $.getJSON(
                    'course_fetch.php',
                    {
                        class_kind: class_kind
                    },
                    function(ret){
                        var text = '<option value="-1">不限</option>'
                        for (var i = 0; i < ret.length; ++i)
                        text += '<option value="' + ret[i][0] + '">' + ret[i][1] + '</option>';
                        $('#class_choose').html(text);
                    }
                );
            };
            check_CLASS_FOR =  function() {
                var class_for = $('#class_for').val();
                var _class = $('#class').val();
                if(_class != 2)
                {
                    class_for = -1;
                }
                $.getJSON(
                        'course_fetch.php',
                        {
                            class_for: class_for
                        },
                        function(ret){
                            var text = '<option value="-1">不限</option>'
                            for (var i = 0; i < ret.length; ++i)
                            text += '<option value="' + ret[i][0] + '">' + ret[i][1] + '</option>';
                            $('#class_choose').html(text);
                        }
                );
            };
            update_show_choose = function(){
                var text = "<p>查詢";
                if($("#class_enable").attr('checked'))
                {
                    text += ">>依課程";
                }
                if($("#date_enable").attr('checked'))
                {
                    text += ">>依時間";
                }
                if($("#type_enable").attr('checked'))
                {
                    text += ">>依身份";
                }
                if($("#location_enable").attr('checked'))
                {
                    text += ">>依縣市";
                }
                text += "</p>";
                $('#show_choose').html(text);
            };
            $('#type').change(check_DOC);
            $('#type_location').change(check_DOC);
            $('#class_kind').change(check_CLASS_KIND);
            $('#class_for').change(check_CLASS_FOR);
            $('#class').change(check_CLASS_KIND);
            var type = $('#type').val();
            if (type != '0') {
                $('#type_detail_div').hide();
                if (type != '-1')
                    $('#type_doc_div').hide();
                else
                    check_DOC();
            }
            if (type != '1' && type != '2') {
                $('#type_title_div').hide();
            }
            var class_ = $('#class').val();
            if (class_ != '1') {
                $('#class_kind_div').hide();
            }
            if (class_ != '2') {
                $('#class_for_div').hide();
            }
            var type_enable = $('#type_enable').attr('checked');
            if (type_enable) {
                $('#type_doc_div').show();
                check_DOC();
            }
{/literal}
{if !isset($date_enable)}$('#date_div').toggle();{/if}
{if !isset($kind_enable)}$('#kind_div').toggle();{/if}
{if !isset($type_enable)}$('#type_div').toggle();{/if}
{if !isset($name_enable)}$('#name_div').toggle();{/if}
{if !isset($class_enable)}$('#class_choose_frame').toggle();{/if}
{if !isset($location_enable)}$('#type_location_div').toggle();{/if}
{literal}
        });
{/literal}
    </script>
</head>

<body>
	<br/>

	<a href="c4d95e68ab901af3eaf0d9af7497d5ce.php" target="_blank"> 資源組-統計查詢報表 </a>&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="93e29a61f7c120f13518f80dd3b577c2.php" target="_blank"> 資教組-統計查詢報表 </a>
	<br/>
	<br/>
  <h1>查詢報表</h1>
  <div class="describe">請輸入查詢條件，可選擇多項。</div>
    <div class="searchbar" style="width:93%;margin-left:30px;"><form id="query" action="people.php" method="post">
       
        <div id="cond">
        <div id="classes">
            <div id="class_title" style="float: left;" class="tag">
            <input type="checkbox" name="class_enable" id="class_enable"{if isset($class_enable)} checked="checked"{/if}>
            依課程：
            </div>
<div align="left">
            <div id="class_choose_frame">
            <div id="choose">
              課程條件：
                <select name="class" id="class">
                    <option value="-1"{if $class eq '-1'} selected="selected"{/if}>不限</option>
                    <option value="1"{if $class eq '1'} selected="selected"{/if}>依課程性質</option>
                    <option value="2"{if $class eq '2'} selected="selected"{/if}>依開課對象</option>
                </select>
            </div>
              <div id="class_kind_div">
                <p align="left">課程性質：
                    <select name= "class_kind" id="class_kind">
                      
                      
{foreach from=$course_property key=id item=name}
                        
                      
                      <option value="{$id|escape}"{if $class_kind eq $id} selected="selected"{/if}>{$name|escape}</option>
                      
                      
{/foreach}
                      
                    
                    </select></p>
                </div>
          <div id="class_for_div">
                    開課對象：
                      <select name="class_for" id="class_for">
                        <option value="-1"{if $class_for eq '-1'} selected="selected"{/if}>不限</option>
                        <option value="1"{if $class_for eq '0'} selected="selected"{/if}>一般民眾</option>
                        <option value="2"{if $class_for eq '1'} selected="selected"{/if}>國民中小學教師</option>
                        <option value="3"{if $class_for eq '2'} selected="selected"{/if}>高中職教師</option>
                        <option value="4"{if $class_for eq '3'} selected="selected"{/if}>大專院校師生</option>
                    </select>
            </div>
            <div id="class_choose_div">
                <p align="left">
請選擇符合條件課程：<select name="class_choose" id="class_choose">
{foreach from=$class_list key=id item=name}
                        <option value="{$id|escape}"{if $class_choose eq $id} selected="selected"{/if}>{$name|escape}</option>
{/foreach}
                    </select>
                </p>
            </div>
        </div>
        <div id="clear" style="clear: left;">&nbsp;</div>
        </div>
        <div id="date">
                <div id="date_title" style="float: left;" class="tag">
                    <input id="date_enable" name="date_enable"type="checkbox" {if isset($date_enable)}checked="checked" {/if}/>
                    依時間：
                </div>
                <div id="date_div" style="float: left;">
                    <p>
                        <label>修課日期</label>
                        <label>在此日之後:</label>
                        <input id="date_begin" name="date_begin" value="{$date_begin|escape}" />
                        <label>在此日之前:</label>
                        <input id="date_end" name="date_end" value="{$date_end|escape}" />
                    </p>
                </div>
            <div id="clear" style="clear: left;">&nbsp;</div>
        </div>
        <div id="profile">

                <div id="type_title" style="float: left;" class="tag">
                    <input id="type_enable" name="type_enable" type="checkbox" {if isset($type_enable)}checked="checked" {/if}/>
                    <label>依身分：</label>
                </div><div align="left">
                <div id="type_div" style="float: left;">
                <p>
                    <select id="type" name="type">
{foreach from=$type_list key=id item=name}
                        <option value="{$id|escape}"{if $type eq $id} selected="selected"{/if}>{$name|escape}</option>
{/foreach}
                    </select>
                  <div id="type_title_div">
                        <label>職稱:</label>
                        <select id="type_title" name="type_title">
{foreach from=$type_title_list key=id item=name}
                        <option value="{$id|escape}"{if $type_title eq $id} selected="selected"{/if}>{$name|escape}</option>
{/foreach}
                        </select>
                  </div>
                    <div id="type_detail_div">
                        <label>身份別:</label>
                        <select id="type_detail" name="type_detail">
{foreach from=$type_detail_list key=id item=name}
                        <option value="{$id|escape}"{if $type_detail eq $id} selected="selected"{/if}>{$name|escape}</option>
{/foreach}
                        </select>
                    </div></div>
                </p>
                </div>
                <div id="clear" style="clear: left;">&nbsp;</div>
        </div>
        <div id="location">
            <div id="type_title" style="float: left;" class="tag">
                <input id="location_enable" name="location_enable" type="checkbox" {if isset($location_enable)}checked="checked" {/if}/>
                依縣市：
            </div><div align="left">
            <div id="type_location_div" style="float: left;">
            <p>
            <label>縣市別</label>
            <select id="type_location" name="type_location">
            <option value="-1">不限</option>
{foreach from=$location_list key=id item=name}
            <option value="{$id|escape}"{if $type_location eq $id} selected="selected"{/if}>{$name|escape}</option>
{/foreach}
            </select>
              <div id="type_doc_div">
                        <label>鄰近DOC:</label>
                        <select id="type_doc" name="type_doc">
                            <option value="-1">不限</option>
                        </select>
              </div></div>
            </p>
            </div>
            <div id="clear" style="clear: left;">&nbsp;</div>
        </div>
            <p align="left">
                <label>查詢結果排序：</label>
                <select name="sort">
{foreach from=$sort_list key=id item=name}
                    <option value="{$id|escape}"{if $sort eq $id} selected="selected"{/if}>{$name|escape}</option>
{/foreach}
                </select>
            </p></div>
        </div>
        <div id="show_choose" class="show">
        </div>
        <input type="submit" value="送出" />
    </form>
</div>
<div id="result">
{if $has_data}
    <h2>查詢結果</h2><table align="center" class="datatable" style="width:93%;">
        <tr>
            <th>圖表</th>
{foreach from=$title item=text}
            <th>{$text|escape}</th>
{/foreach}
        </tr>
{foreach from=$data item=row}
        <tr>
{foreach from=$row item=text name=d}
{if $smarty.foreach.d.first}
            <td align="center"><a href="course_graph.php?id={$text}&style=1"><img src="{$tpl_path}/images/166.gif" alt="檢視統計圖表" width="16" height="16"></a></td>
{else}
            <td>{$text|escape}</td>
{/if}
{/foreach}
        </tr>
{/foreach}
</table>
{/if}
</div>
</body>
