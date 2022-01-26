

//Ouvre le menu déroulant de la bar de navigation
function Collapse() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(e) {
  if (!e.target.matches('.dropbtn')) {
  var myDropdown = document.getElementById("myDropdown");
    if (myDropdown.classList.contains('show')) {
      myDropdown.classList.remove('show');
    }
  }
}


var httpRequest = new XMLHttpRequest();

//Permet d'afficher les équipements du personnage selectionner
  document.addEventListener('DOMContentLoaded',function(){
    var aTr = document.querySelectorAll("#tab_perso tr a"), iNbTitle = aTr.length;
    for(var i = 0; i < iNbTitle; i++){      
      aTr[i].addEventListener('click',function(event) 
      {
        console.log(event.target.id);
        var perso_id= event.target.id;
        var number =perso_id.split('o');
        

       var perso = document.getElementById("id_perso"+number[2]).value;
      console.log(perso);
        httpRequest.open("GET", "../php/requetetable.php?id_perso=" + perso, true);
        httpRequest.send();
        httpRequest.onreadystatechange = function () {
            if (httpRequest.readyState == 4) {
                //console.log(httpRequest.responseText);
                document.getElementById("possesion_perso").innerHTML = httpRequest.responseText;
        
    
            } 
            
        }

        console.log("bonjour !");
      
      
    });

  }});

  //Boite d'avertissement  pour la suppresion du joueur de la base de donnée
  var modalContainer = document.createElement('div');
modalContainer.setAttribute('id', 'modal');

var customBox = document.createElement('div');
customBox.className = 'custom-box';

// Affichage boîte de confirmation
document.getElementById('Suppr_joueur').addEventListener('click', function() {
    pseudo_joueur = document.getElementById("pseudo_joueur").innerHTML;    
    customBox.innerHTML = '<h1 >Attention  !</h1>';
    customBox.innerHTML += '<p >Vous apprêter a supprimer le joueur '+pseudo_joueur+' de la base de donnée</p>';
    customBox.innerHTML += '<p >Cette action est irréversible</p>';
    customBox.innerHTML += '<button id="modal-confirm">Confirmer</button>';
    customBox.innerHTML += '<button id="modal-close">Annuler</button>';
    modalShow();
});

function modalShow() {
    modalContainer.appendChild(customBox);
    document.body.appendChild(modalContainer);

    document.getElementById('modal-close').addEventListener('click', function() {
        modalClose();
    });

    if (document.getElementById('modal-confirm')) {
        document.getElementById('modal-confirm').addEventListener('click', function () {
           console.log('Confirmé !');
           
           modalClose();
        });
    }
}

function modalClose() {
    while (modalContainer.hasChildNodes()) {
        modalContainer.removeChild(modalContainer.firstChild);
    }
    document.body.removeChild(modalContainer);
}
function supprimer_joueur()
{
    var id_perso = document.getElementById("id_joueur").value;
    console.log(perso);
      httpRequest.open("POST", "../php/requetetable.php?suppr_joueur=" + id_perso, true);
      httpRequest.send();
      httpRequest.onreadystatechange = function () {
          if (httpRequest.readyState == 4) {
              //console.log(httpRequest.responseText);
              document.getElementById("possesion_perso").innerHTML = httpRequest.responseText;
      
  
          } 

      }
      console.log("bonjour !");
    
      }

      //Calcul du pourcentage accomplie avant le prochain niveau avec un fichier json , affichage avec une bar de progression
document.addEventListener("load",niveau_adapt());
function niveau_adapt()
{
    var niv_avant =document.getElementById("niv_avant").innerHTML;
    var exp_avant = document.getElementById("exp_avant").value;
    var jsonrequete = "../json/level_requis.json";
    var request = new XMLHttpRequest();
    request.open('GET', jsonrequete);
    request.responseType = 'json';
request.send();
request.onload = function() {
    var level_requis = request.response;
   console.log(level_requis["rank"][niv_avant]);
   console.log(level_requis["exp_avoir"][niv_avant]);
  var exp_avoir = level_requis["exp_avoir"][niv_avant];
  
  
  var bar_result = (exp_avant / exp_avoir) *100;
  $(".html").css("width",bar_result+"%");
}



}


//Ouverture d'un "popup" qui permet de changer l'image d'avatar permit une selection 

