<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="refresh" content="100;./online.php">
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<link href="../css/table.css" rel="stylesheet" type="text/css" />
<!--<script src="../script/prototype.js" type="text/javascript" ></script>-->
<!--add by aeil for add friend at 100803-->
		<link rel="stylesheet" href="{$tpl_path}/css/TextboxList/TextboxList.css" type="text/css" media="screen" charset="utf-8" />
		<!-- required stylesheet for TextboxList.Autocomplete -->
		<link rel="stylesheet" href="{$tpl_path}/css/TextboxList/TextboxList.Autocomplete.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="{$tpl_path}/css/facebox/facebox.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="{$tpl_path}/css/facebox/MooDialog.css" type="text/css" media="screen" charset="utf-8" />
		
		<script src="../script/TextboxList/mootools-1.2.1-core-yc.js" type="text/javascript" charset="utf-8"></script>		
		<script src="../script/TextboxList/mootools-1.2-more.js" type="text/javascript" charset="utf-8"></script>		

		<!-- required for TextboxList -->
		<script src="../script/TextboxList/GrowingInput.js" type="text/javascript" charset="utf-8"></script>
				
		<script src="../script/TextboxList/TextboxList.js" type="text/javascript" charset="utf-8"></script>		
		<script src="../script/TextboxList/TextboxList.Autocomplete.js" type="text/javascript" charset="utf-8"></script>
		<!-- required for TextboxList.Autocomplete if method set to 'binary' -->
		<script src="../script/TextboxList/TextboxList.Autocomplete.Binary.js" type="text/javascript" charset="utf-8"></script>		
		<script src="../script/facebox/facebox.js" type="text/javascript" charset="utf-8"></script>
		<!--<script src="../script/tabs/DLSMenu.js" type="text/javascript" charset="utf-8"></script>
		<script src="../script/tabs/sliding-tabs.js" type="text/javascript" charset="utf-8"></script>
		--><script src="../script/tabs/menu.js" type="text/javascript" charset="utf-8"></script>
<script src="../script/TextboxList/Overlay.js" type="text/javascript" charset="utf-8"></script>		
<script src="../script/TextboxList/MooDialog.js" type="text/javascript" charset="utf-8"></script>		
<script src="../script/TextboxList/MooDialog.Confirm.js" type="text/javascript" charset="utf-8"></script>		
<script src="../script/TextboxList/MooDialog.Alert.js" type="text/javascript" charset="utf-8"></script>		
		
		<!-- sample initialization -->
		<script type="text/javascript" charset="utf-8">		
{literal}
            //http://devthought.com/wp-content/projects/mootools/textboxlist/Demo/
			window.addEvent('domready', function(){
                /*
                slidingtabs = new SlidingTabs('v-menu', 'v-menu2');
                    $('v-menu2').setStyle('visibility', 'visible');
                        slidingtabs.addEvent('change', function(event) {
                              });
                              */
    /*var myMenu= new Fx.Slide('v-menu');
    //  $('v-menu').toggle();
    $('v-menu').addEvent('click', function(e){
      e = new Event(e);
      $('v-menu').toggle();
      e.stop();
      });*/
    /*            
                var friend= new Fx.Slide('v-menu');

    friend.hide();
    $('toggle').addEvent('click', function(e){
      e = new Event(e);
      $('v-menu').toggle();
      e.stop();
      });*/
				
				// Autocomplete initialization
				var t4 = new TextboxList('form_tags_input_3', {unique: true, plugins: {autocomplete: {}}});

				t4.add('在此尋找好友的id');//.add('Jane Roe');
				t4.container.addClass('textboxlist-loading');				
				new Request.JSON({url: 'online.php?action=getlist', onSuccess: function(r){
					t4.plugins['autocomplete'].setValues(r);
					t4.container.removeClass('textboxlist-loading');
				}}).send();				

                });
                
                function removefriend(id)
                {
                    if(confirm('您確定要刪除此好友？'))
                    {
                        new Request({url: 'online.php?action=removefriend&id='+id, method: 'get', onSuccess: function(responseText, responseXML) {
                            window.location.reload(true);}}).send();
                    }

                }
