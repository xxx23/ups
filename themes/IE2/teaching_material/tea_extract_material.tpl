<html>

<head>
<title></title>
{literal}
<script>
function check(){

	var value = document.getElementById('selMaterial').value;
	if(value == 0){
	  alert('你尚未選取教材包喔!!')
	}
	else{
        var result = confirm("是否確定要匯入此教材包?");{
        if(result){
            alert("所要處理的時間依教材包大小而不同,請稍加等待!\n按確定後開始匯入教材,請勿關閉視窗!!")
            document.extract_material.submit();	
        }
      }
	
	}

}
</script>
{/literal}
</head>

<body>
<pre>
<font color="blue">
依據FTP上傳教材包建立教材目錄,您必須先使用FTP將
含有imsmanifest.xml檔案的教材利用rar封裝來,並使用FTP
上傳至ftp://{$username}@{$FTP_IP}:{$FTP_PORT}/textbook
之後便可以在下面選單中選取所需要建立之教材。
</font>
<font color="red">*注意資料夾或檔案請勿含有特殊字元</font>
</pre>
<form name="extract_material" action="import_material.php" method="POST">
<select id="selMaterial" name="selMaterial">
   {html_options values=$selMaterial_ids output=$selMaterial_names selected=$selMaterial}
</select>
<input type="hidden" name="content_type" value="0">
<input type="hidden" name="content_cd" value="{$content_cd}">
<input type="hidden" name="upload_type" value="1">
<input type="button" onclick="check();" value="確定">
</form>

</body>


<html>
