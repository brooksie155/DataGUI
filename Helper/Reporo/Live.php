<?php

/**
 * Class file:
 * Contains conection details for connection to dataAPI @ www.reporo.com
 *
 * @author Stephen Brooks
 */
class Helper_Reporo_Live extends Helper_Reporo_Abstract
{

    // sbdash_login 
    protected $apiKey        = APIKEY;
    protected $sharedSecret  = APISECRET;
    
    protected $gatewayUrl   = 'http://api.reporo.com/analytics/data-api.php';
        
}


