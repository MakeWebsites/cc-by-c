<?php
include_once 'curl_res.php';

$c3 = $_POST['c3']; 
$mv = $_POST['mv'];
    
//Retrieve the json data
$url = 'http://climatedataapi.worldbank.org/climateweb/rest/v1/country/cru/'.$mv.'/year/'.$c3;
$jsonr = new curl_res($url);
$jsond = $jsonr->get_res();

//Build the Google Chart table
$dataTable = array(
        'cols' => array(
             array('type' => 'number', 'label' => '', 'id' => ''), 
             array('type' => 'number', 'label' => '', 'id' => '')
        )
    );
        foreach ($jsond as $caso) { 
            $dataTable['rows'][] = array(
            'c' => array (
                 array('v' => $caso->year), 
                 array('v' => $caso->data)
             )
        ); }
//Send the json       
echo json_encode($dataTable);