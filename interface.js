

function validateSpeciesDataInput(species, TempC, PBar, gibbsDens){
    // Implementation of Table 1 of the 2023 Paper
    console.log("TempC: " + TempC);
    if ( TempC > 600 || TempC <0) return 'Error: The temperature selected is outside the recommended limits for this calculator.';
    if (PBar > 4000 || PBar < 1) return 'Error: The pressure selected is outside the recommended limits for this calculator.';
    // if (gibbsDens < 0.4) return 'Error: Density should be above 0.4 g cm-3';
    // if(gibbsDens < minAllowedDens) return 'Error: Density should be above ' + minAllowedDens + 'g cm -3';
    else return 'OK';

}

const allTextFieldIDs = ['Dens', 'Constant', 'Temp', 'Pres', 'Pkw', 'Pkwl', 'Pkwv', 'LiqDens', 'scDens', 'VapDen', 'Psat', 'Gibbs-Temp', 'Gibbs-Dens', 'Gibbs-Pres', 'Start', 'End', 'Step'];
        const optionToFields = {'PT': ['Pres', 'Temp', 'Psat', 'Pkw', 'Pkwl', 'Pkwv', 'LiqDens', 'scDens', 'VapDen'], 
                                'PT2': ['Gibbs-Temp', 'Gibbs-Pres'], 
                                'PD2': ['Gibbs-Temp'], 
                                'PT3': ['Start', 'End', 'Step', 'Constant'], 
                                'ROT': ['Temp', 'Dens', 'Pkw'], 
                                'T': ['Temp', 'Pkw', 'Pkwl', 'Pkwv', 'LiqDens', 'VapDen', 'Psat']};

        function disableFields(ignoreFields){
            console.log("ignoreFields: ", ignoreFields);
            for(let id of allTextFieldIDs){
                if(ignoreFields && ignoreFields.indexOf(id) !== -1){
                    console.log('enabling id: ', id)
                    document.getElementById(id).disabled = false;
                }
                else{
                    document.getElementById(id).value = '';
                    document.getElementById(id).disabled = true;
                }

            }

        }


        function reSet(){
            document.getElementById('calculate_button').disabled = false;
            disableFields([]);
            document.getElementById("stepTable").innerHTML = '';
            document.getElementById("Species").value = 'Select_One';
            populateDynamicParams(['', '', '', '', '', '', '', '']);
            for (let x of Object.keys(optionToFields)){
                document.getElementById(x).checked = false;
            }
            document.getElementById('constT').checked = false;
            document.getElementById('constP').checked = false;
            displayError('', 'reset');
            

            
        }

        window.onload = function() {
            disableFields([]);
            openCalc(event, 'Gibbs1', false, 'Gibbs');
        }

        function enableFields(id) {
            console.log('enable fields is invoked');
            disableFields(optionToFields[id]);
    
        }

function validateUserInputs(){
    document.getElementById('calculate_button').disabled = false;
    displayMessages = {"error": new Set(), "warning": new Set()};
    console.log('tabname is: ', TABNAME);
    document.getElementById(err).innerHTML = '';
    fields = ['Gibbs-Temp', 'Gibbs-Pres'];
    types = ['Temp', 'Pres'];
    for(let i = 0; i < fields.length; i++){
        validateUserInputRange(document.getElementById(fields[i]), types[i]);
    }
}

