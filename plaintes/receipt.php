<?php 
    require('./fpdf185/fpdf.php');
    if(isset($_GET['id'])){
        if(filter_var($_GET['id'], FILTER_VALIDATE_INT)){
            $db_host="localhost";
            $db_user="atomx";
            $db_password="bruh669";
            $db_name="gestion_plaintes";
            $conn=mysqli_connect($db_host, $db_user, $db_password) or die('db connexion error');
            $db=mysqli_select_db($conn, 'gestion_plaintes') or die(mysqli_errno($conn));
            $id=mysqli_real_escape_string($conn, $_GET['id']);
            $sql = "SELECT * FROM Plainte WHERE NumPlainte=$id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $nomPlaignant="N/A";
                    $modeEmission="Inconnu";
                    $plaignant_id=$row['NumPlaignant'];
                    $sql1 = "SELECT * FROM Plaignant WHERE NumPlaignant='$plaignant_id' LIMIT 1";
                    $plaignantResult = mysqli_query($conn, $sql1);
                    if (mysqli_num_rows($plaignantResult) > 0) {
                        while($plaignant = mysqli_fetch_assoc($plaignantResult)) {
                            if($plaignant['NomPlaignant']!=null){
                                $nomPlaignant=$plaignant['NomPlaignant'];
                            }
                        }
                    }
                    $plainteContent="RECU DE DEPOT - PLAINTE No. ".$row['NumPlainte']."\n\n";
                    $plainteContent.="DETAILS DU PLAIGNANT"."\n";
                    $plainteContent.="PLAIGNANT No. PL-".$row['NumPlaignant']." : ".$nomPlaignant."\n\n";
                    $plainteContent.="DETAILS DE LA PLAINTE"."\n";
                    $plainteContent.="DATE : ".$row['DatePlainte']."\n";
                    $plainteContent.="OBJET : ".strtoupper(str_rot13(base64_decode($row['ObjetPlainte'])))."\n";
                    $plainteContent.="DESCRIPTION : ".str_rot13(base64_decode($row['DescriptionPlainte']))."\n";
                    $plainteContent.="MODE D'EMISSION : ".strtoupper($row['ModeEmission'])."\n";
                    $plainteContent.="\n\nVotre plainte a bien été prise en compte, merci de votre confiance!";
                    $pdf=new FPDF();
                    $pdf->AddPage();
                    $pdf->SetFont('Arial','B',12);
                    $pdf->MultiCell(120,10,iconv('UTF-8', 'windows-1252', $plainteContent));
                    $pdf->Output();       
                }
            }                
        }
    }
?>
