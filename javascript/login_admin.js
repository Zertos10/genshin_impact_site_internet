

var httpRequest = new XMLHttpRequest();
function requeteJoueur() {
 
    var player_char = document.getElementById("searchByPlayer").value;
    httpRequest.open("GET", "../php/requetesb.php?username=" + player_char, true);
    httpRequest.send();
    httpRequest.onreadystatechange = function () {
        if (httpRequest.readyState == 4) {
            //console.log(httpRequest.responseText);
            document.getElementById("joueur_trie").innerHTML = httpRequest.responseText;


        } else {

        }
    }
}
document.getElementById("searchByPlayer").onkeyup = function () { requeteJoueur() };
document.getElementById("body_load").onload = function () { requeteJoueur() };
