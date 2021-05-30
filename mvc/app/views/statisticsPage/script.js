let contor = 1;
function adaugaInput() {
  document.getElementById("numarTari").setAttribute("value", contor);
  var DIV = document.getElementById("listaTari");
  var input = document.createElement("input");
  input.setAttribute("type", "text");
  input.setAttribute("name", "tara" + contor++);
  input.setAttribute("id", "tara" + (contor - 1));
  var BR = document.createElement("br");
  DIV.appendChild(input);
  DIV.appendChild(BR);
  DIV.style.display = "inherit";
}
function adaugaOptiuni() {
  let arrayRegiuni = [];
  arrayRegiuni.push("North America");
  arrayRegiuni.push("Central America & Caribbean");
  arrayRegiuni.push("South America");
  arrayRegiuni.push("East Asia");
  arrayRegiuni.push("Southeast Asia");
  arrayRegiuni.push("South Asia");
  arrayRegiuni.push("Central Asia");
  arrayRegiuni.push("Western Europe");
  arrayRegiuni.push("Eastern Europe");
  arrayRegiuni.push("Middle East & North Africa");
  arrayRegiuni.push("Sub-Saharan Africa");
  arrayRegiuni.push("Australasia & Oceania");
  for (var i = 0; i < arrayRegiuni.length; i++) {
    var option = document.createElement("option");
    option.value = arrayRegiuni[i];
    option.text = arrayRegiuni[i];
    document.getElementById("regiuniDrop2").add(option);
  }
}
function downloadUrl(url, callback) {
  var request = window.ActiveXObject
    ? new ActiveXObject("Microsoft.XMLHTTP")
    : new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      request.onreadystatechange = doNothing;
      callback(request, request.status);
    }
  };

  request.open("GET", url, true);
  request.send(null);
}

function drawMap(datas) {
  var map = new google.maps.Map(document.getElementById("map"), {
    center: new google.maps.LatLng(-33.863276, 151.207977),
    zoom: 12,
  });
  var infoWindows = new google.maps.InfoWindows();
  downloadUrl("../../controllerStats", function (datas) {
      //o sa trebuiasca schimbat acel link de la controller

    var xml = data.responseXML;
    var markers = xml.documentElement.getElementsByTagName("marker");
    Array.prototype.forEach.call(markers, function (markerElem) {
      var id = markerElem.getAttribute("id");
      var name = markerElem.getAttribute("name");
      var address = markerElem.getAttribute("address");
      var type = markerElem.getAttribute("type");
      var point = new google.maps.LatLng(
        parseFloat(markerElem.getAttribute("lat")),
        parseFloat(markerElem.getAttribute("lng"))
      );

      var infowincontent = document.createElement("div");
      var strong = document.createElement("strong");
      strong.textContent = name;
      infowincontent.appendChild(strong);
      infowincontent.appendChild(document.createElement("br"));

      var text = document.createElement("text");
      text.textContent = address;
      infowincontent.appendChild(text);
      var icon = customLabel[type] || {};
      var marker = new google.maps.Marker({
        map: map,
        position: point,
        label: icon.label,
      });
      marker.addListener("click", function () {
        infoWindow.setContent(infowincontent);
        infoWindow.open(map, marker);
      });
    });
  });
}
