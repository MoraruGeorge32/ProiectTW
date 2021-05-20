var contor = 1;
var counter=5;
function setNumberEvents(value){
    /* functie cu rol in setarea numarului de evenimente arata unui administrator */
    counter=parseInt(value);
    listEvents(contor);
}
function arataAdaugaEveniment() {
    document.getElementById('removeEvent').style.display = "none";
    document.getElementById('updateEvent').style.display = "none";
    document.getElementById('formAddEvent').style.display = "block";
    var list = document.getElementById('list-events');
    list.textContent = '';/*nu este eficient deoarece face apel la parser-ul din browser*/
    contor = 1;
}
function arataStergeEveniment() {
    document.getElementById('formAddEvent').style.display = "none";
    document.getElementById('updateEvent').style.display = "none";
    document.getElementById('removeEvent').style.display = "block";
}
function arataModificaEveniment(){
    document.getElementById('formAddEvent').style.display = "none";
    document.getElementById('updateEvent').style.display = "block";
    document.getElementById('removeEvent').style.display = "none";
}
function listEvents(start) {
    /**
     * functie ce afiseaza evenimentele din baza de date de la un indice/start dat
     */
    var list = document.getElementById('list-events');
    list.textContent = '';
    for (let i = start; i < start + counter; i++) {
        var div_eveniment = document.createElement('div');
        div_eveniment.style.display = 'flex';
        div_eveniment.style.flexDirection = 'row';

        var checkbox_to_remove = document.createElement('input');
        checkbox_to_remove.setAttribute('type', 'checkbox');

        var eveniment_terro = document.createElement('em');
        eveniment_terro.appendChild(document.createTextNode('Eveniment numar ' + i));

        div_eveniment.appendChild(checkbox_to_remove);
        div_eveniment.appendChild(eveniment_terro);

        var entry = document.createElement('li');
        entry.appendChild(div_eveniment);
        list.appendChild(entry);
    }
}
function showEvents(flowDirection) {
    /**
     * functie cu rol in setarea indexului de start de afisare al evenimentelor
     */
    if (flowDirection === 'forward') {
        contor = contor + counter;
    }
    else {
        contor = contor - counter;
    }

    if (contor < 0) {
        contor = 1;
    }
    listEvents(contor);
}
