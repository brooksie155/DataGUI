<?php 

/**
 * Class file:
 * Contains abstract connection headers for reporo interfaces
 * 
 * @author Stephen Brooks
 */
abstract class Helper_Reporo_Abstract extends Helper_Abstract
{

    protected     $apiKey        = null;
    protected     $sharedSecret  = null;
    
    
    private function getSignature()
    {
        return hash('sha256', time().$this->sharedSecret);
    }
    
    /**
     * get headers for connecting to Reporo
     *
     * @author Stephen Brooks
     * @return array
     */
    public function getHttpHeaders()
    {
        return array(
            'x-reporo-epoch'  => time(),
            'x-reporo-key'    => $this->apiKey,
            'x-reporo-mash'   => $this->getSignature()
        );
    }
    
    
    public function getCurlHeaders() 
    {
        return array(
            "x-reporo-epoch: " . time(),
            "x-reporo-key: {$this->apiKey}",
            "x-reporo-mash: {$this->getSignature()}"
//                . ",
//            "accept: application/xml"
        );        
    }
  
  /**
   * setter for geteway url, in this case url is static so we just set it
   *
   * @author Stephen Brooks
   */
    public function setGatewayUrl($url=null)
    {
        $this->gatewayUrl = $url;  
    }

}
