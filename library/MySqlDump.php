<?php
/*//使用範例

	$RELEATED_PATH = "../";
	
	require_once($RELEATED_PATH . "config.php");	
	
	//開始output buffering
	ob_start();
	
	$mysqldump = new MySqlDump($DB_CONN, $showResult, $crlf, $create, $drop, $insert, $cmdEnd);
	//$mysqldump->dumpdb("elearningdb");	
	//$mysqldump->dumptable("discuss_info");
	
	//dump要的資料
	$mysqldump->dumptablespecificdata("discuss_info", "\$filterResult = ((\$row[0] == 1) && (\$row[0] == 1));");
	$mysqldump->dumptablespecificdata("discuss_content", "\$filterResult = ((\$row[0] == 1) && (\$row[0] == 1));");
	
	//取得output buffer的資料
	$outputBuffer = ob_get_contents();
	
	//結束並清除output buffer
	ob_end_clean();
	
	echo $outputBuffer;
*/

class MySqlDump
{
	private $DB_CONN = NULL;
	private $showResult = 1;
	private $crlf   =   "\n";   
	private $create = 1;
	private $drop   =   0; 
	private $insert   =   1; 
	private $cmdEnd   =   ";"; 

/****************************************************************************************/
	public function MySqlDump($DB_CONN, $showResult, $crlf, $create, $drop, $insert, $cmdEnd)
	{
		$this->DB_CONN = $DB_CONN;
		$this->showResult = $showResult;
		$this->crlf = $crlf;
		$this->create = $create;
		$this->drop = $drop;
		$this->insert = $insert;
		$this->cmdEnd = $cmdEnd;
	}
	
	
/****************************************************************************************/

