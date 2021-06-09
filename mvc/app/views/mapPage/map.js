let map;
let list_markers;
function initMap(){
    map = new google.maps.Map(document.getElementById("drawHere"),{
        center: {lat: 54.54 , lng: 25.19},
        zoom: 3,
        disableDefaultUI: true,
    });
    let list_markers=[];//folosit pt a pune toate markere de la back-end
}

function createMarkers(){
    let url={};

    let e = document.getElementById("regiune");

    url["region"] = e.options[e.selectedIndex].value; 


    if(document.getElementsByName("periodDiv")[0].checked)
    {
        url["period"] = [document.getElementById("beginYear").value,document.getElementById("endYear").value];
    }
    if(document.getElementsByName("woundContainer")[0].checked)
    {
        url["nwounds"] = [document.getElementById("beginWound").value,document.getElementById("lastWound").value];
    }
    if(document.getElementsByName("killnumContainer")[0].checked)
    {
        url["nkills"] = [document.getElementById("beginNKills").value,document.getElementById("lastNKills").value];
    }

    e = document.getElementById("success");

    if(e.options[e.selectedIndex].text !== "None")
    {
        url["success"] = e.options[e.selectedIndex].text;
    }

    e = document.getElementById("suicide");

    if(e.options[e.selectedIndex].text !== "None")
    {
        url["suicide"] = e.options[e.selectedIndex].text;
    }

    e = document.getElementById("exceeded");
    
    if(e.options[e.selectedIndex].text !== "None")
    {
        url["exceeded"] = e.options[e.selectedIndex].text;
    }

    let urlData = new URLSearchParams(url);

    alert(urlData.toString());

    alert(decodeURIComponent(urlData.toString())); //




//fetch("../../controllers/mapController.php?"+url){}


}


// async function mapPopulated(){
//     await fetch("...",{

//     });
// }


/* fetch (blabla)
        $_GET are toti parametri din URL
*/
