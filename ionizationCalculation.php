<?php

   // $root = $_SERVER['DOCUMENT_ROOT'];
    include_once "DensityH2Ocalculation.php";
    include_once "vappurewater.php";

   function ionizationCalculation($Tk, $Pbar){
    //$Pbar = 4.76159;
    //$Tk = 273.15+150;
    $MH2O = 18.0152;
    $TcrH2O = 647.0960;
    $PcrH2O = 220.64;   
    
    $dH2O = DensityH2OCalculation($Pbar, $Tk);
    $Psat = vappurewater($Tk);
    $liqDens = $dH2O[0];
    $vapDens = $dH2O[1];
    $alphaIoniz = array(0,-0.864671,8659.19,-22786.2); // table 2 of bandura and lvov 2006
    $betaIoniz = array(0,0.642044,-56.8534,-0.375754); // table 2 of bandura and lvov 2006
    $gammaIoniz = array(0,0.61415,48251.33,-67707.93,10102100);
    $n = 6;
    $pKwl = 0;  
    $pKwv1 = 0;
    $pKwv2 = 0;
    
    if ($vapDens == 0 || $liqDens == 0)
    {
        $label = 1; // Water is in Single phase at the given P-T
    }
    elseif ($vapDens != 0 && $liqDens != 0)
    {
        $label = 2; // two phase: VLE 
    }


    $pKwG = $gammaIoniz[1]+$gammaIoniz[2]*pow($Tk,-1)
            +$gammaIoniz[3]*pow($Tk,-2)+$gammaIoniz[4]*pow($Tk,-3);

    if ($label == 1) // Single-phase
    {
        if ($Pbar > $Psat) // Single liquid 
        {
            $z = $liqDens*exp($alphaIoniz[1]+$alphaIoniz[2]*pow($Tk,-1)
                +$alphaIoniz[3]*pow($Tk,-2)*pow($liqDens,(2/3)));
            
            $pKwl1 = -2*$n*(log10(1+$z)-$z/(1+$z)*$liqDens*($betaIoniz[1]
                +$betaIoniz[2]*pow($Tk,-1)+$betaIoniz[3]*$liqDens))+$pKwG
                +2*log10($MH2O/1000);
        }
        elseif ($Pbar <= $Psat) // Single vapor
        {
            $z = $vapDens*exp($alphaIoniz[1]+$alphaIoniz[2]*pow($Tk,-1)
                +$alphaIoniz[3]*pow($Tk,-2)*pow($vapDens,(2/3)));
            
            $pKwv1 = -2*$n*(log10(1+$z)-$z/(1+$z)*$vapDens*($betaIoniz[1]
                +$betaIoniz[2]*pow($Tk,-1)+$betaIoniz[3]*$vapDens))+$pKwG
                +2*log10($MH2O/1000);
        }
    }
    elseif ($label == 2)
    {
        // Ionization constant for liquid phase
        $zl = $liqDens*exp($alphaIoniz[1]+$alphaIoniz[2]*pow($Tk,-1)
            +$alphaIoniz[3]*pow($Tk,-2)*pow($liqDens,(2/3)));
        
        $pKwl2 = -2*$n*(log10(1+$zl)-$zl/(1+$zl)*$liqDens*($betaIoniz[1]
            +$betaIoniz[2]*pow($Tk,-1)+$betaIoniz[3]*$liqDens))+$pKwG
            +2*log10($MH2O/1000);
        
        // Ionization constant for vapor phase
        $zv = $vapDens*exp($alphaIoniz[1]+$alphaIoniz[2]*pow($Tk,-1)
            +$alphaIoniz[3]*pow($Tk,-2)*pow($vapDens,(2/3)));
        
        $pKwv2 = -2*$n*(log10(1+$zv)-$zv/(1+$zv)*$vapDens*($betaIoniz[1]
            +$betaIoniz[2]*pow($Tk,-1)+$betaIoniz[3]*$vapDens))+$pKwG
            +2*log10($MH2O/1000);        
    }
    
    if ($pKwv1 != 0)
    {
        $pKwl = "N/A";
        $liqDens = "N/A";
        
        if ($Tk >= $TcrH2O && $Pbar >= $PcrH2O)
        {
            $pKw = $pKwv1;
            $pkwv = "N/A";
            $scDens = $vapDens;
            $vapDens = "N/A";
        }
        else 
        {
            $pKwv = $pKwv1;
            $pKw = "N/A";
            $scDens = "N/A";
        }
    }
    elseif ($pKwv1 == 0 && $pKwv2 == 0)
    {
        $pKwv = "N/A";
        $vapDens = "N/A";
        if ($Tk >= $TcrH2O && $Pbar >= $PcrH2O)
        {
            $pKw = $pKwl1;
            $scDens = $liqDens;
            $liqDens = "N/A";
            $pKwl = "N/A";
        }
        else 
        {
            $pKwl = $pKwl1;
            $pKw = "N/A";
            $scDens = "N/A";
        }
    }
    elseif ($pKwv2 != 0)
    {
        $pKwl = $pKwl2;
        $pKwv = $pKwv2;
        $pKw = "N/A";
        $scDens = "N/A";
    }
    
   
    $Psat = "N/A";
    
    // prepare the data to be returned in an array
    // define an array variable $selfDefine
    $selfDefine = array();
    $selfDefine[0] = $pKw;
    $selfDefine[1] = $pKwl;
    $selfDefine[2] = $pKwv;
    $selfDefine[3] = $Psat; // saturation pressure
    $selfDefine[4] = $scDens; // liquid phase density
    $selfDefine[5] = $liqDens; // liquid phase density
    $selfDefine[6] = $vapDens; // vapor phase density
    

    return $selfDefine;
   
   }
    