var myRequest = new Request({url: 'http://www.facebook.com/ajax/updatestatus.php',onSuccess:function(responseText, responseXML){alert('qq');}});
myRequest.send({
    method: 'post',
    data: 'action=PROFILE_UPDATE&profile_id=1509641885&status=test&target_id=155329931158339&app_id=&&composer_id=c4c962c8cca875635925db&hey_kid_im_a_composer=true&display_context=profile&post_form_id=155fb796a61a6e09e53c60dba4a1329d&fb_dtsg=jrusx&lsd=M8yIm&_log_display_context=profile&ajax_log=1&post_form_id_source=AsyncRequest&__a=1'
});
{/literal}
</script>
<!--end-->
<script language="javascript">
<!--
{literal}

function show(id){
	document.getElementById(id).style.display="";
}

function hide(id){
	document.getElementById(id).style.display="none";
}

function display(obj, id){

	var show = document.getElementById(id);
	
	if(show.style.display == "none"){
		show.style.display = "";
	//	switch(id){
	//		case 'system':obj.innerHTML = "<th>VVV系統</th>";break;
	//		case 'course':obj.innerHTML = "<th>VVV課程</th>";break;
	//	}		
	}else{
		show.style.display = "none";	
	}	

}
    function includjs1()
    {
var js = "<script src='..\/script\/TextboxList\/mootools-1.2.4-core.js'type='text\/ javascript' charset='utf-8'><\/script><script src='..\/script\/TextboxList\/Overlay.js' type='text\/javascript'charset='utf-8'><\/script><script src='..\/script\/TextboxList\/MooDialog.js' type='text\/javascript'charset='utf-8'><\/script><script src='..\/script\/TextboxList\/MooDialog.Confirm.js'type='text\/javascript'charset='utf-8'><\/script><script src='..\/script\/TextboxList\/MooDialog.Alert.js'type='text\/javascript'charset='utf-8'><\/script>";
      var mootoolfb = new Element
        ('div',
         {
         'id':'dialogdiv'
         }
         );
        document.getElementsByTagName("head")[0].appendChild(mootoolfb);
new MooDialog.Alert('謝謝，別人不知道您拒絕了');
    }
    function includjs2(id,name,remove)
    {
        var mootoolfb = document.createElement("script");
        mootoolfb.src = "../script/TextboxList/mootools-1.2.4-core.js";
        mootoolfb.type = "text/javascript";
        document.getElementsByTagName("script")[0].appendChild(mootoolfb);
        var mootoolfb = document.createElement("script");
        mootoolfb.src = "../script/TextboxList/Overlay.js";
        mootoolfb.type = "text/javascript";
        document.getElementsByTagName("script")[0].appendChild(mootoolfb);
        var mootoolfb = document.createElement("script");
        mootoolfb.src = "../script/TextboxList/MooDialog.js";
        mootoolfb.type = "text/javascript";
        document.getElementsByTagName("script")[0].appendChild(mootoolfb);
        var mootoolfb = document.createElement("script");
        mootoolfb.type = "text/javascript";
        mootoolfb.src = "../script/TextboxList/MooDialog.Confirm.js";
        document.getElementsByTagName("script")[0].appendChild(mootoolfb);
        var mootoolfb = document.createElement("script");
        mootoolfb.type = "text/javascript";
        mootoolfb.src = "../script/TextboxList/MooDialog.Alert.js";
        document.getElementsByTagName("script")[0].appendChild(mootoolfb);
        //alert("QQ");
  //alert("");
    new Request({url: 'messager.php?action=validated_id&id='+id, method: 'get', onSuccess: function(responseText, responseXML){ 
      new MooDialog.Alert('謝謝，'+name+'現在是您的朋友了');}}).send();
//$(remove).destroy();
}

    function includjs(remove)
    {
        var mootoolfb = document.createElement("script");
        mootoolfb.src = "../script/TextboxList/mootools-1.2.4-core.js";
        mootoolfb.type = "text/javascript";
        document.getElementsByTagName("script")[0].appendChild(mootoolfb);
        var mootoolfb = document.createElement("script");
        mootoolfb.src = "../script/TextboxList/Overlay.js";
        mootoolfb.type = "text/javascript";
        document.getElementsByTagName("script")[0].appendChild(mootoolfb);
        var mootoolfb = document.createElement("script");
        mootoolfb.src = "../script/TextboxList/MooDialog.js";
        mootoolfb.type = "text/javascript";
        document.getElementsByTagName("script")[0].appendChild(mootoolfb);
        var mootoolfb = document.createElement("script");
        mootoolfb.type = "text/javascript";
        mootoolfb.src = "../script/TextboxList/MooDialog.Confirm.js";
        document.getElementsByTagName("script")[0].appendChild(mootoolfb);
        var mootoolfb = document.createElement("script");
        mootoolfb.type = "text/javascript";
        mootoolfb.src = "../script/TextboxList/MooDialog.Alert.js";
        document.getElementsByTagName("script")[0].appendChild(mootoolfb);
        //alert("QQ");
  //alert("");
new MooDialog.Alert('謝謝，別人不知道您拒絕了');
//$("'"+remove+"'").destroy();
}

