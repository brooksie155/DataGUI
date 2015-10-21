<?php

/**
 * Abstract gateway adapter, managers basic commands must be extended in order t * apply connection details
 *
 * Requires HttpRequest
 * @see http://php.net/manual/en/http.setup.php
 *
 * @author Stephen Brooks
 */
abstract class Gateway_Abstract
{

  /**
   * Reference to the instance constaining connection information
   * @var Helper_Abstract
   */
  private $_helper;

  /**
   * @var array $_options
   */
  private $_options;


  /**
   * getter for request options
   *
   * @author Stephen Brooks
   * @return Array
   */
  public function getParameters()
  {
    return $this->_options;
  }


  /**
   * Set options to be sent with the request
   *
   * @author Stephen Brooks
   * @param String $key
   * @param String $value
   */
  public function setParameters($key, $value)
  {
    $this->_options[$key] = $value;
  }


  /**
   * setter for the helper instance
   *
   * @author  Stephen Brooks
   * @param   Helper_Abstract
   * @return  Gateway_Abstract
   */
  public function setHelper(Helper_Abstract $helper)
  {
    $this->_helper = $helper;

    return $this;
  }

  /**
   * getter for the helper instance
   *
   * @author Stephen Brooks
   * @return Helper_Abstract
   * @throws Gateway_Exception
   */
    public function getHelper()
    {
        if (!$this->_helper instanceof Helper_Abstract) {
            throw new Gateway_Exception('configuration helper not set.');
        }

        return $this->_helper;
    }

    /**
     * HttpRequest 
     * 
     * requires : pecl install http://pecl.php.net/get/pecl_http-1.7.6.tgz
     *  
     * - default installed now is v2 which has a completely different interface and requires
     * other pecl extensions:
     * 
     *  - raphf
     *  - propro
     *  - spl
     * 
     * as well as the following if --with-http-shared-deps also enabled
     * 
     *  - hash
     *  - iconv
     *  - json (only until < 2.4.0)
     * 
     * 
     * @return type
     * @throws Gateway_Exception
     */
    public function cmdGetHttp() 
    {
        $request = new HttpRequest($this->getHelper()->getGatewayUrl());
        $request->setQueryData($this->getParameters());
        $request->addHeaders($this->getHelper()->getHttpHeaders());
        $request->setMethod(HTTP_METH_GET);
        $request->send(); 
        
        if ($request->getResponseCode() !== 200) {        
            throw new Gateway_Exception(
                "Connection Error [{$request->getResponseCode()}] {$request->getResponseStatus()}"
            );
        }        
        
        return $request->getResponseBody();
    }
  
  
  
  /**
   * Curl request
   * 
   * @author Stephen Brooks
   * @return String response
   * @throws Gateway_Exception
   */
    public function cmdGet()
    {

        // create a new cURL resource
        $queryStr = "";
        foreach($this->getParameters() as $param => $value) {
            $queryStr .= (empty($queryStr))
                ? "?$param=$value"
                : "&$param=$value"
            ;
        }

        $ch = curl_init();
        if (false === $ch) {
            throw new Gateway_Exception('Unable to initialise curl');
        }

        curl_setopt($ch, CURLOPT_URL, $this->getHelper()->getGatewayUrl().$queryStr );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHelper()->getCurlHeaders());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // grab URL and pass it to the browser
        $response = curl_exec($ch);
    
        if (false === $response) {
            throw new Gateway_Exception(curl_error($ch), curl_errno($ch));        
        }
        
        curl_close($ch);
      
        return $response;
    }


}
