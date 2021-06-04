let contor = 1;
let allCountriesList = [];
function adaugaInputTari() {
  var DIV = document.getElementsByClassName("countries")[0];
  var selectReg = document.createElement("select");
  var selectCountry = document.createElement("select");

  var BR = document.createElement("br");
  DIV.appendChild(selectReg);
  DIV.appendChild(selectCountry);
  DIV.appendChild(BR);

  selectCountry.setAttribute("name", "tara" + contor);
  selectCountry.setAttribute("id", "tara" + contor);
  selectReg.setAttribute("id", "RegiuneTara" + contor);

  adaugaOptionsReg(selectReg.id);
  selectReg.setAttribute("onchange", "setCountriesSelect(value," + selectCountry.id + ")");
  setCountriesSelect(selectReg.value, selectCountry);

  DIV.style.display = "inherit";
  contor++;
}
//poate mai bine ii sa creez ambele butoane global
//in acelasi timp nu poate fi chiar ok cand sterg
function createButton(content,action){
  let btn=document.createElement("button");
  btn.setAttribute("class","addBtn");
  btn.setAttribute("type","button");
  btn.setAttribute("onclick",action);
  btn.textContent=content;
  return btn;
}
function setForRegions() {
  //also reset the other div content and the data
  contor = 1;
  let tari = document.getElementsByClassName("countries")[0];
  let regiuni = document.getElementsByClassName("regions")[0];
  console.log(tari);
  console.log(regiuni);
  regiuni.style.display = "block";
  tari.style.display = "none";
  let btn=createButton("Adauga Tari","adaugaInputTari()");
  while (tari.firstChild) {
    console.log(tari.childNodes);
      tari.removeChild(tari.firstChild);
  }
  tari.appendChild(btn);
}
function setForCountries() {
  //also reset the other div content and the data
  contor = 1;
  let tari = document.getElementsByClassName("countries")[0];
  let regiuni = document.getElementsByClassName("regions")[0];
  tari.style.display = "block";
  regiuni.style.display = "none";
  let btn=createButton("Adauga Regiuni","adaugaInputRegiuni()");
  while (regiuni.firstChild) {
    regiuni.removeChild(regiuni.firstChild);
  }
  regiuni.appendChild(btn);
}

function adaugaInputRegiuni() {
  var DIV = document.getElementsByClassName("regions")[0];
  var selectReg = document.createElement("select");

  var BR = document.createElement("br");
  DIV.appendChild(selectReg);
  DIV.appendChild(BR);
  selectReg.setAttribute("id", "Regiune" + contor);
  selectReg.setAttribute("name", "Regiune" + contor);

  adaugaOptionsReg(selectReg.id);

  DIV.style.display = "inherit";
  contor++;
}

function adaugaOptionsReg(id) {
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
    document.getElementById(id).appendChild(option);
  }

}
function removeOptions(selectElement) {
  console.log(selectElement);
  var i, length = selectElement.options.length - 1;
  for (i = length; i >= 0; i--) {
    selectElement.remove(i);
  }
}

function getListCountries() {
  fetch("./tari_reg.json")
    .then(status)
    .then(response => response.json())
    .then(resJson =>
      allCountriesList = resJson
    )
    .catch(err => console.log(err));
}

function setCountriesSelect(nume_reg, countrySelect) {
  removeOptions(countrySelect);
  var countries = allCountriesList.filter(function checkRegion(item) {
    return item.region_txt === nume_reg;
  })
  countries = countries.forEach(function addOptionCountry(item) {
    var option = document.createElement("option");
    option.value = item.country_txt;
    option.text = item.country_txt
    document.getElementById(countrySelect.id).appendChild(option);
  });
}


