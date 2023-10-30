<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="Ionization Constant of Water, Self-ionization Constant of Water, Dissociation constant of water, density of water, equation of state, Kw, high temperature, high pressure, low density">
    <meta name="author" content="Haining Zhao">
    <meta name="description" content="The Ionization Constant of Water pKw≡-log10(Kw) computational tool">
    <title>Web Computational Tool</title>
    <style>
        <?php include 'ion.css'; ?>
    </style>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="jquery-1.11.0.js"></script>
    <script type="text/javascript" src="interface.js"></script>
    <script>
        window.jQuery || document.write('<script src="http://mysite.com/jquery.min.js"><\/script>');
    </script>
    <script>
        var allTextFieldIDs = ['Dens', 'Constant', 'Temp', 'Pres', 'Pkw', 'Pkwl', 'Pkwv', 'LiqDens', 'scDens', 'VapDen', 'Psat', 'PT', 'ROT', 'T', 'PT3', 'constT', 'constP', 'PD2', 'PT2'];

        window.onload = function() {
            document.getElementById('Dens').value = '';
            document.getElementById('Dens').disabled = true;
            document.getElementById('Constant').value = '';
            document.getElementById('Constant').disabled = false;
            document.getElementById('Temp').value = '';
            document.getElementById('Temp').disabled = true;
            document.getElementById('Pres').value = '';
            document.getElementById('Pres').disabled = true;
            document.getElementById('Pkw').value = '';
            document.getElementById('Pkw').disabled = true;
            document.getElementById('Pkwl').value = '';
            document.getElementById('Pkwl').disabled = true;
            document.getElementById('Pkwv').value = '';
            document.getElementById('Pkwv').disabled = true;
            document.getElementById('LiqDens').value = '';
            document.getElementById('scDens').value = '';
            document.getElementById('scDens').disabled = true;
            document.getElementById('LiqDens').disabled = true;
            document.getElementById('VapDen').value = '';
            document.getElementById('VapDen').disabled = true;
            document.getElementById('Psat').value = '';
            document.getElementById('Psat').disabled = true;
            // //document.getElementById('Dilectric').value = '';
            // document.getElementById('Dilectric').disabled = true;
            document.getElementById('PT').onchange = disablefield;
            document.getElementById('ROT').onchange = disablefield;
            document.getElementById('T').onchange = disablefield;
            document.getElementById('PT3').onchange = disablefield;
            document.getElementById('constT').onchange = disablefield;
            document.getElementById('constP').onchange = disablefield;
            document.getElementById('PT').checked = false;
            document.getElementById('ROT').checked = false;
            document.getElementById('T').checked = false;
            document.getElementById('PT3').checked = false;
            document.getElementById('constT').checked = false;
            document.getElementById('constP').checked = false;
            document.getElementById('PD2').checked = false;
            document.getElementById('PD2').onchange = disablefield;
            document.getElementById('PT2').checked = false;
            document.getElementById('PT2').onchange = disablefield;
            openCalc(event, 'Gibbs1', false, 'Gibbs');


        };

        function disablefield() {
            if (document.getElementById('PT').checked == true) {
                document.getElementById('Dens').value = '';
                document.getElementById('Dens').disabled = true;
                document.getElementById('Temp').value = '';
                document.getElementById('Temp').disabled = false;
                document.getElementById('Pres').disabled = false;
                document.getElementById('Psat').disabled = false;
                document.getElementById('Pkw').value = '';
                document.getElementById('Pkw').disabled = false;
                document.getElementById('Pkwl').disabled = false;
                document.getElementById('Pkwv').disabled = false;
                document.getElementById('scDens').disabled = false;
                document.getElementById('LiqDens').disabled = false;
                document.getElementById('VapDen').disabled = false;
                //document.getElementById('Dilectric').value = '';
                document.getElementById('Dilectric').disabled = true;;
            } else if (document.getElementById('ROT').checked == true) {
                document.getElementById('Pres').value = '';
                document.getElementById('Pres').disabled = true;
                document.getElementById('Temp').value = '';
                document.getElementById('Temp').disabled = false;
                document.getElementById('Dens').disabled = false;
                document.getElementById('Pkw').value = '';
                document.getElementById('Pkw').disabled = false;
                //document.getElementById('Dilectric').value = '';
                document.getElementById('Dilectric').disabled = true;
                document.getElementById('scDens').value = '';
                document.getElementById('scDens').disabled = true;
                document.getElementById('Psat').value = '';
                document.getElementById('Psat').disabled = true;
                document.getElementById('LiqDens').value = '';
                document.getElementById('LiqDens').disabled = true;
                document.getElementById('VapDen').value = '';
                document.getElementById('VapDen').disabled = true;
                document.getElementById('Pkwl').value = '';
                document.getElementById('Pkwl').disabled = true;
                document.getElementById('Pkwv').value = '';
                document.getElementById('Pkwv').disabled = true;
            } else if (document.getElementById('T').checked == true) {
                document.getElementById('Pres').value = '';
                document.getElementById('Pres').disabled = true;
                document.getElementById('Temp').value = '';
                document.getElementById('Temp').disabled = false;
                document.getElementById('Dens').disabled = true;
                document.getElementById('Pkw').value = '';
                document.getElementById('Pkw').disabled = true;
                document.getElementById('scDens').value = '';
                document.getElementById('scDens').disabled = true;
                document.getElementById('Psat').value = '';
                document.getElementById('Psat').disabled = false;
                document.getElementById('LiqDens').value = '';
                document.getElementById('LiqDens').disabled = false;
                document.getElementById('VapDen').value = '';
                document.getElementById('VapDen').disabled = false;
                document.getElementById('Pkwl').value = '';
                document.getElementById('Pkwl').disabled = false;
                document.getElementById('Pkwv').value = '';
                document.getElementById('Pkwv').disabled = false;
                //document.getElementById('Dilectric').value = '';
                document.getElementById('Dilectric').disabled = true;
            } else if (document.getElementById('PT2').checked == true) {
                document.getElementById('Dens').value = '';
                document.getElementById('Dens').disabled = true;
                document.getElementById('Temp').value = '';
                document.getElementById('Temp').disabled = false;
                document.getElementById('Pres').disabled = false;
                document.getElementById('Psat').disabled = false;
                document.getElementById('Pkw').value = '';
                document.getElementById('Pkw').disabled = false;
                document.getElementById('Pkwl').disabled = false;
                document.getElementById('Pkwv').disabled = false;
                document.getElementById('scDens').disabled = false;
                document.getElementById('LiqDens').disabled = false;
                document.getElementById('VapDen').disabled = false;
                document.getElementById('Gibbs-Temp').value = '';
                document.getElementById('Gibbs-Temp').disabled = false;
                document.getElementById('Gibbs-Dens').value = '';
                document.getElementById('Gibbs-Dens').disabled = true;
                document.getElementById('Gibbs-Pres').value = '';
                document.getElementById('Gibbs-Pres').disabled = false;
                //document.getElementById('Dilectric').value = '';
                //document.getElementById('Dilectric').disabled = false;
                // //document.getElementById('Gibbs').value = '';
                // //document.getElementById('Gibbs').disabled = false;

            } else if (document.getElementById('PD2').checked == true) {
                document.getElementById('Dens').value = '';
                document.getElementById('Dens').disabled = true;
                document.getElementById('Temp').value = '';
                document.getElementById('Temp').disabled = false;
                document.getElementById('Pres').disabled = false;
                document.getElementById('Psat').disabled = false;
                document.getElementById('Pkw').value = '';
                document.getElementById('Pkw').disabled = false;
                document.getElementById('Pkwl').disabled = false;
                document.getElementById('Pkwv').disabled = false;
                document.getElementById('scDens').disabled = false;
                document.getElementById('LiqDens').disabled = false;
                document.getElementById('VapDen').disabled = false;
                // //document.getElementById('Dilectric').value = '';
                // //document.getElementById('Dilectric').disabled = false;
                //document.getElementById('Gibbs').value = '';
                //document.getElementById('Gibbs').disabled = false;
                document.getElementById('Gibbs-Temp').value = '';
                document.getElementById('Gibbs-Temp').disabled = false;
                document.getElementById('Gibbs-Dens').value = '';
                document.getElementById('Gibbs-Dens').disabled = false;
                document.getElementById('Gibbs-Pres').value = '';
                document.getElementById('Gibbs-Pres').disabled = true;

            } else if (document.getElementById('PT3').checked == true) {
                document.getElementById('Dens').value = '';
                document.getElementById('Dens').disabled = true;
                document.getElementById('Temp').value = '';
                document.getElementById('Temp').disabled = true;
                document.getElementById('Pres').disabled = true;
                document.getElementById('Psat').disabled = true;
                document.getElementById('Pkw').value = '';
                document.getElementById('Pkw').disabled = true;
                document.getElementById('Pkwl').disabled = true;
                document.getElementById('Pkwv').disabled = true;
                document.getElementById('scDens').disabled = true;
                document.getElementById('LiqDens').disabled = true;
                document.getElementById('VapDen').disabled = true;
                // //document.getElementById('Dilectric').value = '';
                // document.getElementById('Dilectric').disabled = true;
                document.getElementById('Gibbs-Temp').value = '';
                document.getElementById('Gibbs-Temp').disabled = true;
                document.getElementById('Gibbs-Dens').value = '';
                document.getElementById('Gibbs-Dens').disabled = true;
                document.getElementById('Gibbs-Pres').value = '';
                document.getElementById('Gibbs-Pres').disabled = true;
            } else if (document.getElementById('constT').checked == true) {
                document.getElementById('Pres').value = '';
                document.getElementById('Pres').disabled = true;
                document.getElementById('Temp').value = '';
                document.getElementById('Temp').disabled = true;
                document.getElementById('Dens').disabled = true;
                document.getElementById('Pkw').value = '';
                document.getElementById('Pkw').disabled = true;
                // //document.getElementById('Dilectric').value = '';
                // document.getElementById('Dilectric').disabled = true;                       
                document.getElementById('scDens').value = '';
                document.getElementById('scDens').disabled = true;
                document.getElementById('Psat').value = '';
                document.getElementById('Psat').disabled = true;
                document.getElementById('LiqDens').value = '';
                document.getElementById('LiqDens').disabled = true;
                document.getElementById('VapDen').value = '';
                document.getElementById('VapDen').disabled = true;
                document.getElementById('Pkwl').value = '';
                document.getElementById('Pkwl').disabled = true;
                document.getElementById('Pkwv').value = '';
                document.getElementById('Pkwv').disabled = true;
                document.getElementById('Constant').value = '';
                document.getElementById('Constant').disabled = false;
                document.getElementById('Start').value = '';
                document.getElementById('Start').disabled = false;
                document.getElementById('End').value = '';
                document.getElementById('End').disabled = false;
                document.getElementById('Step').value = '';
                document.getElementById('Step').disabled = false;
            } else if (document.getElementById('constP').checked == true) {
                document.getElementById('Pres').value = '';
                document.getElementById('Pres').disabled = true;
                document.getElementById('Temp').value = '';
                document.getElementById('Temp').disabled = true;
                document.getElementById('Dens').disabled = true;
                document.getElementById('Pkw').value = '';
                document.getElementById('Pkw').disabled = true;
                // //document.getElementById('Dilectric').value = '';
                // document.getElementById('Dilectric').disabled = true;                       
                document.getElementById('scDens').value = '';
                document.getElementById('scDens').disabled = true;
                document.getElementById('Psat').value = '';
                document.getElementById('Psat').disabled = true;
                document.getElementById('LiqDens').value = '';
                document.getElementById('LiqDens').disabled = true;
                document.getElementById('VapDen').value = '';
                document.getElementById('VapDen').disabled = true;
                document.getElementById('Pkwl').value = '';
                document.getElementById('Pkwl').disabled = true;
                document.getElementById('Pkwv').value = '';
                document.getElementById('Pkwv').disabled = true;
                document.getElementById('Constant').value = '';
                document.getElementById('Constant').disabled = false;
                document.getElementById('Start').value = '';
                document.getElementById('Start').disabled = false;
                document.getElementById('End').value = '';
                document.getElementById('End').disabled = false;
                document.getElementById('Step').value = '';
                document.getElementById('Step').disabled = false;
            }
        }
    </script>
    <script>
        function reSet() {
            document.getElementById('Dens').value = '';
            document.getElementById('Dens').disabled = true;
            //document.getElementById('Gibbs').value = '';
            //document.getElementById('Gibbs').disabled = true;
            document.getElementById('Temp').value = '';
            document.getElementById('Temp').disabled = true;
            document.getElementById('Pres').value = '';
            document.getElementById('Pres').disabled = true;
            document.getElementById('Pkw').value = '';
            document.getElementById('Pkw').disabled = true;
            document.getElementById('Pkwl').value = '';
            document.getElementById('Pkwl').disabled = true;
            document.getElementById('Pkwv').value = '';
            document.getElementById('Pkwv').disabled = true;
            document.getElementById('LiqDens').value = '';
            document.getElementById('scDens').value = '';
            document.getElementById('scDens').disabled = true;
            document.getElementById('LiqDens').disabled = true;
            document.getElementById('VapDen').value = '';
            document.getElementById('VapDen').disabled = true;
            document.getElementById('Psat').value = '';
            document.getElementById('Psat').disabled = true;
            // //document.getElementById('Dilectric').value = '';
            // document.getElementById('Dilectric').disabled = true;
            document.getElementById('PT').onchange = disablefield;
            document.getElementById('ROT').onchange = disablefield;
            document.getElementById('T').onchange = disablefield;
            document.getElementById('PT').checked = false;
            document.getElementById('ROT').checked = false;
            document.getElementById('T').checked = false;
        }

        var TABNAME = "Gibbs";

        function openCalc(evt, calcName, isParams = false, tabName) {
            TABNAME = tabName;

            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(calcName).style.display = "block";
            evt.currentTarget.className += " active";

            var x = document.getElementById("param-display");
            if (isParams) {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
    <link rel="shortcut icon" type="image/x-icon" href="http://carbonlab.org/favicon.ico" />
</head>

<body>

    <!--
        <nav>
            <a href="">Water Model</a> |
            <a href="">CO2 Model</a> |
            <a href="">CO2-Brine Model</a> |
            <a href="">Oil and Gas Model</a> |
            <a href="">DataBase</a>
        </nav>
        -->

    <h1 class="three-titles">Aqueous Thermodynamic Properties at Elevated Temperatures and Pressures</h1>
    <h3 class="three-titles">&#8212;&#8212; A web computational tool &#8212;&#8212;</h3>
    <h4 style="text-align:center; width:720px; margin:auto; color:black; ">This computational tool provides the dissociation constant of water (<em>K</em>w), Dielectric constant of water (<em>ε</em>) and the standard Gibbs Energy of Formation (Δ<sub>f</sub> 𝐺<sup>0</sup><sub>j</sub>) of several aqueous species over a wide range of temperatures (<em>t</em>), pressures (<em>P</em>), and densities (<em>&rho;</em>) above and below the critical point of water. </h4>
    <br>



    <!-- <div class="param">
        <table role="presentation">
            <tr>
                <td style="width:33%;"><button class="tablinks" onclick="openCalc(event, 'Gibbs1', false, 'Gibbs')">Gibbs Energy</button></td>
                <td style="width:33%;"><button class="tablinks" onclick="openCalc(event, 'Gibbs1', true, 'GibbsWithParam')">Gibbs with Parameters</button></td>
                <td style="width:33%;"><button class="tablinks" onclick="openCalc(event, 'ionization', false, 'Ionization')">Ionization</button></td>
            </tr>  
        </table>
    </div>
  -->

    <div class="tab">
        <button class="tablinks" onclick="openCalc(event, 'Gibbs1', false, 'Gibbs')">Gibbs Energy</button>
        <button class="tablinks" onclick="openCalc(event, 'Gibbs1', true, 'GibbsWithParam')">Gibbs with Parameters</button>
        <button class="tablinks" onclick="openCalc(event, 'ionization', false, 'Ionization')">pKw</button>
    </div>


    <div id="Gibbs1" class="tabcontent">
        <h3>Gibbs Energy Calculator</h3>
        <div id="wrap3">
            <p>Enter Pressures between 1-4000 Bar, Temperatures between 0-600 <sup>o</sup>C</p>
            <div id="error_message" style="color:red"></div>

            <div class="bottom-left">
                <fieldset id="fd3">
                    <legend>Select Options</legend>

                    <table role="presentation" style="display:flex;justify-content: center;">
                        <tr>
                            <td>
                                Species:
                                <select id="Species" name="Species" onchange="loadDynamicParams(this.value)">
                                    <option value="Select_One+">Select One</option>
                                    <option value="Ba2+">Ba2+</option>
                                    <option value="BaSO40">BaSO40</option>
                                    <option value="Cl-">Cl-</option>
                                    <option value="HCl0">HCl0</option>
                                    <option value="K+">K+</option>
                                    <option value="KCl0">KCl0</option>
                                    <option value="KOH0">KOH0</option>
                                    <option value="Li+">Li+</option>
                                    <option value="LiOH0">LiOH0</option>
                                    <option value="Na+">Na+</option>
                                    <option value="NaOH0">NaOH0</option>
                                    <option value="NH30">NH30</option>
                                    <option value="NH4+">NH4+</option>
                                    <option value="OH-">OH-</option>
                                    <option value="PO43-">PO43-</option>
                                    <option value="HPO42-">HPO42-</option>
                                    <option value="H2PO4-">H2PO4-</option>
                                    <option value="H3PO40">H3PO40</option>
                                    <option value="SiO20">SiO20</option>
                                    <option value="SO42-">SO42-</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    
                    <form action="" method="get" name="input">
                        <input type="radio" name="inputselector" value="3" id="PT2" onclick="chooseConditions()" />
                        <label for="PT2">Δ<sub>f</sub> 𝐺<sup>0</sup><sub>j</sub> at a given <em>t</em>-<em>P</em></label><br>

                        <input type="radio" name="inputselector" value="4" id="PD2" onclick="chooseConditions()" />
                        <label for="PD2">Δ<sub>f</sub> 𝐺<sup>0</sup><sub>j</sub> at a given <em>t</em>-<em>ρ</em></label><br>

                        <input type="radio" name="inputselector" value="5" id="PT3" onclick="chooseConditions()" />
                        <label for="PT3">Range of Δ<sub>f</sub> 𝐺<sup>0</sup><sub>j</sub></label>
                    </form>
                </fieldset>
            </div>

            <div class="bottom-right">
                <fieldset id="fd4">
                    <legend>Define the Range</legend>
                    <form action="" method="get" name="input">
                        <form action="" method="get" name="input">
                            <input type="radio" name="rangeselector" value="0" id="constT" onclick="chooseRangeConditions()" />
                            <label for="PT">Constant <em>t</em>, variable P</label></br>
                            <input type="radio" name="rangeselector" value="1" id="constP" onclick="chooseRangeConditions()" />
                            <label for="ROT">Constant P, variable <em>t</em></label></br></br>
                            <table role="presentation">
                                <tr>
                                    <td class="one">Constant <em>t</em> or P:</td>
                                    <td><input class="two" type="number" name="Constant" id="Constant" value="" label="Input your constant value here" /></td>
                                </tr>
                            </table>

                        </form>
                        <table role="presentation">
                            <tr>
                                <td class="one">Start <em>t</em> or P:</td>
                                <td><input class="two" type="number" id="Start" label="Input starting Temp or Pres" onblur="" /></td>
                            </tr>
                            <tr>
                                <td class="one">End <em>t</em> or P:</td>
                                <td><input class="two" type="number" id="End" label="Input ending Temp or Pres" onblur="" /></td>
                            </tr>
                            <tr>
                                <td class="one">Δ<em>t</em> or ΔP (Integer):</td>
                                <td><input class="two" type="number" id="Step" label="Input Delta temp or Pres" onblur="" /></td>
                            </tr>


                        </table>
                    </form>
                </fieldset>
            </div>

            <div class="bottom-left">
                <fieldset id="fd5">
                    <legend>Set values</legend>
                    <table role="presentation">
                        <tr>
                            <td class="one"><em>t</em> / <sup>o</sup>C:</td>
                            <td><input class="two" type="number" id="Gibbs-Temp" name="Temp" label="Input  t / oC" title="Input  t / oC" onblur="" onkeyup="validateUserInputRange(this, 'Temp')"/></td>
                        </tr>
                        <tr>
                            <td class="one"><em>P</em> / bar</td>
                            <td><input class="two" type="number" id="Gibbs-Pres" label="Input P / bar" title="Input P / bar" onblur="" onkeyup="validateUserInputRange(this, 'Pres')"/></td>
                        </tr>
                        <tr>
                            <td class="one"><em>ρ</em>H2O(l) / g cm-3</td>
                            <td><input class="two" type="number" id="Gibbs-Dens" label="Input density" title="Input density" onblur="" /></td>
                        </tr>

                    </table>

                </fieldset>
            </div>

        </div>

        <br>


        <div id="param-display" class="param">
                <fieldset id="fd5_param">
                    <legend>Set Parameters</legend>
                    <table role="presentation">
                        <tr>
                            <td class="one" style="width:25%;">G<sup>0</sup><sub>TrPr</sub>: </td>
                            <td style="width:20%;"><input class="two2" type="number" id="params1" name="Temp" label="Input  t / oC" title="Input  t / oC" onblur="" disabled /></td>
                            <td style="width:10%;">&nbsp;</td>
                            <td class="one" style="width:25%;">σ<sub>w</sub> / A:</td>
                            <td style="width:20%;"><input class="two2" type="number" id="params5" name="Temp" label="Input  t / oC" title="Input  t / oC" onblur="" /></td>
                        </tr>
                        <tr>
                            <td class="one" style="width:25%;">S<sup>0</sup><sub>TrPr</sub>: </td>
                            <td style="width:20%;"><input class="two2" type="number" id="params2" name="Temp" label="Input  t / oC" title="Input  t / oC" onblur="" disabled /></td>
                            <td style="width:10%;">&nbsp;</td>
                            <td class="one" style="width:25%;">C / JK<sup>-1</sup>:</td>
                            <td style="width:20%;"><input class="two2" type="number" id="params6" name="Temp" label="Input  t / oC" title="Input  t / oC" onblur="" /></td>
                        </tr>
                        <tr>
                            <td class="one" style="width:25%;">A / Jbar<sup>-1</sup>: </td>
                            <td style="width:20%;"><input class="two2" type="number" id="params3" name="Temp" label="Input  t / oC" title="Input  t / oC" onblur="" /></td>
                            <td style="width:10%;">&nbsp;</td>
                            <td class="one" style="width:25%;">p / D:</td>
                            <td style="width:20%;"><input class="two2" type="number" id="params7" name="Temp" label="Input  t / oC" title="Input  t / oC" onblur="" /></td>
                        </tr>
                        <tr>
                            <td class="one" style="width:25%;">σ<sub>l</sub> /  A: </td>
                            <td style="width:20%;"><input class="two2" type="number" id="params4" name="Temp" label="Input  t / oC" title="Input  t / oC" onblur="" /></td>
                            <td style="width:10%;">&nbsp;</td>
                            <td class="one" style="width:25%;">z:</td>
                            <td style="width:20%;"><input class="two2" type="number" id="params8" name="Temp" label="Input  t / oC" title="Input  t / oC" onblur="" disabled/></td>
                        </tr>
                        

                    </table>

                </fieldset>
        </div>
        <div id="wrap2">
            <div id="stepTable"></div>
        </div>
    </div>
 
    <div id="Gibbs2" class="tabcontent">
        hello
    </div>
    <div id="ionization" class="tabcontent">
        <h3>Ionization Calculator</h3>
        <div id="wrap">
            <br>
            Calculate dissociation constant of water, Saturation Pressure and Density
            <p>Select Temperature between 0-800 <sup>o</sup>C, Pressure between 1-10000 Bar, and Density between 0-1.25 g/cm<sup>3</sup></p>
            <div role="main">
                <div class="left" role="form">
                    <fieldset id="fd1">
                        <legend>Input options</legend>
                        <form action="" method="get" name="input">
                            <input type="radio" name="inputselector" value="0" id="PT" onclick="chooseConditions()" />
                            <label for="PT"><em>t&#8212;P</em>: p<em>K</em>w at a given <em>t</em>-<em>P</em></label></br>
                            <input type="radio" name="inputselector" value="1" id="ROT" onclick="chooseConditions()" />
                            <label for="ROT"><em>t</em>&#8212;<em>&rho;</em><sub>H2O</sub>: p<em>K</em>w at a given <em>t</em>-<em>&rho;</em><sub>H2O</sub></label></br>
                            <input type="radio" name="inputselector" value="2" id="T" onclick="chooseConditions()" />
                            <label for="T"><em>t</em>: p<em>K</em>w at saturation conditions</label></br><br>
                            <!-- Abhinav's Code-->
                            <table role="presentation">
                                <tr>
                                    <td class="one"><em>t</em> / <sup>o</sup>C:</td>
                                    <td><input class="two" type="number" id="Temp" name="Temp" label="Input  t / oC" title="Input  t / oC" onblur="" /></td>
                                </tr>
                                <tr>
                                    <td class="one"><em>P</em> / bar</td>
                                    <td><input class="two" type="number" id="Pres" label="Input P / bar" title="Input P / bar" onblur="" /></td>
                                </tr>
                                <tr>
                                    <td class="one"><em>&rho;</em><sub>H2O</sub> / g cm<sup>-3</sup></td>
                                    <td><input class="two" type="number" id="Dens" label="Input ρH2O / g cm-3" title="Input ρH2O / g cm-3" onblur="" /></td>
                                </tr>

                            </table>

                        </form>
                    </fieldset>
                </div>

                <div class="right">
                    <fieldset id="fd2">
                        <legend>Outputs</legend>
                        <table role="presentation">
                            <tr>
                                <td class="one">p<em>K</em>w<sub>(sc or use <em>&rho;</em>)</sub></td>
                                <td><Input class="two" id="Pkw" label="Input pKw(sc or use ρ)" title="Input pKw(sc or use ρ)" onblur=" "></td>
                            </tr>
                            <tr>
                                <td class="one">p<em>K</em>w<sub>(l)</sub></td>
                                <td><Input class="two" id="Pkwl" label="Input pKw(l)" title="Input pKw(l)" onblur=" "></td>
                            </tr>
                            <tr>
                                <td class="one">p<em>K</em>w<sub>(v)</sub></td>
                                <td><Input class="two" id="Pkwv" label="Input pKw(v)" title="Input pKw(v)" onblur=" "></td>
                            </tr>
                            <tr>
                                <td class="one"><em>P</em><sub>sat</sub> / bar</td>
                                <td><Input class="two" id="Psat" label="Input Psat / bar" title="Input Psat / bar" onblur=" "></td>
                            </tr>
                            <tr>
                                <td class="one"><em>&rho;</em><sub>H2O(sc)</sub> / g cm<sup>-3</sup></td>
                                <td><Input class="two" id="scDens" label="Input ρH2O(sc) / g cm-3" title="Input ρH2O(sc) / g cm-3" onblur=" "></td>
                            </tr>
                            <tr>
                                <td class="one"><em>&rho;</em><sub>H2O(l)</sub> / g cm<sup>-3</sup></td>
                                <td><Input class="two" id="LiqDens" label="Input ρH2O(l) / g cm-3" title="Input ρH2O(l) / g cm-3" onblur=" "></td>
                            </tr>
                            <tr>
                                <td class="one"><em>&rho;</em><sub>H2O(v)</sub> / g cm<sup>-3</sup></td>
                                <td><Input class="two" id="VapDen" label="Input ρH2O(v) / g cm-3" title="Input ρH2O(v) / g cm-3" onblur=" "></td>
                            </tr>

                        </table>
                    </fieldset>

                </div>


                <div style="width: 100px; height: 270px; border: 1px solid transparent;">
                    &nbsp;
                </div>

            </div>


        </div>

    </div>

    <br>
    <div class="buttons">
        <button type="button" onclick="reSet()">Reset</button>
        <button type="button" onclick="ajaxPostBulk()">Calculate</button>
    </div>
    <br>
    <div id="references">
        <h3 style="text-align: left; transform: translate(26%, 0);">Acknowledgements</h3>
        <p class="reference-text"> 1. Lvov, S. N., Hall, D. M., Bandura, A. V., Gamwo, I. K. (2018). A semi-empirical molecular statistical thermodynamic model for calculating standard molar Gibbs energies of aqueous species above and below the critical point of water. <em>Journal of Molecular Liquids</em>, 270, 62-73.<br><br>
            2. Bandura A.V. and Lvov S. N. (2006), The ionization constant of water over wide ranges of temperature and density, <em>J. Phys. Chem. Ref. Data</em>., 35, 15-30.<br><br>
            3. Cooper, J.P. and Dooley R.B. (2007), Release on the ionization constant of H<sub>2</sub>O, <em>The International Association for the Properties of Water and Steam</em>, Lucerne, Switzerland, 7 pages.<br><br>
            4. Lvov S. N. and Harvey A. H. , Ionization constant of water, Chapter 5-70-71, <em>CRC Handbook of Chemistry and Physics</em>, 92<sup>nd</sup> Edition.</p>

        <br>
        <p class="reference-text">
            *Haining Zhao has designed and programmed the functionalities for calculating the Dissociation constant of water, Saturation Pressure, and Density in different phases.
        </p>

        <center>
            <img src="NETL-logo.png" width="200" style="margin-right: 10px;">
            <img src="penn-state-logo.png" width="200">
        </center>

    </div>



</body>

</html>