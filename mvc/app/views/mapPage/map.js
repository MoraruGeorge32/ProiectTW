let map;
let list_markers;
function initMap(){
    let map = new google.maps.Map(document.getElementById("drawHere"),{
        center: {lat: 54.54 , lng: 25.19},
        zoom: 3
    })
    let list_markers=[];//folosit pt a pune toate markere de la back-end
    //dummy data
    // const marker1= new google.maps.Marker({
    //     position:{lat: 54.54 , lng: 25.19} ,
    //     map:map
    // });
    // const marker2= new google.maps.Marker({
    //     position: {lat: 55.54 , lng: 20.19},
    //     map:map
    // });
    // const marker3= new google.maps.Marker({
    //     position: {lat: 25.54 , lng: 40.19},
    //     map:map
    // });

    // list_markers.push(marker1,marker2,marker3);

    // new MarkerClusterer(map, list_markers, {
    //     imagePath:
    //       "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
    //   });
}

// async function mapPopulated(){
//     await fetch("...",{

//     });
// }


/* fetch (blabla)
        $_GET are toti parametri din URL
*/
