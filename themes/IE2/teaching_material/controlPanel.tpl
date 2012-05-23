<Script type="text/javascript">
{literal}
function doShirkExpend(){ 
//縮起來選單  
 if(document.getElementById("hid").value == 1){
       parent.document.getElementById('content').cols = "0,100";
       document.getElementById("but").value="顯示教材目錄";
       document.getElementById("hid").value="0";
   }
//展開選單  
   else{
       parent.document.getElementById('content').cols = "20,80";
       document.getElementById("but").value="隱藏教材目錄";
       document.getElementById("hid").value="1";
  }
}
{/literal}
</script>

<html>
    <head>
        <title>教育部數位學習平台</title>
    </head>
    <input id="but" type="button" value="隱藏教材目錄" onClick="doShirkExpend();">
    <input id="hid" type="hidden" value="1">
</html>

