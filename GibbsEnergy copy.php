<!--
    wrong code implemented by abhinav, later wiped this and adapted as it is from mathematica in GibbsEnergy.php

-->


<?php

include_once "DilectricConstant.php";
$DilectricConstant = $selfDefine[7];

function GibbsEnergy($Species, $TempK, $PressureBar, $DilectricConstant){
    // Create a hashmap that maps each species to the following properties (TABLE 2 of 2023 paper) - can convert to DB later if necessary
    $Species_to_properties = array(
        "Ba2+" => [-560.8, 9.6, -1.94, 7.78, 0.92, -63.85, 0, 2],
        "BaSO40" => [-1290.3, 33.3, -11.28, 21.04, 1.10, -677.12, 406, 0],
        "Cl-" => [-131.3, 56.7, 2.34, 3.00, 1.37, -326.8, 0, -1],
        "HCl0" => [-134.4, 123.6, 0.92, 0.81, 0.15, -326.8, 1.08, 0],
        "K+" => [-282.5, 101, 0.62, 5.28, 1.12, -0.19, 0, 1],
        "KCl0" => [-416.3, 94.3, -3.50, 3.00, 1.37, -93.91, 35.6, 0],
        "KOH0" => [-433.9, 129.7, -5.93, 7.94, 1.68, -181.34, 35.7, 0],
        "Li0" => [-292.6, 11.3, -0.29, 4.62, 1.18, 56.73, 0, 1],
        "LiOH0" => [-447.7, 19.5, -1.18, 7.55, 1.66, -32.35, 32.8, 0],
        "Na+" => [-261.9, 58.4, -0.32, 5.05, 1.23, 35.65, 0, 1],
        "NaOH0" => [-421.9, 14.6, -2.34, 5.65, 2.42, -74.99, 22.8, 0],
        "NH30" => [-79.5, 111.2, 1.45, 5.32, 1.02, 53.09, 0, 1],
        "NH4+" => [-26.7, 107.8, 2.45, 1.96, 1.36, 77.92, 1.1],
        "OH-" => [-157.3, -10.7, 0.3, 2.69, 2.18, -89.04, 0, -1],
        "PO43-" => [-981.1, -221.8, -2.37, 6.7, 1.55, -303.19, 0, -3],
        "HPO42-" => [-1089.1, -33.5, 1.22, 4.99, 1.75, -148.15, 0, -2],
        "H2PO4-" => [-1130.3, 90.4, 3.19, 2.66, 2.58, -48.21, 0, -1],
        "H3PO40" => [-1142.7, 159, 4.41, 0.86, 2.95, 56.28, 0.5, 0],
        "SiO20" => [-833.4, 56.5, 2.19, 1.18, 2.62, -28.68, 1.3, 0],
        "SO42-" => [-744.5, 18.8, 2.11, 5.21, 1.73, -167.53, 0, -2]
    );
    $properties = $Species_to_properties[$Species];

    return $properties[0] + Gibbsk($properties, $TempK, $DilectricConstant) + EntropyK($properties, $TempK, $DilectricConstant, $PressureBar) 
    * ($TempK - 298.15) + $properties[2] * ($PressureBar - 1) -$properties[5] * ($TempK * log($TempK/298.15) + 298.15 - $TempK);


};

function Calcb2($DilectricConstant)
{
    $equation = function ($b2) use ($DilectricConstant) {
        $b3 = 1 + $b2 / 3;
        $b6 = 1 - $b2 / 6;
        $b12 = 1 + $b2 / 12;
        return $DilectricConstant - pow($b12, 4) * pow($b3, 2) / pow($b6, 6);
    };

    // Initial guess for b2 for Newton-Raphson method
    $b2_guess = $DilectricConstant / 10;

    // Newton-Raphson method to find the value of b2 given the Dielectric constant
    function newtonMethod($equation, $initialGuess, $DilectricConstant)
    {
        $maxIterations = 1000;
        $tolerance = 1e-6;

        $x = $initialGuess;

        for ($i = 0; $i < $maxIterations; $i++) {
            $fx = $equation($x, $DilectricConstant);
            $dfx = ($equation($x + $tolerance, $DilectricConstant) - $fx) / $tolerance;

            $x = $x - $fx / $dfx;

            if (abs($fx) < $tolerance) {
                return $x;
            }
        }

        return null; // Solution not found within the maximum number of iterations
    }

    $b2_solution = newtonMethod($equation, $b2_guess, $DilectricConstant);

    return $b2_solution;
}



