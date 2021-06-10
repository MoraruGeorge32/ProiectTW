let contor = 1;
let allCountriesList = [];
let allAttacksList = [];
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
  if (contor > 2) {
    let filterDecese = document.getElementById("filterDecese");
    filterDecese.type = "radio";
    let filterRaniti = document.getElementById("filterRaniti");
    filterRaniti.type = "radio";
    let filterAtacuri = document.getElementById("filterAtacuri");
    filterAtacuri.type = "radio";

  }
}
//poate mai bine ii sa creez ambele butoane global
//in acelasi timp nu poate fi chiar ok cand sterg
function createButton(content, action) {
  let btn = document.createElement("button");
  btn.setAttribute("class", "addBtn");
  btn.setAttribute("type", "button");
  btn.setAttribute("onclick", action);
  btn.textContent = content;
  return btn;
}
function setForRegions() {
  //also reset the other div content and the data
  contor = 1;
  let tari = document.getElementsByClassName("countries")[0];
  let regiuni = document.getElementsByClassName("regions")[0];
  // console.log(tari);
  // console.log(regiuni);
  regiuni.style.display = "block";
  tari.style.display = "none";
  let btn = createButton("Adauga Tari", "adaugaInputTari()");
  while (tari.firstChild) {
    //console.log(tari.childNodes);
    tari.removeChild(tari.firstChild);
  }
  tari.appendChild(btn);
  let filterDecese = document.getElementById("filterDecese");
  filterDecese.type = "checkbox";
  let filterRaniti = document.getElementById("filterRaniti");
  filterRaniti.type = "checkbox";
  let filterAtacuri = document.getElementById("filterAtacuri");
  filterAtacuri.type = "checkbox";
}
function setForCountries() {
  //also reset the other div content and the data
  contor = 1;
  let tari = document.getElementsByClassName("countries")[0];
  let regiuni = document.getElementsByClassName("regions")[0];
  tari.style.display = "block";
  regiuni.style.display = "none";
  let btn = createButton("Adauga Regiuni", "adaugaInputRegiuni()");
  while (regiuni.firstChild) {
    regiuni.removeChild(regiuni.firstChild);
  }
  regiuni.appendChild(btn);
  let filterDecese = document.getElementById("filterDecese");
  filterDecese.type = "checkbox";
  let filterRaniti = document.getElementById("filterRaniti");
  filterRaniti.type = "checkbox";
  let filterAtacuri = document.getElementById("filterAtacuri");
  filterAtacuri.type = "checkbox";
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
  if (contor > 2) {
    let filterDecese = document.getElementById("filterDecese");
    filterDecese.type = "radio";
    let filterRaniti = document.getElementById("filterRaniti");
    filterRaniti.type = "radio";
    let filterAtacuri = document.getElementById("filterAtacuri");
    filterAtacuri.type = "radio";

  }
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

function getListFilters() {
  fetch("./tari_reg.json")
    .then(status)
    .then(response => response.json())
    .then(resJson =>
      allCountriesList = resJson
    )
    .catch(err => console.log(err));
  fetch("./atacuri.json")
    .then(status)
    .then(response => response.json())
    .then(resJson =>
      allAttacksList = resJson
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

//deprecated
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
      if (document.getElementById("Regiune" + i).value === "Central America & Caribbean")
        params = params + "&locatie" + i + "=" + "Central America %26 Caribbean"//escape the & character
      else
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
    return Promise.resolve(response)
  } else {
    // cererea a fost refuzată – reject
    console.log(response.text());
    return Promise.reject(new Error(response.statusText))
  }
}


function drawGraphic(data) {
  let years = [];
  let beginYear = document.getElementById("infYear").value;
  let lastYear = document.getElementById("supYear").value;
  let colorsGenerate = [];
  for (i = beginYear; i <= lastYear; i++) {
    years.push(i);
  }
  let maximValue = -1;
  let dataChart = [];
  console.log(data);
  if (data.nameLocatie === undefined) {
    dataChart = data;
  }
  else {
    dataChart = data.dataColoane;
  }
  dataChart.forEach(function getCurrentList(item) {
    let color = "#" + (Math.floor(Math.random() * 16777215).toString(16));
    colorsGenerate.push(color);
    item.data.forEach(function getMax(value) {
      if (value > maximValue) maximValue = value;
    })
  })
  maximValue += 5;
  console.log(maximValue);
  console.log(dataChart);
  var options = {
    series: dataChart,
    chart: {
      height: '100%',
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
      text: "Evolutie numar evenimente raportate " + (data.nameLocatie !== null ? " pentru locatia " + data.nameLocatie : null),//din js sa modific
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

function drawScatterChart(data) {
  let processedData = [];
  let maximValue = -1;
  console.log("----------------------");
  console.log(data);
  let dataChart = [];
  if (data.nameLocatie === undefined)
    dataChart = data;
  else
    dataChart = data.dataColoane;
  dataChart.forEach(function (item) {
    var events = [];
    item.data.forEach(function (value) {
      var miliseconds = new Date(value[0]).getTime() + 86400000;//i added one day because the events were shown for the precedent day
      if (value[1] > maximValue) maximValue = value[1];
      events.push([miliseconds, value[1]]);
    })
    processedData.push({ name: item.name, data: events });
  });
  console.log("+++++++++++++++++++++++++++++++++");
  console.log(processedData);
  maximValue += 5;

  let beginYear = document.getElementById("infYear").value;
  let lastYear = document.getElementById("supYear").value;

  var options = {
    series: processedData,
    chart: {
      height: '100%',
      type: 'scatter',
      zoom: {
        type: 'xy'
      },
      toolbar: {
        show: true
      }
    },
    dataLabels: {
      enabled: true
    },
    grid: {
      xaxis: {
        lines: {
          show: true
        }
      },
      yaxis: {
        lines: {
          show: true
        }
      },
    },
    xaxis: {
      type: 'datetime',
    },
    yaxis: {
      max: maximValue
    }
  };

  var chart = new ApexCharts(document.querySelector("#drawHere"), options);
  chart.render();
}

function drawColumns(data) {
  console.log(data);
  let locatiiList = [];
  let locatiiValues = [];
  let beginYear = document.getElementById("infYear").value;
  let lastYear = document.getElementById("supYear").value;
  if (data.nameLocatie === undefined)
    data.forEach(function (item) {
      locatiiList.push(item.name);
      locatiiValues.push(item.data);
      //colors.push("#" + (Math.floor(Math.random() * 16777215).toString(16)));
    });
  else {
    data.dataColoane.forEach(function (item) {
      locatiiList.push(item.name);
      locatiiValues.push(item.data);
      //colors.push("#" + (Math.floor(Math.random() * 16777215).toString(16)));
    });
  }

  var options = {
    series: [{
      name: "Numar evenimente ",
      data: locatiiValues
    }],
    annotations: {
    },
    chart: {
      height: '100%',
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
        text: "Evenimente inregistrate intre " + beginYear + " si " + lastYear,
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

function checkParams(params, countRedari, numarLocatii) {
  var stringParams = "";

  if (numarLocatii == 0) {
    alert("Nu ati selectat o regiune/tara!");
    return "Invalid: selectati o regiune sau o tara cel putin";
  }

  if (countRedari == 0) {
    alert("Selectati o statistica numerica!");
    return "Invalid: selectati o statistica numerica (numar decese,raniti,atacuri)";
  }
  if (countRedari > 1 && numarLocatii > 1) {
    alert("Nu puteti alege mai multe tari/regiuni si mai multe statistici de generat!")
    return "Invalid: nu puteti alege mai multe tari/regiuni si mai multe statistici de generat";
  }
  for (var key in params) {
    if (stringParams != "")
      stringParams += "&";
    stringParams += key + "=" + encodeURIComponent(params[key]);
  }
  return stringParams;
}

//the new style
function parseParameters() {
  var params = {};
  if (document.getElementById("tari").checked) {
    console.log(tari);
    params = {};
    params['numarTari'] = (contor - 1);
    let i = 1;
    for (i = 1; i < contor; i++) {
      params['locatie' + i] = document.getElementById("tara" + i).value;
    }

  }
  else {
    params = {};
    params['numarRegiuni'] = (contor - 1);
    let i = 1;
    for (i = 1; i < contor; i++) {
      params['locatie' + i] = document.getElementById("Regiune" + i).value;
    }
  }
  let countTipRedari = 0;
  if (document.getElementById("filterAtacuri").checked) {
    params['numarAtacuri'] = "numarAtacuri";
    countTipRedari++;
  }
  if (document.getElementById("filterRaniti").checked) {
    params['numarRaniti'] = "numarRaniti";
    countTipRedari++;
  }
  if (document.getElementById("filterDecese").checked) {
    params['numarDecese'] = "numarDecese";
    countTipRedari++;
  }
  params['numarRedari'] = countTipRedari;
  if (document.getElementsByName("filterSuicide")[0].checked)
    params['filtruSuicid'] = document.getElementById("filtruSuicid").value;
  if (document.getElementsByName("filterExtend")[0].checked)
    params['filtruExtend'] = document.getElementById("filtruExtend").value;
  if (document.getElementsByName("filterSucces")[0].checked)
    params['filtruSucces'] = document.getElementById("filtruSucces").value;
  if (document.getElementsByName("tipAtacuri")[0].checked)
    params['filtruTipAtac'] = document.getElementById("tipAtac").value;

  params['tipRedare'] = document.getElementById("tipRedare").value;
  params['beginYear'] = document.getElementById("infYear").value;
  params['lastYear'] = document.getElementById("supYear").value;

  var stringParams = checkParams(params, countTipRedari, contor - 1);
  return stringParams;
}

async function showStats() {
  let paramURL = parseParameters();
  console.log(parseParameters());
  var data;
  //waiting for the data from the back-end

  await fetch("../../../public/statisticiController?" + paramURL)
    .then(status)
    .then(response => response.json())
    .then(res => {
      alert("data received!")
      data = res;
    })
    .catch(error => console.error(error));


  // await fetch("../../../public/statisticiController?" + paramURL)
  // .then(res=>res.text())
  // .then(resT=>console.log(resT));

  //reseting the drawMe Div
  console.log(data);
  let areaDraw = document.createElement("div");
  areaDraw.id = "drawHere";
  let parent = document.getElementsByClassName("wrapperDrawMe")[0];
  while (parent.firstChild) {
    parent.removeChild(parent.firstChild);
  }
  parent.appendChild(areaDraw);
  parent.style.background = "white";
  switch (document.getElementById('tipRedare').value) {
    case 'barChart': {
      drawColumns(data);
      break;
    }
    case 'grafic2D': {
      drawGraphic(data);
      break;
    }
    case 'scatter': {
      drawScatterChart(data);
      break;
    }
  }

}
