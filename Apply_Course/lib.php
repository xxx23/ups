<?php 

//config
global $account_categroy ; //開課單位身分別

global $account_list_type_state ;

global $apply_org_table ;  // 開課審核單位, 包含該組資訊


// for smarty html_options

// 1-縣市政府, 2-大專院校, 3-數位機會中心輔導團, 4-DOC(數位機會中心), 5-高中職學校

// 教育部電算中心部內組別: a-資教組, b-資源組, c-學習組 

$account_categroy = array(

	'0'=>'全部', 

	'1'=>'縣市政府', 

	'2'=>'大專院校', 

	'3'=>'數位機會中心輔導團', 

	'4'=>'數位機會中心',// 目前應該沒有這個帳號

    '5'=>'高中職學校',//20111215測試增加

	'a'=>'資教組', 

	'b'=>'資源組', 

	'c'=>'學習組',

    'd'=>'防治藥物濫用'//20110107加的

);





//根據輔導團隊的帳號 判別輔導團對應哪些縣市 => 再根據縣市取得相對的doc

//ex: SELECT doc_cd , doc FROM docs  WHERE  city_cd=2  OR  city_cd=4  OR  city_cd=25 

$doc_instructor = array(  //doc 輔導團

	'adv046' => array(2, 4, 25) , 	//臺北縣、桃園縣、連江縣

	'adv035' => array(5), 	//新竹縣

	'adv044' => array(7), 	//苗栗縣

	'adv036' => array(8,10),//台中縣、彰化縣

	'adv037' => array(20),	//南投縣

	'adv040' => array(11),	//雲林縣

	'adv045' => array(12),	//嘉義縣

	'adv048' => array(14),	//臺南縣 

	'adv043' => array(16),	//高雄縣

	'adv041' => array(18),	//屏東縣

	'adv039' => array(21),	//宜蘭縣

	'adv038' => array(22),	//花蓮縣

	'adv047' => array(23),	//臺東縣

	'adv042' => array(19),	//澎湖縣

	'adv009' => array(24),	//金門縣

);



//資教組excel輸出的縣市排序

$city_order = array("臺北市"=>3,

                    "高雄市"=>17,

                    "新北市"=>2,

                    "宜蘭縣"=>21,

                    "桃園縣"=>4,

                    "新竹縣"=>5,

                    "苗栗縣"=>7,

                    "臺中市"=>8,

                    "彰化縣"=>10,

                    "南投縣"=>20,

                    "雲林縣"=>11,

                    "嘉義縣"=>12,

                    "臺南市"=>14,

                    "高雄市"=>16,

                    "屏東縣"=>18,

                    "臺東縣"=>23,

                    "花蓮縣"=>22,

                    "澎湖縣"=>19,

                    "基隆市"=>1,

                    "新竹市"=>6,

                    "臺中市"=>9,

                    "嘉義市"=>13,

                    "臺南市"=>15,

                    "金門縣"=>24,

                    "連江縣"=>25);





//對應那一組該審那一類的課程

$category4grouping = array(

	'a'=>'1', //資教組=>縣市政府

	'b'=>'3', //資源組=>輔導團

	'c'=>'2', //學習組=>大專院校

	'1' =>'a' , 

	'3' =>'b' , 

	'2' =>'c' 

);





/*ups 用
//需寄信給哪些承辦人 , 可個表可能會不用

$apply_org_table = array(

	//資教組, 縣市政府研習課程, 對象為中小學教師

	'a'=> array('org_title'=>'教育部電算中心-資訊教育組', 'name'=>'承辦人-黃燕如', 'email'=>array('yann@mail.moe.gov.tw','yafen@mail.moe.gov.tw','ups_moe@mail.moe.gov.tw')), 

	//資源組, DOC輔導團隊教師 

	'b'=> array('org_title'=>'教育部電算中心-數位資源組', 'name'=>'承辦人-王振榮', 'email'=>array('sthung@mail.moe.gov.tw','ups_moe@mail.moe.gov.tw')), 

	//學習組, 大專院校教師

	'c'=> array('org_title'=>'教育部電算中心-數位學習組', 'name'=>'承辦人-陳中基', 'email'=>array('cghen@mail.moe.gov.tw','ups_moe@mail.moe.gov.tw'))

);*/

