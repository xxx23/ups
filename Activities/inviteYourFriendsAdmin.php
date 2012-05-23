<?php
/**
 * usb 條件
 * 1. 新會員
 * 2. 通過課程，閱讀時數超過3小時含以上
 * 3.前兩百名
 * ipad條件
 * 1. 新會員拿到上述usb既可
 * 2. 舊會員需要是五個新會員的推薦人 五個新會員需要通過
 *
 *
 */
require_once('../config.php');
require_once('./lib/SimpleFileCache.php');
require_once('../library/filter.php');
require_once('../library/lib_course_pass.php');
require_once('../session.php');

$isAdmin = isset($_SESSION['role_cd']) && $_SESSION['role_cd']==0? true:false;
$cacheTime = optional_param('t',3600000,PARAM_INT);
//US上限
$USB_MAX = 200;
//活動前最後一個註冊註冊學員id
$OLD_USER_T = 47692; 
//為了減少db的負擔 寫了個簡單的file cache
//cacheDir 設定cache file放哪 
//liftime多久更新一次資料
$cache = new SimpleFileCache(array(
    'cacheDir'=>'/tmp',
    'lifetime'=>$cacheTime
));

 $usbList = array();
//取得符合抽獎名單

$ipsadList=array();
if(($ipadList = $cache->load('ipadList')) ==false)
{    
    //取得新學員通過的課程資料
    $sql = "SELECT * 
            FROM take_course T,test_rmd R
            WHERE T.personal_id = R.personal_id 
            AND T.pass=1            
            AND R.rmd_id <= $OLD_USER_T
            ORDER BY T.personal_id ASC";
    $passCourseNewStuData = db_getAll($sql);

    $stuPassCourses =array();
    //整理資料以人為單位列表通過的課程
    foreach($passCourseNewStuData as $data)
    {
        $stuPassCourses[$data['personal_id']][] = $data['begin_course_cd'] ;
    }
    unset($passCourseNewStuData);

    //過濾掉閱讀時數未滿三小時的人
    $stuAfterFiltering =array();
    foreach($stuPassCourses as $personal_id => $courses)
    {
        $pass = false;
        foreach($courses as $begin_course_cd)
        {
            if(10800 <= getReadSecond($begin_course_cd,$personal_id))
            {
                //任意一門課超過三小時既可
                $pass= true;
                break;
            }
        }

        if($pass == true)
        {
            $stuAfterFiltering[] = $personal_id;
        }
    }

    //取得通過判斷的學員個人資料
   
    foreach($stuAfterFiltering as $personal_id)
    {
        $personalData =db_getRow("SELECT * FROM personal_basic WHERE personal_id = '{$personal_id}'");
        $login_id = db_getOne("SELECT login_id FROM register_basic WHERE personal_id = '$personal_id';");
        $ipadList[] = array(
            'login_id'=>$login_id,
            'personal_id'=>$personal_id,
            'personal_name'=>$personalData['personal_name'],
            'phone'=>$personalData['tel'],
            'addr'=>$personalData['addr'],
            'identify_id'=>$personalData['identify_id'],
            'city_cd'=>$personalData['city_cd'],
            'email'=>$personalData['email']
        );
    }
    
    $cache->save('ipadList',$ipadList);
}
$usbList=array();
//取得符合usb贈送名單
if(($usbList = $cache->load('usbList'))==false)
{
    //先取出推薦人數超過五個的人必須都是
    $sql = "
        SELECT * FROM
        (
            SELECT rmd_id,register_basic.personal_id,login_id,count(*) as rmd_number
            FROM test_rmd LEFT JOIN register_basic ON test_rmd.rmd_id = register_basic.personal_id
            where login_state=1
            and validated =1
            Group By rmd_id
        )AS rmd_result
        where  rmd_result.rmd_number >=5
        AND rmd_id < $OLD_USER_T
        ";
    
    $datas = db_getAll($sql);
    

    //取得個人資料
    foreach($datas as $data)
    {
        $personalData =db_getRow("SELECT * FROM personal_basic WHERE personal_id = '{$data['rmd_id']}'");
        $usbList[] = array(
            'login_id'=>$data['login_id'],
            'personal_id'=>$data['personal_id'],
            'personal_name'=>$personalData['personal_name'],
            'phone'=>$personalData['tel'],
            'addr'=>$personalData['addr'],
            'email'=>$personalData['email'],
            'identify_id'=>$personalData['identify_id'],
            'city_cd'=>$personalData['city_cd'],
            'rmd_number'=>$data['rmd_number']
        );
    }
        
    $cache->save('usbList',$usbList);
}


