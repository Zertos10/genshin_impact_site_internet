<?php
  // Definition des constantes et variables
require("config.php");


  $errorMessage = '';
 
  // Test de l'envoi du formulaire
  if(!empty($_POST)) 
  {
    // Les identifiants sont transmis ?
    if(!empty($_POST['login']) && !empty($_POST['password'])) 
    {
      $username = htmlspecialchars($_POST['login']);
      $password = htmlspecialchars($_POST['password']);
        $link = mysqli_connect($servername,"user","user", $dbname,$port);
        if (!$link) {
            die('Erreur de connexion (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
            exit();
        }
     else
     {
      if($connextion = $link->query("SELECT * FROM droit_utilisateur WHERE droit_utilisateur.username = '$username' AND droit_utilisateur.password = '$password' "))
  {
      $rows =  $connextion->num_rows;
      if($rows == 1)
      {
             // On ouvre la session
        session_start();
        // On enregistre le login en session
        $_SESSION['login'] = htmlspecialchars($_POST["login"]);
        $_SESSION['password'] = htmlspecialchars($_POST["password"]);     
        // On redirige vers le fichier admin.php
        header('Location: login_admin.php');
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
      $errorMessage = 'Veuillez inscrire vos identifiants svp !';
  }
  

?>

<html>
<head>
    
<meta http-equiv= »Content-Type » content= »text/html; charset=utf-8″ />
    <title>Panel administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="../css/index.css" rel="stylesheet">
</head>
<body class="text-center">
    <section class="form-signin">
        <article>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                <h1 class="h3 mb-3 fw-normal">Identification Base de donnee </h1>
                <label >Nom utilisateur:</label>
                <input   class="form-control" type="text" name="login" value=''>
                <br>
                <label>Mot de passe :</label>
                <input class="form-control" type="password" name="password" value=''>
                <br>
                <input class="w-100 btn btn-lg btn-primary" type="submit" name="submit" value='Se connecter'>            
            </form>
        </article>
    </section>
    <script src="../javascript/index.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html> 