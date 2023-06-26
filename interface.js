// Abhinav: validation of species
function validateSpeciesDataInput(species, TempC, PBar){
    // Implementation of Table 1 of the 2023 Paper
    const set1 = new Set(["Ba2+", "Cl-", "K+", "Li+", "Na+", "NH30", "NH4+", "OH-", "PO43-", "HPO42-", "H2PO4-", "H3PO40", "SiO20", "SO42-" ]);
    const set2 = new Set(["KCl0", "KOH0", "NaOH0"]);

    if (set1.has(species)){
        if ( TempC > 300 || TempC < 0) return 'Temp should be between 0-300 C for ' + species;
        if (PBar > 500 || PBar < 1) return 'Pressure should be between 1-500 Bar for ' + species;
        else return "OK";
            
        
    }
    else if (set2.has(species)){
        if ( TempC > 600 || TempC < 100) return 'Temp should be between 100-600 C for ' + species;
        if (PBar > 3500 || PBar < 100) return 'Pressure should be between 100-3500 Bar for ' + species;
        else return 'OK';
            
        
    }
    else if (species === "BaSO40"){
        // if ( TempC > 600 || TempC < 200) return 'Temp should be between 200-600 C for ' + species;
        // if (PBar > 2000 || PBar < 400) return 'Pressure should be between 400-2000 Bar for ' + species;
        return 'OK';
            
        
    }
    else if (species === "HCl0"){
        if ( TempC > 500 || TempC < 25) return 'Temp should be between 25-500 C for ' + species;
        if (PBar > 2500 || PBar < 1) return 'Pressure should be between 1-2500 Bar for ' + species;
        else return 'OK';
            
        
    }
    else if (species === "LiOH0"){
        if ( TempC > 600 || TempC < 50) return 'Temp should be between 50-600 C for ' + species;
        if (PBar > 4000 || PBar < 100) return 'Pressure should be between 100-4000 Bar for ' + species;
        else return 'OK';
            
        
    }




    

}

var pres;
var temp;
var rho;
var condition;

function chooseConditions() {
   var radios = document.getElementsByName('inputselector');
    for(var i = 0; i < radios.length; i++) {
        if(radios[i].checked) {
            label = radios[i].value;
        }
    } 
    switch (label) {    
        case '0': // P-T
            condition = 0;
            break;
        case '1': // rho-T
            condition = 1;
            break;
        case '2':
            condition = 2;
            break;
        case '3': // PT2
            condition = 3;  
            break;
        default:
            break;
    }
    console.log(condition);
    // console.log(radios.length);
};


function ajaxPost(){
    p = parseFloat(document.getElementById("Pres").value);
    t = parseFloat(document.getElementById("Temp").value);
    rho = parseFloat(document.getElementById("Dens").value);
    species = document.getElementById("Species").value;
    
    if (condition === 0) 
    {
        if (p>=1 && p<=10000)
        {
            if (t>=0 && t<=800)
            {
                $.ajax({
                url: "ionization.php",  
                type: "POST",
                data:{pres:p,temp:t},
                dataType: "json",
                // Call to PHP is failed
                error: function(){  
                    alert('Error loading XML document');  
                }, 
                // Call to PHP is sucessful   
                success: function(returnedData){    
                    document.getElementById("Pkw").value = returnedData[0];
                    document.getElementById("Pkwl").value = returnedData[1];
                    document.getElementById("Pkwv").value = returnedData[2];
                    document.getElementById("Psat").value = returnedData[3];
                    document.getElementById("scDens").value = returnedData[4];
                    document.getElementById("LiqDens").value = returnedData[5];
                    document.getElementById("VapDen").value = returnedData[6];
                   // alert(returnedData);
                    }
                });
            }
            else
            {
                alert("Please enter the correct temperature: 0-800 oC");
            }
            
        }
        else
        {
            alert("Pressure enter the correct pressure: 1-10000 bar");
        }
    }
    else if (condition === 1)
    {
         if (t>0 && t<800)
         {   
            if (rho>0 && rho<=1.25)
            {
                $.ajax({
                url: "ionizationdens.php",  
                type: "POST",
                data:{dens:rho,temp:t},
                dataType: "json",
                // Call to PHP is failed
                error: function(){  
                    alert('Error loading XML document');  
                }, 
                // Call to PHP is sucessful   
                success: function(returnedData){      
                    document.getElementById("Pkw").value = Math.round(returnedData*100000)/100000;
                    }   
                });
            }
            else
            {
                alert("Please enter the correct density: 0-1.25 g cm-3");
            }    
         }
         else
         {
             alert("Please enter the correct temperature: 0-800 oC");
         }
    }
    else if (condition === 2)
    {
         if (t>=0 && t<=373.917)
         {   
            
            $.ajax({
            url: "Saturation.php",  
            type: "POST",
            data:{dens:rho,temp:t},
            dataType: "json",
            // Call to PHP is failed
            error: function(){  
                alert('Error loading XML document');  
            }, 
            // Call to PHP is sucessful   
            success: function(returnedData){      
                document.getElementById("Pkwl").value = returnedData[0];
                document.getElementById("Pkwv").value = returnedData[1];
                document.getElementById("Psat").value = returnedData[2];
                document.getElementById("LiqDens").value = returnedData[3];
                document.getElementById("VapDen").value = returnedData[4];
                }   
            });   
         }
         else
         {
             alert("Please enter the correct temperature: 0-373.917 oC");
         }
    }
    else if (condition === 3) 
    {
        message = validateSpeciesDataInput(species, t, p)
        if( message !== 'OK'){
            return alert(message);
        }
        if (p>=1 && p<=10000)
        {
            if (t>=0 && t<=800)
            {
                $.ajax({
                url: "DilectricConstant.php",  
                type: "POST",
                data:{pres:p,temp:t,species:species},
                dataType: "json",
                // Call to PHP is failed
                error: function(){  
                    alert('Error loading XML document');  
                }, 
                // Call to PHP is sucessful   
                success: function(returnedData){    
                    document.getElementById("Pkw").value = returnedData[0];
                    document.getElementById("Pkwl").value = returnedData[1];
                    document.getElementById("Pkwv").value = returnedData[2];
                    document.getElementById("Psat").value = returnedData[3];
                    document.getElementById("scDens").value = returnedData[4];
                    document.getElementById("LiqDens").value = returnedData[5];
                    document.getElementById("VapDen").value = returnedData[6];
                    document.getElementById("Dilectric").value = returnedData[7];
                    document.getElementById("Gibbs").value = returnedData[8];

                   // alert(returnedData);
                    }
                });
            }
            else
            {
                alert("Please enter the correct temperature: 0-800 oC");
            }
            
        }
        else
        {
            alert("Pressure enter the correct pressure: 1-10000 bar");
        }
    }

};

