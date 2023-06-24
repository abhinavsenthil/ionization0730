

export function validateSpeciesDataInput(species, TempC, PBar){
    if (species in Set("Ba2+", "Cl-")){
        if (isNaN(TempC) || TempC <= 300 || TempC >= 0) return 'Temp should be between 0-300 C for ' + species;
        if (isNaN(PBar) || TempC <= 500 || TempC >= 1) return 'Pressure should be between 1-500 Bar for ' + species;
            
        
    }
    return 'OK';

}