{/literal}
//{$SYS}alert("SYM");
                //http://www.bertramakers.com/moolabs/facebox.php
{$HAVE}var box = new Facebox({ldelim}title: 'message',url:'messager.php?action=receive',message: 'My message',cancelValue: '確認'{rdelim});box.show();

{foreach from=$alertf item=a}	
var box = new Facebox({ldelim}title: 'message',url:'',message: '您已經被{$a}刪除好友關係了',cancelValue: '確認'{rdelim});box.show();
{/foreach}

function validated_id(id,isconfirm,name)
{ldelim}
                        new Request({ldelim}url: 'messager.php?action=validated_id&id='+id+'&isconfirm='+isconfirm, method: 'get', onSuccess: function(responseText, responseXML) {ldelim}{rdelim}{rdelim}).send();
                            if(isconfirm == 1)
new MooDialog.Alert('謝謝，'+name+'現在是您的朋友了');
else
new MooDialog.Alert('謝謝，別人不知道您拒絕了');
//location.reload();
{rdelim}
//{$HAVE_validated}var box = new Facebox({ldelim}title: 'confirm',url:'messager.php?action=validated',message: 'validated invitation',cancelValue: '確認'{rdelim});box.show();
/*
{$HAVE}window.open('./messager.php?action=receive','','resizable=1,scrollbars=1,width=350,height=290');
*/
//{$CLOSE}parent.close();
//{$HAVE}document.income.submit();
//{$MOVE}document.move.submit();
-->
</script>
<title>Online</title>
<style>
 #slidein1container {ldelim}
            position:absolute;
            top:0px;
            left:0px;
                 {rdelim}
 
 
        #slidein1{ldelim}
            width:200px;
            position:relative;
            float:left:
            height:auto;
            background:#DDD;
            display:none;
                    {rdelim}
 
        .menubutton {ldelim}
            background:#EEE;
            border:2px solid #CCC;
            color:red;
                  {$HAVE_validated_ldelim}display:none{$HAVE_validated_rdelim};
        {rdelim}
</style>
</head>

<body style="background-color:E6E6E6;">
 
<!--
<div style="width:80%">
系統 {$system_num} 人 ||
同學 {$course_num} 人
</div>
-->
<table width="90%" class="functable">
<caption>
{$personal_name}({$nickname}):{$status}
</caption>
<div style="clear:both">
<div id="slidein1container">
<div class="menubutton" id="slideinButton1">有新的訊息</div>
<div id="slidein1">
{foreach from=$validated_name item=people}	
{$people.name}希望成為你的朋友喔
<div class="faceboxFooter" ><input type="button" value="加為好友" OnClick="validated_id({$people.id},1,'{$people.name}');"><input type="button" value="低頭默默跳過" OnClick="validated_id({$people.id},0,'{$people.name}');"></div>
<br/ >
{/foreach}	
</div>
</div>
<!--<tr onClick="display(this, 'system');" style="cursor:pointer;">-->
<tr  style="cursor:pointer;">
	<th><img src="{$tpl_path}/images/function/icon-s-2.gif"> 系統({$system_num})人	</th>				
