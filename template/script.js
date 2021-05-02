
function populare_date() {
   /* const HTTP = new XMLHttpRequest();
    const url = "/mapPage/map.html";
    HTTP.open("GET", url);
    HTTP.send(null);
    console.log(HTTP.responseText);*/
    document.getElementsByTagName("h1").item(0).appendChild(document.createTextNode("Informatii despre " + "HTTP.responseText"));
}


window.onload = populare_date();