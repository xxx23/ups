<?
include "../config.php";
require_once("../session.php");
require_once("./scorm/export_xml.inc");
require_once("./scorm/export_SCORM12.inc");
require_once("./scorm/export_SCORM2004.inc");
require_once("./scorm/export_dump.inc");

global $DATA_FILE_PATH, $smtpl, $tpl_path, $Content_cd;
global $SHARE_PATH;//放share教材位置

$Content_cd = $_GET['content_cd'];
$D_type = $_GET['d_type'];//1108增，判斷下載格式

//取得教材編號
if(isset($Content_cd))
	$Content_cd = $_POST['content_cd'];
$_SESSION['content_cd'] = $Content_cd;	


//1108增，取得下載格式
if(isset($D_type))
	$D_type = $_POST['d_type'];
$_SESSION['d_type'] = $D_type;	


$smtpl = new Smarty;
	
//由教材編號取得 教材名稱 & 老師	
$sql = "select content_name , teacher_cd from course_content where content_cd = '$Content_cd'";
$result=db_getRow($sql);
$Teacher_cd = $result["teacher_cd"];
$Content_name = $result["content_name"];

//看是不是scorm
$sql="select id from mdl_scorm where content_cd = ".$Content_cd;
$scorm_id = db_getOne($sql);

$mnt_file_path = $SHARE_PATH.'/'.$Teacher_cd.'/';

if(!isset($scorm_id))
{
	$is_scorm = 0;
	/*=========1108增，下載檔名依[下載格式]有3種變化===============*/
		switch($D_type)
		{
			case 0:	//平台格式
				$mnt_file_name = $Content_name.'_'.$Content_cd.'.rar';
			break;
            
			case 1:	//1.2
				$mnt_file_name = $Content_name.'_'.$Content_cd."_scorm_12.zip";
			break;
            
			case 2:	//2004
				$mnt_file_name = $Content_name.'_'.$Content_cd."_scorm_2004.zip";
			break;
		}
}
else//SCORM*.zip
{
	//$mnt_file_name = $Content_name.'_'.$Content_cd.'.zip';
    $is_scorm = 1;
    switch($D_type)
    {
         case 3: //1.2
            $mnt_file_name = $Content_name.'_'.$Content_cd."_scorm_12.zip";
         break;
         case 4: //2004
            $mnt_file_name = $Content_name.'_'.$Content_cd."_scorm_2004.zip";
         break;
         case 5: //平台格式
             $mnt_file_name = $Content_name.'_'.$Content_cd.'.rar';
         break;
    }
}
$mnt_file_directory = $mnt_file_path;
$mnt_file_path = $mnt_file_directory.$mnt_file_name;
//var_dump($mnt_file_path);

