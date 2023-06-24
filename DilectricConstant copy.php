<?php

   // $root = $_SERVER['DOCUMENT_ROOT'];
    include_once "DensityH2Ocalculation.php";
    include_once "vappurewater.php";
    include_once "ionization.php";

    // Get pressure and temperature from input box
    
    $Pbar = filter_input(INPUT_POST, 'pres'); 
    $Tk = filter_input(INPUT_POST, 'temp')+273.15;
    //$Pbar = 4.76159;
    //$Tk = 273.15+150;
    $MH2O = 18.0152;
    $TcrH2O = 647.0960;
    $PcrH2O = 220.64;   
    
    $dH2O = DensityH2OCalculation($Pbar, $Tk);
    $Psat = vappurewater($Tk);
    $liqDens = $dH2O[0];
    $vapDens = $dH2O[1];
    $finalDensity = 0;

    // Now, to calculate the Dilectric Constant, we create a function with input parameters of Tk, Pbar, Psat and vapour and liquid dens.
    // first, to check which density to use: liquid or solid, compare given Pressure with saturated Pressure

    if($selfDefine[4] != "N/A"){
        $finalDensity = $selfDefine[4];
    }
    else if($selfDefine[5] != "N/A"){
        $finalDensity = $selfDefine[5];

    }

    else if($selfDefine[6] != "N/A"){
        $finalDensity = $selfDefine[6];
    }

    $rho = $finalDensity * 1000; // kg/m^3


    

    // Coefficients and constants
    $eps0 = ((4 * pow(10, -7)) * pi() * pow(299792459, 2)) ** -1; // C^2/Jm (permittivity)
    $alpha = 1.636 * pow(10, -40); // C^2/Jm^2 (mean molecular polarizability)
    $mu = 6.138 * pow(10, -30); // C m (molecular dipole moment)
    $k = 1.380658 * pow(10, -23); // J/K (Boltzmann's constant)
    $Navo = 6.0221367 * pow(10, 23); // mol^-1 (Avogadro's number)
    $Mw = 0.018015268; // kg/mol (molar mass of water)
    $rhoc = 322; // kg/m^3 (critical density of water)
    $Nh = [0.978224486826, -0.957771379375, 0.237511794148, 0.714692244386, -0.298217036956, -0.108863472196, 0.949327488264 * pow(10, -1), -0.980469816509 * pow(10, -2), 0.165167634970 * pow(10, -4), 0.937359795772 * pow(10, -4), -0.123179218720 * pow(10, -9)];
    $N12 = 0.196096504426 * pow(10, -2);
    $ih = [1, 1, 1, 2, 3, 3, 4, 5, 6, 7, 10]; // exponent for density term
    $jh = [0.25, 1, 2.5, 1.5, 1.5, 2.5, 2, 2, 5, 0.5, 10]; // exponent for temperature term


    function DilectricConstant($Tk, $rho) {

        
        // Coefficients and constants
        $TcrH2O = 647.0960;
        $eps0 = ((4 * pow(10, -7)) * pi() * pow(299792459, 2)) ** -1; // C^2/Jm (permittivity)
        $alpha = 1.636 * pow(10, -40); // C^2/Jm^2 (mean molecular polarizability)
        $mu = 6.138 * pow(10, -30); // C m (molecular dipole moment)
        $k = 1.380658 * pow(10, -23); // J/K (Boltzmann's constant)
        $Navo = 6.0221367 * pow(10, 23); // mol^-1 (Avogadro's number)
        $Mw = 0.018015268; // kg/mol (molar mass of water)
        $rhoc = 322; // kg/m^3 (critical density of water)
        $Nh = [0.978224486826, -0.957771379375, 0.237511794148, 0.714692244386, -0.298217036956, -0.108863472196, 0.949327488264 * pow(10, -1), -0.980469816509 * pow(10, -2), 0.165167634970 * pow(10, -4), 0.937359795772 * pow(10, -4), -0.123179218720 * pow(10, -9)];
        $N12 = 0.196096504426 * pow(10, -2);
        $ih = [1, 1, 1, 2, 3, 3, 4, 5, 6, 7, 10]; // exponent for density term
        $jh = [0.25, 1, 2.5, 1.5, 1.5, 2.5, 2, 2, 5, 0.5, 10]; // exponent for temperature term


        function gh($Nhh, $ei, $ej, $rho, $rhoc, $TcrH2O, $Tk) {
            return $Nhh * pow($rho / $rhoc, $ei) * pow($TcrH2O / $Tk, $ej);
        }

        $term2 = array_sum(array_map('gh', $Nh, $ih, $jh, array_fill(0, count($Nh), $rho), array_fill(0, count($Nh), $rhoc), array_fill(0, count($Nh), $TcrH2O), array_fill(0, count($Nh), $Tk)));
        $term3 = $N12 * ($rho / $rhoc) * (pow($Tk / 228, -1.2));
        $g = 1 + $term2 + $term3;
        $A = ($Navo * pow($mu, 2) * $rho * $g) / ($eps0 * $k * $Tk * $Mw);
        $B = ($Navo * $alpha * $rho) / (3 * $eps0 * $Mw);
        $dc = (1 + $A + 5 * $B + sqrt(9 + 2 * $A + 18 * $B + pow($A, 2) + 10 * $A * $B + 9 * pow($B, 2))) / (4 - (4 * $B));

        return $dc;
    }

    //$DilectricConst = DilectricConstant($Tk, $rho);

    $DilectricConst = 0;

    $selfDefine = array();
    $selfDefine[0] = $pKw;
    $selfDefine[1] = $pKwl;
    $selfDefine[2] = $pKwv;
    $selfDefine[3] = $Psat; // saturation pressure
    $selfDefine[4] = $scDens; // liquid phase density
    $selfDefine[5] = $liqDens; // liquid phase density
    $selfDefine[6] = $vapDens; // vapor phase density
    $selfDefine[7] = $DilectricConst; // Dil. Const.
    
   // echo json_encode($Pbar);
    echo json_encode($selfDefine);




