
//Ajout d'un personnage : 


//
var ajout_tableau = document.getElementById("ajout_tableau");
var bouton_ajout = document.getElementById("ajout_perso");
var fermer = document.getElementsByClassName("close")[0];



//Se déclenche si un personnage est selectionner
bouton_ajout.addEventListener("click",function(e)
{


//Affiche l'interface 
  ajout_tableau.style.display = "block";

  //Fait une requête vers un fichier json pour récuperer les noms de personnage disponible
  var jsonperso = "../json/avatar.json";
  var perso_request = new XMLHttpRequest();
  perso_request.open('GET', jsonperso);
  perso_request.responseType = 'json';
  perso_request.send();
  perso_request.onload = function() {
    //Récupération de  la réponse
    var name_perso_list = perso_request.response;
     nb_list =name_perso_list["avatar_name"].length;
    for(var i=0;i<nb_list;i++)
    {
      if(name_perso_list["avatar_name"][i] !== "Paimon")
      {
      personnage_list.innerHTML += '<option value='+name_perso_list["avatar_name"][i]+'>'+name_perso_list["avatar_name"][i]+'</option>';
      }
      
    }
    
   
  

  }
  //Permet de stocker le personnage selectionner
  var personnage = null;
  $("#personnage-selection").change(function(){
     personnage = $(this).children("option:selected").val();
    
  });
//Permet de valider les entrée pour personnage 
  $("#ajout_perso_valid").click(function(){
    httpRequest.open("POST", "../php/requetetable.php", true);
    httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const nom_const = ["const","apt_1","apt_2","apt_3","perso"];
  var level = [];
  for(var i =0 ;i<nom_const.length;i++)
  {
    level[i] = document.getElementById("level_"+nom_const[i]).value;
  }
    joueur_id = document.getElementById("id_joueur").value;
    var verif_val = true;
    //Vérifier la validite des valeurs entrée
    for(var i =0;i<level.length;i++)
    {
      if(level[i] === null || level[i] === undefined  || level[i] === "" )
      {
        verif_val = false;
        break;
      }
      
    }
    if(verif_val === true && (personnage !== "" && personnage !== null)) 
    {
   httpRequest.send("ajout_perso_valid&personnage="+personnage+"&level_"+nom_const[0]+"="+level[0]+"&level_"+nom_const[1]+"="+level[1]+"&level_"+nom_const[2]+"="+level[2]+"&level_"+nom_const[3]+"="+level[3]+"&level_"+nom_const[4]+"="+level[4]+"&joueur_id="+joueur_id+"");
    httpRequest.onreadystatechange = function () {
        if (httpRequest.readyState == 4) {
        let  convert_temp =httpRequest.responseText.split("/");


          if(convert_temp[0] == "true")
          {
            //Passe vers l'ajout de l'arme du personnage
          ajout_arme(convert_temp[1]);
           

           
          } 
        } 
       
        
    }
  }
  else
  {
    alert("Une ou plusieur ligne sont vide !")
  
  }
  });


});


var personnage_list = document.getElementById("personnage-selection");

//Si la "croix" est clique cela ferme la fenêtre 
fermer.onclick = function() {
  ajout_tableau.style.display = "none";
}

function ajout_arme(id_perso)
{
  //Affiche la partie arme

  var personnage_content = document.getElementById("ajout_personnage");
 var arme_content = document.getElementById("ajout_arme-body");
 personnage_content.style.display = "none";
 arme_content.style.display = "block";
  var arme = null;

  $("#ajout_arme_valid").click(function(){
  httpRequest.open("POST", "../php/requetetable.php", true);
  httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  const arme_const = ["rarete_arme","level_arme","atq_base_arme","level_raff"];
var level = [];
for(var i =0 ;i<arme_const.length;i++)
{
  level[i] = document.getElementById(arme_const[i]).value;
}
var nom_arme = document.getElementById("arme_nom").value;
  joueur_id = document.getElementById("id_joueur").value;
  var verif_val = true;
  for(var i =0;i<level.length;i++)
  {
    if(level[i] === null || level[i] === undefined  || level[i] === "")
    {
      verif_val = false;
      break;
    }
    
  }
  if(verif_val === true) 
  {
 httpRequest.send("ajout_arme_valid&arme="+nom_arme+"&"+arme_const[0]+"="+level[0]+"&"+arme_const[1]+"="+level[1]+"&"+arme_const[2]+"="+level[2]+"&"+arme_const[3]+"="+level[3]+"&id_perso="+id_perso+"");
  httpRequest.onreadystatechange = function () {
      if (httpRequest.readyState == 4) {
        if(httpRequest.responseText == "true")
        {
          
            //Une dernière partie aurait dû être excuté elle correspondait au artéfact
            alert("Personnage ajoutée");
            document.location.reload();
            ajout_tableau.style.display = "none";   
            return true;
        } 
      } 
      
  }
}
else
{
  alert("Une ou plusieur ligne sont vide !")
}
});


}
supprimerPerso();
// Supprimer un personnage

function supprimerPerso()
{
  var ischecked = [];
  var show_trash = false;
//Stock dans une variable tout les personnages à supprimer
  $('input[type="checkbox"].perso_select').on("click",function(event){
    if($(this).prop("checked") == true){
     show_trash = true;
     ischecked.push(event.target.id);

    }
    else if($(this).prop("checked") == false ){
      ischecked.pop();
      if(ischecked.length === 0)
      {
      show_trash= false;
      }
    }
    if(show_trash == true)
    {
      var style_suppr = document.getElementById("supprimer_persos");
      style_suppr.style.display = "table-row";
    }    
  else if(show_trash == false)
  {
    var style_suppr = document.getElementById("supprimer_persos");
    style_suppr.style.display = "none";
  }

});
//Valide la suppression
  $('#button_suppr_persos').click(function()
      {
        var suppr_perso = new XMLHttpRequest();
        suppr_perso.open("POST","../php/requetetable.php",true)
        suppr_perso.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var obje = [];
        for(var i=0;i<ischecked.length;i++)
        {
          var convert_temp = [];
          convert_temp[i] =ischecked[i].split("o");
        
          obje[i] = document.getElementById("id_perso"+convert_temp[i][1]).value;
        }
        suppr_perso.send("suppr_perso_valid&perso="+obje);
        suppr_perso.onreadystatechange = function (){
        if(suppr_perso.readyState ==4)
        {
           var reponse = suppr_perso.responseText.split("/");     
          reponse.forEach(function(rep)
          {
            if(rep == "false")
            {
              alert("une erreur c'est produit !!");
            }
          });
        
          document.location.reload();
          
        }
      }
      });  

}