//  Inialise le model 
var modal = document.getElementById("img_choose");

// Get the button that opens the modal
var btn = document.getElementById("img_avatar");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
   

  modal.style.display = "block";
  var aTr = document.querySelectorAll(".img_choose-content tr img"), nbImg = aTr.length;
  console.log(nbImg);
  for(var i = 0; i < nbImg; i++){      
    aTr[i].addEventListener('click',function(event) 
    {
      console.log(event.target.id);
      var number_avatar= event.target.id;
      var number =number_avatar.split('_');
      var joueur_id = document.getElementById("id_joueur").value;
      console.log(joueur_id);
    console.log(number[2]);
      httpRequest.open("GET", "../php/requetetable.php?change_img=" + number[2]+"&joueur_id="+joueur_id, true);
      httpRequest.send();
      httpRequest.onreadystatechange = function () {
          if (httpRequest.readyState == 4) {
              //console.log(httpRequest.responseText);
              
                // console.log("Reponse :"+httpRequest.responseText);
                var image =  document.getElementById("img_avatar");
                image.setAttribute("src","../image/avatar/img_avatar_"+number[2]);          
                modal.style.display = "none";    
          } 
          
      }
  });

}
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
  if(event.target == ajout_tableau)
  {
    ajout_tableau.style.display="none";
  }
}

//Changement des donnée saisie avec un double click dessus sauf(image d'avatar et perso)

//var pseudo =document.getElementById("pseudo_joueur");


//pseudo.addEventListener("dblclick",modifData,true);
var modif_text = document.querySelectorAll(".modif"), nbModif = modif_text.length;
console.log(nbModif); 
for(var i =0;i<nbModif ; i++)
{
  console.log(modif_text[i].getAttribute("id"));
  modif_text[i].addEventListener('dblclick',function(event){
    console.log(event.target.id);
    id_target = event.target.id;
    var css = $("#"+id_target).css(["width","height","text-align-last","align-self","font-size"])
     console.log(css); 
     if($)
     $("#"+id_target).replaceWith("<input type='text' id='"+id_target+"_change' placeholder='"+document.getElementById(id_target).innerHTML+"'>");
    $("#"+id_target+"_change").css(css);
    var change = document.getElementById(id_target+"_change");
    console.log("Avant event : "+id_target);
    change.addEventListener("blur",function(e){
      console.log("Aprés déclenche"+change.value);
      $('#'+id_target+'_change').replaceWith("<label id='"+id_target+"'>"+change.value+"</label");
      var joueur_id = document.getElementById("id_joueur").value;
  httpRequest.open("GET","../php/requetetable.php?change_pseudo="+pseudo.value+"&joueur_id="+joueur_id,true);
  httpRequest.send();
  httpRequest.onreadystatechange = function () {
    if (httpRequest.readyState == 4) {
        
    } 
    
  }
    },true);

  })
  console.log(i);
}
//$('#pseudo_joueur').on('dblclick',modifData);


function modifData(event)
{

  console.log(event.target.id);
 var css = $('#pseudo_joueur').css(["width","height","text-align-last","align-self","font-size"])
  console.log(css); 
  $('#pseudo_joueur').replaceWith("<input type='text' id='pseudo_joueur_change' placeholder="+pseudo.innerHTML+">");
 $('#pseudo_joueur_change').css(css);
 pseudo = document.getElementById("pseudo_joueur_change");
 pseudo.addEventListener("blur",focusLost,true);

}


//Lorsque l'utilisateur survole une arme , affiche les caractéristique de l'arme


var arme_disponible = document.createElement('div');
arme_disponible.className = 'arme_disponible';