//================================mnt夾下沒該檔==========================================
/*if(!file_exists($mnt_file_path))
{

    if(!file_exists($mnt_file_directory))//no teacher_cd directory
    {
        //var_dump($mnt_file_directory);
         $old_umask = umask(0);
         mkdir($mnt_file_directory,0775);
          umask($old_umask);
    }    

	if($is_scorm == 0) //.rar
	{
		
		$sql = "select file_name from class_content where content_cd = '$Content_cd' and menu_parentid='0'";
		$file_name = db_getOne($sql);
		
		$path_check = $DATA_FILE_PATH.$Teacher_cd."/textbook/".$file_name;
			if(file_exists($path_check))//看在老師夾中的textbook中有沒有這個教材
				$is_exist = 1;
				
			else
				$is_exist = 0;
		
		$path = $DATA_FILE_PATH.$Teacher_cd."/export_data/";
		if($D_type == 0)//平台格式
		{		
			$file_path = $path.$file_name.'.rar';

			//=======壓縮平台格式教材包================	
				if(!file_exists($file_path) && $is_exist == 1)
					export_general($Content_cd, $Content_name, $Teacher_cd);
		}
		else if($D_type == 1)//1.2
		{
			$file_path = $path.$file_name.'_scorm_12.rar';
			//=======壓縮SCORM12教材包================	
				if(!file_exists($file_path) && $is_exist == 1)
					export_SCORM12('1',$Content_cd, $file_name, $Teacher_cd);
		}
		else if($D_type == 2)//2004
		{
			$file_path = $path.$file_name.'_scorm_2004.rar';

			//=======壓縮SCORM2004教材包================	
				if(!file_exists($file_path) && $is_exist == 1)
					export_SCORM2004(1,$Content_cd, $file_name, $Teacher_cd);		
		}
		
		//joyce,1116增 
		//如果得去教師copy教材包的話，只有.rar檔
			$mnt_file_path = str_replace(".zip",".rar",$mnt_file_path);
			$mnt_file_name = str_replace(".zip",".rar",$mnt_file_name);
		
		//copy file to mnt/ cp 來源 目的
			$cmd = "cp $file_path $mnt_file_path";
			exec($cmd);
		
    }

	else //.zip
    {
        $sql = "select id,course,version from mdl_scorm  where content_cd ='$Content_cd'";// 1123 add 撈原本*.zip包的版本 (version)
        $result = db_getRow($sql);

        switch($result['version'])//1123 add 判斷版本
          {
             case 'SCORM_1.2':
                 $scorm_version = 3 ;
             break;
             case 'SCORM_1.3':
                $scorm_version = 4 ;
             break; 
          }

        if($D_type == $scorm_version || $D_type == 5)//如果跟user要的格式 或 平台格式  一樣才做
        {
	    	$scorm_path = str_replace("Data_File","Teaching_Material",$DATA_FILE_PATH);
	    	$scorm_path = $scorm_path."scorm/nccudata/" .$result['course']."/";
		
            if($D_type == 5)
                $scorm_file = $scorm_path . $result['id'].".rar ";
            
            else
                $scorm_file = $scorm_path . $result['id'].".zip";


            //=======壓縮教材包================
            if(!file_exists($scorm_file))//file_exists , 20111124判斷.rar檔的存在=>發生錯誤
            {
                //var_dump("沒檔=".$scorm_file);
                    var_dump("連複製也錯");
		            $scorm_path .= "moddata/scorm/";
                    $cmd = "cd ".$scorm_path."; rar a ".$result['id'].".rar ".$result['id'];
                    $cmd .= "; mv ".$result['id'].".rar ../../".$result['id'].".rar"; 
                    exec($cmd);
	        }  
              //=================================
            
            //copy file to mnt/
            $cmd = "cp $scorm_file $mnt_file_path";
		    exec($cmd);
        }
	}
}*/
//==========================================================================


  $_SESSION['current_path'] = $mnt_file_path;
  $smtpl->assign("content_name",$Content_name);
  $smtpl->assign("export_file_size",filesize($mnt_file_path));
  $smtpl->assign("export_file_time",date("F d Y H:i:s.", fileatime($mnt_file_path)));
  
  $smtpl->assign("export_file_path","redirect_file.php?file_name=".$mnt_file_name);
  
  if(file_exists($mnt_file_path)){//沒檔案就不顯載點
	$smtpl->assign("export_download_name",
              $mnt_file_name."&nbsp;<img src=\"".createTPLPath()."/images/icon/download.gif\">");
	}

	/*=========1108增，下載檔名依[下載格式]有3種變化===============*/
		switch($D_type)
		{
            case 0:	//平台格式
            case 5:
				$export_file_tpye = "平台格式";
			break;
            
            case 1:	//1.2
            case 3:
				$export_file_tpye = "SCORM 1.2";
			break;
            
            case 2:	//2004
            case 4:    
				$export_file_tpye = "SCORM 2004";
			break;
			
		}	
	$smtpl->assign("export_file_tpye",$export_file_tpye);
	
  $edu_use_announce ="<img src='../images/edu_use_announce.png'>" ;
  $smtpl->assign("edu_use_announce",$edu_use_announce);
	
  assignTemplate( $smtpl,"/teaching_material/scorm_textbook_export.tpl");


function export_general($content_cd, $content_name, $teacher_cd)
{
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

  export_textbook(1,$content_cd,$content_name, $teacher_cd, ".rar");//非同步壓縮
}


?>
