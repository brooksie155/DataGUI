<?php

/**
 * Abstract helper class
 */
abstract class Helper_Abstract
{
    
    protected     $apiKey        = null;
    protected     $sharedSecret  = null;    
    
    /**
     * @var string|null
     */
    protected $gatewayUrl = null;
      
    /**
     * getter method for gatewayURL, if not set calls setGatewayUrl which can be
     * used to set the url. If url is unknown until run time 
     *
     * @author Stephen Brooks
     * @return String
     */
    public function getGatewayUrl()
    {
        if (is_null($this->gatewayUrl)) {
          throw new Helper_Exception('Gateway URL not set');
        }
        return $this->gatewayUrl;
    }
    
    public function setApiKey($key)
    {   
        if (!empty($key)) {
            $this->apiKey = $key;
        }
    }

    public function setSharedSecret($secret)
    {
        if (!empty($secret)) {
            $this->sharedSecret = $secret;    
        }
    }    
    
    /**
     * set gateway url string
     */
    abstract public function setGatewayUrl($url=null);

}