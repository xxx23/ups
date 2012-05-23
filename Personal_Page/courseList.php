<?
/*author: lunsrot
 *date: 2007/03/12
 */
    require_once("../config.php");
    require_once("../session.php");
    require_once("../library/common.php");
    $tpl = new Smarty();

    /*
     * modify by Samuel @ 2010/04/27
     * 這裡用來修改如果閒置太久的話，要直接跑到logout介面！
     * 判斷personal_id有沒有人 如果是null的話，表示目前的session被清掉了。
     * 被閒置太久後，會直接移頁面到權限錯誤頁面。
     */
    if( !isset($_SESSION['personal_id']) || $_SESSION['personal_id'] == NULL)
        header("location: ../identification_error.html");

    $pid = $_SESSION['personal_id'];

    $role = $_SESSION['role_cd'];
    
    if($_GET[action] == 'select' && isset($_GET['course_cd']) && $role==1){
        $need_validate_select = ($_GET[need_validate_select] == 0)? 1: 0;

        //更新課程資料，並判斷使用者是否為開課教師
        $sql = "UPDATE course_basic SET need_validate_select='". $need_validate_select."' WHERE course_cd='".$_GET[course_cd]."' 
            and exists(select * from teach_begin_course as t inner join begin_course as b on t.begin_course_cd = b.begin_course_cd where b.course_cd=$_GET[course_cd] and t.teacher_cd=$pid)";
        $res = $DB_CONN->query($sql);   
    }
    elseif ($_GET['action'] == 'drop' && isset($_GET['begin_course_cd']))
    {
        //把某一門課退遠 是把這一筆資料由take_course中刪除
        $sql = "DELETE from take_course
        where begin_course_cd = {$_GET['begin_course_cd']} 
        and personal_id = {$pid}";
        $res = $DB_CONN->query($sql);
        //退選後清除該學生在課程中的紀錄
        clear_student_learning($_GET['begin_course_cd'],$pid);
        clear_student_score($_GET['begin_course_cd'],$pid);
    }
    
    //==============================================================================================================================
    //modify by Samuel @ 2009/09/29
    //如果是訪客使用者 需要把全部的資料都抓出來 並且做分類
    if($role == 4)
    {
        //流程：比較課程分類是否有變動，再決定頁數。
        if(isset($_POST['or_type']))
            $or_type = $_POST['or_type'] ;
        elseif(isset($_GET['or_type']))
            $or_type = $_GET['or_type'];
        else
            $or_type = 0 ;
        

        if(isset($_POST['coursetype']))
            $coursetype = $_POST['coursetype'];
        elseif(isset($_GET['coursetype']))
            $coursetype=$_GET['coursetype'];
        else 
            $coursetype = 0 ;
        $tpl->assign("coursetype",$coursetype);


        if(isset($_POST['or_sub_type']))
                $or_sub_type = $_POST['or_sub_type'];
        elseif(isset($_GET['or_sub_type']))
                $or_sub_type = $_GET['or_sub_type'];
        else
                $or_sub_type = 0;

        if(isset($_POST['sub_coursetype'])) 
            $sub_coursetype = $_POST['sub_coursetype'] ;
        elseif(isset($_GET['sub_coursetype']))
            $sub_coursetype = $_GET['sub_coursetype'];
        else 
            $sub_coursetype = 0 ;

        $tpl->assign("sub_coursetype",$sub_coursetype);
    

        if($coursetype != $or_type)
        {
            $page_number = 1 ;
            $sub_coursetype = 0 ;
            $or_type = $coursetype;
        }
        elseif($coursetype == $or_type && $or_sub_type != $sub_coursetype)
        {
                $page_number = 1;
                $or_sub_type = $sub_coursetype;
        }
        else{
            if(isset($_POST['page_number']))    
                $page_number = $_POST['page_number'];
            elseif(isset($_GET['p']))
                $page_number = $_GET['p'];
            else
                $page_number = 1;
            $tpl->assign("page_number",$page_number); 
        }
        $tpl->assign("or_type",$or_type);
        $tpl->assign("or_sub_type",$or_sub_type);

        $show_data = 10; //設定一頁有幾筆資料
        $course_start = ($page_number-1)*$show_data;
    
        //先判斷是哪一種type 0的話是全部課程 如果是1就是依身份分類 2就是以課程屬性來分類
        if($coursetype == 0)
        {
            // 要顯示全部的課程資訊
            $sql = "SELECT * from begin_course WHERE guest_allowed=1 ORDER BY begin_course_cd DESC limit {$course_start} , {$show_data}";
            $all_course = db_getAll($sql);
            $tpl->assign("all_course",$all_course);
            
            // 計算上下面功能是否可以顯示
            // 如果目前顯示到的筆數 小於 總課程的筆數的話 就有下一頁
            // 如果目前顯示的筆數並非是 第一頁 即可上一頁
            $sql = "select * from begin_course where guest_allowed = 1";
            $all_course_count = db_getAll($sql);
            $tpl->assign("all_course_number",count($all_course_count));

            if($course_start + $show_data < count($all_course_count)){
                    $nextpage = $page_number +1 ;
                    $after_current_page_yes = 1;
            }
            if($page_number != 1 && $page_number > 0){
                    $before_current_page_yes = 1;
                    $awaypage = $page_number -1 ;
            }   

            $tpl->assign("nextpage",$nextpage);
            $tpl->assign("awaypage",$awaypage);
            $tpl->assign("after_current_page_yes",$after_current_page_yes);
            $tpl->assign("before_current_page_yes",$before_current_page_yes);
            $pages = count($all_course_count)/$show_data;
            if($pages == intval($pages))
                    $total_page_number = $pages;
            else
                $total_page_number = intval($pages) + 1;
            $tpl->assign("total_page_number",$total_page_number);
            
            $i = 0 ;
            while( $i < $total_page_number){
            $total_page_index[$i]['count'] = $i + 1;
            $total_page_index[$i]['index'] = $i+1;
            $i++;
            }
            $tpl->assign("total_page_index",$total_page_index);
        }
        elseif($coursetype == 1)
        {
            // 要先把子項目都列出來。於現在這個階段，目前子項目都不變 所以先以固定寫法傳送過去
            $all_sub_coursetype = array(
                    "0" => array( "number"=> "0" , "type_name"=>"一般民眾"),
                    "1" => array( "number"=> "1" , "type_name"=>"國民中小學教師"), 
                    "2" => array( "number"=> "2" , "type_name"=>"高中職教師"),
                    "3" => array( "number"=> "3" , "type_name"=>"大專院校師生")
                  );
            $tpl->assign("all",$all_sub_coursetype);
            $sql = "SELECT unit_cd ,unit_name from lrtunit_basic_ where department = {$sub_coursetype}";
            $all_unit_cd = db_getAll($sql);
            //從begin_course裡面去找這些課程 所以要有一個sql一次把這些query出來
            if($all_unit_cd[0]['unit_cd'] == null)
            {
                //表示底下沒有任何的開課單位 直接去begin_course找有沒有這個類別的課程
                $sql = "select * from begin_course where begin_unit_cd = {$sub_coursetype} and guest_allowed = 1";
                $sql2 = $sql ;
            }
            else
            {
                $sql = "select * from begin_course where guest_allowed = 1 and ( begin_unit_cd = {$all_unit_cd[0]['unit_cd']}";
                $j = 1 ;
                while($all_unit_cd[$j]['unit_cd'] != NULL)
                {
                    $sql = $sql." or begin_unit_cd = {$all_unit_cd[$j]['unit_cd']}";
                    $j++;
                }
                $sql .= ")";
                $sql2 = $sql ;
                $sql = $sql." order by begin_course_cd DESC limit {$course_start},{$show_data}";
            }

            $all_course = db_getAll($sql);
            $k = 0 ;
            $l = 0 ;
            //把類別接到課程的block上
            while( $k < count($all_course))
            {
                    $l = 0; 
                    while($l < count($all_unit_cd))
                    {
                            if($all_course[$k]['begin_unit_cd'] == $all_unit_cd[$l]['unit_cd'])
                                    $all_course[$k]['begin_unit_name'] = $all_unit_cd[$l]['unit_name'];
                            $l++;
                    }
                    $k++;
            }

            $tpl->assign("all_course",$all_course);
            //計算一共有幾頁
            
            $all_course_count = db_getAll($sql2);
            if($course_start + $show_data < count($all_course_count)){
                    $nextpage = $page_number +1 ;
                    $after_current_page_yes = 1;
            }
            if($page_number != 1 && $page_number > 0){
                    $before_current_page_yes = 1;
                    $awaypage = $page_number -1 ;
            }   
        
            $tpl->assign("nextpage",$nextpage);
            $tpl->assign("awaypage",$awaypage);
            $tpl->assign("after_current_page_yes",$after_current_page_yes);
            $tpl->assign("before_current_page_yes",$before_current_page_yes);
            
            $tpl->assign("all_course_number",count($all_course_count));
            $pages = count($all_course_count)/$show_data;
            if($pages == intval($pages))
                $total_page_number = $pages;
            else
                $total_page_number = intval($pages)+1;
            $tpl->assign("total_page_number",$total_page_number);
            $i = 0 ;
            while($i<$total_page_number)
            {
                $total_page_index[$i]['count'] = $i+1;
                $total_page_index[$i]['index'] = $i+1;
                $i++;
            }
            $tpl->assign("total_page_index",$total_page_index);
        }
        elseif($coursetype == 2)
        {   
            //找出所有的子項目
            $sql = "SELECT property_cd as number, property_name as type_name from course_property ORDER by property_cd";
            $all_sub_coursetype = db_getAll($sql);          
            $tpl->assign("all",$all_sub_coursetype);
    
            $sql = "SELECT * from begin_course 
                where course_property={$sub_coursetype} 
                and guest_allowed = 1 
                order by begin_course_cd DESC 
                limit {$course_start},{$show_data}";

            $all_course = db_getAll($sql);
            
            $sql = "SELECT property_name from course_property where property_cd ={$sub_coursetype}";
            $begin_unit_name = db_getRow($sql);
            
            $k = 0 ; 
            while($k < count($all_course))
            {
                    $all_course[$k]['begin_unit_name'] = $begin_unit_name['property_name'];
                    $k++;
            }
            $tpl->assign("all_course",$all_course);
            
            $sql = "SELECT * from begin_course where course_property={$sub_coursetype}";
            $all_course_count = db_getAll($sql);
            $tpl->assign("all_course_number",count($all_course_count));

             
            if($course_start + $show_data < count($all_course_count)){
                    $nextpage = $page_number +1;
                    $after_current_page_yes = 1;
            }
            if($page_number != 1 && $page_number > 0){
                    $before_current_page_yes = 1;
                    $awaypage = $page_number -1 ;
            }   
        
            $tpl->assign("nextpage",$nextpage);
            $tpl->assign("awaypage",$awaypage);
            $tpl->assign("after_current_page_yes",$after_current_page_yes);
            $tpl->assign("before_current_page_yes",$before_current_page_yes);
            $pages = count($all_course_count)/$show_data;
            if($pages == intval($pages))
                $total_page_number = $pages;
            else
                $total_page_number = intval($pages) + 1;

            $tpl->assign("total_page_number",$total_page_number);
            //計算一共有幾頁
            $i = 0 ;
            while($i < $total_page_number)
            {
                $total_page_index[$i]['count'] = $i+1;
                $total_page_index[$i]['index'] = $i+1;
                $i++;
            }
            $tpl->assign("total_page_index",$total_page_index);
        }
    }
    //end 訪客進課程之後會做的事情    

    //===========================================================================================================================
    $fname = array("displayAdmin", "displayTeach", "displayAssis", "displayStudy", "displayStudy");
    call_user_func($fname[$role], $tpl, $pid);
    alert_msg($tpl,$pid);
    $role_cd = $_SESSION['role_cd'];
    $tpl->assign("WEBROOT", $WEBROOT);
    $tpl->assign("role_cd", $role);
    
    if($role == 1 ) {
        $tpl->assign('contents', list_course_content($_SESSION['personal_id'])) ;
    }
    
    assignTemplate($tpl, "/personal_page/courseList.tpl");

    
    
