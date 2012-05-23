<?

	include("config.php");
	$tpl = new Smarty();
	$dsn = array(
	    'phptype'  => "mysql",
	    'username' => "elearning09_test",
	    'password' => "elearning09_test",
	    'hostspec' => "localhost",
	    'database' => "elearning09_test"
	);

	$options = array(
	    'debug'       => 2,
	    'portability' => DB_PORTABILITY_ALL,
	);
        //disconnect();	
	$DB_CONN = DB::connect($dsn, $options);
	if (PEAR::isError($DB_CONN))	die($DB_CONN->getMessage());

	$DB_CONN->query("SET NAMES 'utf8'");

  $query = array
    (
      "course_name" => 
      ($_POST['course_name'] == "") ? "%" : $_POST['course_name'],
      "course_property" => 
      ($_POST['property'] == -1)?"%":$_POST['property'],
        "lrtunit_basic_" => 
        ($_POST['lrtunit_basic_'] == -1)?"%":$_POST['lrtunit_basic_'],
          "attribute" => 
          ($_POST['attribute'] == -1)?"%":$_POST['attribute'],
            "course_platform" => 
            ($_POST['course_platform'] == -1 )?"%":$_POST['course_platform']
      );
        $sql = "SELECT begin_course_name,attribute,certify,class_city
        FROM begin_course
    WHERE course_property LIKE '"
    . $query['course_property'] . "'AND  begin_unit_cd LIKE '"
    . $query['lrtunit_basic_'] . "'AND attribute LIKE '"
    . $query['attribute'] . "'AND class_city LIKE '"
    . $query['course_platform'] ."'";
  
        $result = $DB_CONN->getAll($sql);
        $out = "<div class=i'table'>
          <div class='row grid_rw1clr'>
          <div>序號</div>
          <div>課程名稱</div>
          <div>課程屬性</div>
          <div>認證時數</div>
          <div>平台名稱</div>
          <div class='lastcell'></div></div>";
        $i = 1;
        $search = array
        (
          "attribute" => array("自學","教導")
        );
        foreach( $result as $r)
        {
          $r[1] = $search['attribute'][$r[1]];
          $out .= "<div class='row grid_rw2clr lastrow'>
                <div>$i</div>
                <div class='lastcell'>$r[0]</div>
                <div class='lastcell'>$r[1]</div>
                <div class='lastcell'>$r[2]hr</div>
                <div class='lastcell'>$r[3]</div>
                </div>";
          $i++;
        }
        $out .= "</div>";
        echo $out ;
?>