	public function   dumpdb($mysql_db)   {   
				$crlf = $this->crlf;
				$drop = $this->drop;
				$cmdEnd = $this->cmdEnd;
 
				//$tables   =   mysql_list_tables($mysql_db); 
				$tables   =   $this->DB_CONN->getListOf("tables");
				//$num_tables   =   @mysql_numrows($tables);
				$num_tables   =   count($tables);
				
				if($num_tables   ==   0){   
						//echo   "   No   Table   Found   .";   
				  }   
				  else   {   
						//$str   =   "/*   Dump   Mysql   Database   Into   Sybase   Database   Format   */".$crlf;   
						//$str.=   "/*   From   Mysql   Database     :     $mysql_db                               */".$crlf;   
						//$str.=   "/*   DateTime   :   ".date("Y-m-d   h:i:s")."                 */".$crlf;   
						//echo   $str;   
				  } 
				  
				  $i=0;   
				  while   ($i   <   $num_tables)   {   
						$table   =   current($tables); 

						$this->dumptable($table);  
						
						next($tables); 
				  }   
			}   
	
/****************************************************************************************/
	public function dumptable($table)
	{
		$crlf = $this->crlf;
		$drop = $this->drop;
		$cmdEnd = $this->cmdEnd;	
	
		if($this->showResult == 1 && $this->create == 1)
		{
			//$str   =   $crlf;   
			//$str.=   "/*---------------------------------------------------------*/".$crlf;   
			//$str.=   "/*   Table   Structure     for   '$table'                                                       */".$crlf;   
			//$str.=   "/*---------------------------------------------------------*/".$crlf;   
			//$str.=   $crlf;   
			//echo   $str; 
		}  

		$tb   =   $this->get_table_def($table)   ;   

		$tb_def   =   $tb[0];   
		if($this->showResult == 1 && $this->create == 1)	echo   $tb_def;   
		$tb_col   =   $tb[1];   
		$tb_identity   =   $tb[2];  
		
		if($this->insert == 1)$this->get_table_content($table, $tb_col, $tb_identity);  
	}
	
/****************************************************************************************/
	public function dumptablespecificdata($table, $filter)
	{
		$crlf = $this->crlf;
		$drop = $this->drop;
		$cmdEnd = $this->cmdEnd;
	
		if($this->showResult == 1 && $this->create == 1)
		{
			//$str   =   $crlf;   
			//$str.=   "/*---------------------------------------------------------*/".$crlf;   
			//$str.=   "/*   Table   Structure     for   '$table'                                                       */".$crlf;   
			//$str.=   "/*---------------------------------------------------------*/".$crlf;   
			//$str.=   $crlf;   
			//echo   $str; 
		}  

		$tb   =   $this->get_table_def($table);

		$tb_def   =   $tb[0];   
		if($this->showResult == 1 && $this->create == 1)	echo   $tb_def;   
		$tb_col   =   $tb[1];   
		$tb_identity   =   $tb[2];   
		
		
		$this->get_table_specificcontent($table,$tb_col,$tb_identity, $filter);  
	}
	
/****************************************************************************************/
	public function   get_table_def($table)   
	{   
		$crlf = $this->crlf;
		$drop = $this->drop;
		$cmdEnd = $this->cmdEnd;
		//echo $table . $crlf;	//for test

		$schema_create   =   "";   
		$identity   =   '';   
		if(!empty($drop))
		{   
			$schema_create   .=   "DROP   TABLE   $table   $crlf   ".$cmdEnd."   $crlf   ";   
		}   
		$schema_create   .=   "CREATE   TABLE   $table   ($crlf";   

		//$result   =   mysql_query("SHOW   FIELDS   FROM   $table")   or   die();   
		$result = $this->DB_CONN->query("SHOW   FIELDS   FROM   $table");
		if(PEAR::isError($result))	die($result->getMessage());
		
		//$result->numRows() . $crlf;//for test
		
		//while   ($row   =   mysql_fetch_array($result))  
		$col_def_counter = 0;
		while($result->fetchInto($row))   
		{   
			//echo count($row) . "<br>";//for test
			//echo "1." . $row[0] . " " . $row[1] . " " . $row[2] . " " . $row[3] . " " . $row[4] . " " . $row[5] . "<br>";//for test
			
			//$schema_create   .=   "       $row[Field]   $row[Type]";   
			$schema_create   .=   "       $row[0]   $row[1]";   

			//$col_def[$row[Field]]   =   $row[Type];   
			//$col_def[$row[0]]   =   $row[1];   
			$col_def[$col_def_counter][0] = $row[0];  
			$col_def[$col_def_counter][1] = $row[1];  
			$col_def_counter++;
		
			//if($row["Null"]   ==   "YES")
			if($row[2]   ==   "YES")
			{       //   mysql   
					$schema_create   .=   "   NULL   ";   
			}   
			else
			{   
				$schema_create   .=   "   NOT   NULL   ";   
			}   

			//if(!empty($row["Default"]))   
			if(!empty($row[4]))   
			{   
				//$schema_create   .=   "   DEFAULT   '$row[Default]'   ";   
				$schema_create   .=   "   DEFAULT   '$row[4]'   ";   
			}   

			//if($row["Extra"]   !=   "")
			if($row[5]   !=   "")
			{   
				//$identity   =   $row[Field];   
				$identity   =   $row[0];   
				//$schema_create   .=   "   $row[Extra]";   
				$schema_create   .=   "   $row[5]";   
			}   
		
			$schema_create   .=   ",$crlf";   
		}   
					  
		$schema_create   =   ereg_replace(",".$crlf."$",   "",   $schema_create);   
		
		//$result   =   mysql_query("SHOW   KEYS   FROM   $table")   or   die();   
		$result = $this->DB_CONN->query("SHOW   KEYS   FROM   $table");
		if(PEAR::isError($result))	die($result->getMessage());
		
		//while   ($row   =   mysql_fetch_array($result))
		while($result->fetchInto($row)) 
		{   
			//echo count($row) . "<br>";//for test
			//echo $row[0] . " " . $row[1] . " " . $row[2] . " " . $row[3] . " " . $row[4] . " " . $row[5] . " " . $row[6] . " " . $row[7] . " " . $row[8] . " " . $row[9] . " " . $row[10] . " " . $row[11] . "<br>";//for test
		
			//$kname=$row['Key_name'];   
			$kname=$row[2];   
			//if(($kname   !=   "PRIMARY")   &&   ($row['Non_unique']   ==   0))   $kname="UNIQUE|$kname";   
			if(($kname   !=   "PRIMARY")   &&   ($row[1]   ==   0))   $kname="UNIQUE|$kname";   
			if(!is_array($index[$kname]))
			{   
				$index[$kname]   =   array();   
			}   

			//$index[$kname][]   =   $row['Column_name'];   
			$index[$kname][]   =   $row[4];   
		}   

		while(list($x,   $columns)   =   @each($index))
		{   
			if($x   ==   "PRIMARY")
			{   
				$schema_create   .=   ",$crlf";   
				$schema_create   .=   "       PRIMARY   KEY   ("   .   implode($columns,   ",   ")   .   ")";   
			}   
			else   if   (substr($x,0,6)   ==   "UNIQUE")   
			{   
				$schema_create   .=   ",$crlf";   
				$schema_create   .=   "       UNIQUE     ("   .   implode($columns,   ",   ")   .   ")";   
			}   
			else   
			{   
				$schema_index   .=   "   create   index   i_$x   on   $table   ("   .   implode($columns,   ",   ")   .   ")".$crlf.$cmdEnd.$crlf;   
			}   
		}   
		$schema_create   .=   "$crlf)".$crlf.$cmdEnd.$crlf;   
		$schema_create   .=$schema_index   ;   
							
		return   array(stripslashes($schema_create),$col_def,$identity);   
}   


/****************************************************************************************/
	public function   get_table_content($table,$col_def,$identity='')     
	{   
		$crlf = $this->crlf;
		$drop = $this->drop;
		$cmdEnd = $this->cmdEnd;
	
		$i   =   0;   
		$cols   =   "";   
		//column   name;   
		$cols   =   "(";   
		//while(list($key,$val)=@each($col_def))   
		while($col_def_temp=@each($col_def))   
		{   
			list($name,$type) = $col_def_temp;
			list($key,$val) = $type;
		
			$cols.=$key.",";   
			//echo "name:" . $name . "<br>";//for test
			//echo "key:" . $key . "<br>";//for test
			//echo "val:" . $val . "<br>";//for test
		}   
		$cols   =   substr($cols,0,strlen($cols)-1).")";   
		reset($col_def);   
		
		//$str   =   $crlf;   
		//$str.=   "/*---------------------------------------------------------*/".$crlf;   
		//$str.=   "/*   Dumping   data   for   table   '$table'                                                   */".$crlf;   
		//$str.=   "/*---------------------------------------------------------*/".$crlf;   
		//$str.=   $crlf;   
		//if($this->showResult == 1)	echo   $str;   
		
		//$result   =   mysql_query("SELECT   *   FROM   $table")   or   die();   
		$result = $this->DB_CONN->query("SELECT   *   FROM   $table");
		if(PEAR::isError($result))	die($result->getMessage());
		
		$output_schema_insert = "";
		//while   ($row   =   mysql_fetch_array($result))    
		while($result->fetchInto($row)) 
		{   
			$schema_insert   =   "INSERT   INTO   $table   $cols   VALUES(";   
		
			$col_def_counter = 0;
			while(list($key,$val)=each($col_def))   
			{   
				if(!isset($row[$col_def_counter]))     
				{   
					$schema_insert   .=   "   NULL,";   
				}   
				elseif($row[$col_def_counter]   !=   "")   
				{   
					/*   &frac14;&AElig;&shy;&Egrave;&Atilde;&thorn;&laquo;&not;¤&pound;&macr;à&yen;&Icirc;¤&THORN;&cedil;&sup1;   */   
					$sub_val   =   substr($val,0,4);   
					if(	substr($val,0,3)=='int'   ||   $val=='tinyint'   ||   $val=='integer'   ||   $val=='smallint'   ||   
						$sub_val=='nume'   ||   $sub_val=='floa'   ||   $sub_val=='deci'   ||   
						$sub_val=='doub'   ||   $sub_val=='real'
						)   
						$schema_insert   .=   $row[$key].",";   
					else   if($val=='date'   &&   $row[$key]=="0000-00-00")   
						$schema_insert   .=   "'',";   
					else       
						/*   &brvbar;p&ordf;G&Auml;&aelig;&brvbar;ì&shy;&Egrave;&yen;]§t¤&THORN;&cedil;&sup1;,¤&pound;&not;O&yen;&Icirc;\,&brvbar;&Oacute;&not;O±&Auml;&yen;&Icirc;   &shy;&laquo;&frac12;&AElig;   &ordf;&ordm;¤è&brvbar;&iexcl;   */   
						$schema_insert   .=   "   '".str_replace("\\n","\\\\n",$this->addQuote($row[$key]))."',";   
						//   $schema_insert   .=   "   '".$this->addQuote($row[$key])."',";   
				}   
				else   
				{   
					$schema_insert   .=   "   '',";   
				}  
				
				$col_def_counter++; 
			}   
			$schema_insert   =   ereg_replace(",$",   "",   $schema_insert);   
			$schema_insert   .=   ")";   
			$schema_insert   .=   $cmdEnd.$crlf;   
			$output_schema_insert .= $schema_insert;
			reset($col_def);   
			$i++;   
		}   
			
		if($this->showResult == 1)	echo $output_schema_insert;
		
		return $output_schema_insert;   
	}   

/****************************************************************************************/
	public function   get_table_specificcontent($table,$col_def,$identity='', $filter)     
	{   
		$crlf = $this->crlf;
		$drop = $this->drop;
		$cmdEnd = $this->cmdEnd;
				
		//echo $filter;	//for test
				
	
		$i   =   0;   
		$cols   =   "";   
												//column   name;   
		$cols   =   "(";   
		//while(list($key,$val)=@each($col_def))   
		while($col_def_temp=@each($col_def))   
		{   
			list($name,$type) = $col_def_temp;
			list($key,$val) = $type;
			
			$cols.=$key.",";   
		}   
		$cols   =   substr($cols,0,strlen($cols)-1).")";   
		reset($col_def);   
		
		//$str   =   $crlf;   
		//$str.=   "/*---------------------------------------------------------*/".$crlf;   
		//$str.=   "/*   Dumping   data   for   table   '$table'                                                   */".$crlf;   
		//$str.=   "/*---------------------------------------------------------*/".$crlf;   
		//$str.=   $crlf;   
		//if($this->showResult == 1)	echo   $str;   
		
		//$result   =   mysql_query("SELECT   *   FROM   $table")   or   die();   
		$result = $this->DB_CONN->query("SELECT   *   FROM   $table");
		if(PEAR::isError($result))	die($result->getMessage());
			
		$output_schema_insert = "";
		//while   ($row   =   mysql_fetch_array($result))     
		while($result->fetchInto($row)) 
		{   
			
			//過濾不要的資料
			eval($filter);
			if($filterResult == FALSE)	continue;

			$schema_insert   =   "INSERT   INTO   $table   $cols   VALUES(";   
			
			$col_def_counter = 0;
			while(list($key,$val)=each($col_def))   
			{   
				if(!isset($row[$col_def_counter]))     
				{   
					$schema_insert   .=   "   NULL,";   
				}   
				elseif   ($row[$col_def_counter]   !=   "")   
				{   
					/*   &frac14;&AElig;&shy;&Egrave;&Atilde;&thorn;&laquo;&not;¤&pound;&macr;à&yen;&Icirc;¤&THORN;&cedil;&sup1;   */   
					$sub_val   =   substr($val,0,4);   
					if(	substr($val,0,3)=='int'   ||   $val=='tinyint'   ||   $val=='integer'   ||   $val=='smallint'   ||   
						$sub_val=='nume'   ||   $sub_val=='floa'   ||   $sub_val=='deci'   ||   
						$sub_val=='doub'   ||   $sub_val=='real'
						)   
					$schema_insert   .=   $row[$key].",";   
					else   if($val=='date'   &&   $row[$key]=="0000-00-00")   
						  $schema_insert   .=   "'',";   
					else       /*   &brvbar;p&ordf;G&Auml;&aelig;&brvbar;ì&shy;&Egrave;&yen;]§t¤&THORN;&cedil;&sup1;,¤&pound;&not;O&yen;&Icirc;\,&brvbar;&Oacute;&not;O±&Auml;&yen;&Icirc;   &shy;&laquo;&frac12;&AElig;   &ordf;&ordm;¤è&brvbar;&iexcl;   */   
						$schema_insert   .=   "   '".str_replace("\\n","\\\\n",$this->addQuote($row[$key]))."',";   
						//   $schema_insert   .=   "   '".$this->addQuote($row[$key])."',";   
				}   
				else   
				{   
					$schema_insert   .=   "   '',";   
				}
				$col_def_counter++;   
			}   
			$schema_insert   =   ereg_replace(",$",   "",   $schema_insert);   
			$schema_insert   .=   ")";   
			$schema_insert   .=   $cmdEnd.$crlf;   
			$output_schema_insert .= $schema_insert;
			reset($col_def);   
			$i++;   
		}   
			
		if($this->showResult == 1)	echo $output_schema_insert;
		return $output_schema_insert;   
	}   
/****************************************************************************************/
	  public function   addQuote($str)   {   
			$str   =   str_replace("'","''",$str);   
			return   $str;   
	  }   
}

?>