function validateUserInputRange(field, type){
    let theoretical_val_exceeded_temp = 'Warning: The temperature value selected is outside the data range used to fit these parameters. Calculator outputs may not be reliable. See the supporting publications for more details.';
    let theoretical_val_exceeded_pres = 'Warning: The pressure value selected is outside the data range used to fit these parameters. Calculator outputs may not be reliable. See the supporting publications for more details.';
    let error_msg = '';
    let species = document.getElementById('Species').value;
    let value = parseFloat(field.value);
    let name = field.name;
    console.log('name: ' , name);
    console.log('value: ' , value);
    if(document.getElementById('PD2').checked && type === 'Temp'){
        if(value > 373.95){
            displayError('Error: Temperature should not exceed the critical point of water (373.95 C)', 'error');
            
        }
        else{
            const retData = getSaturation(NaN, value, false);
            console.log('retData: ', retData);
            const lowerDensity = retData[3];
            // error_msg = 'Warning: maximum density allowed is: ' + lowerDensity;
            console.log('lower density: ', lowerDensity);
        }
    }

    const set1 = new Set(["Ba2+", "Cl-", "K+", "Li+", "Na+", "NH30", "NH4+", "OH-", "PO43-", "HPO42-", "H2PO4-", "H3PO40", "SiO20", "SO42-" ]);
    const set2 = new Set(["KCl0", "KOH0", "NaOH0"]);
    if (set1.has(species)){
        if ( type === 'Temp' && (value > 300 || value < 0)) error_msg = theoretical_val_exceeded_temp;
        if (type === 'Pres' && (value > 500 || value < 1)) error_msg = theoretical_val_exceeded_pres;
    }
    else if (set2.has(species)){
        if (type === 'Temp' && (value > 600 || value < 100)) error_msg = theoretical_val_exceeded_temp;
        if (type === 'Pres' &&  (value > 3500 || value < 100)) error_msg = theoretical_val_exceeded_pres;

    }
    else if (species === "BaSO40"){
        // if ( TempC > 600 || TempC < 200) return 'Temp should be between 200-600 C for ' + species;
        // if (PBar > 2000 || PBar < 400) return 'Pressure should be between 400-2000 Bar for ' + species;
        if (type === 'Temp' && (value > 600 || value < 200)) error_msg = theoretical_val_exceeded_temp;
        if (type === 'Pres' && (value > 2000 || value < 400)) error_msg = theoretical_val_exceeded_pres;
    }

    displayError(error_msg, 'warning');
 
}

var displayMessages = {"error": new Set(), "warning": new Set()};
function displayError(msg, type='error'){
    
    if(msg && (type === 'error' || type === 'warning')){
        displayMessages[type].add(msg);
    }

    if(type==='warning'){
        document.getElementById(err).style.color = 'blue';
    }
    else if(type === 'note'){
        document.getElementById(err).style.color = 'black';
    }
    else if(type === 'reset'){
        document.getElementById(err).innerHTML = '';
        displayMessages = {"error": new Set(), "warning": new Set()};;
    }
    else{
        document.getElementById(err).style.color = 'red';
    }

    document.getElementById(err).innerHTML = '';
    let messages = '';
    let note = '';
    for (const type in displayMessages) {
        messages =  displayMessages['error'];
        if(messages && messages.size > 0) note = displayMsgByType(messages, 'error');
        else {note = displayMsgByType(displayMessages['warning'], 'warning');}
      
    }
    
      document.getElementById(err).innerHTML = note + '</br>';
 
}

function displayMsgByType(messages, type){
    let note = '';
    for (const message of messages) {
        let color = 'blue';
        if(type === 'error'){
            color = 'red';
            document.getElementById('calculate_button').disabled = true;
        }
        note += ('<div style = "color:'+color + ';">' + message + '</div>');     
      }
      return note;
}

var pres;
var temp;
var rho;
var condition;
var range_condition;
var allData = [];
var gibbsDens;

let startTime;
let endTime;

var params1;
var params2;
var params3;
var params4;
var params5;
var params6;
var params7;
var params8;
var minAllowedDens;


function chooseConditions(obj) {
    if(obj && obj.checked === true){
        enableFields(obj.id);
    }
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
        case '4': // PT3
            condition = 4;
            break;
        case '5':
            condition = 5;
        default:
            break;
    }
    console.log(condition);
    console.log("testing");
    console.log(radios.length);
};