function Gibbsk($properties, $TempK, $DilectricConstant) {
    $R = 8.3145; //J K-1 mol-1
    $avogadro = 6.023e23;
    $rho = 0.9970614;
    $Mw  = 18.0152;
    $n = $avogadro * $rho / $Mw;
    $D = $properties[3]/$properties[4];
    $e = 1.60218e-19;
    $eta = ($properties[4]**3)*pi()*$n/6;
    $epsilon_0 = 8.85e-12;


    function GjHS($R, $eta, $D, $TempK){
        $part1 = $R * $TempK * (-log(1-$eta) + 3*$D*($eta/(1-$eta)) + 3*($D**2) *(($eta/(1-$eta)**2)+ ($eta/(1-$eta)) + log(1-$eta)));
        $part2 = -$R * $TempK * $D**3 * ((3*($eta**3) -6*($eta**2) + $eta)/((1-$eta)**3) + 2*log(1-$eta));
        return $part1 + $part2;
    };

    $b2 = Calcb2($DilectricConstant);
    $b12 = 1 + $b2/12;
    $b3 = 1 + $b2 / 3;
    $b6 = 1 - $b2 / 6;

    function GjID($e, $avogadro, $DilectricConstant, $properties, $epsilon_0, $b6, $b3){
        $part1 = -$avogadro * $e**2 * ($properties[7])**2 * (1- (1/$DilectricConstant));
        $part2 = (8*pi()* $epsilon_0)*($properties[3] + $properties[4]*($b6/$b3));

        return $part1/$part2;

    };

    function GjDD($avogadro, $properties, $DilectricConstant, $epsilon_0, $b12, $b3, $b6){
        $part1 = -8* $avogadro * ($properties[6]) **2 * ($DilectricConstant - 1);
        $part2 = (4*pi()*$epsilon_0) * (2* $properties[4] **3 * ( 1- $b12/ $b3) * ($b12/$b6) ** 3 + (2 * $DilectricConstant *($properties[3] + $properties[4] * ($b6/$b3))**3) + ($properties[3] + $properties[4] * ($b12/$b6)) ** 3);

        return $part1/$part2;
    };

    function GjSS($TempK, $R, $rho){
        return -$R * $TempK * log($rho * $R * $TempK/1);

    };

    $ret = GjHS($R, $eta, $D, $TempK) + GjID($e, $avogadro, $DilectricConstant, $properties, $epsilon_0, $b6, $b3) 
    + GjDD($avogadro, $properties, $DilectricConstant, $epsilon_0, $b12, $b3, $b6) + GjSS($TempK, $R, $rho);

    return $ret;

};

