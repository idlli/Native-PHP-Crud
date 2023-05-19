<?php
  include 'config/database.php';

  $nom = $prenom = $nomutilisateur = $email = $motdepasse = "";
  $flag = true;

  function verifyInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }    

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["nom"]) || !preg_match('/^[a-zA-Z]{2}[a-zA-Z\s]{0,18}$/', $_POST["nom"])) {
      $nom = "Veuillez vérifier votre nom";
      $flag = false;
    }
    else $vnom = verifyInput($_POST["nom"]);

    if (empty($_POST["prenom"]) || !preg_match('/^[a-zA-Z]{2}[a-zA-Z\s]{0,28}$/', $_POST["prenom"])) {
      $prenom = "Veuillez vérifier votre prénom";
      $flag = false;
    }
    else $vprenom = verifyInput($_POST["prenom"]);

    if (empty($_POST["nomutilisateur"]) || !preg_match('/^[a-zA-Z0-9]{4,20}$/', $_POST["nomutilisateur"])) {
      $nomutilisateur = "Veuillez vérifier votre nom d'utilisateur";
      $flag = false;
    }
    else $vnomutilisateur = verifyInput($_POST["nomutilisateur"]);

    if (empty($_POST["email"]) || !preg_match('/^[a-zA-Z][a-zA-Z0-9._-]+@[a-zA-Z][a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/', $_POST["email"])) {
      $email = "Veuillez vérifier votre e-mail";
      $flag = false;
    }
    else $vemail = verifyInput($_POST["email"]);

    if (empty($_POST["motdepasse"]) || !preg_match('/^.{8,}$/', $_POST["motdepasse"])) {
      $motdepasse = "Veuillez vérifier votre mot de passe";
      $flag = false;
    }
    else $vmotdepasse = verifyInput($_POST["motdepasse"]);

    if ($flag) {

      $query = "INSERT INTO user VALUES (NULL, '$vnom', '$vprenom', '$vnomutilisateur', '$vemail', '$vmotdepasse')";
      $stmt = $con->prepare($query);
      if ($stmt->execute()) {
        header("Location: ./login.php");
      }

    }

  }
?>
<link rel="stylesheet" href="identification.css"/>
<script src="https://kit.fontawesome.com/0de603fa79.js" crossorigin="anonymous"></script>
<div class="form">
  <div class="form-panel">
    <div class="form-header">
      <h1>Créez votre compte</h1>
    </div>
    <div class="form-content">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="form-group">
          <label for="nom">Nom</label>
          <input type="text" id="nom" name="nom" required="required" value="<?php echo isset($_POST['nom']) ? $_POST['nom'] : '';?>">
          <p class="required"><?php echo $nom;?></p>
        </div>
        <div class="form-group">
          <label for="prenom">Prénom</label>
          <input type="text" id="prenom" name="prenom" required="required" value="<?php echo isset($_POST['prenom']) ? $_POST['prenom'] : '';?>">
          <p class="required"><?php echo $prenom;?></p>
        </div>
        <div class="form-group">
          <label for="nomutilisateur">Nom d'utilisateur</label>
          <input type="text" id="nomutilisateur" name="nomutilisateur" required="required" value="<?php echo isset($_POST['nomutilisateur']) ? $_POST['nomutilisateur'] : '';?>">
          <p class="required"><?php echo $nomutilisateur;?></p>
        </div>
        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '';?>">
          <p class="required"><?php echo $email;?></p>
        </div>
        <div class="form-group">
          <label for="motdepasse">Mot de passe</label>
          <input type="password" id="motdepasse" name="motdepasse" required="required">
          <p class="required"><?php echo $motdepasse;?></p>
        </div>
        <div class="form-group">
          <button type="submit">S’inscrire</button>
        </div>
      </form>
    </div>
  </div>
  <p class="form-info">Vous avez déjà un compte? <a href="./login.php">Se connecter</a>.</p>
</div>
<script>
  var docs = document.querySelectorAll(".required");
  for (var i = 0; i < docs.length; i++) {
    if (docs[i].innerHTML.length == 0) {
      docs[i].style.display = "none";
    } 
  }
</script>