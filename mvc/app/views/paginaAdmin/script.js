var contor = 1;
var counter = 5;
function setNumberEvents(value) {
  /* functie cu rol in setarea numarului de evenimente arata unui administrator */
  counter = parseInt(value);
  listEvents(contor, cfunction);
}
function trateazaEvent() {
  var object = {};
  object.id = input;
  let message = `{ "id": "${String.fromCharCode(input)}"}`;
  let request = new Request("URL", {
    method: "GET",
    body: JSON.stringify(message),
    headers: {},
  });
  fetch(request)
    .then((response) => {
      let contentType = response.headers.get("Content-Type");
      if (contentType && contentType.includes("application/json")) {
        return response.json();
      }
      throw new TypeError("Datele primite nu-s JSON :(\n murim cu gratie");
    })
    .then((json) => {
      console.log(json);
    })
    .catch((err) => console.error(err));
}

function sendData() {
  var input = document.getElementById("idvalue").value;
  if (!input) alert("Introduceti o valoare!");
  else {
    //aici de fapt facem susta cand avem input smh


    const URL = "../../controllers/updateEventController.php"
    var object = {};
    object.id = input;
    let request = new Request(URL, {
      method: "POST",
      body: JSON.stringify(object),
      headers: { "Content-Type": "application/json" },
    });
    fetch(request)
      .then((response) => {
        let contentType = response.headers.get("Content-Type");
        console.log(response);
        console.log(contentType);
        if (contentType && contentType === "application/json") {
          return response.json();
        }
        throw new TypeError("Datele primite nu-s JSON :(\n murim cu gratie");
      })
      .then((json) => {
        console.log(json);
      })
      .catch((err) => console.error(err));

    // fetch("",{
    //     method : "GET",
    //     body: JSON.stringify(object),
    //     headers:{}
    // })
    // .then(res=> res.json);
  }
}

function arataAdaugaEveniment() {
  document.getElementById("removeEvent").style.display = "none";
  document.getElementById("updateEvent").style.display = "none";
  document.getElementById("formAddEvent").style.display = "block";
  var list = document.getElementById("list-events");
  list.textContent =
    ""; /*nu este eficient deoarece face apel la parser-ul din browser*/
  contor = 1;
}
function arataStergeEveniment() {
  document.getElementById("formAddEvent").style.display = "none";
  document.getElementById("updateEvent").style.display = "none";
  document.getElementById("removeEvent").style.display = "block";
}
function arataModificaEveniment() {
  document.getElementById("formAddEvent").style.display = "none";
  document.getElementById("updateEvent").style.display = "block";
  document.getElementById("removeEvent").style.display = "none";
}

function cfunction(response, start){

  var list = document.getElementById("list-events");
  list.textContent = "";
  var obj_response = JSON.parse(response);
  console.log("JSON: " + obj_response[0]);
  var j=0;
  for (let i = start; i < start + counter; i++) {
    var div_eveniment = document.createElement("div");
    div_eveniment.style.display = "flex";
    div_eveniment.style.flexDirection = "row";

    var checkbox_to_remove = document.createElement("input");
    checkbox_to_remove.setAttribute("type", "checkbox");

    var eveniment_terro = document.createElement("em");
    eveniment_terro.appendChild(
      document.createTextNode("Evenimentul cu id-ul " + obj_response[j].eventid + " de la data de " + obj_response[j].iday + '/' + obj_response[j].imonth + '/' + obj_response[j].iyear + " in " + obj_response[j].country_txt)
      //document.createTextNode("Evenimentu cu num " + i)
    );
    
    j++;
    div_eveniment.appendChild(checkbox_to_remove);
    div_eveniment.appendChild(eveniment_terro);

    var entry = document.createElement("li");
    entry.appendChild(div_eveniment);
    list.appendChild(entry);
  }
}

function listEvents(start, cfunction) {
  /**
   * functie ce afiseaza evenimentele din baza de date de la un indice/start dat
   */
   var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        console.log("merge pana aici");
        console.log(this.responseText);
        cfunction(this.responseText, start);
      }
    }
      xhttp.open("GET", "lista_evenimente.php?start=" + start + '&counter=' + counter, true);
      xhttp.send();

  /*for (let i = start; i < start + counter; i++) {
    var div_eveniment = document.createElement("div");
    div_eveniment.style.display = "flex";
    div_eveniment.style.flexDirection = "row";

    var checkbox_to_remove = document.createElement("input");
    checkbox_to_remove.setAttribute("type", "checkbox");

    var eveniment_terro = document.createElement("em");
    eveniment_terro.appendChild(
      document.createTextNode("Eveniment numar " + i)
    );

    div_eveniment.appendChild(checkbox_to_remove);
    div_eveniment.appendChild(eveniment_terro);

    var entry = document.createElement("li");
    entry.appendChild(div_eveniment);
    list.appendChild(entry);
  } */
}

function showEvents(flowDirection) {
  /**
   * functie cu rol in setarea indexului de start de afisare al evenimentelor
   */
  if (flowDirection === "forward") {
    contor = contor + counter;
  } else {
    contor = contor - counter;
  }

  if (contor < 0) {
    contor = 1;
  }
  listEvents(contor);
}