function chooseRangeConditions(){
    var radios = document.getElementsByName('rangeselector');
    for(var i=0; i<radios.length; i++){
        if(radios[i].checked){
            label = radios[i].value;
        }
    }
    switch (label) {    
        case '0': // fixed t
            range_condition = 0;
            break;
        case '1': // fixed P
            range_condition = 1;
            break;
        default:
            break;
    }
    console.log('range');
    console.log(range_condition);
}



function roundDensity(x) {
    let number = Number.parseFloat(x).toFixed(6);
    if(number == "NaN")return 'N/A';
    return number;
  }



function ajaxPostBulk(){

    displayError('', 'reset');
    //if (document.getElementById('PD2').checked == true) {
    
    startTime = performance.now();
    if (condition === 5){
        // t constant
        allData = [];
        let constant = parseFloat(document.getElementById("Constant").value);
        let start = parseFloat(document.getElementById("Start").value);
        let end = parseFloat(document.getElementById("End").value);
        let step = parseFloat(document.getElementById("Step").value);

        if(range_condition === 0){
            let t = constant
            for(let p = start; p<=end; p = p + step){
                ajaxPost(p, t);

            }

        }
        // pressure is fixed
        else if(range_condition === 1){
            let p = constant
            for(let t = start; t<=end; t = t + step){
                console.log('postbulk');
                console.log(t);
                ajaxPost(p, t);


            }

        }
        
    }
    else { 
        
        let pName = "Pres";
        let tName = "Temp";
        
        if(TABNAME === "Gibbs"){
            pName = "Gibbs-Pres";
            tName = "Gibbs-Temp";
        }

        p = parseFloat(document.getElementById(pName).value);
        t = parseFloat(document.getElementById(tName).value);
        ajaxPost(p, t);
        }

}

