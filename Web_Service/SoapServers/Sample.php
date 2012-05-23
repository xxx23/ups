<?php
class Sample{
  private $demo = array("sam" => 98.42);
  /**
   *
   * @param string  $name
   * @return float
   */
  function getDemo($name) {
    $auth = new UPS_ApplyCourse_Auth();
    if(!$auth->hasIdentity())
       throw new SoapFault("Server","Need to login!");
    else if (isset($this->demo[$name])) {
      return $this->demo[$name];
    } else {
      throw new SoapFault("Server","Unknown name '$name'.");
    }
  }
}
?>
