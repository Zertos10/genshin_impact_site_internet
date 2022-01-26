<!DOCTYPE html>
<html>
<head>
<meta http-equiv= »Content-Type » content= »text/html; charset=utf-8″ />
    <title>Connexion utilisateur</title>
    <link href="../css/style.css" rel="stylesheet" >
</head>
<?php
 require("config.php");
  // Definition des constantes et variables

  $errorMessage = '';
 
  // Test de l'envoi du formulaire
  if(!empty($_POST)) 
  {
    // Les identifiants sont transmis ?
    if(!empty($_POST['PSEUDO']) && !empty($_POST['MOT_DE_PASSE'])) 
    {
      $username = htmlspecialchars($_POST['PSEUDO']);
      $password = htmlspecialchars($_POST['MOT_DE_PASSE']);
        //$link = mysqli_connect("192.168.102.5","Noah","Noah","base_genshin-impact", '3308');
        $link = mysqli_connect($servername,"user","user",$dbname, $port);

        if (!$link) {
            die('Erreur de connexion (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
            exit();
        }
     else
     {
      if($connextion = $link->query("SELECT access FROM droit_utilisateur WHERE droit_utilisateur.username = '$username' AND droit_utilisateur.password = '$password'"))
  {
    $row = $connextion->fetch_array(MYSQLI_ASSOC);
    if($row != null)
      {
             // On ouvre la session
        session_start();
        // On enregistre le login en session
        $_SESSION['login'] = htmlspecialchars($_POST["PSEUDO"]);
        $_SESSION['password'] = htmlspecialchars($_POST["MOT_DE_PASSE"]);     
        // On redirige vers l'interface utilisateur
        if($row["access"] == "user")
        {
        header('Location: connexion2.0.php');
        }
        else if ($row["access"] == "admin")
        {
          //Connextion a l'interface administrateur
          
          header('Location: login_admin.php');

        }
        exit();
      }
      else{
        $error_auth = true;    
        ?> <input type="hidden" name="error_auth" value="<?php echo $error_auth ?>">
        <?php      
       }
      }
     
     mysqli_close($link);
      }
    }
  }
  else
  {
      $errorMessage = 'Mauvais mot de passe ou identifiant! Recommencez!';
  }
?>
<body class="text-center">
    <section class="form-signin">
        <article>
            <form class="box" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                <h1  class="box-title">Connexion </h1>
                <label >Nom utilisateur:</label>
                <input type="text" class="box-input" name="PSEUDO" placeholder="Nom d'utilisateur" value='' required>
                <br>
                <label>Mot de passe :</label>
                <input type="password" class="box-input" name="MOT_DE_PASSE" placeholder="Mot de passe" value='' required>
                <br>
                <input type="submit" name="submit" value='Se connecter' class="box-button">    
				<br>
				<a href="Inscription.php">S'inscrire</a>
            </form>
        </article>
    </section>
</body>
</html> 