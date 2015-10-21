<?php

    /**
     * class autoloaded
     */
    function __autoload($classname)
    {
      require_once(str_replace('_','/',$classname).'.php');
    }

    $gatewayReporo  = new Gateway_Reporo();
    $helperReporo   = new Helper_Reporo_Live();
    
    $helperReporo->setApiKey(filter_input(INPUT_POST, 'sKey'));
    $helperReporo->setSharedSecret(filter_input(INPUT_POST, 'sSecret'));    
    
    $gatewayReporo->setHelper($helperReporo);

    // test connection
    error_log($gatewayReporo->testConnection());

    // check
    if (!isset($_REQUEST['sAction']) || !isset($_REQUEST['sFrom'])) {
        header("HTTP/1.0 400 Bad request");
        exit();
    }

    $gatewayReporo->setAction($_REQUEST['sAction']);
    $gatewayReporo->setParameters('from',$_REQUEST['sFrom']);

    if (isset($_REQUEST['sTo'])) {
      $gatewayReporo->setParameters('to',$_REQUEST['sTo']);
    }

    $break = 'date';
    if (isset($_REQUEST['sBreak'])) {
        $gatewayReporo->setParameters('break',$_REQUEST['sBreak']);
        $break = $_REQUEST['sBreak'];
    }

    // get data
    $data = $gatewayReporo->cmdGet();
    
    if (strpos('inventory', $_REQUEST['sAction']) !== false) {
        echo json_encode($data); 
        exit;
    }
    
    // format data for output
    // @refactor - handle different result sets correctly, combining entity id + name wirhn present and returning 
    // requests when present 
    
    $chartData = (array) json_decode($data);
    $output   = array();
    $output[] = array($break,'impressions','clicks','revenue','spend');
    if (!empty($chartData)) {
        foreach ($chartData as $row) {
            
            $iColCount = 0;
            $dropID = false;
            
            $newRow = array();
            foreach ((array) $row as $key => $value) {
                
                if ($key === 'requests') {
                    continue;
                }
                
                $newRow[$iColCount++] = $value;

                if ($break == 'entity' && $dropID == false) {
                    $iColCount = 0;
                    $dropID = true;
                }                
                
            }
            $output[] = $newRow;

        }
    }

    // output data
    echo json_encode($output);


