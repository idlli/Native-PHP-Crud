<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="style.css"/>
    <title>Ajouter un etudiant</title>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Créer un etudiant</h1>
        </div>
            <?php
            if($_POST){
                include 'config/database.php';
                try{
                    $query = "INSERT INTO Etudiant
                                SET Cin=:cin, Nom=:nom, Prenom=:prenom,
                                    Diplome=:diplome, DateNaissance=:datenaissance, Image=:image";
                    $stmt = $con->prepare($query);

                    $cin=htmlspecialchars(strip_tags($_POST['Cin']));
                    $nom=htmlspecialchars(strip_tags($_POST['Nom']));
                    $prenom=htmlspecialchars(strip_tags($_POST['Prenom']));
                    $diplome=htmlspecialchars(strip_tags($_POST['Diplome']));
                    $datenaissance=htmlspecialchars(strip_tags($_POST['DateNaissance']));

                    $image=!empty($_FILES["Image"]["name"])
                            ? sha1_file($_FILES['Image']['tmp_name']) . "-" . basename($_FILES["Image"]["name"])
                            : "";
                    $image=htmlspecialchars(strip_tags($image));

                    $stmt->bindParam(':cin', $cin);
                    $stmt->bindParam(':nom', $nom);
                    $stmt->bindParam(':prenom', $prenom);
                    $stmt->bindParam(':diplome', $diplome);
                    $stmt->bindParam(':datenaissance', $datenaissance);
                    $stmt->bindParam(':image', $image);

                    if($stmt->execute()){
                        echo "<div class='alert alert-success'>Record was saved to database.</div>";
                        if($image){
                            $target_directory = "uploads/";
                            $target_file = $target_directory . $image;
                            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                            $file_upload_error_messages="";
                            $check = getimagesize($_FILES["Image"]["tmp_name"]);
                            if($check===false){
                                $file_upload_error_messages.="<div>Submitted file is not an image.</div>";
                            }
                            $allowed_file_types=array("jpg", "jpeg", "png", "gif");
                            if(!in_array($file_type, $allowed_file_types)){
                                $file_upload_error_messages.="<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                            }
                            if(file_exists($target_file)){
                                $file_upload_error_messages.="<div>Image already exists. Try to change file name.</div>";
                            }
                            if($_FILES['Image']['size'] > (1024000)){
                                $file_upload_error_messages.="<div>Image must be less than 1 MB in size.</div>";
                            }
                            if(!is_dir($target_directory)){
                                mkdir($target_directory, 0777, true);
                            }
                            if(empty($file_upload_error_messages)){
                                if(!move_uploaded_file($_FILES["Image"]["tmp_name"], $target_file)){
                                    echo "<div class='alert alert-danger'>";
                                        echo "<div>Unable to upload photo.</div>";
                                        echo "<div>Update the record to upload photo.</div>";
                                    echo "</div>";
                                }
                            }
                            else{
                                echo "<div class='alert alert-danger'>";
                                    echo "<div>{$file_upload_error_messages}</div>";
                                    echo "<div>Update the record to upload photo.</div>";
                                echo "</div>";
                            }
                        }
                    }else{
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }

                }
                catch(PDOException $exception){
                    die('ERROR: ' . $exception->getMessage());
                }
            }
            ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
        <table class='my-stable'>
            <tr>
                <td>Cin :</td>
                <td><input type='text' name='Cin' placeholder="Votre cin"/></td>
            </tr>
            <tr>
                <td>Nom :</td>
                <td><input type='text' name='Nom' placeholder="Votre nom"/></td>
            </tr>
            <tr>
                <td>Prenom :</td>
                <td><input type='text' name='Prenom' placeholder="Votre prenom"/></td>
            </tr>
            <tr>
                <td>Diplome :</td>
                <td><select name="Diplome">
                    <option value="DEUG">DEUG</option>
                    <option value="DEUST">DEUST</option>
                    <option value="DUT">DUT</option>
                    <option value="BTS">BTS</option>
                    <option value="DTS">DTS</option>
                    <option value="Autre">Autre</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Date de naissance :</td>
                <td><input type="date" name="DateNaissance"/></td>
            </tr>
            <tr>
                <td>Photo :</td>
                <td><input type="file" name="Image" /></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Enregistrer' class='btn-save' />
                    <a href='index.php' class='btn-back'>Retour à list des etudiants</a>
                </td>
            </tr>
        </table>
    </form>
    </div>
</body>
</html>
