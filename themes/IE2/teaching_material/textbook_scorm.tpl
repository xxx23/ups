<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SCORM教材管理頁面</title>

<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>
 <fieldset><legend>匯入外部檔案做為教材 </legend>
    </p>
      可接受的檔案格式為<font color="red">zip</font>。
      在此上傳成功後，於教材列表中的顯示為<font color="red">scorm_教材名稱_編號</font>
      <form action="scorm/mod/scorm/scorm_add.php" enctype="multipart/form-data" name="upload_import" id="upload_import" method="post">
    	<p>scorm教材名稱：<input name="scorm_name" type="text" id="scorm_name"></p>
      	匯入scorm 教材包：
      	<input type="file" name="import_file4" id="import_file4" />
      	<input type="hidden" name="teacher_cd" id="teacher_cd" value="{$teacher_cd}" />
      	<input type="hidden" name="begin_course_cd" id="begin_course_cd" value="{$begin_course_cd}" />
      	<input class="btn" type="submit" name="upload4" id="upload4" value="確定上傳" />
      </form>
 </fieldset>

</body>
</html>