$apply_org_table = array(

	//資教組, 縣市政府研習課程, 對象為中小學教師

	'a'=> array('org_title'=>'教育部電算中心-資訊教育組', 'name'=>'承辦人-黃燕如', 'email'=>array('')), 

	//資源組, DOC輔導團隊教師 

	'b'=> array('org_title'=>'教育部電算中心-數位資源組', 'name'=>'承辦人-王振榮', 'email'=>array('')), 

	//學習組, 大專院校教師

	'c'=> array('org_title'=>'教育部電算中心-數位學習組', 'name'=>'承辦人-張鈞閩', 'email'=>array(''))

);







//課程狀態

$begin_course_state =  array (

	'0' =>	'尚未審核' ,

	'1' =>	'審核通過' , 

	'p' =>	'審核中' ,

	'n'	=>	'審核不通過'

); 







// 帳號通過狀態 

$account_list_type_state =  array (

	-1 => '審核不通過'  ,

	 0 => '審核通過'  , 

	 1 => '尚未審核'  

); 



//menu 登入網頁可做的事情~因為使用的頁面很少因此寫此在這裡。

//如需新增功能則 增加在這邊

//menu 的key 就是每個網頁的filename , 此key也會記在session['menu_role'] 內供判斷權限用

//每頁要限制身份, 就是看這頁設定check 這個key值存不存在。

$all_menu_ctrl = array ( 

	'begin_course_list' 		=> array('menu_group'=>'apply_course', 	'title' => '已申請課程列表') ,

	'begin_course' 				=> array('menu_group'=>'apply_course', 	'title' => '申請開設課程') ,

	'begin_course_passed_list'	=> array('menu_group'=>'apply_course', 	'title' => '已申請通過課程') ,

	'verify_course_list'		=> array('menu_group'=>'verfiy_course', 'title'	=> '待審核課程列表') ,

	'verify_passed_course_list'	=> array('menu_group'=>'verfiy_course', 'title'	=> '已審核通過列表') , 

	'yet_passed_course_list'	=> array('menu_group'=>'verfiy_course', 'title'	=> '不通過審核列表') ,

	'stattistic_group'			=> array('menu_group'=>'statistic', 	'title'	=> '認證時數報表查詢') ,

	'stat_request1'				=> array('menu_group'=>'statistic',	'title' => '統計報表') ,

	'stat_request2'				=> array('menu_group'=>'statistic',	'title' => '統計報表') ,

    'stat_request3'             => array('menu_group'=>'statistic', 'title' => '統計報表') , //20111215測試增加

    'stat_request_medicine'	    => array('menu_group'=>'statistic',	'title' => '統計報表'), //20110107加的
    'stat_request_city'         => array('menu_group'=>'statistic', 'title' => '統計報表','link'=>'../Web_Service/webapp.php?controller=LearningDataStat&action=cityView'),
    'stat_request_doc'          => array('menu_group'=>'statistic', 'title' => '統計報表','link'=>'../Web_Service/webapp.php?controller=LearningDataStat&action=docView'),
    'stat_request_university'   => array('menu_group'=>'statistic', 'title' => '統計報表','link'=>'../Web_Service/webapp.php?controller=LearningDataStat&action=universityView'),
    'stat_request_school'       => array('menu_group'=>'statistic', 'title' => '統計報表','link'=>'../Web_Service/webapp.php?controller=LearningDataStat&action=schoolView'),

    'ws_user_index'             => array('menu_group'=>'webservice','title' => 'API Key管理','link'=>'../Web_Service/WS_User.php?action=index'),
    'ws_user_service_summary'   => array('menu_group'=>'webservice','title' => 'API說明','link'=>'../Web_Service/WS_User.php?action=serviceSummary'),

    'ws_admin_wait_key'         => array('menu_group'=>'webservice','title' => 'API使用者審核','link'=>'../Web_Service/WS_Admin.php?action=index'),
    'ws_admin_browse_user'      => array('menu_group'=>'webservice','title' => 'API使用者管理','link'=>'../Web_Service/WS_Admin.php?action=browseUser'),
    'ws_admin_service_list'     => array('menu_group'=>'webservice','title' => 'API管理','link'=>'../Web_Service/WS_Admin.php?action=serviceList'),
    'ws_admin_service_permission'=> array('menu_group'=>'webservice','title' => 'API權限管理','link'=>'../Web_Service/WS_Admin.php?action=servicePermission'),
);