function EntropyK($properties, $TempK, $DilectricConstant, $PressureBar){
    $R = 8.3145; //J K-1 mol-1
    $avogadro = 6.023e23;
    $rho = 0.9970614;
    $Mw  = 18.0152;
    $n = $avogadro * $rho / $Mw;
    $D = $properties[3]/$properties[4];
    $e = 1.60218e-19;
    $eta = ($properties[4]**3)*pi()*$n/6;
    $epsilon_0 = 8.85e-12;
    $D = $properties[3] / $properties[4]; // ratio of sigma j and sigma w
    $L = 1/ $D;

    $b2 = Calcb2($DilectricConstant);
    $b12 = 1 + $b2/12;
    $b3 = 1 + $b2 / 3;
    $b6 = 1 - $b2 / 6;

    $depsdb2 = 2* (1 + ($b2/12)) **4 * (1 +$b2/3)/(3*(1-$b2/6)**6) + (1 + $b2/12)**3 * (1 + $b2/3)**2 /(3*(1-$b2/6)**6) + (1 + ($b2/12)) **4 * (1 +$b2/3)**2 /(1-$b2/6)**7 ;

    function SjDD($b6, $b12, $b2, $b3, $properties, $L, $DilectricConstant, $avogadro, $depsdb2){
        $part1 = -8 * $avogadro * ($properties[6])**2 * ($depsdb2)/ (($properties[3]/2)**3 * 
        ((1+ $L * $b12/$b6) ** 3 + 2 * $L ** 3 * $b12 ** 3 * (1 - $b12/$b3)/$b6**3 + 2 * $DilectricConstant *( 1 + $L * $b6/$b3)**3 ));
        $part2 = 8 * $avogadro * $properties[6] ** 2 * ($DilectricConstant - 1) * 
        (6 * $L **3 * $b12 ** 2 * (1 - $b12/$b3) * (1/12)/$b6**3 + 2 * $L **3 * $b12 ** 3 *(-(1/12) / $b3) + $b12 * (1/3) / $b3**2 ) / $b6**3;
        $part3 = -6 * $L **3 * $b12 ** 3 * (1 - $b12/$b3) * (-1/6)/ $b6 ** 4 
        + 6 * (1 + $L * $b6/$b3)**2 * $DilectricConstant * (-($L * $b6 * (1/3) / $b3**2) + $L * (-1/6) / $b3);
        $part4 = 3 * (1 + $L * $b12/$b6)**2 * ( $L * (1/12) / $b6 - $L * $b12 * (-1/6) / $b6 ** 2);
        $part5 = 2 * (1 + $L * $b6/$b3)**3 * (-0.36/ $depsdb2) / (($properties[3]/2) ** 3 * ((1 + $L * $b12/ $b3) ** 3) + 2 * (1 + $L * $b6/$b3)**3 * (-0.36/ $depsdb2))
        / ((($properties[3] / 2) ** 3) * ((1 + $L * $b12/$b6) ** 3 + 2* $L**3 * $b12**3 * (1 - $b12/$b3) / $b6**3) + 2*(1 + $L * $b6/$b3) **3 * $DilectricConstant);

        return $part1 + $part2 + $part3 + $part4 + $part5;
    };

    function SjID($avogadro, $e, $properties, $b3, $b6, $DilectricConstant, $depsdb2) {
        $part1 = ($depsdb2) * $avogadro * $e ** 2 * $properties[7] ** 2 / ((($properties[3]) + ($properties[4]) * ($b6/$b3)) * $DilectricConstant ** 2);
        $part2 = $avogadro * $e **2 * $properties[7] **2 / (($properties[3]) + ($properties[4]) * ($b6/$b3))**2 * (1/($DilectricConstant**2) -1) 
        * ($properties[4]) * (-0.36/ $depsdb2) * (-(1/(6* $b3)) -$b6/(3*$b3**2));

        return $part1 + $part2;

    };

    function GjHardSphere($R, $eta, $D, $TempK){
        $part1 = $R * $TempK * (-log(1-$eta) + 3*$D*($eta/(1-$eta)) + 3*($D**2) *(($eta/(1-$eta)**2)+ ($eta/(1-$eta)) + log(1-$eta)));
        $part2 = -$R * $TempK * $D**3 * ((3*($eta**3) -6*($eta**2) + $eta)/((1-$eta)**3) + 2*log(1-$eta));
        return $part1 + $part2;
    };

    $eta1 = 1 - $eta;

    function Y($eta1, $D, $eta){
        return $eta1 + 3 * $D * (1/$eta1 + $eta/($eta1**2)) + 3 * $D**2 * (2 * ($eta/$eta1**3) + (1 + $eta) / $eta1**2) 
        - $D ** 3 * ((9* $eta**2 +-12 *$eta + 1 )/$eta1**3 + (9 * $eta**3 - 18 * $eta**2 + 3 * $eta)/ $eta1**4 -2/$eta1);

    };

    $GjHS = GjHardSphere($R, $eta, $D, $TempK);
    $Y = Y($eta1, $D, $eta);

    function SjHS($R, $GjHS, $Y, $rho, $TempK, $eta){
        return -$R * ($GjHS - $eta * $TempK * $Y * (2.553e-4/$rho));

    };

    function SjSS($R, $rho, $TempK, $PressureBar) {
        return -$R * log($R * $rho * $TempK / $PressureBar) -1 + ($TempK/$rho) * (2.553e-4)/$rho;
    };

    return SjDD($b6, $b12, $b2, $b3, $properties, $L, $DilectricConstant, $avogadro, $depsdb2) + SjID($avogadro, $e, $properties, $b3, $b6, $DilectricConstant, $depsdb2)
            + SjHS($R, $GjHS, $Y, $rho, $TempK, $eta) + SjSS($R, $rho, $TempK, $PressureBar);

};