//列出該教師擁有之教材
function list_course_content($teacher_cd) {
    $sql_get_contents = " SELECT * FROM course_content WHERE teacher_cd={$_SESSION['personal_id']}";
    $contents = db_getAll($sql_get_contents);  
    
    $return_arr = array(); 
    foreach($contents as $v) {
        $return_arr[$v['content_cd'] ] = $v ;
    }
    return $return_arr ; 
}

    
function displayAdmin($tpl, $pid){
}




function displayTeach($tpl, $pid){

    $sql = "select * from `teach_begin_course` A, `begin_course` B, `lrtunit_basic_` C
        where A.teacher_cd=$pid and B.begin_course_cd=A.begin_course_cd and C.unit_cd=B.begin_unit_cd and B.begin_coursestate='1' AND B.note IS NOT NULL";
    
    $result = db_query( $sql );
    $n = $result->numRows();
    while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
        //($row[need_validate_select] == 0)? $row[select]='不開放': $row[select]='開放';
        /* 把教導式的時間都append進去 */
        if($row['attribute'] == 0)
        {
            $date = $row['d_course_begin']."~".$row['d_course_end'];
            $row['course_period'] = $date;
        }
        elseif($row['attribute'] == 1)
        {
            /* 原本紀錄的時間除了日期之外，還有時、分、秒 */
            $split_course_begin = split(" ",$row['d_course_begin']);
            $split_course_end = split(" ",$row['d_course_end']);

            $date = $split_course_begin[0]."~".$split_course_end[0];
            $row['course_period'] = $date ;
        }
        $tpl->append('courseList', $row);
    }   

    
    //列出待審核之課程。
    //看begin_coursestate , char(1), 'p': 正在審核中 , 'n': 審核不通過, '1': 審核通過, '0': 還沒審核
    $sql = 
        "SELECT 
            bc.begin_course_cd, bc.begin_course_name, u.unit_name, bc.inner_course_cd, p.personal_name ,bc.begin_coursestate
        FROM 
            begin_course bc, lrtunit_basic_ u, teach_begin_course tbc, personal_basic p
        WHERE
            bc.begin_course_cd=tbc.begin_course_cd and
            tbc.teacher_cd='".$pid."'  and
            p.personal_id='".$pid."'  and
            bc.begin_unit_cd=u.unit_cd and
            bc.begin_coursestate !='1' 
        ORDER BY bc.begin_course_cd ASC ";  
    $result = db_query($sql);
    $num = 0;
    while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
        $row['num'] = $num++;
        $sql_get_course_content = " SELECT content_cd FROM class_content_current WHERE begin_course_cd=" . $row['begin_course_cd'] ;
        $content_cd = db_getOne($sql_get_course_content);
        
        if($content_cd == null)
            $row['conten_cd'] = -1; 
        else 
            $row['content_cd'] = $content_cd ; 
 
        $tpl->append('new_course_data', $row);                  
    }
    
    $tpl->assign("num", $num);
}