$default_menu_group_str = array ( 

	'apply_course' 	=> '申請開設課程', 

	'verfiy_course' => '課程審核', 

	'statistic' 	=> '學習資料管理', 

	'webservice' 	=> 'Web Service' 

); 





//output 可顯示的menu

// 會產生像這樣 array 給tpl 產生menu 

// 	$test_arr = array(

// 		"開設課程" => array(

// 			'begin_course_list.php' => '已開課程列表',

// 			'begin_course.php' => '開新課程', 

// 		), 

// 		"學習資料管理" => array(

// 			'statistic.php' => '認證時數報表查詢' 

// 		)

// );

function filter_menu_ctrl($all_menus, $menu_group_str, $allow_ctrl) 

{

	if(empty($allow_ctrl) ) 

		return array();

	$return_arr = array();

	foreach($all_menus as $k => $v) {

        if( in_array($k, $allow_ctrl)  ) { //如果是有權限可以看的頁面 	

            if(isset($v['link']))
                $return_arr[ $menu_group_str[$v['menu_group']] ][$v['link']] = $v['title'].'' ;
            else
                $return_arr[ $menu_group_str[$v['menu_group']] ][ $k .'.php' ] = $v['title']. '' ; 

		}

	}

	return $return_arr ; 

}





function gen_url_param($arr) {

	if( empty($arr) )

		return ;

	

	$url_param =''; 

	foreach ($arr as $k => $v) {

		$url_param .= '&'. $k .'=' . urlencode($v) ;  

	}

}



function redirect($url) {

	header("Location:$url"); 

	exit; 

}



