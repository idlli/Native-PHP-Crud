<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="style.css"/>
    <title>Modifier un etudaint</title>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Modifier les informations</h1>
        </div>
                    <?php
                    $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
                    include 'config/database.php';
                    try {
                        $query = "SELECT Id, Cin, Nom, Prenom, Diplome FROM Etudiant WHERE id = ? LIMIT 0,1";
                        $stmt = $con->prepare( $query );
                        $stmt->bindParam(1, $id);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        $cin = $row['Cin'];
                        $nom = $row['Nom'];
                        $prenom = $row['Prenom'];
                        $diplome = $row['Diplome'];
                    }
                    catch(PDOException $exception){
                        die('ERROR: ' . $exception->getMessage());
                    }
                    ?>
                         <?php
                        $Id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
                        include 'config/database.php';
                        if($_POST){
                            try{
                                $query = "UPDATE Etudiant
                                            SET Cin=:cin, Nom=:nom, Prenom=:prenom, Diplome=:diplome
                                            WHERE Id=:id";
                                $stmt = $con->prepare($query);

                                $cin=htmlspecialchars(strip_tags($_POST['Cin']));
                                $nom=htmlspecialchars(strip_tags($_POST['Nom']));
                                $prenom=htmlspecialchars(strip_tags($_POST['Prenom']));
                                $diplome=htmlspecialchars(strip_tags($_POST['Diplome']));

                                $stmt->bindParam(':cin', $cin);
                                $stmt->bindParam(':nom', $nom);
                                $stmt->bindParam(':prenom', $prenom);
                                $stmt->bindParam(':diplome', $diplome);
                                $stmt->bindParam(':id', $id);

                                if($stmt->execute()){
                                    echo "<div class='alert alert-success'>Record was updated.</div>";
                                }else{
                                    echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                                }

                            }

                            catch(PDOException $exception){
                                die('ERROR: ' . $exception->getMessage());
                            }
                        }
                        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
            <table class='my-stable'>
                <tr>
                    <td>Cin :</td>
                    <td><input type='text' name='Cin' value="<?php echo htmlspecialchars($cin, ENT_QUOTES);  ?>" /></td>
                </tr>
                <tr>
                    <td>Nom :</td>
                    <td><input type='text' name='Nom' value="<?php echo htmlspecialchars($nom, ENT_QUOTES);  ?>"/></td>
                </tr>
                <tr>
                    <td>Prenom :</td>
                    <td><input type='text' name='Prenom' value="<?php echo htmlspecialchars($prenom, ENT_QUOTES);  ?>"/></td>
                </tr>
                <tr>
                    <td>Diplome :</td>
                    <td>
                        <select name="Diplome" value="<?php echo htmlspecialchars($diplome, ENT_QUOTES);?>">
                            <option value="DEUG">DEUG</option>
                            <option value="DEUST">DEUST</option>
                            <option value="DUT">DUT</option>
                            <option value="BTS">BTS</option>
                            <option value="DTS">DTS</option>
                            <option value="Autre">Autre</option>
                        </select></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Sauvegarder les modifications' class='btn-save' />
                        <a href='index.php' class='btn-back'>Retour à list des etudiants</a>
                    </td>
                </tr>
            </table>
            </form>
    </div>
</body>
</html>