function ajaxPost(p, t){

    rho = parseFloat(document.getElementById("Dens").value);
    species = document.getElementById("Species").value;
    params1 = parseFloat(document.getElementById("params1").value);
    params2 = parseFloat(document.getElementById("params2").value);
    params3 = parseFloat(document.getElementById("params3").value);
    params4 = parseFloat(document.getElementById("params4").value);
    params5 = parseFloat(document.getElementById("params5").value);
    params6 = parseFloat(document.getElementById("params6").value);
    params7 = parseFloat(document.getElementById("params7").value);
    params8 = parseFloat(document.getElementById("params8").value);
    //let paramsArr = [1000, 100, 200, 400, 500, 600, 700, 800];
    let paramsArr = [params1, params2, params3, params4, params5, params6, params7, params8];
    paramsArr = JSON.stringify(paramsArr);
    console.log('paramarray');
    console.log(paramsArr);
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
                    displayError('Error loading XML document');
                }, 
                // Call to PHP is sucessful   
                success: function(returnedData){    
                    document.getElementById("Pkw").value = returnedData[0];
                    document.getElementById("Pkwl").value = returnedData[1];
                    document.getElementById("Pkwv").value = returnedData[2];
                    document.getElementById("Psat").value = returnedData[3];
                    document.getElementById("scDens").value = roundDensity(returnedData[4]);
                    document.getElementById("LiqDens").value = roundDensity(returnedData[5]);
                    document.getElementById("VapDen").value = roundDensity(returnedData[6]);
                   // alert(returnedData);
                    }
                });
            }
            else
            {
                displayError("Please enter the correct temperature: 0-800 oC");
            }
            
        }
        else
        {
            displayError("Please complete all steps before calculating a value");
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
                    displayError('Error loading XML document');  
                }, 
                // Call to PHP is sucessful   
                success: function(returnedData){      
                    document.getElementById("Pkw").value = Math.round(returnedData*100000)/100000;
                    //document.getElementById("Psat").value = Math.round(returnedData*100000)/100000;
                    }   
                });
            }
            else
            {
                displayError("Please enter the correct density: 0-1.25 g cm-3");
            }    
         }
         else
         {
             displayError("Please enter the correct temperature: 0-800 oC");
         }
    }
    else if (condition === 2)
    {
         if (t>=0 && t<=373.917)
         {   
            
            getSaturation(rho, t, true);   
         }
         else
         {
            displayError("Please enter the correct temperature: 0-373.95 oC");
         }
         // Done by abhinav from here
    }
    else if (condition === 3 || condition === 4) 
    {
        if(species==='Select_One'){
            displayError('Error: No species was selected.', 'error');
        }
        allData = [];
        p = parseFloat(document.getElementById("Gibbs-Pres").value);
        t = parseFloat(document.getElementById("Gibbs-Temp").value);
        gibbsDens = parseFloat(document.getElementById("Gibbs-Dens").value);
        message = validateSpeciesDataInput(species, t, p, gibbsDens);
        if( message !== 'OK'){
            return displayError(message);
        }
        if (p>=1 && p<=10000 || condition === 4)
        {
            if (t>=0 && t<=800)
            {
                $.ajax({
                url: "DilectricConstant.php",  
                type: "POST",
                data:{pres:p,temp:t,species:species, gibbsDens: gibbsDens, paramsArr: paramsArr},
                dataType: "json",
                // Call to PHP is failed
                error: function(){  
                    displayError('Internal server error');  
                }, 
                // Call to PHP is sucessful   
                success: function(returnedData){    
                    // returnedData.unshift(p, t);
                    console.log(returnedData);
                    appendStepTable(returnedData);
                   // alert(returnedData);
                    }
                });
            }
            else
            {
                displayError("Please enter the correct temperature: 0-800 oC");
            }
            
        }
        else
        {
            displayError("Please complete all steps before calculating a value");
        }
    }

    

    else if (condition === 5) 
    {
        gibbsDens = parseFloat(document.getElementById("Gibbs-Dens").value);
        message = validateSpeciesDataInput(species, t, p, gibbsDens)
        if( message !== 'OK'){
            return displayError(message);
        }

            if (t>=0 && t<=600)
            {
                
                $.ajax({
                url: "DilectricConstant.php",  
                type: "POST",
                data:{pres:p,temp:t,species:species, gibbsDens: gibbsDens, paramsArr: paramsArr},
                dataType: "json",
                // Call to PHP is failed
                error: function(){  
                    displayError('Error loading XML document');  
                }, 
                // Call to PHP is sucessful   
                success: function(returnedData){    
                    // returnedData.unshift(p, t);
                    appendStepTable(returnedData);
                   // alert(returnedData);
                    }
                });
            }
            else
            {
                displayError("Please enter the correct temperature: 0-800 oC");
            }
            
        }
        else
        {
            displayError("Please complete all steps before calculating a value");
        }
    

};

// Custom comparison function for sorting based on the second element of each sub-array
function sortBySecondElement(a, b) {
    if (range_condition === 0) {
        const firstElementA = a[0];
        const firstElementB = b[0];
        return firstElementA - firstElementB;
    } else if (range_condition === 1) {
        const secondElementA = a[1];
        const secondElementB = b[1];
        return secondElementA - secondElementB;
    } else {
        // If range_condition is neither 0 nor 1, return 0 to keep the original order.
        return 0;
    }
}

// Sort the allData array using the custom comparison function
allData.sort(sortBySecondElement);



function appendStepTable(val){
    console.log(val);
    allData.push(val);
    allData.sort(sortBySecondElement); // Sort the array based on the second element
    document.getElementById("stepTable").innerHTML = generateTable();

}

var valsOmmitted = false;

