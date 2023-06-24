<?php


   // $root = $_SERVER['DOCUMENT_ROOT'];
    include_once "DensityH2Ocalculation.php";
    include_once "vappurewater.php";

    // Get pressure and temperature from input box
    
    // $Pbar = 4.76159;
    //$Tk = 273.15+150;
    
    $Tk = filter_input(INPUT_POST, 'temp')+273.15;
    $Psat = vappurewater($Tk);
    $Pbar = $Psat;
    
    $MH2O = 18.0152;
    $TcrH2O = 647.0960;
    $PcrH2O = 220.64;   
    
    $dH2O = DensityH2OCalculation($Pbar, $Tk);
 
    $liqDens = $dH2O[0];
    $vapDens = $dH2O[1];
    $alphaIoniz = array(0,-0.864671,8659.19,-22786.2);
    $betaIoniz = array(0,0.642044,-56.8534,-0.375754);
    $gammaIoniz = array(0,0.61415,48251.33,-67707.93,10102100);
    $n = 6;
    $pKwv1 = 0;
    $pKwv2 = 0;
    

    $pKwG = $gammaIoniz[1]+$gammaIoniz[2]*pow($Tk,-1)
            +$gammaIoniz[3]*pow($Tk,-2)+$gammaIoniz[4]*pow($Tk,-3);

    // Ionization constant for liquid phase
    $zl = $liqDens*exp($alphaIoniz[1]+$alphaIoniz[2]*pow($Tk,-1)
        +$alphaIoniz[3]*pow($Tk,-2)*pow($liqDens,(2/3)));

    $pKwl = -2*$n*(log10(1+$zl)-$zl/(1+$zl)*$liqDens*($betaIoniz[1]
        +$betaIoniz[2]*pow($Tk,-1)+$betaIoniz[3]*$liqDens))+$pKwG
        +2*log10($MH2O/1000);

    // Ionization constant for vapor phase
    $zv = $vapDens*exp($alphaIoniz[1]+$alphaIoniz[2]*pow($Tk,-1)
        +$alphaIoniz[3]*pow($Tk,-2)*pow($vapDens,(2/3)));

    $pKwv = -2*$n*(log10(1+$zv)-$zv/(1+$zv)*$vapDens*($betaIoniz[1]
        +$betaIoniz[2]*pow($Tk,-1)+$betaIoniz[3]*$vapDens))+$pKwG
        +2*log10($MH2O/1000);        
  
    
    // prepare the data to be returned in an array
    // define an array variable $selfDefine
    $selfDefine = array();
    $selfDefine[0] = $pKwl;
    $selfDefine[1] = $pKwv;
    $selfDefine[2] = $Psat; // saturation pressure
    $selfDefine[3] = $liqDens; // liquid phase density
    $selfDefine[4] = $vapDens; // vapor phase density
    
   // echo json_encode($Pbar);
    echo json_encode($selfDefine);
   