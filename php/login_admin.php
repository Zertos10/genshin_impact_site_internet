<?php
session_start();
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
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link href="../css/login_page.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <title>Site admin page</title>
  <meta name="description" content="Site de gestion d'une base de données pour le jeu vidéo Genshin-Impact \n Regroupe les informations des joueur entrée dans la base de données">
  <meta name="author" content="Guillaume SIMON">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body id="body_load">

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


<section id="recherche_joueur" class="container p-3 my-3 ">

<input id="searchByPlayer" type="text" placeholder="Entrer le nom d'un joueur" class="form-control" >
</section>
<script src="../javascript/login_admin.js"></script>


<article id="joueur_trie" class="table-responsive"></article>

</body>
<script src="//code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</html>
