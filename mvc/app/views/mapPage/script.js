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
function parseParamsStats() {
    let formular = document.getElementsByClassName("formStatistici")[0].firstElementChild;
    var params = "";
    let contor = document.getElementById("numarTari").value;
    params = params + "numarTari=" + document.getElementById("numarTari").value;
    let i = 1;
    for (i = 1; i <= contor; i++) {
        //console.log(document.getElementById("tara" + i));
        params = params + "&tara" + i + "=" + document.getElementById("tara" + i).value;
    }
    params = params + "&tipStatistica=" + document.getElementById("listaStatistici").value;
    params = params + "&perioadaStatistica=" + document.getElementById("perioadaCalculStatistica").value;
    params = params + "&tipRedare=" + document.getElementById("tipRedare").value;
    console.log(params);
    return params;
}

function drawGraphic(data) {
    let typeStat = "";
    switch (document.getElementsByClassName("mapGenerate")[0]) {
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
    let countResulst = data.length;
    let interval = document.getElementById("perioadaCalculStatistica").value;
    let years = [];
    let colorsGenerate = [];
    for (i = 2017 - interval; i <= 2017; i++) {
        let color = "#" + (Math.floor(Math.random() * 16777215).toString(16));
        years.push(i);
        colorsGenerate.push(color);
    }
    console.log(data);
    var options = {
        /*series: [
            {
                name: "High - 2013",
                data: [28, 29, 33, 36, 32, 32, 33]
            },
            {
                name: "Low - 2013",
                data: [12, 11, 14, 18, 17, 13, 13]
            }
        ],*/
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
                show: false
            }
        },
        //colors: ['#77B6EA', '#545454'],//sa generez din js un numar de culori egal cu numarul de tari date
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
            //categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
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
            max: 500
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            floating: true,
            offsetY: -25,
            offsetX: -5
        }
    };

    var chart = new ApexCharts(document.querySelector("#drawHere"), options);
    chart.render();
}


function drawColumns(data) {
    let title = "";
    let text = "";
    switch (document.getElementById("listaStatistici").value) {
        case 'numarDecese': {
            text = "Barchart numar omoruri in ultimii " + document.getElementById("perioadaCalculStatistica").value + " ani";
            title = "Numar omoruri";
            break;
        }
        case 'numarAtacuri': {
            text = "Barchart numar atacuri in ultimii " + document.getElementById("perioadaCalculStatistica").value + " ani";
            title = "Numar atacuri/evenimente";
            break;
        }
        case 'numarRaniti': {
            text = "Barchart numar raniti in ultimii " + document.getElementById("perioadaCalculStatistica").value + " ani";
            title = "Numar raniti";
            break;
        }
        default: {
            text = "error";
            title = "errorColumn";
            break;
        }
    }
    var chart = new CanvasJS.Chart("drawHere", {
        animationEnabled: true,
        theme: "light2",
        title: {
            text: text
        },
        axisY: {
            title: title
        },
        data: [{
            type: "column",
            yValueFormatString: "#,##0.## kills",
            dataPoints: data
        }]
    });
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
    console.log(data);

    document.getElementsByClassName("mapGenerate")[0].innerHTML = "";
    switch (document.getElementById('tipRedare').value) {
        case 'barChart': {
            document.getElementsByClassName("mapGenerate")[0].style.backgroundColor = "white";
            drawColumns(data);
            break;
        }
        case 'grafic2D': {
            document.getElementsByClassName("mapGenerate")[0].style.backgroundColor = "white";
            drawGraphic(data);
            break;
        }
        case 'tabel': {

        }
    }

}
function initMap(){
map = new google.maps.Map(document.getElementById('drawHere'), {
    center: {lat: -34.397, lng: 150.644},
    zoom: 8
  });}