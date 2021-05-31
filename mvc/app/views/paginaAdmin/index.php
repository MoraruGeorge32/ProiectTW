<?php
include 'verifica_provinienta.php';
?>
<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,
            initial-scale=1.0" />
    <title>Administrare aplicație</title>
    <link rel="stylesheet" href="./style.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
    <script src="./script.js"></script>
</head>

<body>
    <div id="main">
        <div id="leftside">
            <div id="topleftside">
                <!--Div pentru afisarea numelui unui utilizator-->
                <label> Hello, <?php echo $_SESSION['user']; ?> </label>
            </div>
            <div id="bodyleftside">
                <!--Div ca un panou de control. Administratorul-->
                <div>
                    <div id="adaugareBtn" class="action" onclick="arataAdaugaEveniment()">
                        Adaugare event
                    </div>
                    <div id="stergereBtn" class="action" onclick="arataStergeEveniment()">
                        Stergere event
                    </div>
                    <div id="updateBtn" class="action" onclick="arataModificaEveniment()">
                        Update event
                    </div>
                </div>
                <a id="btn" href="delogare.php">
                    <div id="delog">
                        <div id="delogare">
                            <span>Delogare</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div id="rightside">
            <div id="toprightside">
                <div id="title-page">
                    <h1>
                        TerroViz : administrare
                    </h1>
                </div>
            </div>

            <div id="bodyrightside">
                <!--Div dedicat unu meniu pentru perfomarea diferitelor actiuni-->
                <div id="eventZone">
                    <div id="formAddEvent">
                        <!-- <iframe name="response"></iframe> -->
                        <!---
                            <form id="formAdaugare" 
                            method="GET" 
                            action="../../controllers//AdminDataBaseControllers/requestAddEventController.php">
                        -->
                        <form id="AdaugareEvent">
                            <div id="formAdaugareDiv">
                                <div id="dateEvent">
                                    <label>Data evenimentului</label>
                                    <br>
                                    <br>
                                    <label for="year">
                                        An:
                                    </label>
                                    <br>
                                    <input type="number" value="1970" id="year" name="iyear">
                                    <br>
                                    <label for="month">
                                        Luna (numeric):
                                    </label>
                                    <br>
                                    <input value="1" type="number" id="month" name="imonth">
                                    <br>
                                    <label for="day">
                                        Zi (numeric):
                                    </label>
                                    <br>
                                    <input value="1" type="number" id="day" name="iday">
                                    <br>
                                </div>

                                <div id="locationEvent">
                                    <label>Locul evenimentului</label>
                                    <br>
                                    <br>
                                    <label for="country">
                                        Țară:
                                    </label>
                                    <br>
                                    <input value="Tara" type="text" id="country" name="country_txt">
                                    <br>
                                    <label for="region">
                                        Regiune:
                                    </label>
                                    <br>
                                    <input value="regiune" type="text" id="region" name="region_txt">
                                    <br>
                                    <label for="city">
                                        Oraș:
                                    </label>
                                    <br>
                                    <input value="oras" type="text" id="city" name="city">
                                    <br>
                                    <label for="latitude">
                                        latitudine:
                                    </label>
                                    <br>
                                    <input value="1" type="text" id="latitude" name="latitude">
                                    <br>
                                    <label for="longitude">
                                        Longitudine:
                                    </label>
                                    <br>
                                    <input value="1" type="text" id="longitude" name="longitude">
                                    <br>
                                </div>

                                <div id="clasificareEvent">
                                    <label>Tipul de atac</label>
                                    <br>
                                    <br>
                                    <label for="suicide">Suicid</label>
                                    <br>
                                    <select id="suicide" name="suicide">
                                        <option value="da">Da</option>
                                        <option value="nu">Nu</option>
                                    </select>
                                    <br>
                                    <label for="extended">Extins pe mai mult de 24h?</label>
                                    <br>
                                    <select id="extended" name="extended">
                                        <option value="da">Da</option>
                                        <option value="nu">Nu</option>
                                    </select>
                                    <br>
                                    <label for="type">Tipul eveniment</label>
                                    <br>
                                    <input value="tip" type="text" id="type" name="attacktype1_txt">
                                    <br>
                                    <label for="target">Țintă eveniment</label>
                                    <br>
                                    <input value="tinta" type="text" id="target" name="targsubtype1_txt">
                                    <br>
                                    <label for="success">A avut succes?</label>
                                    <br>
                                    <select id="success" name="success">
 u                                       <option value="da">Da</option>
                                        <option value="nu">Nu</option>
                                    </select>
                                    <br>
                                    <label for="tip_arma"> Tipul armei</label>
                                    <br>
                                    <input value="tip arma" type="text" id="weaptype1_txt" name="weaptype1_txt">
                                    <br>
                                    <label for="nr_ucisi"> Numărul persoanelor ucise</label>
                                    <br>
                                    <input value="1" type="number" id="nkill" name="nkill">
                                    <br>
                                    <label for="nr_raniti"> Numărul persoanelor rănite</label>
                                    <br>
                                    <input value="1" type="number" id="nwound" name="nwound">
                                    <br>
                                </div>
                                <div id="atacator">
                                    <label>Autorii atacului terorist</label>
                                    <br>
                                    <br>
                                    <label for="gname">Numele grupului terorist</label>
                                    <br>
                                    <input value="numele grupului terorist" type="text" id="gname" name="gname">
                                    <br>
                                    <label for="motive"> Motivul </label>
                                    <br>
                                    <input value="motiv" type="text" id="motive" name="motive">
                                    <br>
                                    <label for="nr_teroristi">Numărul total de teroriști implicați</label>
                                    <br>
                                    <input value="1" type="number" id="nperps" name="nperps">
                                    <br>
                                </div>
                            </div>
                            <!--Div pentru plasarea butonului de submit in a doua coloana din grid-->
                            <div id="submitBtn">
                                <button type="button" onclick="sendDataAdd()" class="glow-on-hover">
                                    Adauga eveniment
                                </button>
                            </div>
                        </form>
                    </div>
                    <div id="removeEvent">
                        <p>Lista evenimente </p>
                        <form id="countElements" method="POST" action="../../controllers/AdminDataBaseControllers/requestDeleteEventController.php">
                            <input type="radio" id="5elements" value="5" name="chooseCounter" onclick="setNumberEvents(value)">
                            <label for="5elements">5 evenimente</label><br>
                            <input type="radio" id="10elements" value="10" name="chooseCounter" onclick="setNumberEvents(value)">
                            <label for="10elements">10 evenimente</label><br>
                            <input type="radio" id="15elements" value="15" name="chooseCounter" onclick="setNumberEvents(value)">
                            <label for="15elements">15 evenimente</label><br>
                            <!--lista de evenimente teroriste din baza de date-->
                            <ol id="list-events">
                            </ol>

                            <div id="butoaneMeniuStergere">
                                <button type="button" id="backward" onclick="showEvents(id)">Evenimente
                                    mai vechi</button>
                                <button type="submit" value="">Stergeti evenimentele
                                    selectate</button>
                                <button type="button" id="forward" onclick="showEvents(id)">Evenimente
                                    mai noi</button>

                            </div>
                        </form>

                    </div>
                    <div id="updateEvent">

                        <div id="dateShow">
                            <div class="labels">
                                <label>ID</label>
                                <label>Country</label>
                                <label>Region</label>
                                <label>Date</label>
                                <label>Edit Option</label>  
                            </div>
                            <div class="updateRow">
                                <p>Bla</p>
                                <p>BlaBla</p>
                                <p>BlaBlaBla</p>
                                <p>BlaBlaBlaBla</p>
                                <button class="editButton">Edit</button>
                            </div>
                            <div class="updateRow">
                                <p>Bla</p>
                                <p>BlaBla</p>
                                <p>BlaBlaBla</p>
                                <p>BlaBlaBlaBla</p>
                                <button class="editButton">Edit</button>
                            </div>
                            <div class="updateRow">
                                <p>Bla</p>
                                <p>BlaBla</p>
                                <p>BlaBlaBla</p>
                                <p>BlaBlaBlaBla</p>
                                <button class="editButton">Edit</button>
                            </div>
                            <div class="updateRow">
                                <p>Bla</p>
                                <p>BlaBla</p>
                                <p>BlaBlaBla</p>
                                <p>BlaBlaBlaBla</p>
                                <button class="editButton">Edit</button>
                            </div>
                            <div class="updateRow">
                                <p>Bla</p>
                                <p>BlaBla</p>
                                <p>BlaBlaBla</p>
                                <p>BlaBlaBlaBla</p>
                                <button class="editButton">Edit</button>
                            </div>
                            <div class="updateRow">
                                <p>Bla</p>
                                <p>BlaBla</p>
                                <p>BlaBlaBla</p>
                                <p>BlaBlaBlaBla</p>
                                <button class="editButton">Edit</button>
                            </div>
                            <div class="updateRow">
                                <p>Bla</p>
                                <p>BlaBla</p>
                                <p>BlaBlaBla</p>
                                <p>BlaBlaBlaBla</p>
                                <button class="editButton">Edit</button>
                            </div>
                            <div class="updateRow">
                                <p>Bla</p>
                                <p>BlaBla</p>
                                <p>BlaBlaBla</p>
                                <p>BlaBlaBlaBla</p>
                                <button class="editButton">Edit</button>
                            </div>
                            <div class="updateRow">
                                <p>Bla</p>
                                <p>BlaBla</p>
                                <p>BlaBlaBla</p>
                                <p>BlaBlaBlaBla</p>
                                <button class="editButton">Edit</button>
                            </div>
                            <div class="updateRow">
                                <p>Bla</p>
                                <p>BlaBla</p>
                                <p>BlaBlaBla</p>
                                <p>BlaBlaBlaBla</p>
                                <button class="editButton">Edit</button>
                            </div>
                            <div class="updateRow">
                                <p>Bla</p>
                                <p>BlaBla</p>
                                <p>BlaBlaBla</p>
                                <p>BlaBlaBlaBla</p>
                                <button class="editButton">Edit</button>
                            </div>
                            <div class="updateRow">
                                <p>Bla</p>
                                <p>BlaBla</p>
                                <p>BlaBlaBla</p>
                                <p>BlaBlaBlaBla</p>
                                <button class="editButton">Edit</button>
                            </div>
                            <div class="updateRow">
                                <p>Bla</p>
                                <p>BlaBla</p>
                                <p>BlaBlaBla</p>
                                <p>BlaBlaBlaBla</p>
                                <button class="editButton">Edit</button>
                            </div>
                            <div class="updateRow">
                                <p>Bla</p>
                                <p>BlaBla</p>
                                <p>BlaBlaBla</p>
                                <p>BlaBlaBlaBla</p>
                                <button class="editButton">Edit</button>
                            </div>
                            <div class="updateRow">
                                <p>Bla</p>
                                <p>BlaBla</p>
                                <p>BlaBlaBla</p>
                                <p>BlaBlaBlaBla</p>
                                <button class="editButton">Edit</button>
                            </div>
                        </div>
                        <div class="submitAndPage">
                            <button onclick="decreasePage()"> &lt;&lt;Previous </button>
                            <div class="showPage"> 
                                <input onkeypress="receiveEvents(event)" id="numPage" value="1" >
                            </div>
                            <button onclick="increasePage()"> Next&gt;&gt; </button> 
                        </div>








                        <!-- <label for="idEventModif">Introduceti ID-ul evenimentului pe care il doriti schimbat</label>
                        <input id="idvalue" name="idEventModif" type="text" placeholder="id eveniment">
                        <br>
                        <button onclick="sendDataUpdate()"> Cautați eveniment </button>
                        <div id="eventGasit" style="display:none"> -->
                            <!--
                                initial display none
                            de pus aici info returnat de la request
                            daca ii gasit aratam idk valorile si coloanele
                            -->

                            <!-- <button onclick="baga_input_pereche()">Adaugati campuri + valori ce doriti a fi actualizate</button>

                        </div>
                        <div id="eventNotFound" style="display:none">
                            
                            la fel initial display none
                            nasol man nu s-o gasit-->
                            <!-- <p>Evenimentul nu a fost gasit</p> -->
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>