<?php

    $dH2O = filter_input(INPUT_POST, 'dens'); 
    $Tk = filter_input(INPUT_POST, 'temp')+273.15;
//    $dH2O = 1.1;
//    $Tk = 273.15+150;
 
    $MH2O = 18.0152;
    
    $alphaIoniz = array(0,-0.864671,8659.19,-22786.2);
    $betaIoniz = array(0,0.642044,-56.8534,-0.375754);
    $gammaIoniz = array(0,0.61415,48251.33,-67707.93,10102100);
    $n = 6;
    $pKwl = 0;  
    $pKwv1 = 0;
    $pKwv2 = 0;
    
    $pKwG = $gammaIoniz[1]+$gammaIoniz[2]*pow($Tk,-1)
            +$gammaIoniz[3]*pow($Tk,-2)+$gammaIoniz[4]*pow($Tk,-3);

    $z = $dH2O*exp($alphaIoniz[1]+$alphaIoniz[2]*pow($Tk,-1)
                +$alphaIoniz[3]*pow($Tk,-2)*pow($dH2O,(2/3)));
            
    $pKw = -2*$n*(log10(1+$z)-$z/(1+$z)*$dH2O*($betaIoniz[1]
                +$betaIoniz[2]*pow($Tk,-1)+$betaIoniz[3]*$dH2O))+$pKwG
                +2*log10($MH2O/1000);
        
    
    // prepare the data to be returned in an array
    // define an array variable $selfDefine

    $selfDefine = $pKw;
    echo json_encode($selfDefine);