/* default 帳號



INSERT INTO `register_applycourse` (`no`, `account`, `password`, `category`, `org_title`, `undertaker`, `identify`, `title`, `tel`, `email`, `usage_note`, `apply_date`, `verify_date`, `login_date`, `state`, `state_reason`, `menu_role`) VALUES


(12, 'moe9056', 'b60dbd77ad846cae6f59b8df7df99f75', 'c', '教育部電算中心-學習組', '學習組-承辦人', '', '學習組-承辦人', '9056', 'moe9056@moe.gov.tw', '審核大專院校開課。\r\n', '2010-07-22 16:42:09', '2010-08-04 17:56:33', '2010-08-09 14:21:23', 1, NULL, '["verify_course_list","verify_passed_course_list","yet_passed_course_list"]'),

(13, 'moe9053', 'cd8f06f709537fe8bbc1d8cf30be7d71', 'a', '教育部電算中心-資教組', '資教組承辦人', '', '資教組承辦人', '9053', 'moe9053@moe.gov.tw', 'test', '2010-07-22 16:55:55', '2010-08-04 17:56:33', '2010-08-13 18:42:10', 1, NULL, '["verify_course_list","verify_passed_course_list","yet_passed_course_list","stat_request2"]'),

(14, 'moe9081', '099bd4c50e1953c83ecaf8eb5163ab3d', 'b', '教育部電算中心-資源組', '資源組承辦人', '', '資源組承辦人', 'moe9081', 'moe9081@moe.gov.tw', '', '2010-07-22 16:55:55', '2010-08-04 17:56:33', '2010-08-09 14:21:30', 1, NULL, '["verify_course_list","verify_passed_course_list","yet_passed_course_list","stat_request1"]');



INSERT INTO `register_applycourse` (`account`, `password`, `category`, `org_title`, `undertaker`, `identify`, `title`, `tel`, `email`, `usage_note`, `apply_date`, `verify_date`, `login_date`, `state`, `state_reason`, `menu_role`) VALUES ('adv046', md5('adv046'), '3', '臺北縣、桃園縣、連江縣 輔導團', '財團法人中國生產力中', '', '財團法人中國生產力中', '', '', '', '2010-08-13 18:54:36', '2010-08-13 18:55:39', '2010-08-13 18:55:39', 1, NULL, '["begin_course_list","begin_course","begin_course_passed_list"]');

INSERT INTO `register_applycourse` (`account`, `password`, `category`, `org_title`, `undertaker`, `identify`, `title`, `tel`, `email`, `usage_note`, `apply_date`, `verify_date`, `login_date`, `state`, `state_reason`, `menu_role`) VALUES ('adv035', md5('adv035'), '3', '新竹縣 輔導團', '承揚興業股份有限公司', '', '承揚興業股份有限公司', '', '', '', '2010-08-13 18:54:36', '2010-08-13 18:55:39', '2010-08-13 18:55:39', 1, NULL, '["begin_course_list","begin_course","begin_course_passed_list"]');

INSERT INTO `register_applycourse` (`account`, `password`, `category`, `org_title`, `undertaker`, `identify`, `title`, `tel`, `email`, `usage_note`, `apply_date`, `verify_date`, `login_date`, `state`, `state_reason`, `menu_role`) VALUES ('adv044', md5('adv044'), '3', '苗栗縣 輔導團', '財團法人明基友達文教基金會', '', '財團法人明基友達文教基金會', '', '', '', '2010-08-13 18:54:36', '2010-08-13 18:55:39', '2010-08-13 18:55:39', 1, NULL, '["begin_course_list","begin_course","begin_course_passed_list"]');

INSERT INTO `register_applycourse` (`account`, `password`, `category`, `org_title`, `undertaker`, `identify`, `title`, `tel`, `email`, `usage_note`, `apply_date`, `verify_date`, `login_date`, `state`, `state_reason`, `menu_role`) VALUES ('adv036', md5('adv036'), '3', '臺中縣、彰化縣 輔導團', '國立雲林科技大學', '', '國立雲林科技大學', '', '', '', '2010-08-13 18:54:36', '2010-08-13 18:55:39', '2010-08-13 18:55:39', 1, NULL, '["begin_course_list","begin_course","begin_course_passed_list"]');

INSERT INTO `register_applycourse` (`account`, `password`, `category`, `org_title`, `undertaker`, `identify`, `title`, `tel`, `email`, `usage_note`, `apply_date`, `verify_date`, `login_date`, `state`, `state_reason`, `menu_role`) VALUES ('adv037', md5('adv037'), '3', '南投縣 輔導團', '朝陽科技大學', '', '朝陽科技大學', '', '', '', '2010-08-13 18:54:36', '2010-08-13 18:55:39', '2010-08-13 18:55:39', 1, NULL, '["begin_course_list","begin_course","begin_course_passed_list"]');

INSERT INTO `register_applycourse` (`account`, `password`, `category`, `org_title`, `undertaker`, `identify`, `title`, `tel`, `email`, `usage_note`, `apply_date`, `verify_date`, `login_date`, `state`, `state_reason`, `menu_role`) VALUES ('adv040', md5('adv040'), '3', '雲林縣 輔導團', '國立虎尾科技大學', '', '國立虎尾科技大學', '', '', '', '2010-08-13 18:54:36', '2010-08-13 18:55:39', '2010-08-13 18:55:39', 1, NULL, '["begin_course_list","begin_course","begin_course_passed_list"]');

INSERT INTO `register_applycourse` (`account`, `password`, `category`, `org_title`, `undertaker`, `identify`, `title`, `tel`, `email`, `usage_note`, `apply_date`, `verify_date`, `login_date`, `state`, `state_reason`, `menu_role`) VALUES ('adv045', md5('adv045'), '3', '嘉義縣 輔導團', '吳鳳技術學院', '', '吳鳳技術學院', '', '', '', '2010-08-13 18:54:36', '2010-08-13 18:55:39', '2010-08-13 18:55:39', 1, NULL, '["begin_course_list","begin_course","begin_course_passed_list"]');

INSERT INTO `register_applycourse` (`account`, `password`, `category`, `org_title`, `undertaker`, `identify`, `title`, `tel`, `email`, `usage_note`, `apply_date`, `verify_date`, `login_date`, `state`, `state_reason`, `menu_role`) VALUES ('adv048', md5('adv048'), '3', '臺南縣 輔導團', '崑山科技大學', '', '崑山科技大學', '', '', '', '2010-08-13 18:54:36', '2010-08-13 18:55:39', '2010-08-13 18:55:39', 1, NULL, '["begin_course_list","begin_course","begin_course_passed_list"]');

INSERT INTO `register_applycourse` (`account`, `password`, `category`, `org_title`, `undertaker`, `identify`, `title`, `tel`, `email`, `usage_note`, `apply_date`, `verify_date`, `login_date`, `state`, `state_reason`, `menu_role`) VALUES ('adv043', md5('adv043'), '3', '高雄縣 輔導團', '北淞企業有限公司', '', '北淞企業有限公司', '', '', '', '2010-08-13 18:54:36', '2010-08-13 18:55:39', '2010-08-13 18:55:39', 1, NULL, '["begin_course_list","begin_course","begin_course_passed_list"]');

INSERT INTO `register_applycourse` (`account`, `password`, `category`, `org_title`, `undertaker`, `identify`, `title`, `tel`, `email`, `usage_note`, `apply_date`, `verify_date`, `login_date`, `state`, `state_reason`, `menu_role`) VALUES ('adv041', md5('adv041'), '3', '屏東縣 輔導團', '高雄市資訊服務暨應用協會', '', '高雄市資訊服務暨應用協會', '', '', '', '2010-08-13 18:54:36', '2010-08-13 18:55:39', '2010-08-13 18:55:39', 1, NULL, '["begin_course_list","begin_course","begin_course_passed_list"]');

INSERT INTO `register_applycourse` (`account`, `password`, `category`, `org_title`, `undertaker`, `identify`, `title`, `tel`, `email`, `usage_note`, `apply_date`, `verify_date`, `login_date`, `state`, `state_reason`, `menu_role`) VALUES ('adv039', md5('adv039'), '3', '宜蘭縣 輔導團', '國立宜蘭大學', '', '國立宜蘭大學', '', '', '', '2010-08-13 18:54:36', '2010-08-13 18:55:39', '2010-08-13 18:55:39', 1, NULL, '["begin_course_list","begin_course","begin_course_passed_list"]');

INSERT INTO `register_applycourse` (`account`, `password`, `category`, `org_title`, `undertaker`, `identify`, `title`, `tel`, `email`, `usage_note`, `apply_date`, `verify_date`, `login_date`, `state`, `state_reason`, `menu_role`) VALUES ('adv038', md5('adv038'), '3', '花蓮縣 輔導團', '國立東華大學', '', '國立東華大學', '', '', '', '2010-08-13 18:54:36', '2010-08-13 18:55:39', '2010-08-13 18:55:39', 1, NULL, '["begin_course_list","begin_course","begin_course_passed_list"]');

INSERT INTO `register_applycourse` (`account`, `password`, `category`, `org_title`, `undertaker`, `identify`, `title`, `tel`, `email`, `usage_note`, `apply_date`, `verify_date`, `login_date`, `state`, `state_reason`, `menu_role`) VALUES ('adv047', md5('adv047'), '3', '臺東縣 輔導團', '財團法人台灣網站分級推廣基金會', '', '財團法人台灣網站分級推廣基金會', '', '', '', '2010-08-13 18:54:36', '2010-08-13 18:55:39', '2010-08-13 18:55:39', 1, NULL, '["begin_course_list","begin_course","begin_course_passed_list"]');

INSERT INTO `register_applycourse` (`account`, `password`, `category`, `org_title`, `undertaker`, `identify`, `title`, `tel`, `email`, `usage_note`, `apply_date`, `verify_date`, `login_date`, `state`, `state_reason`, `menu_role`) VALUES ('adv042', md5('adv042'), '3', '澎湖縣 輔導團', '深耕文化工作坊', '', '深耕文化工作坊', '', '', '', '2010-08-13 18:54:36', '2010-08-13 18:55:39', '2010-08-13 18:55:39', 1, NULL, '["begin_course_list","begin_course","begin_course_passed_list"]');

INSERT INTO `register_applycourse` (`account`, `password`, `category`, `org_title`, `undertaker`, `identify`, `title`, `tel`, `email`, `usage_note`, `apply_date`, `verify_date`, `login_date`, `state`, `state_reason`, `menu_role`) VALUES ('adv009', md5('adv009'), '3', '金門縣 輔導團', '國立金門技術學院', '', '國立金門技術學院', '', '', '', '2010-08-13 18:54:36', '2010-08-13 18:55:39', '2010-08-13 18:55:39', 1, NULL, '["begin_course_list","begin_course","begin_course_passed_list"]');





ALTER TABLE  `begin_course` 

 add   `state_note` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用以填寫begin_coursestate = n 不通過的理由、原因',

 add   `applycourse_no` INT( 11 ) NULL DEFAULT  '0' COMMENT  '是由哪一個開課帳號所開課，系統管理員預設為0，其餘值則對應到register_applycourse.no ',

 add   `applycourse_doc` INT( 11 ) NOT NULL COMMENT  '用來紀錄開課單位屬於哪個doc，只有為applycourse_no為輔導團的no時才需要參考這個'

*/



?>