function displayAssis($tpl, $pid){
    $sql = "select * from `teach_begin_course` A, `begin_course` B, `lrtunit_basic_` C
        where A.teacher_cd=$pid and B.begin_course_cd=A.begin_course_cd and C.unit_cd=B.begin_unit_cd AND B.begin_coursestate='1' AND B.note IS NOT NULL";
    $result = db_query( $sql );

    while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false){
        $row[select]='不開放';
        $tpl->append('courseList', $row);
    }   
}

function displayStudy($tpl, $pid){
    
    $sql = 
    "select             
    A.begin_course_cd,
    A.course_begin,
    A.course_end,
    A.pass,
    B.*,
    C.unit_name                     
    from 
        `take_course` A, `begin_course` B, `lrtunit_basic_` C 
    where 
         A.personal_id=$pid and
         B.begin_course_cd=A.begin_course_cd and
         C.unit_cd=B.begin_unit_cd and
         A.allow_course=1 and
         (A.course_end > NOW() or A.course_end is NULL) and
         B.begin_coursestate='1' AND
         B.note IS NOT NULL order by B.attribute";

    $result = db_query($sql);
    //file_put_contents("/tmp/abcdtext.txt",$result);
    while(($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) != false)
    {
        //$row['personal_name'] = new array();
        //$row['personal_id'] = new array();

      $result2 = db_query("select P.personal_name,P.personal_id 
        from teach_begin_course T inner join register_basic R 
        on T.teacher_cd = R.personal_id inner join personal_basic P on T.teacher_cd = P.personal_id
        where begin_course_cd = $row[begin_course_cd] and role_cd=1");
        while(($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC)) != false)
        {
            $row['personal_name'][] = $row2['personal_name'];
            $row['personal_id'][] = $row2['personal_id'];
        }

        // add by Samuel @ 2009/07/31 
        // 以下的程式是用來顯示自學式課程和教導式課程的修課日期
        
        if($row['attribute'] == 0) // 表示是自學式
        {
            $date = $row['course_begin']."~".$row['course_end'];
            $row['course_period'] = $date;

            //用來設定是否可以退選 如果是自學式 可以隨時選隨時退選

            $row['is_allow_drop'] = 1; 

        }
        elseif($row['attribute'] == 1 )// 表示是教導式
        {
            $split_course_begin = split(" ",$row['d_course_begin']);
            $split_course_end = split(" ",$row['d_course_end']);

            $date = $split_course_begin[0]."~".$split_course_end[0];
            $row['course_period'] = $date ;

            //教導式的課程如果選課時間已經過了 就不能退選了 看選課時間是否正確 來決定能不能退選
            $today = date("Y-m-d");

            if( $today > $row['d_select_end'] )
                $row['is_allow_drop'] = 0;
            else
                $row['is_allow_drop'] = 1;        
        }

        //add by Samuel @2009/07/31
        //以下程式用來判斷 觀看這一門課是否真的可以選課 如果可以退選 就把 is_allow_drop 設成1

        $tpl->append('courseList', $row);
    }
}

