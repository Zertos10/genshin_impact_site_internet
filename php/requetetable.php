<?php
session_start();
require("config.php");
//Vérifie si la session est toujours valide
if(empty($_SESSION['login'])) 
{
  // Si inexistante ou nulle, on redirige vers le formulaire de login
  header('Location: ../php/index.php?expire');
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
//Connection à la base de donnée
if (!$mysqli->real_connect($servername, $user  ,$password, $dbname,$port)) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
       }     
else
{
//Si la requête est pour l'affichage de l'équipement du personnage
if(isset($_GET["id_perso"]))
{
$q= $_GET["id_perso"];

//L'arme du personnage
if($arme_perso = $mysqli->query("SELECT * FROM personnage,arme WHERE personnage.ID_PERSONNAGE = arme.ID_PERSONNAGE AND personnage.ID_PERSONNAGE = $q")) 
{
echo("<tr>");
echo("<th>arme</th>");
echo("<th>nom de l'arme</th>");
echo("<th>Rareté de l'arme</th>");
echo("<th>Niveau de l'arme</th>");
echo("<th>Niveau de raffinement</th>");
echo("<tr>");


while($arme = mysqli_fetch_array($arme_perso))
{
echo"<tr >";
echo"<td><img alt='image de l'arme'></td>";
echo "<td>".$arme['NOM_ARME']."</td>";
echo"<td>".$arme['RARETE_ARME']."</td>";
echo"<td>".$arme['NIVEAU_ARME']."</td>";
echo"<td>".$arme['RANG_DE_RAFFINEMENT']."</td>";
echo"</tr>";
}

}
echo'<tr>';
echo '<td colspan="8"> </td>';
echo'<td></td>';
echo'<tr>';
//Les artéfact du personnage
if($artefact_perso = $mysqli->query("SELECT * FROM personnage,artefact WHERE personnage.ID_PERSONNAGE = artefact.ID_PERSONNAGE AND personnage.ID_PERSONNAGE = $q"))
{
echo("<tr>");
echo("<th>artéfact</th>");
echo("<th>Nom de l'artéfact</th>");
echo("<th>Rareté de l'artéfact</th>");
echo("<th>Niveau de l'artéfact</th>");
echo("<tr>");
while($artefact = mysqli_fetch_array($artefact_perso))
{

echo"<tr >";
echo"<td><img alt='image de l'artefact'></td>";
echo "<td>".$artefact['TYPE_ARTEFACT']."</td>";
echo"<td>".$artefact['RARETE_ARTEFACT']."</td>";
echo"<td>".$artefact    ['NIVEAU_ARTEFACT']."</td>";
echo"</tr>";
}
}   
$mysqli->close();    

}
//Si la réquête est pour le changement de l'avatar du joueur
if(isset($_GET["change_img"]))
{
    $change_avatar =  $_GET["change_img"];
    //Requête vers un fichier json pour les noms de personnage
    $joueur_id = $_GET["joueur_id"];
    $result_img  = json_decode(file_get_contents("../json/avatar.json"));
    $avatar = $result_img->avatar[$change_avatar];
    
    $name_avatar =$result_img->avatar_name[$change_avatar];
   $change_avatar =$mysqli->query("UPDATE joueur SET joueur.AVATAR = '$name_avatar' WHERE joueur.UID_JOUEUR = $joueur_id");
   $mysqli->close();    
}


}
//Si la réquête est pour le changement de donnée du joueur
if(isset($_GET["change_pseudo"]))
{
    $change_pseudo = $_GET["change_pseudo"];
    if($change_pseudo != null)
    {
    $joueur_id = $_GET["joueur_id"];
    $change_avatar =$mysqli->query("UPDATE joueur SET joueur.PSEUDO = '$change_pseudo' WHERE joueur.UID_JOUEUR = $joueur_id");
    }
  
    $mysqli->close();    

}
//Si la réquête est pour l'ajout d'un personnage (seulement le personnage )
if(isset($_POST["ajout_perso_valid"]))
{
    $personnage = htmlspecialchars($_POST["personnage"]);
    $level_const = htmlspecialchars($_POST["level_const"]);
    $level_apt_1 = htmlspecialchars($_POST["level_apt_1"]);
    $level_apt_2 = htmlspecialchars($_POST["level_apt_2"]);
    $level_apt_3 = htmlspecialchars($_POST["level_apt_3"]);
    $level_perso = htmlspecialchars($_POST["level_perso"]);
    $joueur_id = htmlspecialchars($_POST["joueur_id"]);
    $rank =null;
    $element = null;
    $result_rank = json_decode(file_get_contents("../json/avatar.json"));
    for($i = 0;$i<count($result_rank->avatar_name);$i++)
    {
        
        if($result_rank->avatar_name[$i] == $personnage)
        {
            $element = $result_rank->element_perso[$i];
            $rank = $result_rank->rank_perso[$i];
            break;    
        }
    }
    if($insert_perso =$mysqli->query("INSERT INTO personnage VALUE (NULL,$joueur_id,NULL,'$personnage','$rank','$element',$level_const,$level_apt_1,$level_apt_2,$level_apt_3,$level_perso)"))
    {
        $last_id = mysqli_insert_id($mysqli);
      
        echo("true/".$last_id);
        $last_id = null;
    }
    else
    {
        die("Erreur quelque chose c'est passée ...");
        echo("false");
    }


}
//Si la requête est pour l'ajout d'un personnage (seulement les armes)
if(isset($_POST["ajout_arme_valid"]))
{
    $arme = htmlspecialchars($_POST["arme"]);
    $rarete_arme = htmlspecialchars($_POST["rarete_arme"]);
    $level_arme = htmlspecialchars($_POST["level_arme"]);
    $atq_base_arme = htmlspecialchars($_POST["atq_base_arme"]);
    $level_raff = htmlspecialchars($_POST["level_raff"]);
    $id_perso = htmlspecialchars($_POST["id_perso"]);
    if($insert_arme =$mysqli->query("INSERT INTO `arme` VALUES (null,$id_perso,11,'$arme',$rarete_arme,$level_arme,$atq_base_arme,$level_raff)"))
    {
       $select_id_arme = $mysqli->query("SELECT `ID_ARME` from arme ORDER BY `ID_ARME` desc LIMIT 1");
    while($select_id = $select_id_arme->fetch_assoc()){
        $mysqli->query("UPDATE `personnage` SET `ID_ARME`= ".$select_id['ID_ARME']."  WHERE  personnage.ID_PERSONNAGE  = $id_perso");
        echo("true");
}    
    }
    else
    {
        die($mysqli->error);
        echo("false");
    }
}



