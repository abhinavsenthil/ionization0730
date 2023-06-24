<?php
//$root = $_SERVER['DOCUMENT_ROOT'];
include_once "vappurewater.php";
include_once "InitialDensForH2O.php";
include_once "H2ODensityCycle.php";

function DensityH2OCalculation($Pbar, $Tk)
{
//    $Pbar = 150;
//    $Tk = 273.15+150;
    $Psat = vappurewater($Tk);
    
    $dcrH2O = 0.322;
    $TcrH2O = 647.0960;
    $dH2O = array(0,0);

    
    $waterProperties = array();
    
    $Preduced = 0;
    $den_counter = 0;
    $MH2O = 18.0152; 
    $RgasJbar = 83.1447;
    $bH2O = array(0,1.99274064,1.09965342,-0.510839303,-1.75493479,-45.5170352,-674699.45);
    
    $cH2O = array(0,-2.0315024,-2.6830294,-5.38626492,-17.2991605,-44.7586581,-63.9201063);
    
    if (abs($Pbar/$Psat-1)>1e-4) 
    // Calculation for single phase region
    {
        // Pbar > Psat yield liquid phase
        // Pbar < Psat yield vapor phase
        
        $dH2Oi = InitialDensForH2O($Pbar,$Tk); // density of water , g/cm3;
        
        do
        {
            $den_counter = $den_counter+1;
            
            $waterProperties = H2ODensityCycle($dH2Oi,$Tk);
            $deltaH2O = $waterProperties[0];
            $phirH2Odlt = $waterProperties[1];
            $phirH2Odltdlt = $waterProperties[2];
            
            $Preduced = $dH2Oi*(1+$deltaH2O*$phirH2Odlt);
            $deviationH2O = $Preduced/($Pbar/($RgasJbar*$Tk/$MH2O))-1;
            $dPreducedddH2O = 1+2*$deltaH2O*$phirH2Odlt+pow($deltaH2O,2)*$phirH2Odltdlt;

            // Newton-Raphson for density eqation in table 3. P1517 Span & Wagner,
            // 1996
            // f(dH2O) = dH2O * (1 + deltaH2O * phirdlt) - A
            // A = Pbar * / (RgasJbar * Tk / MH2O) 
            // df(dH2O) = dPreduceddH2O
            // dH2O = dH2O - f(dH2O) / df(dH2O), this is Newton-Raphson algrithom 
            // Note: P/(RT) In table 3 is actually equals to Pbar / (RT) * MH2O
            $dH2Oi = $dH2Oi -($Preduced-$Pbar/($RgasJbar*$Tk/$MH2O))/$dPreducedddH2O;

            if ($dH2Oi > 1.7)
            {
                $dH2O[0] = 1.7;
            } 
            elseif ($dH2Oi < 0)
            {
                $dH2O[1] = 0.005;
            }
        } while (abs($deviationH2O) > 1e-5);
        
        if ($Pbar > $Psat)
        {
            $dH2O[0] = $dH2Oi; // Single phase liquid
        }
        elseif ($Pbar < $Psat)
        {
            $dH2O[1] = $dH2Oi; // Single phase vapor
        }
    } 
        
    elseif (abs($Pbar/$Psat-1)<=1e-4)
    // Calculation for two-phase region
    {
        $thetaH2O = 1 - $Tk / $TcrH2O;
        // Saturation liquid density
        $dH2O[0] = $dcrH2O*(1+$bH2O[1]*pow($thetaH2O,(1/3))
                +$bH2O[2]*pow($thetaH2O,(2/3))+$bH2O[3]*pow($thetaH2O,(5/3))
                +$bH2O[4]*pow($thetaH2O,(16/3))+$bH2O[5]*pow($thetaH2O,(43/3))
                +$bH2O[6]*pow($thetaH2O,(110/3)));
        
        // Saturation vapor density
        $dH2O[1] = $dcrH2O*exp($cH2O[1]*pow($thetaH2O,(1/3))
                +$cH2O[2]*pow($thetaH2O,(2/3))+$cH2O[3]*pow($thetaH2O,(4/3))
                +$cH2O[4]*pow($thetaH2O,3)+$cH2O[5]*pow($thetaH2O,(37/6))
                +$cH2O[6]*pow($thetaH2O,(71/6)));
    }  
    //echo json_encode($dH2O);
    return $dH2O;
}
?>