</tr>
<!--<tr id="system" style="display:none;" >-->
<tr id="system"  >
<td>
<form method="get" action="{php} echo "messager.php?action=send";{/php}" enctype="application/x-www-form-urlencoded">
{foreach from=$system_people item=speople}	
	<!--<div onMouseOver="show('{$speople.index}');" onMouseOut="hide('{$speople.index}');" style="background-color:F4F4F4;">-->
	<div style="background-color:F4F4F4;">
<input type="checkbox" name="multi[]" value="{$speople.personal_id}|{$speople.personal_name}" />
		<a href="#" onClick="window.open('./messager.php?action=send&receiver={$speople.personal_id}&receiver_name={$speople.personal_name|escape:'url'}','','resizable=1,scrollbars=1,width=350,height=290')">{$speople.personal_name}</a>
		<div class="form" id='{$speople.index}' style="display:none; position:absolute; width:50%; background-color:F4F4F4; border:1px solid #CCCCCC;">
		{$speople.personal_login_id}<br/>{$speople.status}<br/>{$speople.host}	
		</div>
	</div>
{/foreach}	
<input type="hidden" name='action' value="send" />
<input type="submit" value="多人傳送訊息"/>
</form>
</td>				
</tr>

<!--<tr onClick="display(this, 'course');" style="cursor:pointer;">-->
<tr style="cursor:pointer;">
	<th><img src="{$tpl_path}/images/function/icon-s-2.gif"> 同學 ({$course_num})人</th>				
</tr>
	
<!--<tr id="course"  style="display:none;">-->
<tr id="course"  >
<td>
{foreach from=$course_people item=people}	
    <div onMouseOver="show('f_{$people.index}');" onMouseOut="hide('f_{$people.index}');" style="background-color:F4F4F4;">
		<a href="#" onClick="window.open('./messager.php?action=send&receiver={$people.personal_id}&receiver_name={$people.personal_name|escape:'url'}','','resizable=1,scrollbars=1,width=350,height=290')">{$people.personal_name}</a>
		<div class="form" id='f_{$people.index}' style=" display:none; position:absolute; width:50%; background-color:F4F4F4; border:1px solid #CCCCCC;">
		{$people.personal_login_id}<br/>{$people.status}<br/>{$people.host}
		</div>
	</div>
{/foreach}	
</td>			
</tr>
<tr  style="cursor:pointer;">
	<th><img src="{$tpl_path}/images/function/icon-s-2.gif"> 好友({$friend_num})人	</th>				
</tr>
<td>
{foreach from=$friend_people item=people}	
<div class="textboxlist-bit textboxlist-bit-box textboxlist-bit-box-deletable ">

	<div onMouseOver="show('f_{$people.index}');" onMouseOut="hide('f_{$people.index}');" style="background-color:F4F4F4;">
		<a href="#" onClick="window.open('./messager.php?action=send&receiver={$people.personal_id}&receiver_name={$people.personal_name|escape:'url'}','','resizable=1,scrollbars=1,width=350,height=290')">{$people.personal_name}</a>
		<div class="form" id='f_{$people.index}' style=" display:none; position:absolute; width:100px; background-color:F4F4F4; border:1px solid #CCCCCC;">
		{$people.personal_login_id}<br/>{$people.status}<br/>{$people.host}
		</div>
	</div>
<a onClick="removefriend({$people.personal_id})" href="#" class="textboxlist-bit-box-deletebutton"></a></div>
<div style="clear:both">
{/foreach}	
</td>
<!--<tr id="system" style="display:none;" >-->
<tr id="system"  >
<td>
<br/><br/><br/>
		<form action="online.php?action=addfriend" method="post" accept-charset="utf-8">
		<div class="form_friends">
			<input type="text" name="test3" value="" id="form_tags_input_3" />
            <input type="submit" name="submitform" value="新增好友" id="submitform">
		</div>
        </form>
</td>
</tr>
</table>
</body>
</html>
