<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="style.css"/>
    <title>Afficher un etudiant</title>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Informations personnelles</h1>
        </div>
            <?php
            $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
            include 'config/database.php';
            try {
                $query = "SELECT Id, Nom, Prenom, Diplome, Image, DateNaissance FROM Etudiant WHERE id = ? LIMIT 0,1";
                $stmt = $con->prepare( $query );
                $stmt->bindParam(1, $id);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $nom = $row['Nom'];
                $prenom = $row['Prenom'];
                $diplome = $row['Diplome'];
                $image = htmlspecialchars($row['Image'], ENT_QUOTES);
                $DateNaissance = $row['DateNaissance'];
            }
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
            ?>
        <table class='my-stable'>
            <tr>
                <td>Nom :</td>
                <td><?php echo htmlspecialchars($nom, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Prenom :</td>
                <td><?php echo htmlspecialchars($prenom, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Diplome :</td>
                <td><?php echo htmlspecialchars($diplome, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>DateNaissance :</td>
                <td><?php echo htmlspecialchars($DateNaissance, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Image :</td>
                <td>
                <?php echo $image ? "<img src='uploads/{$image}' style='width:300px;' />" : "No image found.";  ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href='index.php' class='btn-back'>Retour à list des etudiants</a>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
