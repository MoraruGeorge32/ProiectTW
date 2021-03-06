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
                        <form id="formAdaugare">
                            <div id="dateEvent">
                                <label>Data evenimentului</label>
                                <br>
                                <br>
                                <label for="year">
                                    An:
                                </label>
                                <br>
                                <input type="text" id="year">
                                <br>
                                <label for="year">
                                    Luna (numeric):
                                </label>
                                <br>
                                <input type="text" id="month">
                                <br>
                                <label for="month">
                                    Zi (numeric):
                                </label>
                                <br>
                                <input type="text" id="day">
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
                                <input type="text" id="country">
                                <br>
                                <label for="region">
                                    Regiune:
                                </label>
                                <br>
                                <input type="text" id="region">
                                <br>
                                <label for="city">
                                    Oraș:
                                </label>
                                <br>
                                <input type="text" id="city">
                                <br>
                                <label for="latitude">
                                    latitudine:
                                </label>
                                <br>
                                <input type="text" id="latitude">
                                <br>
                                <label for="longitude">
                                    Longitudine:
                                </label>
                                <br>
                                <input type="text" id="longitude">
                                <br>
                                <label for="vecinity">
                                    Vecinătate:
                                </label>
                                <br>
                                <input type="text" id="vecinity">
                                <br>
                            </div>
                            <div id="clasificareEvent">
                                <label>Tipul de atac</label>
                                <br>
                                <br>
                                <label for="suicide">Suicid</label>
                                <br>
                                <select id="suicide">
                                    <option value="da">Da</option>
                                    <option value="nu">Nu</option>
                                </select>
                                <br>
                                <label for="type">Tipul eveniment</label>
                                <br>
                                <input type="text" id="type">
                                <br>
                                <label for="target">Țintă eveniment</label>
                                <br>
                                <input type="text" id="target">
                                <br>
                            </div>
                            <div></div>
                            <!--Div pentru plasarea butonului de submit in a doua coloana din grid-->
                            <div id="submitBtn">
                                <button onclick="" class="glow-on-hover">
                                    Adauga eveniment </button>
                            </div>
                        </form>
                    </div>
                    <div id="removeEvent">
                        <p>Lista evenimente </p>
                        <form id="countElements">
                            <input type="radio" id="5elements" value="5" name="chooseCounter" onclick="setNumberEvents(value)">
                            <label for="5elements">5 evenimente</label><br>
                            <input type="radio" id="10elements" value="10" name="chooseCounter" onclick="setNumberEvents(value)">
                            <label for="10elements">10 evenimente</label><br>
                            <input type="radio" id="15elements" value="15" name="chooseCounter" onclick="setNumberEvents(value)">
                            <label for="15elements">15 evenimente</label><br>
                        </form>
                        <!--lista de evenimente teroriste din baza de date-->
                        <ol id="list-events">
                        </ol>

                        <div id="butoaneMeniuStergere">
                            <button type="button" id="backward" onclick="showEvents(id)">Evenimente
                                mai vechi</button>
                            <button type="button">Stergeti evenimentele
                                selectate</button>
                            <button type="button" id="forward" onclick="showEvents(id)">Evenimente
                                mai noi</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>