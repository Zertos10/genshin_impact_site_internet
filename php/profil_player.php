

<?php
session_start();
require("config.php");

// On teste si la variable de session existe et contient une valeur
if(empty($_SESSION['login'])) 
{
  // Si inexistante ou nulle, on redirige vers le formulaire de login
  header('Location: http://127.0.0.1/admin_configuration/php/index.php?expire');
  exit();
}
else
{
    $user = $_SESSION["login"];
    $password = $_SESSION["password"];
    
}
$mysqli = mysqli_init();
if (!$mysqli) {
    die('mysqli_init failed');
}

if (!$mysqli->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) {
    die('Setting MYSQLI_INIT_COMMAND failed');
}

if (!$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5)) {
    die('Setting MYSQLI_OPT_CONNECT_TIMEOUT failed');
}

if (!$mysqli->real_connect($servername, $user ,$password, $dbname,$port)) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
       }     
else
{
//echo 'Succès... ' . $mysqli->host_info . "\n";

//requete donne tout la table joueur 
if(isset($_GET["id"] ))
{
  $id_joueur = htmlspecialchars($_GET["id"]);
  //$result = $mysqli->query("SELECT * FROM `joueur` WHERE PSEUDO ='$q'");
  $inventaire_joueur =$mysqli->query("SELECT * FROM joueur , inventaire WHERE joueur.ID_INVENTAIRE = inventaire.ID_INVENTAIRE AND joueur.UID_JOUEUR = '$id_joueur'");

while($row = mysqli_fetch_array($inventaire_joueur)) {
  $pseudo =$row["PSEUDO"];
  $mail =$row["MAIL"];
  $commentaire_profil =$row["COMMENTAIRE_PROFIL"]; 
  $niveau =$row["NIVEAU"];
  $exp_actuelle =$row["EXP_ACTUELLE"];
  $niveau_monde =$row["NIVEAU_MONDE"];
  $anniv =$row["ANNIVERSAIRE"];
  $avatar =$row["AVATAR"];
  $niv_statue_anemo =$row["NIV_STATUE_ANEMO"];
  $niv_statue_geo =$row["NIV_STATUE_GEO"];
  $quantite_mora =$row["QUANTITE_MORA"];
  $quantite_primo_gemmes =$row["QUANTITE_PRIMO_GEMMES"];
}

$file = '../json/avatar.json'; 
// mettre le contenu du fichier dans une variable
$data = file_get_contents($file); 
// décoder le flux JSON
$obj = json_decode($data); 
// accéder à l'élément approprié
$taille_avatar = count($obj->avatar_name);
$avatarnumb = 0;
for( $i=0;$i<$taille_avatar;$i++)
{
  if($avatar == $obj->avatar_name[$i])
  {
    
    $avatarnumb = $i;
 
  }
  
  
  
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta name="description" content="Site de gestion d'une base de données pour le jeu vidéo Genshin-Impact \n Regroupe les informations des joueur entrée dans la base de données">
  <meta name="author" content="Guillaume SIMON">
  <title>Page de <?php echo $pseudo?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <link href="../css/profil_player.css" rel="stylesheet">
  <link href="../css/profil_player_beau.css" rel="stylesheet">

</head>
<body id="body">
  <header>

<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <a class="navbar-brand"  href="login_admin.php">Base de données Genshin Impact</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse flex-row-reverse" id="collapsibleNavbar">
    <ul class="navbar-nav">
    <li class="nav-item ml-auto" id="switch_compte">
        <a class="nav-link" href="connexion2.0.php">Passer en interface utilisateur</a> 
</li>
      <li class="nav-item  ml-auto" id="deconnexion">
        <a class="nav-link" href="#">Se déconnecter</a>
      </li> 
     
    </ul>
  </div>  
</nav>


</header>
<section  id="profil_player">
<section id="info_joueur">
<img id="img_avatar" src='../image/avatar/img_avatar_<?php echo $avatarnumb; ?>.jpg'  alt="Image de l'avatar du joueur">

<article id="administration_joueur">
<div id="img_choose">
  <article class="img_choose-content">
  <table>
    <tr>
      <?php
      $result_img  = json_decode(file_get_contents("../json/avatar.json"));
     // var_dump($result_img);
     // $parsed_img =json_decode($result_img,true);
     $avatar = $result_img->avatar;
     $avatar_name = $result_img->avatar_name;
     echo("<tr>");
     echo("<td>");
     for($i =0;$i<count($avatar);$i++)
     { 
	 
       echo("<img id='img_avatar_".$avatar[$i]."' class='img' src='../image/avatar/img_avatar_".$avatar[$i].".jpg'  alt='image de ".$avatar_name[$i]."'>");
      }
      echo("</td>");
      echo("</tr>");
      ?>
       </tr>
      </table>

</article>
</div>
<label id="pseudo_joueur" class="modif"><?php echo $pseudo ;?></label>
<input type="hidden" id="id_joueur"  value= "<?php echo $id_joueur ?>">
<input type='button' id="Suppr_joueur"  value='Supprimer joueur'>

<label id='mail'><?php echo $mail ;?></label>
<article id='niveau' class="container">
  <div class="skills html">
    <label id="niv_avant" class="modif"><?php echo  $niveau ;?></label>
    <input type="hidden" id="exp_avant" value="<?php echo $exp_actuelle?>">
  </div>

</article>
</article>
<article id="arg_niv">
<article id='niv_monde'>
<label>Niveau monde :<?php echo $niveau_monde ;?></label>
<img></img>
</article>
<article id="niv_geo">
<label >Niveau statue géo : <?php echo $niv_statue_geo ;?></label>
<img></img>
</article>
<article id='niv_anemo' >
<label id="niv_anemo_label" class="modif">Niveau anemo <?php echo $niv_statue_anemo ; ?></label>
</article>


</article>
<article id='moras'>

<label id="quantite_mora" class="modif"><?php echo $quantite_mora ;?></label>

</article>
<article id='primo_gemme' >
<label class="modif" id="primo-gemme"><?php echo $quantite_primo_gemmes ; ?></label>
</article>
</section>

</article>

<section id="description_joueur">
<article>
  <h4>Description: </h4>
<p  id='description' class="modif"><?php echo $commentaire_profil ;?></p>
</article>

</section>




<section id="personnage" class="table-responsive">
<article id="liste_perso" >
<table class="table table-dark table-hover " id="tab_perso">
<tr>
<th>Nom personnage</th>
<th>Rarete </th>
<th>élement</th>
<th>niveau constellation</th>
<th>niveau aptitude 1</th>
<th>niveau aptitude 2</th>
<th>niveau aptitude 3</th>
<th>niveau perso</th>
<th><button style="background: rgba(255,255,255,0);" id="ajout_perso"><img src="../image/icon/add.png" style="width:50px ; height:50px;"></img></button></th>
</tr>
<?php 
$number =0;
$perso_joueur = $mysqli->query("SELECT * FROM joueur,personnage WHERE joueur.UID_JOUEUR = personnage.UID_JOUEUR AND joueur.UID_JOUEUR = '$id_joueur'");
while($perso = mysqli_fetch_array($perso_joueur))
 {

  echo "<tr >";
  echo "<td><a href='javascript:void(0)' id='nom_perso".$number."'>". $perso['NOM_PERSO']."</a><input type='hidden' id='id_perso".$number."' value=".$perso['ID_PERSONNAGE']."></td>";
  echo "<td>" . utf8_encode($perso['RARETE']) . "</td>";
  echo "<td>" . $perso['ELEMENT'] . "</td>";
  echo "<td>" . utf8_encode($perso['NIVEAU_CONSTELLATION']) . "</td>";
  echo "<td>" . utf8_encode($perso['NIV_APTITUDE_1']). "</td>";
  echo "<td>" . utf8_encode($perso['NIV_APTITUDE_2']). "</td>";
  echo "<td>" . utf8_encode($perso['NIV_APTITUDE_3']) . "</td>";
  echo "<td>" . utf8_encode($perso['NIVEAU_PERSO']) . "</td>";
  echo "<td><input type='checkbox' id='suppr_perso".$number."' class='perso_select'></td>";
  echo "</tr>";
  $number++;
}
?>
<tr id="supprimer_persos">
  <td colspan="8"> </td>
  <td><input type="image" id="button_suppr_persos" src="../image/icon/trash-symbol_blanc.png" ></td>
</tr>
</table>

</article>
<article>
  <table id="possesion_perso" class="table table-dark table-hover " ></table>
</article>  




<div id="ajout_tableau">
  <div class="ajout_tableau_content">
  <div class="ajout_tableau-header">
      <span class="close">&times;</span>
      <h2>Ajout d'un nouveau personnage</h2>
    </div>
    <div id="ajout_personnage">
        <label>Personnage :</label>
        <select id="personnage-selection" name="personnage">
        <option value="" >--Choisir un personnage--</option>      
      </select>
        <br>
        <label>Niveau constellation :</label> 
        <input type="number" id="level_const" name='level_const' min="0" max="5">
        <br>
        <label>Niveau aptitude 1:</label>
        <input type="number" id="level_apt_1" name='level_apt_1' min="1" >
        <br>
        <label>Niveau aptitude 2:</label>
        <input type="number" id="level_apt_2" name='level_apt_2' min="1">
        <br>
        <label>Niveau aptitude 3:</label>
        <input type="number" id="level_apt_3" name='level_apt_3' min="1">
        <br>
        <label>Niveau personnage :</label>
        <input type="number" id="level_perso" name='level_perso' min="1" max="90" >
        <input type="submit" id="ajout_perso_valid" value="Suivant" >
  
    </div>
    <div id="ajout_arme-body">

      <br>
      <label>Nom de l'arme</label>
      <input type="text" id="arme_nom" name='arme_nom'>
        <br>
        <label>Rarete :</label> 
        <input type="number" id="rarete_arme" name='rarete_arme' min="1" max="5">
        <br>
        <label>Niveau arme:</label>
        <input type="number" id="level_arme" name='level_arme' min="1" max="90">
        <br>
        <label>Attaque de base de l'arme:</label>
        <input type="number" id="atq_base_arme" name='atq_base_arme' min=0>
        <br>
        <label>Rang de rafinement :</label>
        <input type="number" id="level_raff" name='level_raff' min="0" max="5">
        <br>
        <input type="submit" id="ajout_arme_valid" value="Créer personnage" >
  
    </div>
    <div id="arme_selection">
     
      
</div>
    <div class="ajout_tableau-footer">
    
    </div>
    </div>
</div>

</section>
</section>
<script src="//code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="../javascript/personnage/personnage_ajout.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../javascript/profil_player.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>


</body>
<foot>
  
</foot>
</html>
<?php

}
}
?>