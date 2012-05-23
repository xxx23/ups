<?php
/********************************************************************/
/* id: export_SCORM12.inc v1.0 2007/5/15 by hushpuppy Exp. 			*/
/* function: 將教材匯出成scorm v1.2的格式,由export_textbook.php呼叫 */
/********************************************************************/

require_once("../session.php");
//匯出SCORM主程式
function export_SCORM2004($asyn,$content_cd, $content_name, $teacher_cd){
	global $DATA_FILE_PATH, $store_path;
	
	$store_path = $DATA_FILE_PATH.$teacher_cd."/textbook/".$content_name."/";
	
	$doc = new DOMDocument('1.0','UTF-8');

	$root_element = generate_basic_elements_SCORM2004($doc, $content_name);
	$new_node = $doc->appendChild($root_element);
	
	//取得organization那個node
	$organization_node = $doc->getElementsByTagName('organization');
	//根節點設為organizations
	generate_branch_nodes($doc, $organization_node->item(0), $content_cd);
	$store_path_xml = $store_path."/imsmanifest.xml";
	//print $store_path_xml;
	$doc->save($store_path_xml);
	export_SCORM2004_operation($asyn,$content_cd,$content_name, $teacher_cd);
	//echo $doc->saveXML();
}

//搬移SCORM所需相關檔案,以及壓縮檔案的動作
function export_SCORM2004_operation($asyn,$content_cd,$content_name, $teacher_cd){
	global $store_path;

	//將SCORM2004所需的檔案由/Teaching_Material/scorm2004_xml/ 中搬移到教材目錄底下
	if(copy("./scorm2004_xml/XMLSchema.dtd",$store_path."XMLSchema.dtd") == false)
		die("Failed to copy \"XMLSchema.dtd\".");
	if(copy("./scorm2004_xml/adlcp_v1p3.xsd",$store_path."adlcp_v1p3.xsd") == false)
		die("Failed to copy \"adlcp_v1p3.xsd\".");
	if(copy("./scorm2004_xml/adlnav_v1p3.xsd",$store_path."adlnav_v1p3.xsd") == false)
		die("Failed to copy \"adlnav_v1p3.xsd\".");
	if(copy("./scorm2004_xml/adlseq_v1p3.xsd",$store_path."adlseq_v1p3.xsd") == false)
		die("Failed to copy \"adlseq_v1p3.xsd\".");
	if(copy("./scorm2004_xml/datatypes.dtd",$store_path."datatypes.dtd") == false)
		die("Failed to copy \"datatypes.dtd\".");
	if(copy("./scorm2004_xml/ims_xml.xsd",$store_path."ims_xml.xsd") == false)
		die("Failed to copy \"ims_xml.xsd\".");
	if(copy("./scorm2004_xml/imscp_v1p1.xsd",$store_path."imscp_v1p1.xsd") == false)
		die("Failed to copy \"imscp_v1p1.xsd\".");
	if(copy("./scorm2004_xml/imsss_v1p0.xsd",$store_path."imsss_v1p0.xsd") == false)
		die("Failed to copy \"imsss_v1p0.xsd\".");
	if(copy("./scorm2004_xml/imsss_v1p0auxresource.xsd",$store_path."imsss_v1p0auxresource.xsd") == false)
		die("Failed to copy \"imsss_v1p0auxresource.xsd\".");
	if(copy("./scorm2004_xml/imsss_v1p0control.xsd",$store_path."imsss_v1p0control.xsd") == false)
		die("Failed to copy \"imsss_v1p0control.xsd\".");
	if(copy("./scorm2004_xml/imsss_v1p0delivery.xsd",$store_path."imsss_v1p0delivery.xsd") == false)
		die("Failed to copy \"imsss_v1p0delivery.xsd\".");
	if(copy("./scorm2004_xml/imsss_v1p0limit.xsd",$store_path."imsss_v1p0limit.xsd") == false)
		die("Failed to copy \"imsss_v1p0limit.xsd\".");
	if(copy("./scorm2004_xml/imsss_v1p0objective.xsd",$store_path."imsss_v1p0objective.xsd") == false)
		die("Failed to copy \"imsss_v1p0objective.xsd\".");
	if(copy("./scorm2004_xml/imsss_v1p0random.xsd",$store_path."imsss_v1p0random.xsd") == false)
		die("Failed to copy \"imsss_v1p0random.xsd\".");
	if(copy("./scorm2004_xml/imsss_v1p0rollup.xsd",$store_path."imsss_v1p0rollup.xsd") == false)
		die("Failed to copy \"imsss_v1p0rollup.xsd\".");
	if(copy("./scorm2004_xml/imsss_v1p0seqrule.xsd",$store_path."imsss_v1p0seqrule.xsd") == false)
		die("Failed to copy \"imsss_v1p0seqrule.xsd\".");
	if(copy("./scorm2004_xml/imsss_v1p0util.xsd",$store_path."imsss_v1p0util.xsd") == false)
		die("Failed to copy \"imsss_v1p0util.xsd\".");
	if(copy("./scorm2004_xml/imsssp_v1p0.xsd",$store_path."imsssp_v1p0.xsd") == false)
		die("Failed to copy \"imsssp_v1p0.xsd\".");
	if(copy("./scorm2004_xml/lom.xsd",$store_path."lom.xsd") == false)
		die("Failed to copy \"lom.xsd\".");
	if(copy("./scorm2004_xml/xml.xsd",$store_path."xml.xsd") == false)
		die("Failed to copy \"xml.xsd\".");
	
	//---------------------------------------複製common資料夾----------------------------------------------------------
	if(file_exists($store_path."common/") == false)
		mkdir($store_path."common/");
	if(copy("./scorm2004_xml/common/anyElement.xsd",$store_path."common/anyElement.xsd") == false)
		die("Failed to copy \"anyElement.xsd\".");
	if(copy("./scorm2004_xml/common/dataTypes.xsd",$store_path."common/dataTypes.xsd") == false)
		die("Failed to copy \"dataTypes.xsd\".");
	if(copy("./scorm2004_xml/common/elementNames.xsd",$store_path."common/elementNames.xsd") == false)
		die("Failed to copy \"elementNames.xsd\".");
	if(copy("./scorm2004_xml/common/rootElement.xsd",$store_path."common/rootElement.xsd") == false)
		die("Failed to copy \"rootElement.xsd\".");
	if(copy("./scorm2004_xml/common/vocabTypes.xsd",$store_path."common/vocabTypes.xsd") == false)
		die("Failed to copy \"vocabTypes.xsd\".");
	if(copy("./scorm2004_xml/common/vocabValues.xsd",$store_path."common/vocabValues.xsd") == false)
		die("Failed to copy \"vocabValues.xsd\".");

	//--------------------------------------複製extend資料夾---------------------------------------------------------
	if(file_exists($store_path."extend/") == false)
		mkdir($store_path."extend/");
	if(copy("./scorm2004_xml/extend/custom.xsd",$store_path."extend/custom.xsd") == false)
		die("Failed to copy \"custom.xsd\".");
	if(copy("./scorm2004_xml/extend/strict.xsd",$store_path."extend/strict.xsd") == false)
		die("Failed to copy \"strict.xsd\".");
		
	//---------------------------------------複製unique資料夾--------------------------------------------------------
	if(file_exists($store_path."unique/") == false)
		mkdir($store_path."unique/");
	if(copy("./scorm2004_xml/unique/loose.xsd",$store_path."unique/loose.xsd") == false)
		die("Failed to copy \"loose.xsd\".");
	if(copy("./scorm2004_xml/unique/strict.xsd",$store_path."unique/strict.xsd") == false)
		die("Failed to copy \"strict.xsd\".");
	
	//---------------------------------------複製vocab資料夾--------------------------------------------------------
	if(file_exists($store_path."vocab/") == false)
		mkdir($store_path."vocab/");
	if(copy("./scorm2004_xml/vocab/custom.xsd",$store_path."custom.xsd") == false)
		die("Failed to copy \"custom.xsd\".");
	if(copy("./scorm2004_xml/vocab/loose.xsd",$store_path."loose.xsd") == false)
		die("Failed to copy \"loose.xsd\".");
	if(copy("./scorm2004_xml/vocab/strict.xsd",$store_path."strict.xsd") == false)
		die("Failed to copy \"strict.xsd\".");
	
	//壓縮檔案的動作
	export_textbook($asyn, $content_cd,$content_name, $teacher_cd, "_scorm_2004.rar");
	
	//匯出動作完畢後,把SCORM相關檔案移除
	$cmd1 = "cd ".$store_path;
    $cmd2 = "rm -rf unique/ common/ extend/ vocab/ adlseq_v1p3.xsd imsss_v1p0.xsd imsss_v1p0random.xsd imsss_v1p0auxresource.xsd imsss_v1p0rollup.xsd datatypes.dtd imsss_v1p0control.xsd imsss_v1p0seqrule.xsd xml.xsd XMLSchema.dtd imsss_v1p0delivery.xsd imsss_v1p0util.xsd adlcp_v1p3.xsd ims_xml.xsd imsss_v1p0limit.xsd imsssp_v1p0.xsd adlnav_v1p3.xsd imscp_v1p1.xsd imsss_v1p0objective.xsd lom.xsd custom.xsd loose.xsd strict.xsd imsmanifest.xml";

    $cmd =  $cmd1.";".$cmd2;
    if(!strstr($cmd2,"../"))
    {
        system_log($cmd);
        exec($cmd);
    }

}

