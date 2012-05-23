<?php
/*author: lunsrot
 * date:2007/04/03
 */
    require_once("../config.php");
    require_once("../session.php");
    require_once($HOME_PATH . 'library/smarty_init.php');
    require_once('../library/course.php');

    include "exam_info.php";
    include "library.php";///===
    checkMenu("/Examine/tea_view.php");
    

    $begin_course_cd = $_SESSION['begin_course_cd'];
    $pid = $_SESSION['personal_id'];
    $option = $_GET['option'];
    session_unregister("test_no");

    $tmp = gettimeofday();
    $time = $tmp['sec'];
    //$tpl = new Smarty;

    //啟動自動催繳功能
    if(isset($_REQUEST['remind'])){
      echo $_REAUEST['remind'];
      $remindsql = "UPDATE test_course_setup SET remind={$_REQUEST['remind']} 
            WHERE begin_course_cd=$begin_course_cd AND test_no={$_REQUEST['test_no']}";
    db_query($remindsql);
    }


    $sql = "select test_no
            from test_course_setup 
        where begin_course_cd=$begin_course_cd AND is_online=1 AND remind=1";
    $result = db_query($sql);
    $remind_test = Array();
            while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
                $remind_test[]= $row['test_no'];
         }
                    $tpl->assign('remind_test', $remind_test);

     


    $sql = "select * from `test_course_setup` where begin_course_cd=$begin_course_cd AND is_online = 1 order by percentage desc, test_name;";
    $result = db_query($sql);
    while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
        $row['test_type_str'] = ($row[test_type] == 2) ? "正式測驗" : "自我評量";
        $row['string'] = "發佈時間：".$row[d_test_public]."<br/>"."測驗開始：".$row[d_test_beg]."<br/>"."測驗結束：".$row[d_test_end];
        if($row[d_test_public] == NULL)
            $row['state'] = 0;//"未設定";
        else if( timecmp( $time, strtotime($row[d_test_end]) ) == 1 ){
            $row['state'] = 4;//"測驗結束";
        }else if( timecmp( $time, strtotime($row[d_test_beg]) ) == 1 ){
            $row['state'] = 3;//"測驗中";
        }else if( timecmp( $time, strtotime($row[d_test_public]) ) == 1 ){	
            $row['state'] = 2;//"已發佈";
        }else if( timecmp( $time, strtotime($row[d_test_public]) ) == -1 ){
            $row['state'] = 1;//"未發佈";
        }
        $tpl->append('exam_data', $row);
    }

    $tpl->assign('attribute',get_course_attribute($begin_course_cd));
    assignTemplate($tpl, "/examine/tea_view.tpl");
?>
