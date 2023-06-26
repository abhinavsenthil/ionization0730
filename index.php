<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/strict.dtd">
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
        <title>The Ionization Constant of Water pKw≡-log10(Kw) computational tool</title>
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
                window.onload = function() 
                {
                    document.getElementById('Dens').value = '';
                    document.getElementById('Dens').disabled = true;
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
                    document.getElementById('Dilectric').value = '';
                    document.getElementById('Dilectric').disabled = true;
                    document.getElementById('PT').onchange = disablefield;
                    document.getElementById('ROT').onchange = disablefield;
                    document.getElementById('T').onchange = disablefield;
                    document.getElementById('PT2').onchange = disablefield;
                    document.getElementById('PT').checked = false;
                    document.getElementById('ROT').checked = false;
                    document.getElementById('T').checked = false;
                    document.getElementById('PT2').checked = false;
                    
                };
                function disablefield()
                {
                    if ( document.getElementById('PT').checked == true )
                    {
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
                        document.getElementById('Dilectric').value = '';
                        document.getElementById('Dilectric').disabled = true;;
                    }
                    else if (document.getElementById('ROT').checked == true )
                    {
                        document.getElementById('Pres').value = '';
                        document.getElementById('Pres').disabled = true; 
                        document.getElementById('Temp').value = '';
                        document.getElementById('Temp').disabled = false;
                        document.getElementById('Dens').disabled = false;
                        document.getElementById('Pkw').value = '';
                        document.getElementById('Pkw').disabled = false;
                        document.getElementById('Dilectric').value = '';
                        document.getElementById('Dilectric').disabled = true;
                        
                        
                        document.getElementById('scDens').value ='';
                        document.getElementById('scDens').disabled =true;
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
                    }
                    else if (document.getElementById('T').checked == true )
                    {
                        document.getElementById('Pres').value = '';
                        document.getElementById('Pres').disabled = true; 
                        document.getElementById('Temp').value = '';
                        document.getElementById('Temp').disabled = false;
                        document.getElementById('Dens').disabled = true;
                        document.getElementById('Pkw').value = '';
                        document.getElementById('Pkw').disabled = true;
                        document.getElementById('scDens').value ='';
                        document.getElementById('scDens').disabled =true;
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
                        document.getElementById('Dilectric').value = '';
                        document.getElementById('Dilectric').disabled = true;
                    }
                    else if ( document.getElementById('PT2').checked == true )
                    {
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
                        document.getElementById('Dilectric').value = '';
                        document.getElementById('Dilectric').disabled = false;
                    }
                }
        </script>
        <script>
                function reSet() 
                {
                    document.getElementById('Dens').value = '';
                    document.getElementById('Dens').disabled = true;
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
                    document.getElementById('Dilectric').value = '';
                    document.getElementById('Dilectric').disabled = true;
                    document.getElementById('PT').onchange = disablefield;
                    document.getElementById('ROT').onchange = disablefield;
                    document.getElementById('T').onchange = disablefield;
                    document.getElementById('PT').checked = false;
                    document.getElementById('ROT').checked = false;
                    document.getElementById('T').checked = false;
                }
        </script>
        <link rel="shortcut icon" type="image/x-icon" href="http://carbonlab.org/favicon.ico" />
    </head>
    <body>
            <p role="banner"><a href="/" title="Home"><img src="http://www.energy.psu.edu/sites/default/files/EI_Wordmark-web.png" alt="Home" width="392" height="54" /></a></p>
        <p align="center">
          <nav class="links" id="nav" role="navigation" aria-label="Navigation"><a href="http://www.energy.psu.edu" title="EMS Energy Institute">Home</a> |  <a href="http://www.energy.psu.edu/about.html" title="About the EMS Energy Institute">About Us</a> |  <a href="http://www.energy.psu.edu/research.html" title="EMS Energy Institute research">Research</a> |  <a href="http://www.energy.psu.edu/facilities.html" title="Facilities at the EMS Energy Institute">Facilities</a> |  <a href="http://www.energy.psu.edu/news.html" title="News &amp; publications of the EMS Energy Institute">News & Publications</a> |  <a href="http://www.energy.psu.edu/energyoutreach" title="Services of the EMS Energy Institute">Services</a> |  <a href="http://www.energy.psu.edu/osd/index.html" title="Office of Student Development">Students</a> |  <a href="http://www.energy.psu.edu/employeeinfo.html" title="EMS Energy Institute employees section">Employees</a> |  <a href="http://www.energy.psu.edu/sitemap" title="Site map of the EMS Enregy Institute">Site Map</a></nav>
        </p>
        <!--
        <nav>
            <a href="">Water Model</a> |
            <a href="">CO2 Model</a> |
            <a href="">CO2-Brine Model</a> |
            <a href="">Oil and Gas Model</a> |
            <a href="">DataBase</a>
        </nav>
        -->
        <h1>The Ionization Constant of Water</h1>
        <h2>p<em>K</em>w&equiv;-log<sub>10</sub>(<em>K</em>w)</h2>
        <h3>&#8212;&#8212; A web computational tool &#8212;&#8212;</h3>
        <div id="wrap">
            <p style="text-align:center">Negative logarithm (base 10) of the ionization constant of water, <em>K</em>w, can be <br> calculated at temperatures of 0-800 <sup>o</sup>C, pressures of 1-10000 bar, and densities of 0-1.25 g cm<sup>-3</sup></p>
            <p style="text-align:center; font-size:13px">The water properties are calculated by IAPWS-95 EOS (Wagner and Pruβ, 2002).</p>
                        <div role="main">
            <div class="left" role="form" >
                <fieldset id="fd1">
                    <legend>Input options</legend>
                        <form action="" method="get" name="input">
                            <input type="radio" name="inputselector" value="0" id="PT" onclick="chooseConditions()"/>
                            <label for="PT"><em>t&#8212;P</em>: p<em>K</em>w at a given <em>t</em>-<em>P</em></label></br>
                            <input type="radio" name="inputselector" value="1" id="ROT" onclick="chooseConditions()"/>
                            <label for="ROT"><em>t</em>&#8212;<em>&rho;</em><sub>H2O</sub>: p<em>K</em>w at a given <em>t</em>-<em>&rho;</em><sub>H2O</sub></label></br>
                            <input type="radio" name="inputselector" value="2" id="T" onclick="chooseConditions()"/>
                            <label for="T"><em>t</em>: p<em>K</em>w at saturation conditions</label></br>
                            <!-- Abhinav's Code-->
                            <input type="radio" name="inputselector" value="3" id="PT2" onclick="chooseConditions()"/>
                            <label for="PT2"><em>t&#8212;P</em>: <em>ε</em> at a given <em>t</em>-<em>P</em></label></br></br>
                            <table role="presentation">
                                <tr>
                                    <td class="one"><em>t</em> / <sup>o</sup>C:</td>
                                    <td><input class="two" type="number" id="Temp" name="Temp" label="Input  t / oC" title="Input  t / oC" onblur=""/></td>
                                </tr>
                                <tr>
                                    <td class="one"><em>P</em> / bar</td>
                                    <td><input class="two" type="number" id="Pres" label="Input P / bar" title="Input P / bar" onblur=""/></td>
                                </tr>
                                <tr>
                                    <td class="one"><em>&rho;</em><sub>H2O</sub> / g cm<sup>-3</sup></td>
                                    <td><input class="two" type="number" id="Dens" label="Input ρH2O / g cm-3" title="Input ρH2O / g cm-3" onblur=""/></td>
                                </tr>
                                <tr>
                                    <td class="one">Speices</td>
                                    <td>
                                    <select id="Species" name="Species">
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
                            <button type="button" onclick="reSet()" >Reset</button>
                            <button type="button" onclick="ajaxPost()" >Calculate</button>
                        </form>
                </fieldset>
            </div>
            <div class="right">
                <fieldset id="fd2">
                    <legend>Outputs</legend>
                        <table role="presentation">
                            <tr>
                                <td class="one" >p<em>K</em>w<sub>(sc or use <em>&rho;</em>)</sub></td>
                                <td><Input class="two" id="Pkw" label="Input pKw(sc or use ρ)" title="Input pKw(sc or use ρ)" onblur=" "></td>
                            </tr>
                            <tr>
                                <td class="one" >p<em>K</em>w<sub>(l)</sub></td>
                                <td><Input class="two" id="Pkwl" label="Input pKw(l)" title="Input pKw(l)" onblur=" "></td>
                            </tr>
                            <tr>
                                <td class="one" >p<em>K</em>w<sub>(v)</sub></td>
                                <td><Input class="two" id="Pkwv" label="Input pKw(v)" title="Input pKw(v)" onblur=" "></td>
                            </tr>
                            <tr>
                                <td class="one"><em>P</em><sub>sat</sub> / bar</td> 
                                <td><Input class="two" id="Psat" label="Input Psat / bar" title="Input Psat / bar" onblur=" "></td>  
                            </tr>
                            <tr>
                                <td class="one"><em>&rho;</em><sub>H2O(sc)</sub> / g cm<sup>-3</sup></td> 
                                <td><Input class="two" id="scDens" label="Input ρH2O(sc) / g cm-3" title="Input ρH2O(sc) / g cm-3"  onblur=" "></td>  
                            </tr>
                            <tr>
                                <td class="one"><em>&rho;</em><sub>H2O(l)</sub> / g cm<sup>-3</sup></td> 
                                <td><Input class="two" id="LiqDens" label="Input ρH2O(l) / g cm-3" title="Input ρH2O(l) / g cm-3" onblur=" "></td>  
                            </tr>
                            <tr>
                                <td class="one"><em>&rho;</em><sub>H2O(v)</sub> / g cm<sup>-3</sup></td> 
                                <td><Input class="two" id="VapDen" label="Input ρH2O(v) / g cm-3" title="Input ρH2O(v) / g cm-3" onblur=" "></td>  
                            </tr>
                            <tr>
                                <td class="one"><em>ε</em></td> 
                                <td><Input class="two" id="Dilectric" label="ε" title="Dilectric constant" onblur=" "></td>  
                            </tr>
                            <tr>
                                <td class="one">Δ<sub>f</sub> 𝐺<sup>0</sup><sub>j</sub> / kcal mol<sup>-1</sup></td>
                                <td><Input class="two" id="Gibbs" label="Input Δ𝑓 𝐺₀ⱼ / J" title="Input Δ𝑓 𝐺₀ⱼ / J" onblur=""></td>
                            </tr>

                        </table>
                </fieldset>
                <br> <br>
            </div>
        </div><br>
        <!-- <div id="footer" role="contentinfo">
                <p><br><br></p>
                <p style="margin-left:15px; margin-right:15px; font-size:13px">
                    <em>P</em>&#8212; pressure, bar<br>
                    p<em>K</em>w&#8212; negative logarithm (base 10) of the ionization constant of water<br>
                    <em>P</em><sub>sat</sub>&#8212; water saturation pressure, bar<br>
                    <em>t</em>&#8212; temperature, <sup>o</sup>C<br>
                    <em>&rho;</em><sub>H2O</sub>&#8212; density of water, g cm<sup>-3</sup><br>
                    <sub>(l)</sub>&#8212; liquid phase<br>
                    <sub>(v)</sub>&#8212; vapor phase<br>
                    <sub>(sc)</sub>&#8212; supercritical phase<br>
                </p><br>
                
                <p style="margin-left:15px;"><Strong>References</strong></p>
                <p style="margin-left:15px; margin-right:15px; font-size:13px">
                    1.  Bandura A.V. and Lvov S. N. (2006), The ionization constant of water over wide ranges of temperature and density, <em>J. Phys. Chem. Ref. Data</em>., 35, 15-30.<br>
                    2. Cooper, J.P. and Dooley R.B. (2007), Release on the ionization constant of H<sub>2</sub>O, <em>The International Association for the Properties of Water and Steam</em>, Lucerne, Switzerland, 7 pages.<br>
                    3. Lvov S. N. and Harvey A. H. , Ionization constant of water, Chapter 5-70-71, <em>CRC Handbook of Chemistry and Physics</em>, 92<sup>nd</sup> Edition.</p><br>
                
               
                <p p style="margin-left:15px; margin-right:15px; font-size:13px">
                    *Haining Zhao has designed and programmed this web computational tool.
                </p>
        </div><br><br> -->
       
    </body>
</html>
