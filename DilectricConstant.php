<?php
   // $root = $_SERVER['DOCUMENT_ROOT'];
    include_once "ionizationCalculation.php";
    include_once "GibbsEnergy.php";

    // Get pressure and temperature from input box
    
    $Pbar = filter_input(INPUT_POST, 'pres'); 
    $Tk = filter_input(INPUT_POST, 'temp')+273.15;
    $Species = filter_input(INPUT_POST, 'species');

    $selfDefine = ionizationCalculation($Tk, $Pbar);

    function findFinalDensity($selfDefine){
        $finalDensity = 0;
        if($selfDefine[4] != "N/A"){
            $finalDensity = $selfDefine[4];
        }
        else if($selfDefine[5] != "N/A"){
            $finalDensity = $selfDefine[5];
    
        }
    
        else if($selfDefine[6] != "N/A"){
            $finalDensity = $selfDefine[6];
        }
        return $finalDensity;
    };

    function DilectricCalc($Tk, $selfDefine){
        $finalDensity = findFinalDensity($selfDefine);

        $rho = $finalDensity * 1000; // kg/m^3

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
    $Tc = $Tk - 273.15;
    $epsilon = DilectricCalc($Tk, $selfDefine);
    $selfDefine[7] = $epsilon;

    $finalDensity = findFinalDensity($selfDefine);

    //$selfDefine[8] = $Species;
    $selfDefine[8] = GibbsEnergy($Species, $Tc, $Pbar, $epsilon, $finalDensity);



    // Function to round float values to 4 decimal places
    function roundFloatToFourDP(&$value) {
        if (is_float($value)) {
            $value = round($value, 4);
        }
    }

    // Loop through the $selfDefine array and round float values to 4 decimal places
    foreach ($selfDefine as &$item) {
        if (is_float($item)) {
            roundFloatToFourDP($item);
        }
    }

    


   // echo json_encode($Pbar);
    echo json_encode($selfDefine);
   