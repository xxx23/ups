<?php
/********************************************************************/
/* id: export_SCORM12.inc v1.0 2007/5/15 by hushpuppy Exp. 			*/
/* function: 將教材匯出成scorm v1.2的格式,由export_textbook.php呼叫 */
/********************************************************************/

require_once("../session.php");
//匯出SCORM主程式
function export_SCORM12($asyn,$content_cd, $content_name, $teacher_cd){
	global $DATA_FILE_PATH, $store_path;
	$store_path = $DATA_FILE_PATH.$teacher_cd."/textbook/".$content_name."/";
	
	$doc = new DOMDocument('1.0','UTF-8');

	$root_element = generate_basic_elements_SCORM12($doc, $content_name);
	$new_node = $doc->appendChild($root_element);
	
	//取得organization那個node
	$organization_node = $doc->getElementsByTagName('organization');
	//根節點設為organizations
	generate_branch_nodes($doc, $organization_node->item(0), $content_cd);
	$store_path_xml = $store_path."/imsmanifest.xml";
	$doc->save($store_path_xml);
	export_SCORM12_operation($asyn,$content_cd,$content_name, $teacher_cd);
	//echo $doc->saveXML();
}

//搬移SCORM所需相關檔案,以及壓縮檔案的動作
function export_SCORM12_operation($asyn,$content_cd,$content_name, $teacher_cd){
	global $store_path;
	//print $store_path;
	//將SCORM1.2所需的檔案由/Teaching_Material/scorm1.2_xml/ 中搬移到教材目錄底下	
	if(copy("./scorm1.2_xml/adlcp_rootv1p2.xsd",$store_path."adlcp_rootv1p2.xsd") == false)
		die("Failed to copy \"adlcp_rootv1p2.xsd\".");
	if(copy("./scorm1.2_xml//ims_xml.xsd",$store_path."ims_xml.xsd") == false) 
		die("Failed to copy \"/ims_xml.xsd\".");
	if(copy("./scorm1.2_xml/imscp_rootv1p1p2.xsd",$store_path."imscp_rootv1p1p2.xsd") == false) 
		die("Failed to copy \"imscp_rootv1p1p2.xsd\".");
	if(copy("./scorm1.2_xml/imsmd_rootv1p2p1.xsd",$store_path."imsmd_rootv1p2p1.xsd") == false) 
		die("Failed to copy \"imsmd_rootv1p2p1.xsd\".");
	
	//壓縮檔案的動作
	export_textbook($asyn,$content_cd,$content_name, $teacher_cd, "_scorm_12.rar");
	
	//匯出動作完畢後,把SCORM相關檔案移除
	if(file_exists($store_path."imsmanifest.xml") == true) 
		unlink($store_path."imsmanifest.xml");
	if(file_exists($store_path."adlcp_rootv1p2.xsd") == true) 
		unlink($store_path."adlcp_rootv1p2.xsd");
	if(file_exists($store_path."ims_xml.xsd") == true) 
		unlink($store_path."ims_xml.xsd");
	if(file_exists($store_path."imscp_rootv1p1p2.xsd") == true) 
		unlink($store_path."imscp_rootv1p1p2.xsd");
	if(file_exists($store_path."imsmd_rootv1p2p1.xsd") == true) 
		unlink($store_path."imsmd_rootv1p2p1.xsd");
}

//產生imsmanifest.xml必含的elements
function generate_basic_elements_SCORM12($doc,$course_name) {
  
   	$root = $doc->createElement("manifest");
	$root->setAttribute("xmlns", "http://www.imsproject.org/xsd/imscp_rootv1p1p2");
	$root->setAttribute("xmlns:imsmd", "http://www.imsglobal.org/xsd/imsmd_rootv1p2p1");
	$root->setAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
	$root->setAttribute("xmlns:adlcp", "http://www.adlnet.org/xsd/adlcp_rootv1p2");
	$root->setAttribute("xsi:schemaLocation", "http://www.imsproject.org/xsd/imscp_rootv1p1p2 imscp_rootv1p1p2.xsd http://www.imsglobal.org/xsd/imsmd_rootv1p2p1 imsmd_rootv1p2p1.xsd http://www.adlnet.org/xsd/adlcp_rootv1p2 adlcp_rootv1p2.xsd");
	$root->setAttribute("identifier", "MANIFEST");
	
	$node_organizations = $root->appendChild($doc->createElement("organizations"));
	$node_organizations->setAttribute("default","edu");
	
	$node_organization = $node_organizations->appendChild($doc->createElement("organization"));
	$node_organization->setAttribute("identifier","edu");
        $node_organization->setAttribute("structure","hierarchical");

	$node_organization_title = $node_organization->appendChild($doc->createElement("title"));
	$node_organization_title->appendChild($doc->createTextNode($course_name));
	
	
	$node_resources = $root->appendChild($doc->createElement("resources"));
	
	return $root;
}
?>
