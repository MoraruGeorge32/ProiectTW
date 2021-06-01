function populatePage(){
    let url = window.location.href;
    let params= {};
    url=url.split("?")[1];
    url=url.split("&");
    console.log(url);
    for(var i=0; i< url.length; i++)
    {
        var pair = url[i].split("=");
        if(pair[0] === "eventid")
            document.getElementById("idEvent").setAttribute("value", decodeURIComponent(pair[1]));
        if(pair[0]!=="success" && pair[0]!=="suicide" && pair[0]!=="extended" && pair[0] !== "eventid")
            document.getElementsByName(pair[0])[0].placeholder = decodeURIComponent(pair[1]);
        if(pair[0] === "iday" || pair[0] === "imonth")
                if(pair[1]==="0")
                    document.getElementsByName(pair[0])[0].placeholder = "Nu este setata in baza de date"
        if(pair[0]==="success" || pair[0]==="suicide" || pair[0]==="extended")
            {
                var options = Array.from(document.getElementsByName(pair[0])[0].options);
                for(var j=0; j<options.length; j++)
                    {
                        if(options[j].value === pair[1])
                            {options[j].selected = true;
                            break;}
                    }
            }
    }
    console.log(params);
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

function updateDataInDb(){
    var input = {}
    var inputValues = document.getElementsByTagName("input");
    for(var i=0; i<inputValues.length; i++)
        if(inputValues[i].value!=inputValues[i].placeholder && inputValues[i].value!== null && inputValues[i].value !== "")
            {
                input[inputValues[i].name] = inputValues[i].value;
            }
    var selectValues = document.getElementsByTagName("select");
    for(var j=0; j<selectValues.length; j++)
            input[selectValues[j].name] = selectValues[j].value;
    var url = "../../controllers/updateEventController.php"
    fetch(url,{
        method: "POST",
        body: JSON.stringify(input),
        headers:{
            'Content-Type': 'application/json'
        }
    })
    .then(status)
    .then(res=> res.text())
    .then(resText => (resText === "OK") ? window.location.href="../paginaAdmin/index.php": (alert(resText)))
    .catch(err => console.log(err))
}