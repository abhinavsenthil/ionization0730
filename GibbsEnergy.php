<?php

function GibbsEnergy($Species, $t, $p, $DilectricConstant, $ro){
    // Create a hashmap that maps each species to the following properties (TABLE 2 of Hall et al 2023) - can convert to DB later if necessary
    // $ro is density, g/cm^3
    // Trun is in Kelvin


    $Species_to_properties = array(
        "PO43-" => [-234480, -53.00, -0.567, 3.351, 0.776, -72.463, 0.00, -3],
        "HPO42-" => [-260310, -8.00, 0.292, 2.493, 0.873, -35.409, 0.00, -2],
        "H2PO4-" => [-270140, 21.60, 0.763, 1.332, 1.290, -11.523, 0.00, -1],
        "H3PO40" => [-273100, 38.00, 1.053, 0.432, 1.476, 13.452, 0.51, 0],
        "Na+" => [-62591, 13.96, -0.076, 2.527, 0.617, 8.521, 0.00, 1],
        "OH-" => [-37595, -2.56, 0.071, 1.346, 1.090, -21.282, 0.00, -1],
        "NaOH0" => [-100840, 3.48, -0.558, 2.825, 1.208, -17.923, 22.82, 0],
        "Ba2+" => [-134030, 2.30, -0.464, 3.891, 0.462, -15.260, 0.00, 2],
        "SO42-" => [-177930, 4.50, 0.505, 2.603, 0.864, -40.040, 0.00, -2],
        "BaSO40" => [-308394, 7.96, -2.696, 10.520, 0.548, -161.836, 406.00, 0],
        "Cl-" => [-31379, 13.56, 0.558, 1.499, 0.686, -17.635, 0.00, -1],
        "HCl0" => [-30179, 16.19, 0.584, 0.714, 0.223, -10.383, 1.11, 0],
        "K+" => [-67510, 24.15, 0.147, 2.642, 0.561, -0.045, 0.00, 1],
        "KCl" => [-99507, 22.54, -0.084, 3.949, 0.971, -22.444, 35.64, 0],
        "NH4+" => [-18990, 26.57, 0.346, 2.659, 0.509, 12.689, 0.00, 1],
        "NH30" => [-6383, 25.77, 0.587, 0.981, 0.681, 18.623, 1.13, 0],
        "Li+" => [-69933, 2.70, -0.069, 2.310, 0.589, 13.560, 0.00, 1],
        "LiOH0" => [-107000, 4.66, -0.283, 3.774, 0.832, -7.733, 32.76, 0],
        "KOH0" => [-103715, 31.01, -1.418, 3.968, 0.840, -43.341, 35.69, 0],
        "NaCl" => [-94019, 26.25, 0.3397, 3.739, 0.3449, -8.343, 32.03, 0],
        "SiO20" => [-199190, 13.54, 0.523, 0.592, 1.312, -6.855, 1.34, 0]
    );

    $properties = $Species_to_properties[$Species];
    


    // All of this is a direct conversion of Dr. Hall's Mathematica code
    $Trun = $t + 273.15;
    $Gfaqs = $properties[0];
    $Sref = $properties[1];
    $aa1 = $properties[2];
    $riMSA = $properties[3];
    $rw = $properties[4];
    $cc1 = $properties[5];
    $dmol = $properties[6];
    $zi = $properties[7];

    //b2 values through Calcb2 function

    $b2 = Calcb2($DilectricConstant);

    $b3 = 1 + $b2 / 3;
    $b6 = 1 - $b2 / 6;
    $b12 = 1 + $b2 / 12;

    $Pref = 1;
    $Tref = 298.15;
    $epsref = 78.24514;
    $Mw = 18.0152;
    $b225 = 2.13101;
    $cj = 4.184;
    $roref = 0.9970614;  // units g/cm3
    $R = 1.9872;  // units cal/K/mol


    $G1 = $Gfaqs - $Sref * ($Trun - $Tref);
    $G2 = - $cc1 * ($Trun * log($Trun / $Tref) - $Trun + $Tref) + $aa1 * ($p - $Pref);


    $b625 = 1 - $b225 / 6;
    $b325 = 1 + $b225 / 3;
    $b1225 = 1 + $b225 / 12;

    $depsdt25 = -0.36005189; // del eps del  (numerical approximation)
    $dbdt25 = -0.00206593; // del b del t (numerical approximation)
    $gmsa = 166261.8 * ($zi ** 2) / ($riMSA + $rw * $b6 / $b3) * (1 / $DilectricConstant - 1); // Gmsa

    $gmsa25 = 166261.8 * ($zi ** 2) / ($riMSA + $rw * $b625 / $b325) * (1 / $epsref - 1); // Gmsa25
    $dsmsa25 = (166261.8 * ($zi ** 2) / ($riMSA + $rw * $b625 / $b325) / ($epsref ** 2) * $depsdt25 + 166261.8 * ($zi ** 2) / ($riMSA + $rw * $b625 / $b325) ** 2 * (1 / $epsref - 1) * $rw * $dbdt25 * (-1 / 6 / $b325 - $b625 / $b325 ** 2 / 3)); // smsaref
    $G3 = ($gmsa - $gmsa25 + $dsmsa25 * ($Trun - $Tref)); // MSA contributions, Gmsa - Gmsaref + Smsaref(T-Tr)
    $G4 = ($R * $Trun * log($R * $cj * $Trun * $ro / (100 * $Pref)) - 
        $R * $Tref * log($R * $cj * $Tref * $roref / (100 * $Pref)) + ($Trun - $Tref) *
        $R * (-log($roref * $R * $cj * $Tref / (100 * $Pref)) - (1 + 
            $Tref / $roref * (-0.258666 * 10 ** -3)))); // standard state contributions, Gss-Gssref+ Sssref(T-Tref)
    $alf25 = 2.5530 * 10 ** -4;

    $K = $riMSA / $rw; // ratio of radii
    $Nconv = 0.602214; // Na*cm3/A3
    $tet = pi() / 6 * (2 * $rw) ** 3 * $Nconv * $ro / $Mw; // eta = pi/6*simga^3*ro/MW*Na*cm3/A3
    $tet1 = 1 - $tet; // 1-eta
    $tet25 = pi() / 6 * (2 * $rw) ** 3 * $Nconv * $roref / $Mw;
    $tet125 = 1 - $tet25;
    $F = -log($tet1) + 3 * $K * ($tet / $tet1) + 
    3 * $K ** 2 * ($tet / $tet1 ** 2 + $tet / $tet1 + log($tet1)) - 
    $K ** 3 * (((3 * $tet ** 3 - 6 * $tet ** 2 + $tet) / $tet1 ** 3) + 2 * log($tet1)); // Ghs/RT
    $F25 = -log($tet125) + 3 * $K * ($tet25 / $tet125) + 
    3 * $K ** 2 * ($tet25 / $tet125 ** 2 + $tet25 / $tet125 + log($tet125)) - 
    $K ** 3 * (((3 * $tet25 ** 3 - 6 * $tet25 ** 2 + $tet25) / $tet125 ** 3) + 
        2 * log($tet125)); // Ghs/RT 25C
    $L25 = (1 / $tet125) + 3 * $K * (1 / $tet125 + $tet25 / $tet125 ** 2) + 
    3 * $K ** 2 * (2 * $tet25 / $tet125 ** 3 + (1 + $tet25) / $tet125 ** 2) - 
    $K ** 3 * (((9 * $tet25 ** 2 - 12 * $tet25 + 1) / $tet125 ** 3) + ((9 * $tet25 ** 3 - 18 * $tet25 ** 2 + 3 * $tet25) / $tet125 ** 4) - (2 / $tet125)); // Lvov 1990 appendix HS

    $muhs25 = $R * $Tref * $F25; // G Hard sphere at 25C
    $muhs = $R * $Trun * $F; // G hard sphere
    $shs25 = -$R * ($F25 - $tet25 * $alf25 * $Tref * $L25); // hs entropy at 25C
    $G5 = $muhs - $muhs25 + $shs25 * ($Trun - $Tref); // hard sphere contribution
    $KK = $rw / $riMSA;

    $GDMSA = -14393.164 * pow($dmol, 2) * ($DilectricConstant - 1) /
    ($riMSA**3 * (($KK**3*2*(1 - $b12/$b3)*pow($b12/$b6, 3)) +
        2*$DilectricConstant*pow(1 + $KK*$b6/$b3, 3) + pow(1 + $KK*$b12/$b6, 3)));

    $Deps25 = 2 * pow(1 + $b225/12, 4) * pow(1 + $b225/3, 2) / (3 * pow(1 - $b225/6, 6))
    + pow(1 + $b225/12, 3) * pow(1 + $b225/3, 2) / (3 * pow(1 - $b225/6, 6))
    + pow(1 + $b225/12, 4) * pow(1 + $b225/3, 2) / pow(1 - $b225/6, 7);

    $Db1225 = 1/12;
    $Db325 = 1/3;
    $Db625 = -1/6;
    $db2dt25 = $depsdt25 / $Deps25;

    $dGDMSAdb225 = -14393.164 * $dmol**2 * $Deps25 /
        ($riMSA**3 * (($KK*$b1225/$b625)**3 +
            2*$KK**3*$b1225**3*($Db1225/$b325 - $b1225*$Db325/$b325**2)/$b625**3 +
            2*(1 + $KK*$b625/$b325)**3*$epsref))
        + 14393.164 * $dmol**2 * (-1 + $epsref) *
        (6*$KK**3*$b1225**2*($Db1225/$b325 - $b1225*$Db325/$b325**2)/$b625**3 +
            2*$KK**3*$b1225**3*(-$Db1225/$b325 + $b1225*$Db325/$b325**2)/$b625**3 -
            6*$KK**3*$b1225**3*($Db625/$b625**4) +
            6*(1 + $KK*$b625/$b325)**2*$epsref*(-$KK*$b625*$Db325/$b325**2 + $KK*$Db625/$b325) +
            3*(1 + $KK*$b1225/$b625)**2*($KK*$Db1225/$b625 - $KK*$b1225*$Db625/$b625**2) +
            2*pow(1 + $KK*$b625/$b325, 3) * $Deps25)
        / ($riMSA**3 * (($KK*$b1225/$b625)**3 +
            2*$KK**3*$b1225**3*($Db1225/$b325 - $b1225*$Db325/$b325**2)/$b625**3 +
            2*(1 + $KK*$b625/$b325)**3*$epsref)**2);

    $SDMSA25 = -$dGDMSAdb225 * $db2dt25;

    $GDMSA25 = -14393.164 * $dmol**2 * ($epsref - 1) /
        ($riMSA**3 * (($KK*$b1225/$b325)**3 +
            2*$KK**3*$b1225**3*($Db1225/$b625 - $b1225*$Db625/$b625**2)/$b325**3 +
            2*(1 + $KK*$b1225/$b625)**3*$epsref));

    if($properties[7] == 0) {
        $G6 = 0;
        }
    else $G6 = $GDMSA - $GDMSA25 + $SDMSA25 * ($Trun - $Tref);
    // Dipole-dipole contributions
    $Gvalues = $G1 + $G2 + $G3 + $G4 + $G5 + $G6;
    $Gent = $G1 - $Gfaqs;
    $Gref = $G1 - $Gent;


    return $Gvalues * 4.184;
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
    $b2_guess = $DilectricConstant / 100;

    // Newton-Raphson method to find the value of b2 given the Dielectric constant
    function newtonMethod($equation, $initialGuess, $DilectricConstant)
    {
        $maxIterations = 1000;
        $tolerance = 1e-8;

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
};

