<?php

/**
 * Class file:
 * Contains conection details for connection to dataAPI @ www.reporo.com
 *
 * @author Stephen Brooks
 */
class Helper_Reporo_Lira extends Helper_Reporo_Abstract
{
    protected $apiKey        = APIKEY;
    protected $sharedSecret  = APISECRET;
    protected $gatewayUrl       = 'http://lira.reporo.com/analytics/data-api.php';
}

