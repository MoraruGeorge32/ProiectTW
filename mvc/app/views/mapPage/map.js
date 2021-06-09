let map;
let list_markers;
function initMap() {
  map = new google.maps.Map(document.getElementById("drawHere"), {
    center: { lat: 54.54, lng: 25.19 },
    zoom: 3,
    disableDefaultUI: true,
  });
}

async function createMarkers() {
  let url = {};

  map = new google.maps.Map(document.getElementById("drawHere"), {
    center: { lat: 54.54, lng: 25.19 },
    zoom: 3,
    disableDefaultUI: true,
  });

  let e = document.getElementById("regiune");

  url["region"] = e.options[e.selectedIndex].value;

  if (document.getElementsByName("periodDiv")[0].checked) {
    url["period"] = [
      document.getElementById("beginYear").value,
      document.getElementById("lastYear").value,
    ];
  }
  if (document.getElementsByName("woundContainer")[0].checked) {
    url["nwound"] = [
      document.getElementById("beginWound").value,
      document.getElementById("lastWound").value,
    ];
  }
  if (document.getElementsByName("killnumContainer")[0].checked) {
    url["nkill"] = [
      document.getElementById("beginNKills").value,
      document.getElementById("lastNKills").value,
    ];
  }

  e = document.getElementById("success");

  if (e.options[e.selectedIndex].text !== "None") {
    url["success"] = e.options[e.selectedIndex].value;
  }

  e = document.getElementById("suicide");

  if (e.options[e.selectedIndex].text !== "None") {
    url["suicide"] = e.options[e.selectedIndex].value;
  }

  e = document.getElementById("exceeded");

  if (e.options[e.selectedIndex].text !== "None") {
    url["exceeded"] = e.options[e.selectedIndex].value;
  }

  let urlData = "";
  let filters = false;
  Object.keys(url).map((key) => {
    urlData += key + "=" + encodeURIComponent(url[key]) + "&";
    filters = true;
  });

  if (filters) 
    urlData += "filters=" + filters;

  alert(urlData);

  let markersInfo;

  await fetch("../../controllers/MapController/mapController.php?" + urlData)
    .then((res) => res.json())
    .then((resJ) => {
      if (resJ != "0 results selected") markersInfo = resJ;
    });

  let markers = [];
  if (markersInfo !== undefined) {
    markersInfo.map((object) => {
      let marker = new google.maps.Marker({
        position: {
          lat: parseFloat(object.latitude),
          lng: parseFloat(object.longitude),
        },
        map,
      });
      markers.push(marker);
      let content_string = '<div id="container" style="display:flex; flex-direction:column;">';
      if(object.region_txt!=="")
        content_string += '<p> Region: ' + object.region_txt + ' </p>'
      if(object.country_txt!=="")
        content_string += '<p> Country: ' + object.country_txt + ' </p>'
      content_string += '<p> Date: '
      if(object.iday!=="")
        content_string+= object.iday 
      if(object.imonth!=="")
        content_string+= '/' + object.imonth
      if(object.iyear!=="")
        content_string+= '/' + object.iyear
      content_string+= '</p>'
      if(object.attacktype1_txt !== "")
        content_string+= '<p> Attack type: ' + object.attacktype1_txt + '</p>'
      if(object.nperps!=="")
        content_string+='<p> Numarul de persoane implicate: ' + object.nperps + '</p>'
      if(object.weaptype1_txt!== "")
        content_string+='<p> Tipul armelor: ' +object.weaptype1_txt + '</p>'
      if(object.weapsubtype1_txt!=="")
        content_string += '<p> Subtipul armelor: ' + object.weapsubtype1_txt + '</p>'
      if(object.gname!=="")
        content_string+='<p> Grupul terorist: ' + object.gname + ' </p>'
      if(object.nwound!=="")
        content_string+='<p> Numarul de persoane ranite: ' + object.nwound + '</p>'
      if(object.summary!=="")
       content_string+= '<p> Rezumat: ' + object.summary + '</p>'
      else
        content_string+= '<p> Rezumat: Unknown </p>'
      '</div>';

      var infowindow = new google.maps.InfoWindow();

      google.maps.event.addListener(marker, 'click', (function (marker) {
        return () => {
            infowindow.setContent(content_string);
            infowindow.open(map, marker);
        }
    })(marker)); 
    });
  }
}
// async function mapPopulated(){
//     await fetch("...",{

//     });
// }

/* fetch (blabla)
        $_GET are toti parametri din URL
*/
