<?php 
/**
 * Gateway adapter for conncting to Reporo API
 *
 */

class Gateway_Reporo extends Gateway_Abstract
{
    
  /**
   * test connection by requesting server time
   *
   * @author Stephen Brooks
   * @return integer epoch time
   * @throws Helper_Exception
   */
  public function testConnection()
  {      
      $this->setAction('time');
      return $this->cmdGetHttp();
  }
  
  /**
   * setter for the action parameter
   */
  public function setAction($action)
  {
    $this->setParameters('action',$action);
  }
  
}
