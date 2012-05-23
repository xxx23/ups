<html>
<head>
<title>檔案目錄名稱設定</title>

<script>
{literal}

//去除字串左邊的空白
function ltrim(instr){
return instr.replace(/^[\s]*/gi,"");
}

//去除字串右邊的空白
function rtrim(instr){
return instr.replace(/[\s]*$/gi,"");
}
//去除字串右邊和左邊的空白
function trim(instr){
	instr = ltrim(instr);
	instr = rtrim(instr);
  return instr;
}

function check(){
     
     var elements = document.getElementsByTagName("input");
     //var re = /[\/\\?+&%#$<>{}|\[\]@]/;
     var re = /[\\?+#%@|<>]/;
       for(i = 0 ; i < elements.length ; i++){
       	 //去除前後空白
	  elements[i].value = trim(elements[i].value);

        if(elements[i].value == "")
        {
            alert("欄位不可有空白");
	         return -1;
        }

        //========add 1204 joyce===========
            var str = elements[i].value;
            var error_str = "../";
            if(str.search(error_str)!=-1)
            {
                     {/literal} alert("錯誤字串:"+error_str);{literal}
                        return -1;
            }
        //================================

	    if(elements[i].name == "file_name[]")
        {
	        if(re.test(elements[i].value)){
  	            alert("檔案名稱不可有特殊字元");
                return -1;
	         }
	    }
    }  
//after three secs reload the opener's page
window.opener.setTimeout(function(){window.opener.document.location.reload();},1000);
document.getElementsByTagName('form')[0].submit();
	
}
	
{/literal}
</script>
<head>
<body>
{if $action eq 'edit'}
<!--show出目前Tree節點的caption與file_name資訊-->
<form name="form" method="POST" action="tea_save_node_map.php?action=save">
 <div style='margin-left:0em'> 
    <caption><b><font size="5" color="blue">教材樹節點名稱與目錄/檔案名稱對應設定</font></b></caption><br>
    <caption>
    <font color="red">注意!<br>1.目錄/檔案名稱不可輸入特殊字元!<br>
    2.教材根目錄資料夾之目錄/檔案名稱只能為資料夾不可指定到檔案<br>
      &nbsp;&nbsp;&nbsp;當點選教材根目錄節點時它將會抓取目錄底下之index.htm/index.html/index.swf來顯示<br></font>
    <caption><font >教材樹節點名稱&lt;=&gt;目錄/檔案名稱</font>
 </div>	

 <div>
      {$root}
      {$mapping_Buff}
 </div>
</form>
   <input style='margin-left:2em' type="button" value="更新目錄名稱對應" onClick="check();">
{else}
   <center>
      <b>更新成功<br>
         請點選關閉此頁重新整理教材頁面     
      </b>
      <br>
      <input type='button' value='關閉此頁' OnClick='window.opener.document.location.reload();window.close();'>
  </center>
{/if}
</body>
</html>
