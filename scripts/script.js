ok = document.getElementById("etesvoussur");
ok.addEventListener("click", affiche);

function affiche(){

    oko = document.getElementById("bouton");

    var message = document.createElement("p");
    message.setAttribute("id", "p");
    message.innerHTML = "Êtes vous sur de supprimer l'utilisateur";

    var bouton = document.createElement("INPUT");
    bouton.setAttribute("type", "submit");
    bouton.setAttribute("id", "oui");
    bouton.setAttribute("name","supprimer_utilisateur");
    bouton.setAttribute("value","Oui");

    var bouton2 = document.createElement("INPUT");
    bouton2.setAttribute("type", "button");
    bouton2.setAttribute("id", "non");
    bouton2.setAttribute("value","Non");

    oko.appendChild(message);
    oko.appendChild(bouton);
    oko.appendChild(bouton2);

    
    bouton2.addEventListener("click", deaffiche);
}

// ko = document.getElementById("non");
// ko.addEventListener("click", deaffiche);

function deaffiche(){

    bouton = document.getElementById("oui");
    bouton2 = document.getElementById("non");
    p = document.getElementById("p");

    p.remove();
    bouton.remove();
    bouton2.remove();

}