arme_selection = document.getElementById("arme_selection");
document.getElementById('arme_nom').addEventListener('focus', function() {
pseudo_joueur = document.getElementById("pseudo_joueur").innerHTML;    
arme_disponible.innerHTML = '<h1>Arme disponible :</h1>';
arme_disponible.innerHTML += "<button><img  id='5etA' src='../image/arme/etoile/cinq_etoile.png' alt='5 etoile'></button>";
arme_disponible.innerHTML += "<button><img src='../image/arme/etoile/quatre_etoile.png'  id='4etA' alt='4 etoile'></button>";
arme_disponible.innerHTML += "<button><img src='../image/arme/etoile/trois_etoile.png' id='3etA' alt='3 etoile'></button>";

    selection_arme();
});
    function selection_arme() {
      arme_selection.appendChild(arme_disponible);
      
      var etoile_arme = document.querySelectorAll(".arme_disponible button"), nbEtoileAr = etoile_arme.length;
      for(var i=0;i<nbEtoileAr;i++)
      {
        etoile_arme[i].addEventListener("click",function(event)
        {
          let jsonrequete_arme = "../json/arme/epee_1_main.json";
          let request_arme = new XMLHttpRequest();
          request_arme.open('GET', jsonrequete_arme);
          request_arme.responseType = 'json';
        request_arme.send();
          let id_arme_target = event.target.id;
          switch(id_arme_target)
          {
            case "5etA":

              let arme_cinq_et = document.createElement('section');
              arme_cinq_et.className = 'etoile_css';
             //Emplacement requete
            request_arme.onload = function() {
              let arme_dispo = request_arme.response;
          
              
              let arme_5_dispo  = arme_dispo["epee_1_main"]["5etoile"];
              console.log(arme_5_dispo);
              for(var i =0;i<arme_5_dispo.length;i++)
              {
         
              arme_cinq_et.innerHTML += "<img  class='img_arme' id='img_"+arme_5_dispo[i]+"' src='../image/arme/epee_1_main/5/"+arme_5_dispo[i]+".png'>";
              
              }
              arme_disponible.appendChild(arme_cinq_et);
              let arme_select = document.querySelectorAll(".img_arme"), nbArme = arme_select.length;
              for(var i=0;i<nbArme;i++)
              {
                arme_select[i].addEventListener("click",function(event)
                {
                  let img_select_arme =  event.target.id.split("_");
                  document.getElementById("arme_nom").value =  img_select_arme[1];
                  arme_disponible.removeChild(arme_cinq_et);

                });
              }
            


            }
              break;
            case "4etA":
              let arme_quatre_et = document.createElement('section');
              arme_quatre_et.className = 'etoile_css';
            
            request_arme.onload = function() {
              let arme_dispo = request_arme.response;
              console.log(arme_dispo);
              console.log(arme_dispo["epee_1_main"]["4etoile"])
              
              let arme_4_dispo  = arme_dispo["epee_1_main"]["4etoile"];
              for(var i =0;i<arme_4_dispo.length;i++)
              {
         
              arme_quatre_et.innerHTML += "<img  class='img_arme' id='img_"+arme_4_dispo[i]+"' src='../image/arme/epee_1_main/4/"+arme_4_dispo[i]+".png'>";
              
              }
              arme_disponible.appendChild(arme_quatre_et);
              let arme_select = document.querySelectorAll(".img_arme"), nbArme = arme_select.length;
              for(var i=0;i<nbArme;i++)
              {
                arme_select[i].addEventListener("click",function(event)
                {
                  let img_select_arme =  event.target.id.split("_");
                  document.getElementById("arme_nom").value =  img_select_arme[1];
                  arme_disponible.removeChild(arme_quatre_et);

                });
              }
            }
              break;
            case "3etA":
              let arme_trois_et = document.createElement('section');
              arme_trois_et.className = 'etoile_css';
            
            request_arme.onload = function() {
              let arme_dispo = request_arme.response;
    
              let arme_3_dispo  = arme_dispo["epee_1_main"]["3etoile"];
              console.log(arme_3_dispo);
              for(var i =0;i<arme_3_dispo.length;i++)
              {
              
         
              arme_trois_et.innerHTML += "<img  class='img_arme' id='img_"+arme_3_dispo[i]+"' src='../image/arme/epee_1_main/3/"+arme_3_dispo[i]+".png'>";
              
              }
              arme_disponible.appendChild(arme_trois_et);
              let arme_select = document.querySelectorAll(".img_arme"), nbArme = arme_select.length;
              for(var i=0;i<nbArme;i++)
              {
                arme_select[i].addEventListener("click",function(event)
                {
                  let img_select_arme =  event.target.id.split("_");
            
            
                  document.getElementById("arme_nom").value =  img_select_arme[1];
                  arme_disponible.removeChild(arme_trois_et);

                });
              }
            }
              break;
          
        }

        });
      }  
    }  
