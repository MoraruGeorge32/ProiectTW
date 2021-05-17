let contor=1;
function adaugaInput(){
    document.getElementById("numarTari").setAttribute("value",contor);
    var DIV = document.getElementById("listaTari");
    var input=document.createElement("input");
    input.setAttribute("type","text");
    input.setAttribute("name","tara"+contor++);
    var BR=document.createElement("br");
    DIV.appendChild(input);
    DIV.appendChild(BR);
    DIV.style.display="inherit";
}