function displayOther($tpl, $pid){
    echo $pid;
}

function alert_msg($tpl,$pid){
    
    //$seven_day_sec = 7*24*60*60;
    //$timestamp = time()-$seven_day_sec;
    $seven_day_before = date("Y-m-d H:i:s",time()+7*86400);
    $sql = "SELECT  b.begin_course_name,t.course_end
        FROM begin_course b,take_course t 
                WHERE b.begin_course_cd=t.begin_course_cd AND
              t.personal_id = {$pid} AND 
              (t.course_end < '{$seven_day_before}' AND t.course_end > NOW()) AND
              t.allow_course = 1";
    $course_List = db_getAll($sql);
    $msg = '';
    foreach( $course_List as $course)
    {
        $msg.=$course['begin_course_name']." - 即將結束 (修課期限為:".$course['course_end'].")\\n";
    }
    $tpl->assign("alert_msg",$msg);
}

//刪除課程中學生的閱讀教材紀錄
function clear_student_learning($begin_course_cd, $personal_id)
{   
        if( ($begin_course_cd != null) && ($personal_id != null) ){     
            $sql = "DELETE FROM student_learning
                    WHERE begin_course_cd=$begin_course_cd AND
                    personal_id=$personal_id ;";
            //echo $sql;
            db_query($sql);

            $sql = "DELETE FROM event_statistics
                       WHERE begin_course_cd='$begin_course_cd' AND
                         personal_id='$personal_id';";
            db_query($sql);
        }
}

    //刪除課程中學生的分數紀錄
function clear_student_score($begin_course_cd, $personal_id)
{   
        if( ($begin_course_cd != null) && ($personal_id != null) ){
            $sql = "DELETE FROM course_concent_grade 
                       WHERE begin_course_cd='$begin_course_cd' AND
                         student_id='$personal_id' ;";
            //echo $sql;
            db_query($sql);
        }
}

function displayDate($tpl, $pid){

}


function begin_course_cd() {

}
?>
