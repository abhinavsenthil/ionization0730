<?php
//$root = $_SERVER['DOCUMENT_ROOT'];
include_once "vappurewater.php";
//include_once '/home/users/web/b2828/ipg.outoilnet/vappurewater.php';

function InitialDensForH2O($Pbar,$Tk) 
{
    //$Pbar = 150;
    //$Tk = 273.15+150;
    $TcrH2O = 647.0960;
    $PcrH2O = 220.64;               // bar
    $MH2O = 18.0152;                // molecular weight of water
    $RgasJbar = 83.1447;            // gas constant (bar*cm3)/(mol*K)
    $dcrH2O = 0.322;
    
    $bH2O = array();
    $bH2O[0] = 1.99274064;
    $bH2O[1] = 1.09965342;
    $bH2O[2] = -0.510839303;
    $bH2O[3] = -1.75493479;
    $bH2O[4] = -45.5170352;
    $bH2O[5] = -6.7469945e+05;
        
    $thetaH2O = (1 - $Tk / $TcrH2O);
    
    
    if ($Tk < $TcrH2O) 
    {
        $Psat = vappurewater($Tk);
    }
    else
    {
        $Psat = $PcrH2O;
    }
     
    if ($Pbar < $Psat)
    {
        $Vs = $RgasJbar * $Tk / $Pbar;
        $ro = 18.0152 / $Vs / $dcrH2O; 
    }
    elseif ($Pbar == $Psat) // page 399 of wagner and pruss equation 2.6
    {
        $ro = 1+$bH2O(0)*pow($thetaH2O,(1/3))
            +$bH2O(1)*pow($thetaH2O,(2/3))+$bH2O(2)*pow($thetaH2O,(5/3))
            +$bH2O(3)*pow($thetaH2O,(16/3))+$bH2O(4)*pow($thetaH2O,(43/3))
            +$bH2O(5)*pow($thetaH2O,(110/3)); 
    }   
    elseif ($Pbar > $Psat)
    {
        if ($Pbar<=1000)
        {   // where did this come from?
            $Vs = 116.271-1.03596*$Tk+3.90561e-03*pow($Tk,2)
                    -6.2842e-06*pow($Tk,3)+3.7039e-09*pow($Tk,4);
        }    
        elseif ($Pbar>1000 && $Pbar<=2000)
        {
            $Vs = 5.851212+0.0822269*$Tk
                    -1.99974e-04*$Tk*$Tk+1.82853e-07*pow($Tk,3);
        }
        elseif ($Pbar>2000 && $Pbar<=3000)
        {   // 23.666 doesn't seem to be in the paper
            $Vs = 23.666-0.04115*$Tk+0.0000696*$Tk*$Tk-1.462e-08*pow($Tk,3);
        }
        elseif ($Pbar>3000 && $Pbar<=5000)
        {
            $Vs = 13.956+0.002059*$Tk+1.3935E-05*pow($Tk,2);
        }  
        elseif ($Pbar>5000 && $Pbar<=10000)
        {
            $Vs = 13.737+0.0032645*$Tk+4.822E-06*pow($Tk,2);
        }
        elseif ($Pbar>10000)
        {
            $Vs = 11.894+0.007639*$Tk;
        }  
        $ro = 18.0152/$Vs/$dcrH2O; 
    }
    $dH2O = $ro*$dcrH2O; 
    
    return $dH2O;
    // echo $dH2O;
}            

?>