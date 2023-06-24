<?php

   // $root = $_SERVER['DOCUMENT_ROOT'];
    include_once "ionizationCalculation.php";

    // Get pressure and temperature from input box
    
    $Pbar = filter_input(INPUT_POST, 'pres'); 
    $Tk = filter_input(INPUT_POST, 'temp')+273.15;

    $selfDefine = ionizationCalculation($Tk, $Pbar);
    
   // echo json_encode($Pbar);
    echo json_encode($selfDefine);
   