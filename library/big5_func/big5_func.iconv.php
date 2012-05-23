<?
/* big5 function use iconv */

# ���p CP950 �����D�i�H�令 BIG5
# define("BIG5_ENCODER" , "BIG5");
define("BIG5_ENCODER" , "CP950");
define("UNICODE_BACKSLASHE" , chr(0).chr(0x5c));
define("UNICODE_SQUOTE" , chr(0).chr(0x27));
define("UNICODE_DQUOTE" , chr(0).chr(0x22));


function big5_addslashes($str) {
    $str = iconv(BIG5_ENCODER , "UTF-16" , $str);
    
    $return_str = str_replace(
        array(UNICODE_BACKSLASHE,UNICODE_SQUOTE,UNICODE_DQUOTE),
        array(UNICODE_BACKSLASHE.UNICODE_BACKSLASHE,UNICODE_BACKSLASHE.UNICODE_SQUOTE,UNICODE_BACKSLASHE.UNICODE_DQUOTE),
        $str) ;
    return iconv("UTF-16" , BIG5_ENCODER , $return_str);
}
function big5_addcslashes($str,$charlist) {
    $str = iconv(BIG5_ENCODER , "UTF-16" , $str);

    $return_str = "";
    $tmp = "";
    $len = strlen($str);

    for($i=2; $i<$len; $i+=2)
    {
        $ch = substr($str,$i,2);
        if( hexdec(bin2hex($ch)) < 256 )
        {
            $tmp = addcslashes($ch[1],$charlist);
            $return_str.= substr(iconv(BIG5_ENCODER , "UTF-16" , $tmp),2);
        }
        else
        {
            $return_str.= $ch;
        }
    }

    return iconv("UTF-16" , BIG5_ENCODER , $return_str);
}
function big5_stripslashes($str) {
    $str = iconv(BIG5_ENCODER , "UTF-16" , $str);
    $return_str = "";
    $len = strlen($str);
    for($i=2; $i<$len; $i+=2)
    {
    	$s1 = substr($str,$i,2);
    	
        if( $s1==UNICODE_BACKSLASHE )
        {
            $s2 = substr($str,$i+2,2);
            if($s2 == UNICODE_BACKSLASHE)
                $return_str.=UNICODE_BACKSLASHE;
            else
                $return_str.=$s2;
            $i+=2;
        }
        else
            $return_str .=$s1;

    }
    return iconv("UTF-16" , BIG5_ENCODER , $return_str);

}
function big5_stripcslashes($str) {
    $str = iconv(BIG5_ENCODER , "UTF-16" , $str);
    $return_str = "";
    $len = strlen($str);
    for($i=2; $i<$len; $i+=2)
    {
    	$s1 = substr($str,$i,2);
        if( $s1==UNICODE_BACKSLASHE )
        {
            $s2 = substr($str,$i+2,2);
            if(
                          $s2  == chr(0)."0" || $s2  == chr(0)."a" ||
                          $s2  == chr(0)."b" || $s2  == chr(0)."f" ||
                          $s2  == chr(0)."n" || $s2  == chr(0)."r" ||
                          $s2  == chr(0)."t" || $s2  == chr(0)."v"
            )
                $return_str .= substr(iconv(BIG5_ENCODER , "UTF-16" , stripcslashes($s1[1].$s2[1])),2);
            else
                $return_str.=$s2;
            $i+=2;
        }
        else
            $return_str .=$s1;
    }

    return iconv("UTF-16" , BIG5_ENCODER , $return_str);

}
function big5_strtolower($str) {
	
    for($i=0;$i<27;$i++)
    {
    	$lower_string[$i] = chr(0).chr(97+$i);
    	$upper_string[$i] = chr(0).chr(65+$i);
    }
    $str = iconv(BIG5_ENCODER , "UTF-16" , $str);
    
    $return_str = str_replace(
        $upper_string,
        $lower_string,
        $str) ;
    return iconv("UTF-16" , BIG5_ENCODER , $return_str);

}
function big5_strtoupper($str) {
    for($i=0;$i<27;$i++)
    {
    	$lower_string[$i] = chr(0).chr(97+$i);
    	$upper_string[$i] = chr(0).chr(65+$i);
    }
    $str = iconv(BIG5_ENCODER , "UTF-16" , $str);
    
    $return_str = str_replace(
        $lower_string,
        $upper_string,
        $str) ;
    return iconv("UTF-16" , BIG5_ENCODER , $return_str);
}
function big5_str_replace($search , $replace, $subject)
{
    $replace = substr(iconv(BIG5_ENCODER,"UTF-16",$replace) , 2);
    $search = substr(iconv(BIG5_ENCODER,"UTF-16",$search) ,2);
    $subject = iconv(BIG5_ENCODER,"UTF-16",$subject);
    $subject = str_replace( $search , $replace , $subject);
    return iconv("UTF-16" , BIG5_ENCODER , $subject);
}


function big5_strlen($str)
{

   $len = strlen(iconv(BIG5_ENCODER,"UTF-16",$str))/2 - 1;
   if($len<=0) $len = 0;
   return  $len;
}

function big5_substr($str,$start,$len=0)
{
   if(!$len) $len = strlen($str);
   if($start < 0) $start = big5_strlen($str)+$start;
   

   return iconv("UTF-16",BIG5_ENCODER,substr(iconv(BIG5_ENCODER,"UTF-16",$str),($start+1)*2,$len*2));
}






function big5_deunicode($str)
{
    $regs = array();
    $tmp  = array();
    $tmp_big5 = array();
    $replace_arr = array();
    preg_match_all ("/&#[0-9]{1,5};/", $str, $regs);

    $tmp = array_values(array_unique($regs[0]));
    $len = count($tmp);
    for($i=0 ; $i<$len; $i++)
    {
    	$s = sprintf("%04X",(int)str_replace( array(";" , "&#") , "", $tmp[$i]));
    	$tmp_big5[$i] = iconv("UTF-16",BIG5_ENCODER,UTF16_FIRST_CHAR. Chr( hexdec( substr($s,2,2))) . Chr( hexdec( substr($s,0,2))));
    }
    return str_replace($tmp,$tmp_big5, $str) ;
}

function big5_unicode($str)
{
    $str = iconv(BIG5_ENCODER,"UTF-16",$str);
    for($i=2 ; $i< strlen($str) ; $i+=2)
        $tmp .= "&#".sprintf("%05d",hexdec(bin2hex($str[$i] . $str[$i+1]))) . ";";
    return $tmp;
}

function big5_utf8_encode($str)
{
    return iconv(BIG5_ENCODER,"UTF-8",$str);
}

function big5_utf8_decode($str)
{
    return iconv("UTF-8",BIG5_ENCODER,$str);
}

function big5_utf16_encode($str)
{
    return iconv(BIG5_ENCODER,"UTF-16",$str);
}


function big5_utf16_decode($str)
{
    return iconv("UTF-16",BIG5_ENCODER,$str);
}

?>