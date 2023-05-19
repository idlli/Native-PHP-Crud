<?php // content="text/plain; charset=utf-8"
include 'config/database.php';
require_once ('jpgraph-4.3.0/src/jpgraph.php');
require_once ('jpgraph-4.3.0/src/jpgraph_pie.php');
// Some data
$datan = array();
// Some data
$data = array(40,21,17,14,23);

// Create the Pie Graph. 
$graph = new PieGraph(350,250);

$theme_class="DefaultTheme";
//$graph->SetTheme(new $theme_class());

// Set A title for the plot
$graph->title->Set("A Simple Pie Plot");
$graph->SetBox(true);


$query = "SELECT Diplome, Count(*) AS NDiplome FROM Etudiant Group BY Diplome";
$stmt = $con->prepare($query);
$stmt->execute();
$num = $stmt->rowCount();

if($num>0){
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        array_push($datan, $NDiplome);
    }
}


// Create
$p1 = new PiePlot($datan);
$graph->Add($p1);

$p1->ShowBorder();
$p1->SetColor('black');
$p1->SetSliceColors(array('#1E90FF','#2E8B57','#ADFF2F','#DC143C','#BA55D3'));
$graph->Stroke();


?>