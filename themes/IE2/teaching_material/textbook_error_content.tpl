<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教材勘誤頁面</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<script>
{literal}
    function textbook_errortable_page(content_cd)
    {
        var url = "error_report_func.php?content_cd="+content_cd;
            window.open(url,"錯誤回報","scrollbars=yes,width=900px,height=900px,toolbar=no,location=no,status=yes");
    }

    function textbook_error_list(content_cd)
    {
        var url="error_report_list.php?content_cd="+content_cd;
            window.location=url;
    }
{/literal}
</script>
</head>

<body class="ifr" id="tabA">
<h1>教材勘誤頁面</h1>

    <div class="tab">
        <ul id="tabnav">
        <li class="tabA" >{$Caption}&nbsp;教材勘誤列表</li>
        </ul>
        <table border="0" width="90%">
            <td align="right">
            <input class="btn" type="button" value="錯誤回報" onClick="textbook_errortable_page({$Content_cd});"/>
            <input class="btn" type="button" value="錯誤回報列表" onClick="textbook_error_list({$Content_cd});"/>
            </td>
        </table>
        <div class="inner_contentA" id="inner_contentA">
            <legend></legend>
            <table class="datatable" width="100%" border="1">
            <caption>                       以下列表順序依章節排序(共{$cnt}筆)              </caption>
        <tr>
        <th width="15%">章節 </th>
        <th width="10%">頁數 </th>
        <th width="15%">勘誤者 </th>
        <th width="60%">勘誤內容 </th>
        </tr>
        {foreach from = $content2 item = element name=contentloop}
        <tr  class="{cycle values=" ,tr2"}">
        <td><img src="{$webroot}images/folderopen.gif">{$element.caption} </td>
        <td>{$element.page}</td>
        <td>{$element.login_id}</td>
        <td>{$element.content}</td>
        </tr>
        {/foreach}
        </table>
    </div>
</div>




</body>
</html>
