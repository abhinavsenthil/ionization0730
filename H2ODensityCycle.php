<?php
// Pure water properties
function H2ODensityCycle($dH2O, $Tk)
{
//    $dH2O = 0.9;
//    $Tk = 273.15+90;

    $TcrH2O = 647.096;
    $dcrH2O = 0.322;
    
    $AHelmH2O = array(0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0.32,0.32);
    
    $BHelmH2O = array(0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0.2,0.2);

    $CHelmH2O = array(0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,28,32);

    $DHelmH2O = array(0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,700,800);

    $alphaHelmH2O = array(0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,20,20,20,0,0);

    $betaHelmH2O = array(0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,150,150,250,0.3,0.3);

    $aHelmH2O = array(0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,3.5,3.5);

    $bHelmH2O = array(0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0.85,0.95);

    $cHelmH2O = array(0,
            0,0,0,0,0,0,0,1,1,1,
            1,1,1,1,1,1,1,1,1,1,
            1,1,2,2,2,2,2,2,2,2,
            2,2,2,2,2,2,2,2,2,2,
            2,2,3,3,3,3,4,6,6,6,
            6,0,0,0,0,0);
    
    $dHelmH2O = array(0,
            1,1,1,2,2,3,4,1,1,1,
            2,2,3,4,4,5,7,9,10,11,
            13,15,1,2,2,2,3,4,4,4,
            5,6,6,7,9,9,9,9,9,10,
            10,12,3,4,4,5,14,3,6,6,
            6,3,3,3,0,0);

    $epsilonHelmH2O = array(0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,1,1,1,0,0);
    
    $gammaHelmH2O = array(0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,0,0,0,0,0,0,0,0,0,
            0,1.21,1.21,1.25,0,0);

    $gammaoHelmH2O = array(0,
        0,0,0,1.28728967,3.53734222,7.74073708,9.24437796,27.5075105);

    $nHelmH2O = array(0,
        0.0125335479355230,7.89576347228280,-8.78032033035610,0.318025093454180,-0.261455338593580,
        -0.0078199751687981,0.00880894931021340,-0.668565723079650,0.204338109509650,-6.62126050396870e-05,
        -0.192327211560020,-0.257090430034380,0.160748684862510,-0.040092828925807,3.93434226032540e-07,
        -7.59413770881440e-06,0.000562509793518880,-1.56086522571350e-05,1.15379964229510e-09,3.65821651442040e-07,
        -1.32511800746680e-12,-6.26395869124540e-10,-0.107936009089320,0.0176114910087520,0.221322951675460,
        -0.402476697635280,0.580833999857590,0.0049969146990806,-0.0313587007125490,-0.743159297103410,
        0.478073299154800,0.0205279408959480,-0.136364351103430,0.0141806344006170,0.00833265048807130,
        -0.0290523360095850,0.0386150855742060,-0.0203934865137040,-0.00165540500637340,0.00199555719795410,
        0.000158703083241570,-1.63885683425300e-05,0.0436136157238110,0.0349940054637650,-0.0767881978446210,
        0.0224462773320060,-6.26897104146850e-05,-5.57111185656450e-10,-0.199057183544080,0.317774973307380,
        -0.118411824259810,-31.3062603234350,31.5461402377810,-2521.31543416950,-0.148746408567240,0.318061108784440);

    $noHelmH2O = array(0,
        -8.320446482, 6.683210527, 3.00632, 0.012436, 0.97315,1.2795,0.96956,0.24873);

    $tHelmH2O = array(0,
            -0.5,0.875,1,0.5,0.75,0.375,1,4,6,12,
            1,5,4,2,13,9,3,4,11,4,
            13,1,7,1,9,10,10,3,7,10,
            10,6,10,10,1,2,3,4,8,6,
            9,8,16,22,23,23,10,50,44,46,
            50,0,1,4,0,0);
    
    $deltaH2O = $dH2O / $dcrH2O; 
    $tauH2O = $TcrH2O / $Tk;
    $phirH2Odlt  = 0;
    $phirH2Odltdlt = 0;

    for ($i = 1; $i<=7 ; $i++) 
    {
        $phirH2Odlt = $phirH2Odlt+$nHelmH2O[$i]*$dHelmH2O[$i]
                *pow($deltaH2O, ($dHelmH2O[$i]-1))
                *pow($tauH2O, $tHelmH2O[$i]); 
        
        $phirH2Odltdlt = $phirH2Odltdlt+$nHelmH2O[$i]*$dHelmH2O[$i]
                *($dHelmH2O[$i]-1)*pow($deltaH2O,($dHelmH2O[$i] - 2))
                *pow($tauH2O,$tHelmH2O[$i]);
    }

    for ($i = 8; $i<=51 ; $i++) 
    {
        $phirH2Odlt = $phirH2Odlt+$nHelmH2O[$i]
                *exp(-pow($deltaH2O, $cHelmH2O[$i]))
                *(pow($deltaH2O, ($dHelmH2O[$i] - 1))
                *pow($tauH2O, $tHelmH2O[$i])*($dHelmH2O[$i]
                -$cHelmH2O[$i]*pow($deltaH2O, $cHelmH2O[$i])));
        
        $phirH2Odltdlt = $phirH2Odltdlt+$nHelmH2O[$i]
                *exp(-pow($deltaH2O, $cHelmH2O[$i])) 
                *(pow($deltaH2O, ($dHelmH2O[$i]-2)) 
                *pow($tauH2O, $tHelmH2O[$i])*(($dHelmH2O[$i]-$cHelmH2O[$i]
                *pow($deltaH2O, $cHelmH2O[$i]))
                *($dHelmH2O[$i]-1-$cHelmH2O[$i]*pow($deltaH2O,$cHelmH2O[$i])) 
                - pow($cHelmH2O[$i],2)*pow($deltaH2O, $cHelmH2O[$i])));
    }
   
    
    for ($i = 52; $i<=54 ; $i++) 
    {
        $phirH2Odlt = $phirH2Odlt+$nHelmH2O[$i]*pow($deltaH2O,$dHelmH2O[$i])
                *pow($tauH2O, $tHelmH2O[$i])*exp(-$alphaHelmH2O[$i] 
                *pow(($deltaH2O-$epsilonHelmH2O[$i]),2) 
                -$betaHelmH2O[$i]*pow(($tauH2O - $gammaHelmH2O[$i]),2)) 
                *($dHelmH2O[$i]/$deltaH2O-2*$alphaHelmH2O[$i]
                *($deltaH2O -$epsilonHelmH2O[$i]));
        
        $phirH2Odltdlt = $phirH2Odltdlt+$nHelmH2O[$i]
                *pow($tauH2O,$tHelmH2O[$i])*exp(-$alphaHelmH2O[$i]
                *pow(($deltaH2O-$epsilonHelmH2O[$i]),2)-$betaHelmH2O[$i]
                *pow(($tauH2O - $gammaHelmH2O[$i]),2))*(-2*$alphaHelmH2O[$i]
                *pow($deltaH2O, $dHelmH2O[$i])+4*pow($alphaHelmH2O[$i], 2) 
                *pow($deltaH2O, $dHelmH2O[$i])*pow(($deltaH2O-$epsilonHelmH2O[$i]),2) 
                -4*$dHelmH2O[$i]*$alphaHelmH2O[$i]*pow($deltaH2O, ($dHelmH2O[$i] - 1))
                *($deltaH2O - $epsilonHelmH2O[$i])+$dHelmH2O[$i]*($dHelmH2O[$i] - 1) 
                *pow($deltaH2O,($dHelmH2O[$i] - 2)));
    }
    
    for ($i = 55; $i<=56 ; $i++) 
    {
        $thetaH2O = (1-$tauH2O)+$AHelmH2O[$i]
                *pow((pow(($deltaH2O - 1), 2)), (1/(2*$betaHelmH2O[$i])));
        
        $DeltabigH2O = pow($thetaH2O,2)+$BHelmH2O[$i]
                *pow(pow(($deltaH2O-1),2),$aHelmH2O[$i]);
        
        $dDeltaH2Oddelta = ($deltaH2O-1)*($AHelmH2O[$i]
                *$thetaH2O*2/$betaHelmH2O[$i]
                *pow(pow(($deltaH2O-1),2),(1/(2*$betaHelmH2O[$i])-1))
                +2*$BHelmH2O[$i]*$aHelmH2O[$i]
                *pow(pow(($deltaH2O-1),2),($aHelmH2O[$i]-1)));
       
        $dDeltaH2Obiddelta = $bHelmH2O[$i]
                *pow($DeltabigH2O,($bHelmH2O[$i]-1))*$dDeltaH2Oddelta;

        $tmp1 = 4*$BHelmH2O[$i]*$aHelmH2O[$i]*($aHelmH2O[$i]-1)
                *pow(pow(($deltaH2O-1),2),($aHelmH2O[$i]-2));
        
        $d2DeltaH2Oddelta2 = 1/($deltaH2O-1)*$dDeltaH2Oddelta+pow(($deltaH2O-1),2)
                *($tmp1+2*pow($AHelmH2O[$i],2)*pow((1/$betaHelmH2O[$i]),2)
                *pow((pow((pow(($deltaH2O-1),2)),(1/(2*$betaHelmH2O[$i])-1))),2) 
                +$AHelmH2O[$i]*$thetaH2O*4/$betaHelmH2O[$i]*(1/(2*$betaHelmH2O[$i])-1) 
                *pow(pow(($deltaH2O-1),2),(1/(2*$betaHelmH2O[$i])-2)));
        
        
        $d2DeltaH2Obiddelta2 = $bHelmH2O[$i]*(pow($DeltabigH2O,($bHelmH2O[$i]-1)) 
                *$d2DeltaH2Oddelta2+($bHelmH2O[$i]-1)
                *pow($DeltabigH2O,($bHelmH2O[$i]-2))*pow($dDeltaH2Oddelta,2));

        $PsiH2O = exp(-$CHelmH2O[$i]*pow(($deltaH2O-1),2)
                -$DHelmH2O[$i]*pow(($tauH2O-1),2));
        
        $dPsiH2Oddelta = -2*$CHelmH2O[$i]*($deltaH2O-1)*$PsiH2O;
        $d2PsiH2Oddelta2 = (2*$CHelmH2O[$i]*pow(($deltaH2O-1),2)-1)
                *2*$CHelmH2O[$i]*$PsiH2O;

        $phirH2Odlt = $phirH2Odlt+$nHelmH2O[$i]*(pow($DeltabigH2O,$bHelmH2O[$i])
                *($PsiH2O+$deltaH2O*$dPsiH2Oddelta)+$dDeltaH2Obiddelta*$deltaH2O*$PsiH2O);
        $phirH2Odltdlt = $phirH2Odltdlt+$nHelmH2O[$i]*(pow($DeltabigH2O, $bHelmH2O[$i])
                *(2*$dPsiH2Oddelta+$deltaH2O*$d2PsiH2Oddelta2)
                +2*$dDeltaH2Obiddelta*($PsiH2O+$deltaH2O*$dPsiH2Oddelta)
                +$d2DeltaH2Obiddelta2*$deltaH2O*$PsiH2O); 

    }
    $waterProperties = array();
    $waterProperties[0] = $deltaH2O;
    $waterProperties[1] = $phirH2Odlt;
    $waterProperties[2] = $phirH2Odltdlt;
//    echo json_encode($waterProperties);
    return $waterProperties;   
}
    
     