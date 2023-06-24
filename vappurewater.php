<?php
// This function calculated water vapor pressure according to IAPWS-95 EoS
// Wagner and Pruß (2002)
// Created by Haining Zhao Mar 24th, 2014 by using PHP
function vappurewater($Tk)
    {
        $TcrH2O = 647.0960;  // K
        $PcrH2O = 220.64;    // bar
        // These coefficients can be found at Wagner and Pruß (2002)
        // 
        $avap = array();
        $avap[0] = -7.85951783;
        $avap[1] = 1.84408259;
        $avap[2] = -11.7866497;
        $avap[3] = 22.6807411;
        $avap[4] = -15.9618719;
        $avap[5] = 1.80122502; 
        $thetaH2O = (1 - $Tk / $TcrH2O);
        // eq 2.5a in page 399 of wagner and pruss
        $Ps = $PcrH2O * exp(($TcrH2O/$Tk)*($avap[0]*$thetaH2O
                +$avap[1]*pow($thetaH2O,1.5)+$avap[2]*pow($thetaH2O,3)
                +$avap[3]*pow($thetaH2O,3.5)+$avap[4]*pow($thetaH2O,4)
                +$avap[5]*pow($thetaH2O,7.5)));
        if ($Tk < $TcrH2O) 
        {
            $Psat = $Ps;
        }
        else
        {
            $Psat = $PcrH2O;
        }
        return $Psat;
    }