function parseParamsStats() {
  var params = "";
  if (document.getElementById("tari").checked) {
    console.log(tari);
    params = "";
    params = params + "numarTari=" + (contor - 1);
    let i = 1;
    for (i = 1; i < contor; i++) {
      params = params + "&locatie" + i + "=" + document.getElementById("tara" + i).value;
    }

  }
  else {
    params = "";
    params = params + "numarRegiuni=" + (contor - 1);
    let i = 1;
    for (i = 1; i < contor; i++) {
      params = params + "&locatie" + i + "=" + document.getElementById("Regiune" + i).value;
    }
  }
  params = params + "&tipStatistica=" + document.getElementById("listaStatistici").value;
  //params = params + "&perioadaStatistica=" + document.getElementById("perioadaCalculStatistica").value;
  params = params + "&tipRedare=" + document.getElementById("tipRedare").value;
  params = params + "&beginYear=" + document.getElementById("infYear").value;
  params = params + "&lastYear=" + document.getElementById("supYear").value;
  console.log(params);
  return params;
}


function status(response) {
  if (response.status >= 200 && response.status < 300) {
    // cererea poate fi rezolvată – fulfill
    console.log(response);
    return Promise.resolve(response)
  } else {
    // cererea a fost refuzată – reject
    return Promise.reject(new Error(response.statusText))
  }
}


function drawGraphic(data) {
  let typeStat = "";
  switch (document.getElementById("listaStatistici").value) {
    case 'numarDecese': {
      typeStat = "Evolutie numar decese";
      break;
    }
    case 'numarAtacuri': {
      typeStat = "Evolutie numar atacuri";
      break;
    }
    case 'numarRaniti': {
      typeStat = "Evolutie numar raniti";
      break;
    }
    default: {
      typeStat = "Evolutie numar incidente";
      break;
    }
  }
  let years = [];
  let beginYear = document.getElementById("infYear").value;
  let lastYear = document.getElementById("supYear").value;
  let colorsGenerate = [];
  for (i = beginYear; i <= lastYear; i++) {
    let color = "#" + (Math.floor(Math.random() * 16777215).toString(16));
    years.push(i);
    colorsGenerate.push(color);
  }
  let maximValue = -1;
  data.forEach(function getCurrentList(item) {
    item.data.forEach(function getMax(value) {
      if (value > maximValue) maximValue = value;
    })
  })
  maximValue += 5;
  console.log(maximValue);
  console.log(data);
  var options = {
    series: data,
    chart: {
      height: 700,
      type: 'line',
      dropShadow: {
        enabled: true,
        color: '#fff',
        top: 18,
        left: 7,
        blur: 10,
        opacity: 0.2
      },
      toolbar: {
        show: true
      }
    },
    colors: colorsGenerate,
    dataLabels: {
      enabled: true,
    },
    stroke: {
      curve: 'smooth'
    },
    title: {
      text: typeStat,//din js sa modific
      align: 'left'
    },
    grid: {
      //cred ca asta ii background-ul
      borderColor: '#e7e7e7',
      row: {
        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
        opacity: 0.5
      },
    },
    markers: {
      size: 1
    },
    xaxis: {
      categories: years,
      title: {
        text: 'ani'//default
      }
    },
    yaxis: {
      title: {
        text: 'Incidente'//din js cred
      },
      min: 0,
      max: maximValue
    },
    legend: {
      position: 'top',
      horizontalAlign: 'right',
      floating: true,
      offsetY: -25,
      offsetX: -5
    }
  };

  document.getElementById("drawHere").innerHTML = "";
  var chart = new ApexCharts(document.querySelector("#drawHere"), options);
  chart.render();
}


function drawColumns(data) {
  console.log(data);
  let locatiiList = [];
  let locatiiValues = [];
  let typeStat = "";
  let beginYear = document.getElementById("infYear").value;
  let lastYear = document.getElementById("supYear").value;
  switch (document.getElementById("listaStatistici").value) {
    case 'numarDecese': {
      typeStat = "numar decese";
      break;
    }
    case 'numarAtacuri': {
      typeStat = "numar atacuri";
      break;
    }
    case 'numarRaniti': {
      typeStat = "numar raniti";
      break;
    }
    default: {
      typeStat = "numar incidente";
      break;
    }
  }
  data.forEach(function (item) {
    locatiiList.push(item.name);
    locatiiValues.push(item.data);
    //colors.push("#" + (Math.floor(Math.random() * 16777215).toString(16)));
  });

  var options = {
    series: [{
      name: typeStat,
      data: locatiiValues
    }],
    annotations: {
    },
    chart: {
      height: 600,
      type: 'bar',
    },
    plotOptions: {
      bar: {
        borderRadius: 10,
        columnWidth: '50%',
      }
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      width: 2
    },

    grid: {
      row: {
        colors: ['#fff', '#f2f2f2']
      }
    },
    xaxis: {
      labels: {
        rotate: -45
      },
      categories: locatiiList,
      tickPlacement: 'on'
    },
    yaxis: {
      title: {
        text: 'Evenimente ' + typeStat + " intre " + beginYear + " si " + lastYear,
      },
    },
    fill: {
      type: 'gradient',
      gradient: {
        shade: 'light',
        type: "horizontal",
        shadeIntensity: 0.25,
        gradientToColors: undefined,
        inverseColors: true,
        opacityFrom: 0.85,
        opacityTo: 0.85,
        stops: [50, 0, 100]
      },
    }
  };
  document.getElementById("drawHere").innerHTML = "";
  var chart = new ApexCharts(document.querySelector("#drawHere"), options);
  chart.render();
}

