<?php
require_once 'UPS/ModelFactory.php';
/**
 * Description of Doc
 *
 * @author wewe0901
 */
class UPS_Model_Doc extends UPS_Model_Db {
    protected $_docInstructCity  = array(  //doc 輔導團
	'adv046' => array(2, 4, 25) ,//臺北縣、桃園縣、連江縣
	'adv035' => array(5),      //新竹縣
	'adv044' => array(7), 	//苗栗縣
	'adv036' => array(8,10), //台中縣、彰化縣
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
	'dtest1' => array(2,4,25),	//金門縣
	'dtest2' => array(2,4,25),	//金門縣
	'dtest3' => array(2,4,25),	//金門縣
	'dtest4' => array(2,4,25),	//金門縣
	'dtest5' => array(2,4,25),	//金門縣
    );
    protected $_docInstructCityDetail =array();
    protected $_docs=array();
    protected $_docNames = array('-2'=>'不清楚','-3'=>'未設置');
    
    public function getDocInstructCity($account)
    {
        if(!isset($this->_docInstructCity[$account]))
                return null;
        
        if(!isset($this->_docInstructCityDetail[$account]))
        {
            $schoolModel = UPS_ModelFactory::createModel('School');

           $this->_docInstructCityDetail[$account]=array();
            foreach($this->_docInstructCity[$account] as $city)
            {
                $this->_docInstructCityDetail[$account][$city] = $schoolModel->getSchoolCityName($city);
            }
        }   
        
        return $this->_docInstructCityDetail[$account];
    }
    
    public function getDocByCity($city)
    {
     
        if(is_array($city))
        {
            $cityList = array();
            foreach($city as $c)
            {
                    $cityList[] = $this->getDocByCity($c);
            }
            return $cityList;
        }
        
       
        if(  !isset($this->_docs[$city]))
        {
            $this->_docs[$city] = db_getAll("SELECT * FROM docs WHERE city_cd = '{$city}';");
        }
        return$this->_docs[$city];
    }
    
    public function getDocCity($doc_cd)
    {
        
        $city_cd = db_getOne("SELECT city_cd FROM docs WHERE doc_cd = '$doc_cd' ");
        
        return db_getOne("SELECT doc FROM docs WHERE doc_cd='$doc_cd' ");
    }
    
    public function getDocName($doc_cd)
    {
        if(!isset($this->_docNames[$doc_cd]))
        {
            $this->_docNames[$doc_cd] = db_getOne("SELECT doc FROM docs WHERE doc_cd=$doc_cd");
        }
        return $this->_docNames[$doc_cd] ;
    }
}

?>