$studyList =array();
$row =0;
if (($handle = fopen("studyList.csv", "r")) !== FALSE) {
        
    while (($str = fgets($handle, 1000)) !== FALSE) {
        
        $data = explode(',',$str);
        if($row==0){$row++;continue;}
         $studyList[] = array(
            'login_id'=>'',
            'personal_id'=>'',
            'personal_name'=>$data[3],
            'phone'=>'',
            'addr'=>$data[8],
            'email'=>$data[9],
            'identify_id'=>'',
            'city_cd'=>0,
            'rmd_number'=>0
        );
        
        $row++;
    }
    fclose($handle);
}

global $DEBUG;
$DEBUG=true;
$cityData = db_getAll("SELECT DISTINCT city_cd,city FROM location");
$cityTable = array();
foreach($cityData as $city_cd => $name)
    $cityTable[$city_cd] = $name['city'];

$usbLeft = $USB_MAX - count($usbList);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" /> 
 
<title>教育部數位學習服務平台</title> 
<script type="text/javascript" src="../script/jquery-1.2.6.pack.js"></script> 
<link href="../themes/IE2/css/font_style.css" rel="stylesheet" type="text/css" /> 
<link href="../themes/IE2/css/table.css" rel="stylesheet" type="text/css" /> 
<style>
div#USBList
{
width :90%;
margin:0 auto;
padding-top: 20px;
padding-bottom:20px;
}
div#iPadList
{
width:90%;
margin:0 auto;
padding-top: 20px;
padding-bottom:20px;
}
</style>
</head>

<body>

<div id="USBList">
<h1>原有會員</h1> 
<ul> 
    <ul> 
            <li>於活動期間推薦好友<strong><u>成功加入</u></strong><span class="style1">*</span> UPS，<u>推薦數達五人以上(含五人)</u>，即可於活動結束後<span class="style1"><u>參加抽獎(每人僅一次抽獎機會)</u></span>。此外，依照推薦完成時間的先後順序(依第五個人註冊成功且完成帳號開通為達成條件)，前200名可獲得4G USB隨身碟1支(創見 TS4GJF300-市值320元)。</li> 
          
    </ul> 
<h1>獲贈USB名單</h1>
    <b>剩餘USB隨身碟數量:<?=$usbLeft?></b>
<table class="datatable">
<thead>
    <th>序號</th>
    <th>姓名</th>
    <th>所屬縣市</th>

<?php if($isAdmin):?>
    <th>帳號</th>
    <th>身分證字號</th>
    <th>email</th>i
    <th>電話</th>
    <th>地址</th>
    <th>personal_id</th>
<?php endif;?>
<thead>

    <?php $index=0;?>
    <?php foreach($usbList as $usbUser):?>
    <tr>
    <td><?php echo ++$index;?></td>
    <?php 
        $len = mb_strlen($usbUser['personal_name']);
        $name = $usbUser['personal_name'];
        if($len == 2)
            $name = mb_substr($name,0,1,"UTF-8").'*';
        elseif($len >2)
            $name = mb_substr($name,0,1,"UTF-8").'*'.mb_substr($name,-1,1,"UTF-8");
            
        
    ?>
    <td><?=($isAdmin)?$usbUser['personal_name']:$name?></td>
    <td><?=$cityTable[$usbUser['city_cd']];?></td>
<?php if($isAdmin):?>
    <td><?=$usbUser['login_id']?></td>
    <td><?=$usbUser['identify_id']?></td>
    <td><?=$usbUser['email']?></td>
    <td><?=$usbUser['phone']?></td>
    <td><?=$usbUser['addr']?></td>
    <td><?=$usbUser['personal_id']?></td>
<?php endif;?>
    </tr>
    <?php endforeach;?>
</table>

</div>
<div id ="iPadList">
<h1>新進會員</h1> 
<ul> 
    <ul> 
        <li>2011年6月15日(含)之後加入者為新加入會員(不包含2011年6月14當天加入者)，且須在註冊時填入推薦人帳號始符合被推薦人資格。</li> 
        <p>凡上述所加入的新會員，若於活動期間在UPS平台上完成任一門課程研習，並瀏覽該教材總時數達<span class="style1"><strong><u>3小時以上</u></strong></span>，即可於活動結束後參加抽獎，<strong><u>每人僅一次抽獎機會</u></strong>。 <br /> 
        </p> 
    </ul> 
