<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- author: carlcarl -->
<html>
<head>
    <title>社群專區</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
    {literal}
        function showArea(val, id)
        {
            if(val == true)
                document.getElementById(id).style.display="";
            else
                document.getElementById(id).style.display="none";

        }
        function showArea2(id)
        {
            if(document.getElementById(id).style.display=="none")
                document.getElementById(id).style.display="";
            else
                document.getElementById(id).style.display="none";

        }

    {/literal}
    </script>
</head>

<body>
    
    <h1>申請加入社群名單</h1>
    <h2>{$begin_course_name}</h2>

    {if $wantJoinList == null}
    </br></br>
    <div class="describe">課程管理者您好! 您的社群目前沒有申請者需審核!!　<a href="group.php">回社群專區</a></div>

    {else}
    <br/>
    <div class="describe">
                    通過：
                    您按下"通過"後，該位教師可登入此教師社群，參與教案分享與討論。
    </div>
    
    <div class="describe">
                    拒絕：
                    您按下"拒絕"後，該位教師可查看拒絕理由，並決定是否再次申請。
    </div>
    <br />
    <table class="datatable" style="table-layout:fixed;width:90%">
        <tr>
            <th style="width: 100px;">教師名稱</th>
            <th>申請理由</th>
            <th>審核</th>
        </tr>
        {foreach from=$wantJoinList item=wantJoin}
        <tr>
            <td>{$wantJoin.name}</td>
            <td>
                <input type="button" value="觀看申請理由" onclick="javascript:showArea2('joinReason{$wantJoin.teacher_cd}')" />
                <textarea id="joinReason{$wantJoin.teacher_cd}" cols="30" rows="10" readonly="readonly" style="display:none;">{$wantJoin.join_reason}</textarea>
            </td>
            <td>
                {if $wantJoin.not_pass_reason == NULL}
                <input type="button" value="核准" onclick="window.location.href='agreeJoin.php?course={$begin_course_cd}&teacher={$wantJoin.teacher_cd}&name={$wantJoin.name}'" /> 
                <input type="button" value="拒絕並輸入理由" onclick="javascript:showArea(true, 'rejectReason{$wantJoin.teacher_cd}');" />
                <form id="rejectReason{$wantJoin.teacher_cd}" method="post" action="rejectJoin.php?course={$begin_course_cd}&teacher={$wantJoin.teacher_cd}&name={$wantJoin.name}" style="display: none">
                    <textarea cols="30" rows="10" name="reason"></textarea>
                    <br />
                    <input type="submit" value="送出" />
                    <input type="button" value="取消" onclick="javascript:showArea(false, 'rejectReason{$wantJoin.teacher_cd}');" />
                </form>
                {else}
                不通過
                {/if}
            </td>
        </tr>
        {/foreach}
    </table>
{/if}
</br>
<div align="center">
<input type="button" value="回社群專區" onclick="window.location.href='group.php'"/>
</div>
</body>
</html>

