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

//requete donne tout la table joueur 
if(isset($_GET["username"]))
{
$q= $_GET["username"];
  echo "<br>";
if($q=="")
{
$result = $mysqli->query("SELECT * FROM `joueur` WHERE 1");
$correspond = true;
}
else
{
if($result = $mysqli->query("SELECT * FROM `joueur` WHERE PSEUDO  LIKE '%$q%'"))
{
  $correspond =true;
}
else
{
  echo "Erreur";
  $correspond =false;
}
}
if($correspond)
{

 echo "<table class='table table-striped'>
<tr>
<th>Pseudo</th>
<th>Email</th>
<th>Commentaire</th>
<th>Niveau</th>
<th>Anniversaire</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td><a href='../php/profil_player.php?id=".$row['UID_JOUEUR']."'> ". $row['PSEUDO']."</a></td>";
  echo "<td>" . $row['MAIL'] . "</td>";
  echo "<td>" . $row['COMMENTAIRE_PROFIL'] . "</td>";
  echo "<td>" . $row['NIVEAU'] . "</td>";
  echo "<td>" . $row['ANNIVERSAIRE'] . "</td>";
  echo "</tr>";
}
echo "</table>";
}
$mysqli->close();    
}


}

?>