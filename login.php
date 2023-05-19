<?php
  include 'config/database.php';
  $nomutilisateur = $motdepasse = $error = "";
  $flag = true;

  function verifyInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }    

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["nomutilisateur"]) || !preg_match('/^[a-zA-Z0-9]{4,20}$/', $_POST["nomutilisateur"])) {
      $nomutilisateur = "Veuillez vérifier votre nom d'utilisateur";
      $flag = false;
    }
    else $vnomutilisateur = verifyInput($_POST["nomutilisateur"]);

    if (empty($_POST["motdepasse"]) || !preg_match('/^.{8,}$/', $_POST["motdepasse"])) {
      $motdepasse = "Veuillez vérifier votre mot de passe";
      $flag = false;
    }
    else $vmotdepasse = verifyInput($_POST["motdepasse"]);

    if ($flag) {

      try {
        $query = "SELECT id FROM user WHERE username = ? AND password = ? LIMIT 0,1";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $vnomutilisateur);
        $stmt->bindParam(2, $vmotdepasse);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {

          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          session_start();
          $_SESSION['id'] = $row['id'];
          header("Location: ./index.php");
        }
        else {
          $error = "l'utilisateur est introuvable";
        }
      }
      catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
      }

    }

  }
?>
<link rel="stylesheet" href="identification.css"/>
<script src="https://kit.fontawesome.com/0de603fa79.js" crossorigin="anonymous"></script>
<div class="form">
  <div class="form-panel">
    <div class="form-header">
      <h1>Account Login</h1>
    </div>
    <div class="form-content">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="form-group">
          <label for="nomutilisateur">Nom d'utilisateur</label>
          <input type="text" id="nomutilisateur" name="nomutilisateur" required="required" value="<?php echo isset($_POST['nomutilisateur']) ? $_POST['nomutilisateur'] : '';?>">
          <p class="required"><?php echo $nomutilisateur;?></p>
        </div>
        <div class="form-group">
          <label for="motdepasse">Mot de passe</label>
          <input type="password" id="motdepasse" name="motdepasse" required="required">
          <p class="required"><?php echo $motdepasse;?></p>
        </div>
        <div class="form-group">
          <button type="submit">Se connecter</button>
          <p class="required"><?php echo $error;?></p>
        </div>
      </form>
    </div>
  </div>
  <p class="form-info">Vous n'avez pas de compte? <a href="./sign-up.php">S'inscrire</a>.</p>
</div>
<script>
  var docs = document.querySelectorAll(".required");
  for (var i = 0; i < docs.length; i++) {
    if (docs[i].innerHTML.length == 0) {
      docs[i].style.display = "none";
    } 
  }
</script>