function generateTable(){
    let tableHTML = "";
    if(condition === 4 || condition === 3 || condition === 5){
        tableHTML += "<table class='innerTable'>";
        tableHTML += "<tr>";
        tableHTML += "<th style='width:10%'>P/ bar</th>";
        tableHTML += "<th style='width:10%'><em>t</em> / <sup>o</sup>C:</th>";
        tableHTML += "<th style='width:15%'>p<em>K</em>w<sub>(l)</sub></th>";
        tableHTML += "<th style='width:25%'><em>&rho;</em><sub>H2O(l)</sub> / g cm<sup>-3</sup></th>";
        tableHTML += "<th style='width:15%'><em>ε</em></th>";
        tableHTML += "<th>Δ<sub>f</sub>G<sup>0</sup><sub>j</sub> / kJ mol<sup>-1</sup></th>";
        tableHTML += "</tr>";
    }
    
    for (let i = 0; i < allData.length; i++) {
        
        data = allData[i];
        if(data[7] < 0.4){
            valsOmmitted = true;
            continue;
        }
        tableHTML += "<tr>";
        for (let j = 0; j < data.length; j++) {
            let val = data[j]
            if(j===1 || j=== 0){
                val = Number(data[j]).toPrecision(5);
            }
            if(j=== 3){
                val = Number(data[j]).toFixed(3); //pkw
            }
            if(j=== 7){
                val = Number(data[j]).toFixed(6); //dens
            }
            if(j===9){
                val = Number(data[j]).toFixed(2); //d const
            }
            if(j===10){
                val = Number(data[j]).toFixed(3);
            }
            if(j === 2 || j === 4 || j === 5 || j === 6|| j === 8){
                continue
            }
            tableHTML += "<td>" + val + "</td>";       
        }
        tableHTML += "</tr>";
        if (allData[i][7] === 'N/A'){
            tableHTML+= '</table>';
            tableHTML += "In the last value of the Temperature and Pressure printed above, you are beyond the Liquid Phase and the model is not built for Predicting Gibbs energy of reaction values in the Supercritical or vapour phase.";
            break;
        }
    }

    // will have to update the table significantly

    const endTime = performance.now(); // Record the end time
    console.log("Time taken to generate the table: " + (endTime - startTime) + " milliseconds");

    console.log(allData);

    if(valsOmmitted === true){
        displayError("Some value(s) are not displayed as certain input(s) of pressure and temperature yield a density below 0.4 g cm <sup>-3</sup>") 
        valsOmmitted = false;
    }

    return tableHTML;

}


function loadDynamicParams(val){
    if (val === 'Select_One'){
        populateDynamicParams(['', '', '', '', '', '', '', '']);
        displayError("Select a valid value");
        return;
    }

    $.ajax({
        url: "DilectricConstant.php",  
        type: "POST",
        data:{command:'GetParams', selectedSpecies: val},
        dataType: "json",
        // Call to PHP is failed
        error: function(){  
            displayError('Error loading XML document');  
        }, 
        // Call to PHP is sucessful   
        success: function(returnedData){    
            // returnedData.unshift(p, t);
            console.log("returned data " + returnedData);
            populateDynamicParams(returnedData);
           // alert(returnedData);
            }
        });

}

function populateDynamicParams(returnedData){ 
    for (let i = 0; i < returnedData.length; i++) {
        document.getElementById("params" + (i+1)).value = returnedData[i];
      }
}

function getSaturation(rho, t, display = true){
    let retData = [];
    $.ajax({
        url: "Saturation.php",  
        type: "POST",
        data:{dens:rho,temp:t},
        dataType: "json",
        // Call to PHP is failed
        error: function(){  
            // displayError('Error loading XML document');  
        }, 
        // Call to PHP is sucessful   
        success: function(returnedData){ 
            retData = returnedData;  
            if(display){
                document.getElementById("Pkwl").value = returnedData[0].toFixed(3);
                document.getElementById("Pkwv").value = returnedData[1].toFixed(3);
                document.getElementById("Psat").value = returnedData[2].toFixed(2);
                document.getElementById("LiqDens").value = returnedData[3].toFixed(6);
                document.getElementById("VapDen").value = returnedData[4].toFixed(6);
            }
            else{
                minAllowedDens = returnedData[3].toFixed(6);

                document.getElementById('Gibbs-Dens').value = minAllowedDens;
                displayError('Note:- Density is calculated at saturation conditions', 'note');  
            }

            }   
        });
    return retData;
}


