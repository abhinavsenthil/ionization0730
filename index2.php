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
    <title>Gibbs energy calculator</title>
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

        var TABNAME = "Gibbs";

        function openCalc(evt, calcName, isParams = false, tabName) {
            
            TABNAME = tabName;

            if(tabName === 'Gibbs'){
                document.getElementById('SpeciesBlock').style.display = "block";
                document.getElementById('fd7').style.display = "block";
                document.getElementById('calculatorTitle').innerHTML = '<h3> Gibbs Energy Calculator </h3>';
            }
            else{
                document.getElementById('SpeciesBlock').style.display = "none";
                
            }
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

            // doing this for changing the heading of the calculator - december 4
            if(tabName === 'GibbsWithParam'){
                document.getElementById('calculatorTitle').innerHTML = '<h3> Gibbs Energy Calculator (custom) </h3>';
                document.getElementById('fd7').style.display = "none";
                
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

    <h1 class="three-titles"> Thermodynamic Properties of Aqueous Species at Elevated Temperatures and Pressures</h1>
    <h3 class="three-titles">&#8212;&#8212; A web computational tool &#8212;&#8212;</h3>
    <h4 style="text-align:center; width:720px; margin:auto; color:black; ">This computational tool provides the standard Gibbs energy of formation (Δ<sub>f</sub> 𝐺<sup>0</sup><sub>j</sub>), the dielectric constant of water (<em>ε</em>) and ionization constant of water (<em>K</em><sub>w</sub>) of several aqueous species over a wide range of temperatures (<em>t</em>), pressures (<em>P</em>), and densities (<em>&rho;</em>) above and below the critical point of water. </h4>
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
        <button class="tablinks" onclick="openCalc(event, 'Gibbs1', false, 'Gibbs')" style="width:30%;">Gibbs Energy Calculator</button>
        <button class="tablinks" onclick="openCalc(event, 'Gibbs1', true, 'GibbsWithParam')" style="width:30%;">Gibbs Energy Calculator (Custom)</button>
        <button class="tablinks" onclick="openCalc(event, 'ionization', false, 'Ionization')" style="width:30%;">Ionization Constant Calculator</button>
    </div>
    <br>
    <div id="Gibbs1" class="tabcontent">
        <div id="calculatorTitle">
            <h3>Gibbs Energy Calculator</h3>
        </div>
        <div id="wrap3">
            <p>Enter Pressures between 1-4000 bar, Temperatures between 0-600 <sup>o</sup>C, and Densities above 0.4 g cm<sup>-3</sup></p>
            

            <div class="bottom-left">

                <fieldset id="fd7">
                    <legend><b>Step 1:</b> Select A Species</legend>

                    <table role="presentation" style="display:flex;justify-content: center;">
                        <tr>
                            <td>
                                <div id="SpeciesBlock">
                                Species:
                                <select id="Species" name="Species" onchange="loadDynamicParams(this.value)">
                                    <option value="Select_One">Select One</option>
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
                                </div>
                            </td>
                        </tr>
                    </table>
                    
                </fieldset>

                <fieldset id="fd3">
                    <legend><b>Step 2a:</b> Select Options</legend>

        
                    
                    <form action="" method="get" name="input">
                        <input type="radio" name="inputselector" value="3" id="PT2" onclick="chooseConditions(this)" />
                        <label for="PT2">Δ<sub>f</sub> 𝐺<sup>0</sup><sub>j</sub> at a given <em>t</em>-<em>P</em></label><br>

                        <input type="radio" name="inputselector" value="4" id="PD2" onclick="chooseConditions(this)" />
                        <label for="PD2">Δ<sub>f</sub> 𝐺<sup>0</sup><sub>j</sub> on saturation curve</label><br>

                    </form>

                    
                    <table role="presentation">
                        <tr>
                            <td class="one"><em>t</em> / <sup>o</sup>C:</td>
                            <td><input class="two" type="number" id="Gibbs-Temp" name="Temp" label="Input  t / oC" title="Input  t / oC" onblur="" onkeyup="validateUserInputs()"/></td>
                        </tr>
                        <tr>
                            <td class="one"><em>P</em> / bar</td>
                            <td><input class="two" type="number" id="Gibbs-Pres" label="Input P / bar" title="Input P / bar" onblur="" onkeyup="validateUserInputs()"/></td>
                        </tr>
                        <tr>
                            <td class="one"><em>ρ</em><sub>H2O</sub>(l) / g cm<sup>-3</sup></td>
                            <td><input class="two" type="number" id="Gibbs-Dens" label="Input density" title="Input density" onblur="" /></td>
                        </tr>

                    </table>
                </fieldset>

                <!-- <fieldset id="fd5">
                    

                </fieldset> -->
            </div>

            <div class="bottom-right">
                <fieldset id="fd4">
                    <legend><b>Step 2b:</b> Define the Range</legend>
                    <form action="" method="get" name="input">
                        <form action="" method="get" name="input">

                            <input type="radio" name="inputselector" value="5" id="PT3" onclick="chooseConditions(this)" />
                            <label for="PT3">Range of Δ<sub>f</sub> 𝐺<sup>0</sup><sub>j</sub></label></br>

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

            <!-- <div class="bottom-left">
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
                            <td class="one"><em>ρ</em>H2O(l) / g cm<sup>-3</sup></td>
                            <td><input class="two" type="number" id="Gibbs-Dens" label="Input density" title="Input density" onblur="" /></td>
                        </tr>

                    </table>

                </fieldset>
            </div> -->

        </div>

        <br>


        <div id="param-display" class="param">
                <fieldset id="fd5_param">
                    <legend>Set Parameters</legend>
                    <table role="presentation">
                        <tr>
                            <td class="one" style="width:25%;">Δ<sub>f</sub>G<sup>0</sup><sub>TrPr</sub>: </td>
                            <td style="width:20%;"><input class="two2" type="number" id="params1" name="Temp" label="Input  t / oC" title="Input  t / oC" onblur="" /></td>
                            <td style="width:10%;">&nbsp;</td>
                            <td class="one" style="width:25%;">σ<sub>w</sub> / A:</td>
                            <td style="width:20%;"><input class="two2" type="number" id="params5" name="Temp" label="Input  t / oC" title="Input  t / oC" onblur="" /></td>
                        </tr>
                        <tr>
                            <td class="one" style="width:25%;">ΔS<sub>j</sub><sup>0</sup><sub>TrPr</sub>: </td>
                            <td style="width:20%;"><input class="two2" type="number" id="params2" name="Temp" label="Input  t / oC" title="Input  t / oC" onblur="" /></td>
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
                            <td style="width:20%;"><input class="two2" type="number" id="params8" name="Temp" label="Input  t / oC" title="Input  t / oC" onblur=""/></td>
                        </tr>
                        

                    </table>

                </fieldset>
        </div>
        <br>
        <div id="error_message" style="color:red; text-align:center;"></div>
        <br>
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
            Calculate Ionization constant of water, Saturation Pressure and Density
            <p>Select Temperature between 0-800 <sup>o</sup>C, Pressure between 1-10000 Bar, and Density between 0-1.25 g/cm<sup>3</sup></p>
            <div role="main">
                <div class="left" role="form">
                    <fieldset id="fd1">
                        <legend>Input options</legend>
                        <form action="" method="get" name="input">
                            <input type="radio" name="inputselector" value="0" id="PT" onclick="chooseConditions(this)" />
                            <label for="PT"><em>t&#8212;P</em>: p<em>K</em>w at a given <em>t</em>-<em>P</em></label></br>
                            <input type="radio" name="inputselector" value="1" id="ROT" onclick="chooseConditions(this)" />
                            <label for="ROT"><em>t</em>&#8212;<em>&rho;</em><sub>H2O</sub>: p<em>K</em>w at a given <em>t</em>-<em>&rho;</em><sub>H2O</sub></label></br>
                            <input type="radio" name="inputselector" value="2" id="T" onclick="chooseConditions(this)" />
                            <label for="T"><em>t</em>: p<em>K</em>w on saturation curve</label></br><br>
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
        <button type="button" id="calculate_button" onclick="ajaxPostBulk()">Calculate</button>
    </div>
    <br>
    <br>
    <div id="references">
        <h3 style="text-align: center;">References</h3>
        <p class="reference-text"> 1. Lvov, S. N., Hall, D. M., Bandura, A. V., Gamwo, I. K. (2018). A semi-empirical molecular statistical thermodynamic model for calculating standard molar Gibbs energies of aqueous species above and below the critical point of water. <em>Journal of Molecular Liquids</em>, 270, 62-73.<br><br>
            2. Bandura A.V. and Lvov S. N. (2006), The ionization constant of water over wide ranges of temperature and density, <em>J. Phys. Chem. Ref. Data</em>., 35, 15-30.<br><br>
            3. Derek M. Hall, Serguei N. Lvov, Andrzej Anderko, Isaac K. Gamwo (2023), Modeling aqueous association constants and mineral solubilities at subcritical and supercritical temperatures, <em>Journal of Molecular Liquids</em>, Volume 390, Part B, 2023.
        </p>
        <br>
        <h3 style="text-align: center;">Acknowledgements</h3>
        <p class="reference-text">
            *Haining Zhao has designed and programmed the functionalities for calculating the dissociation constant of water, saturation pressure, and density in different phases.
        </p>

        <center>
            <img src="NETL-logo.png" width="200" style="margin-right: 10px;">
            <img src="penn-state-logo.png" width="200">
        </center>

    </div>



</body>

</html>