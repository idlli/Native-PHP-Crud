<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="style.css"/>
    <script src="https://kit.fontawesome.com/0de603fa79.js" crossorigin="anonymous"></script>
    <title>CRUD PHP Native</title>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>List des etudiants</h1>
            
            <?php 
                require_once ('jpgraph-4.3.0/src/jpgraph.php');
                require_once ('jpgraph-4.3.0/src/jpgraph_line.php');
                include 'config/database.php';
                session_start();
                $query = "SELECT lname, fname FROM user WHERE id = ? LIMIT 0,1";
                $stmt = $con->prepare($query);
                $stmt->bindParam(1, $_SESSION["id"]);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
        </div>
        <div class="mid-container">
            <?php
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $records_per_page = 9;
            $from_record_num = ($records_per_page * $page) - $records_per_page;
            $action = isset($_GET['actilert alon']) ? $_GET['action'] : "";
            if($action == 'deleted'){
                echo "<div class='aert-success'>Record was deleted.</div>";
            }
            $query = "SELECT Id, Cin, Nom, Prenom, Diplome, Image FROM Etudiant ORDER BY Nom DESC LIMIT :from_record_num, :records_per_page";
            $stmt = $con->prepare($query);
            $stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
            $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
            $stmt->execute();
            $num = $stmt->rowCount();

            echo "<div class='mid-buttons'><a href='create.php' class='btn-add'><i class='fa-solid fa-user-plus'></i>Ajouter un etudiant</a>
            <a href='affichage.php' class='btn-add'>Afficher le graph</a>
            <a href='affichage1.php' class='btn-add'>List des etudiants (pdf)</a></div>";

            if($num>0){

                echo "<div class='my-container'>";
                    // echo "<thead>";
                    // echo "<tr>";
                    //     echo "<th>Cin</th>";
                    //     echo "<th>Nom</th>";
                    //     echo "<th>Prenom</th>";
                    //     echo "<th>Diplome</th>";
                    //     echo "<th>Date de Naissance</th>";
                    //     echo "<th>Action</th>";
                    // echo "</tr>";
                    // echo "</thead>";
                    // echo "<tbody>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        $image = htmlspecialchars($Image, ENT_QUOTES);
                        // echo "<tr>";
                        //     echo "<td>{$Cin}</td>";
                        //     echo "<td>{$Nom}</td>";
                        //     echo "<td>{$Prenom}</td>";
                        //     echo "<td>{$Diplome}</td>";
                        //     echo "<td>{$DateNaissance}</td>";
                        //     echo "<td>";
                        //         echo "<a href='read_one.php?id={$Id}' class='btn-read'>Afficher</a>";
                        //         echo "<a href='update.php?id={$Id}' class='btn-edit'>Modifier</a>";
                        //         echo "<a href='#' onclick='delete_user({$Id});'  class='btn-delete'>Supprimer</a>";
                        //     echo "</td>";
                        // echo "</tr>";

                        echo "<div class=\"etud-card\">";
                        echo "<div class=\"etud-img\">";
                        echo "<a href='read_one.php?id={$Id}'><img src=\"uploads/{$image}\"/></a>";
                        echo "</div>";
                        echo "<div class=\"etud-info\">";
                        echo "<div class=\"etud-buttons\">";
                        echo "<a class=\"edit\" href=\"update.php?id={$Id}\"></a>";
                        echo "<a class=\"delete\" href=\"#\" onclick=\"delete_user({$Id});\"></a>";
                        echo "</div>";
                        echo "<div class=\"etud-details\">";
                        echo "<p class=\"name\"><a href='read_one.php?id={$Id}'>{$Nom} {$Prenom}</a></p>";
                        echo "<p class=\"cin\">{$Cin}</p>";
                        echo "<p class=\"diplome\">{$Diplome}</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                    // echo "</tbody>";
                echo "</div>";

                $query = "SELECT COUNT(*) as total_rows FROM Etudiant";
                $stmt = $con->prepare($query);
                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $total_rows = $row['total_rows'];
                $page_url="index.php?";
                include_once "paging.php";
            }

            else{
                echo "<div class='alert alert-danger'>No records found.</div>";
            }

            ?>
        </div>
    </div>
<a href="#" onclick="logout();" class="log-out">Se déconnecter</a>
<script type='text/javascript'>
function delete_user( id ){
    var answer = confirm('Êtes-vous sûr?');
    if (answer){
        window.location = 'delete.php?id=' + id;
    }
}
function logout(){
    window.location = 'login.php';
}
</script>
</body>
</html>