async function showStats() {
  let paramURL = parseParamsStats();
  var data;
  //waiting for the data from the back-end
  await fetch("../../controllers/statisticiController.php?" + paramURL)
    .then(status)
    .then(response => response.json())
    .then(res => {
      alert("data received!")
      data = res;
    })
    .catch(error => console.error(error));
  // await fetch("../../controllers/statisticiController.php?" + paramURL)
  // .then(res=>res.text())
  // .then(resT=>console.log(resT));

  //reseting the drawMe Div
  console.log(data);
  let draw = document.getElementById("drawHere");
  let parent = draw.parentNode;
  while (parent.firstChild) {
    parent.removeChild(parent.firstChild);
  }
  draw = document.createElement("div");
  draw.id = "drawHere";
  parent.appendChild(draw);


  while (draw.firstChild) {
    draw.removeChild(draw.firstChild);
  }
  switch (document.getElementById('tipRedare').value) {
    case 'barChart': {
      document.getElementById("drawHere").style.backgroundColor = "white";
      drawColumns(data);
      break;
    }
    case 'grafic2D': {
      document.getElementById("drawHere").style.backgroundColor = "white";
      drawGraphic(data);
      break;
    }
    case 'tabel': {
      break;
    }
  }

}


// function downloadUrl(url, callback) {
//   var request = window.ActiveXObject
//     ? new ActiveXObject("Microsoft.XMLHTTP")
//     : new XMLHttpRequest();

//   request.onreadystatechange = function () {
//     if (request.readyState == 4) {
//       request.onreadystatechange = doNothing;
//       callback(request, request.status);
//     }
//   };

//   request.open("GET", url, true);
//   request.send(null);
// }

// function drawMap(datas) {
//   var map = new google.maps.Map(document.getElementById("map"), {
//     center: new google.maps.LatLng(-33.863276, 151.207977),
//     zoom: 12,
//   });
//   var infoWindows = new google.maps.InfoWindows();
//   downloadUrl("../../controllerStats", function (datas) {
//     //o sa trebuiasca schimbat acel link de la controller

//     var xml = data.responseXML;
//     var markers = xml.documentElement.getElementsByTagName("marker");
//     Array.prototype.forEach.call(markers, function (markerElem) {
//       var id = markerElem.getAttribute("id");
//       var name = markerElem.getAttribute("name");
//       var address = markerElem.getAttribute("address");
//       var type = markerElem.getAttribute("type");
//       var point = new google.maps.LatLng(
//         parseFloat(markerElem.getAttribute("lat")),
//         parseFloat(markerElem.getAttribute("lng"))
//       );

//       var infowincontent = document.createElement("div");
//       var strong = document.createElement("strong");
//       strong.textContent = name;
//       infowincontent.appendChild(strong);
//       infowincontent.appendChild(document.createElement("br"));

//       var text = document.createElement("text");
//       text.textContent = address;
//       infowincontent.appendChild(text);
//       var icon = customLabel[type] || {};
//       var marker = new google.maps.Marker({
//         map: map,
//         position: point,
//         label: icon.label,
//       });
//       marker.addListener("click", function () {
//         infoWindow.setContent(infowincontent);
//         infoWindow.open(map, marker);
//       });
//     });
//   });
// }
