var counter = 1;
function agregarCampo()
    {
        var x = document.getElementById("campos_txt");
        var campo = document.createElement("input");
        campo.setAttribute('type', "text");
        campo.setAttribute('name', "texto[]");
        campo.setAttribute('id', "action_"+counter);
        var br = document.createElement("br");
       // x.appendChild(document.createTextNode("Campo"+counter+": "));
       //x.appendChild(document.createTextNode("New action: "));
        x.appendChild(campo);
        x.appendChild(br);
        counter++;
    }
    
function borrarElemento()
    {
        var x = document.getElementById("campos_txt");
        x.removeChild(x.lastChild);
        x.removeChild(x.lastChild);
        x.removeChild(x.lastChild);
    }

function agregarCampoSubProject()
    {
        var x = document.getElementById("campos_txt_subproject");
        var campo = document.createElement("input");
        campo.setAttribute('type', "text");
        campo.setAttribute('name', "texto_subproject[]");
        campo.setAttribute('id', "action_"+counter);
        var br = document.createElement("br");
        //x.appendChild(document.createTextNode("New Action: "+counter+": "));
        //x.appendChild(document.createTextNode("New sub project: "));
        x.appendChild(campo);
        x.appendChild(br);
        counter++;
    }
    
function borrarElementoSubProject()
    {
        var x = document.getElementById("campos_txt_subproject");
        x.removeChild(x.lastChild);
        x.removeChild(x.lastChild);
        x.removeChild(x.lastChild);
    }    
