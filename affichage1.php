<?php // content="text/plain; charset=utf-8"
include 'config/database.php';
require_once ('fpdf185/fpdf.php');

$query = "SELECT Id, Cin, Nom, Prenom, Diplome FROM Etudiant ORDER BY Nom";
$stmt = $con->query("SELECT Id, Cin, Nom, Prenom, Diplome FROM Etudiant ORDER BY Nom");
$etudiants = $stmt->fetchAll();

$stmt = $con->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();

            $pdf = new FPDF();

            $pdf->AddPage();
            
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(40, 10, 'ID');
            $pdf->Cell(60, 10, 'Cin');
            $pdf->Cell(60, 10, 'Nom');
            $pdf->Cell(60, 10, 'Prenom');
            $pdf->Cell(60, 10, 'Diplome');
            $pdf->Ln();
            
            foreach ($etudiants as $etud) {
                $pdf->Cell(40, 10, $etud['Id']);
                $pdf->Cell(60, 10, $etud['Cin']);
                $pdf->Cell(60, 10, $etud['Nom']);
                $pdf->Cell(60, 10, $etud['Prenom']);
                $pdf->Cell(60, 10, $etud['Diplome']);
                $pdf->Ln();
            }
            
            $pdf->Output();


?>