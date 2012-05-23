<?php
/***********************************************************/
/* id: export_textbook.php v1.0 2011/3/28 by joyce */
/* function: �N�Ч��D�P�B�ץX���\��			 	   */
/* required : rar���Y�{�� version: rar-3.70b1_2,1	   */
/***********************************************************/
include "../config.php";
require_once("../session.php");
require_once("./scorm/export_xml.inc");
require_once("./scorm/export_SCORM12.inc");
require_once("./scorm/export_SCORM2004.inc");
require_once("./scorm/export_dump.inc");
checkMenu("/Teaching_Material/textbook_manage.php");
global $DATA_FILE_PATH, $smtpl, $tpl_path, $Content_cd;

$Teacher_cd = $_SESSION['personal_id'];
$Content_cd = $_GET['content_cd'];
	if(isset($Content_cd))
          $_SESSION['content_cd'] = $Content_cd;
	else
          $Content_cd = $_SESSION['content_cd'];

$Export_option = $_GET['export_option'];

//�ѱЧ��s�����o�Ч��W��
$sql = "select file_name from class_content where content_cd = '$Content_cd' and menu_parentid='0'";
$Content_name = db_getOne($sql);
/* Modified by Zoe
 * �p�G�O.zip��scorm�Ч�$Content_name
 */
if(!isset($Content_name))
{
  $sql="select content_name from course_content where content_cd='$Content_cd'";
  $Content_name=db_getOne($sql);
}

if($Export_option == 1){	//�ץX�@��Ч�
  //export_textbook($Content_name, $Teacher_cd, ".rar");  
    //�@��Ч��榡�ȮɻPSCORM1.2�@��,�D�n������imsmenifast.xml
  export_general($Content_cd, $Content_name, $Teacher_cd);
}
else if($Export_option == 2){	//�ץXscorm 1.2
  export_SCORM12(1,$Content_cd, $Content_name, $Teacher_cd);
}
else if($Export_option == 3){	//�ץXscorm 2004
	export_SCORM2004(1,$Content_cd, $Content_name, $Teacher_cd);
}

function export_general($content_cd, $content_name, $teacher_cd)
{
  global $DATA_FILE_PATH, $store_path;
  $store_path = $DATA_FILE_PATH.$teacher_cd."/textbook/".$content_name."/";
  
  $doc = new DOMDocument('1.0','UTF-8');

  $root_element = generate_basic_elements_SCORM12($doc, $content_name);
  
  $new_node = $doc->appendChild($root_element);
  $organization_node = $doc->getElementsByTagName('organization');
  
  generate_branch_nodes($doc, $organization_node->item(0), $content_cd);
  $store_path_xml = $store_path."/imsmanifest.xml";
  $doc->save($store_path_xml);

  export_textbook(1,$content_cd,$content_name, $teacher_cd, ".rar");
}

?>