//Si la requête est pour la suppresion d'un ou plusieurs personnage avec leur équipement
if(isset($_POST["suppr_perso_valid"]))
{
    $tab_num = $_POST["perso"];
   
    $split_num =explode(",",$tab_num);
   for($i = 0 ;$i<count($split_num);$i++)
  {
      //Suppression des armes de chaque personnages
        if($suppr_perso_arme = $mysqli->query("DELETE FROM arme WHERE  arme.ID_PERSONNAGE = ".$split_num[$i].""))
        {
            echo("arme_supprimer/");
        }
        else
        {
            die("Erreur quelque chose c'est passée ...");
            echo("false");
        }
              //Suppression des artéfact de chaque personnages
        if($suppr_perso_arme = $mysqli->query("DELETE FROM artefact WHERE  artefact.ID_PERSONNAGE = ".$split_num[$i].""))
        {
            echo("artefact_supprimer/");
        }
        else
        {
            die("Erreur quelque chose c'est passée ...");
            echo("false");
        }
      
      
  //Suppression des personnage
    if($suppr_perso =$mysqli->query("DELETE FROM personnage WHERE  personnage.ID_PERSONNAGE = ".$split_num[$i].""))
    {
        echo("personnage_supprimer/");
    }
    else
    {
        die("Erreur quelque chose c'est passée ...");
        echo("false");
    }
    
  }
}

?>