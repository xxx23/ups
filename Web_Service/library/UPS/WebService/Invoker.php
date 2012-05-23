<?php
require_once 'Zend/Soap/AutoDiscover.php';
require_once 'Zend/Soap/Server.php';
/**
 * ups webservice的進入點
 * 使用Zend framework的soap library
 * 負責分派使用者webservice的請求到正確的handler
 *
 * @filesource UPS_WebService_Invoker.php
 * @author wewe0901
 */
class UPS_WebService_Invoker {
 // user url get parameter
    public $_param = array();

   // system filter library path
    protected $_filterPath = 'filter.php';

    // service class diractory path
    protected $_serviceDir = './SoapServers/';


    protected $_none = 'none';

    protected $_servicesModel = null;
   public function __construct($server_path)
   {
       if(!empty($server_path))
           $this->_serviceDir = $server_path;
       require_once 'UPS/Model/Services.php';
       $this->_servicesModel = new UPS_Model_Services();
   }
   /**
    * 處理webservice的請求
    */
    public function handle()
    {

        $this->_param = $this->_getRequestParam();
        
        if(!$this->_servicesModel->serviceExists($this->_param["service"]))
            die("{$this->_param['service']}:Service not exsists");

        if($this->_param['wsdl'] == true)
            //User Download WSDL file
            $this->handleWSDL();
        else
            //User Request SOAP Service
            $this->handleService();
        
    }

    /**
     *
     * 處理 WSDL 下載的請求
     * 利用Zend_AutoDiscover來自動產生服務的WSDL檔
     */
    public function handleWSDL()
    {
        $servicePath = $this->_getServicePath();


        if(empty($servicePath))
            return;
        //Load Service Class
        require_once $servicePath;
        
        $autodiscover = new Zend_Soap_AutoDiscover();
        $autodiscover->setUri(HOME_URL.'/Web_Service/api.php?service='.$this->_param['service']);
        $autodiscover->setClass($this->_param['service']);
        $autodiscover->handle();

    }

    /**
     * 處理使用者使用API的服務
     * 利用Zend_Soapt串接
     */
    public function handleService()
    {
        $servicePath = $this->_getServicePath();
      

        if(empty($servicePath) )
            return;

        //Load Service Class
        require_once $servicePath;
        $wsdl_url = HOME_URL."/Web_Service/api.php?wsdl&service={$this->_param['service']}";
         $options = array('uri' => 'urn:'.$this->_param['service'],
                       'location' =>$wsdl_url);
        $soap = new Zend_Soap_Server(null,$options);
        
        $soap->setClass($this->_param['service']);
        $soap->handle();
    }

    /**
     *取的SoapServer的path
     * @return string
     */
    protected function _getServicePath()
    {
        $path = $this->_serviceDir .'/'. $this->_param['service'].'.php';

        if(empty($this->_param['service'])||false == glob($path))
                return null;
        return $path;
    }

    /**
     * 取得使用者輸入的參數
     * @return string
     */
    protected function  _getRequestParam()
    {
        require_once $this->_filterPath;

        return array(
            'wsdl'=> isset($_GET['wsdl']),
            'service'=>  optional_param('service',$this->_none,PARAM_TEXT),
      //      'apikey' => optional_param('apikey','',PARAM_TEXT)
        );
    }

}
//END OF Invoker.php