<h1>抽獎獎項</h1> 
 
    <table style="width:30%" border="1" cellspacing="0" cellpadding="0" class="datatable"> 
      <tr> 
        <td width="60"><p align="center">名額 </p></td> 
        <td width="250"><p align="center">獎項 </p></td> 
      </tr> 
      <tr> 
        <td width="60"><p align="center">1</p></td> 
        <td width="250"><h5 align="center"><font color=red><strong>iPad 2(白色) Wi-Fi 16GB</strong> </font><br>市值    NT$ 15,500</h5></td> 
      </tr> 
    </table> 
<h1>iPad抽獎名單</h1>
<table class="datatable">
<thead>
    <th>序號</th>
    <th>姓名</th>
    <th>所屬縣市</th>
<?php if($isAdmin):?>
    <th>帳號</th>
    <th>身分證字號</th>
    <th>email</th>
    <th>電話</th>
    <th>地址</th>
    <th>personal_id</th>
<?php endif;?>
<thead>
    <?php $index=0;?>
    <?php foreach($usbList as $usbUser):?>
    <tr>
    <td><?php echo ++$index;?></td>
    <?php 
        $len = mb_strlen($usbUser['personal_name']);
        $name = $usbUser['personal_name'];
        if($len == 2)
            $name = mb_substr($name,0,1,"UTF-8").'*';
        elseif($len >2)
            $name = mb_substr($name,0,1,"UTF-8").'*'.mb_substr($name,-1,1,"UTF-8");
            
        
    ?>
    <td><?=($isAdmin)?$usbUser['personal_name']:$name?></td>
    <td><?=$cityTable[$usbUser['city_cd']];?></td>
    <?php if($isAdmin):?>
    <td><?=$usbUser['login_id']?></td>
    <td><?=$usbUser['identify_id']?></td>
    <td><?=$usbUser['email']?></td>
    <td><?=$usbUser['phone']?></td>
    <td><?=$usbUser['addr']?></td>
    <td><?=$usbUser['personal_id']?></td>
    <?php endif;?>
    </tr>
    <?php endforeach?>
    <tr><td colspan="<?php if(!$isAdmin){echo 3;} else{ echo 9;}?>"style="text-align:center;">以上為原有會員滿足條件的名單，以下為新會員滿足條件的名單</td></tr>
    <?php foreach($ipadList as $usbUser):?>
    <tr>
    <td><?php echo ++$index;?></td>
 <?php 
        $len = mb_strlen($usbUser['personal_name'],"UTF-8");
        $name = $usbUser['personal_name'];
        if($len == 2)
            $name = mb_substr($name,0,1,"UTF-8").'*';
        elseif($len >2)
            $name = mb_substr($name,0,1,"UTF-8").'*'.mb_substr($name,-1,1,"UTF-8");
            
        
    ?>
    <td><?=($isAdmin)?$usbUser['personal_name']:$name?></td>
    <td><?=$cityTable[$usbUser['city_cd']];?></td>
   
    <?php if($isAdmin):?>
    <td><?=$usbUser['login_id']?></td>
    <td><?=$usbUser['identify_id']?></td>
    <td><?=$usbUser['email']?></td>
    <td><?=$usbUser['phone']?></td>
    <td><?=$usbUser['addr']?></td>
    <td><?=$usbUser['personal_id']?></td>
    <?php endif;?>
    </tr>
    <?php endforeach;?>
    <tr><td colspan="<?php if(!$isAdmin){echo 3;} else{ echo 9;}?>"style="text-align:center;">以下為參加南區參訪活動名單</td></tr>
    <?php foreach($studyList as $usbUser):?>
    <tr>
    <td><?php echo ++$index;?></td>
    <?php 
        $len = mb_strlen($usbUser['personal_name'],"UTF-8");
        $name = $usbUser['personal_name'];
        if($len == 2)
            $name = mb_substr($name,0,1,"UTF-8").'*';
        elseif($len >2)
            $name = mb_substr($name,0,1,"UTF-8").'*'.mb_substr($name,-1,1,"UTF-8");
            
        
    ?>
    <td><?=($isAdmin)?$usbUser['personal_name']:$name?></td>
    <td></td>
   
    <?php if($isAdmin):?>
    <td><?=$usbUser['login_id']?></td>
    <td><?=$usbUser['identify_id']?></td>
    <td><?=$usbUser['email']?></td>
    <td><?=$usbUser['phone']?></td>
    <td><?=$usbUser['addr']?></td>
    <td><?=$usbUser['personal_id']?></td>
    <?php endif;?>
    </tr>

    <?php endforeach;?>    
    </table>
</div>


</body>

</html>