//產生imsmanifest.xml必含的elements
function generate_basic_elements_SCORM2004($doc,$course_name) {
	$root = $doc->createElement("manifest");
	$root->setAttribute("xmlns", "http://www.imsglobal.org/xsd/imscp_v1p1");
	$root->setAttribute("xmlns:imsmd", "http://ltsc.ieee.org/xsd/LOM");
	$root->setAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
	$root->setAttribute("xmlns:adlcp", "http://www.adlnet.org/xsd/adlcp_v1p3");
	$root->setAttribute("xmlns:imsss","http://www.imsglobal.org/xsd/imsss");
	$root->setAttribute("xmlns:adlseq","http://www.adlnet.org/xsd/adlseq_v1p3");
	$root->setAttribute("xmlns:adlnav","http://www.adlnet.org/xsd/adlnav_v1p3");
	$root->setAttribute("xsi:schemaLocation", "http://www.imsglobal.org/xsd/imscp_v1p1 imscp_v1p1.xsd http://ltsc.ieee.org/xsd/LOM lom.xsd http://www.adlnet.org/xsd/adlcp_v1p3 adlcp_v1p3.xsd http://www.imsglobal.org/xsd/imsss imsss_v1p0.xsd http://www.adlnet.org/xsd/adlseq_v1p3 adlseq_v1p3.xsd http://www.adlnet.org/xsd/adlnav_v1p3 adlnav_v1p3.xsd");
	$root->setAttribute("identifier", "MANIFEST");
	
	//-------------------------產生metadata--------------------------------------------------------------
	$node_metadata = $root->appendChild($doc->createElement("metadata"));
	$node_metadata_schema = $node_metadata->appendChild($doc->createElement("schema"));
	$node_metadata_schema->appendChild($doc->createTextNode("ADL SCORM"));
	
	$node_metadata_schemaversion = $node_metadata->appendChild($doc->createElement("schemaversion"));
	$node_metadata_schemaversion->appendChild($doc->createTextNode("CAM 1.3"));
	
	//-------------------------產生organizations---------------------------------------------------------
	$node_organizations = $root->appendChild($doc->createElement("organizations"));
	$node_organizations->setAttribute("default","CCU");
	
	//-------------------------產生organization----------------------------------------------------------
	$node_organization = $node_organizations->appendChild($doc->createElement("organization"));
	$node_organization->setAttribute("identifier","CCU");
    $node_organization->setAttribute("structure","hierarchical");
	
	$node_organization_title = $node_organization->appendChild($doc->createElement("title"));
	$node_organization_title->appendChild($doc->createTextNode($course_name));
	$node_resources = $root->appendChild($doc->createElement("resources"));
	
	return $root;
}

?>
