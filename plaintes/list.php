<?php 
    $db_host="localhost";
    $db_user="atomx";
    $db_password="bruh669";
    $db_name="gestion_plaintes";
    $conn=mysqli_connect($db_host, $db_user, $db_password) or die('db connexion error');
    $db=mysqli_select_db($conn, 'gestion_plaintes') or die(mysqli_errno($conn));
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" required>
    <title>Liste des Plaintes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
</head>
<body>
    <h1 class="text-center mt-3">LISTE DES PLAINTES</h1>
    <p class="text-center mb-5">
        <a href="/plaintes/new.php">Soumettre une plainte &rarr;</a>
    </p>
    <div class="row">
        <div class="col-lg-9 mx-auto">
            <table id="dataTable" class="dt table table-responsive border">
                <thead>
                    <tr>
                        <th class='border text-center'>#</th>
                        <th class='border text-center'>Numéro Plaignant</th>
                        <th class='border text-center'>Nom Plaignant</th>
                        <th class='border text-center'>Objet</th>
                        <th class='border text-center'>Date</th>
                        <th class='border text-center'>Description</th>
                        <th class='border text-center'>Pièce Jointe</th>
                        <th class='border text-center'>Mode d'émission</th>
                        <th class='border text-center'>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php                
                    $sql = "SELECT * FROM Plainte ORDER BY NumPlainte DESC";
                    $result = mysqli_query($conn, $sql);
                    echo "<h4 class='my-3'>Total : ".mysqli_num_rows($result)." plaintes</h4>";
                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
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
                            if(isset($row['PieceJointePlainte'])){
                                $pj_plainte="<a class='btn btn-success' href='".str_rot13(base64_decode($row['PieceJointePlainte']))."' download>Voir &rarr;</a>";
                            }else{
                                $pj_plainte="N/A";
                            }
                            echo "
                                <tr>
                                    <td class='border text-center'>".$row['NumPlainte']."</td>
                                    <td class='border text-center'>".$row['NumPlaignant']."</td>
                                    <td class='border text-center'>".$nomPlaignant."</td>
                                    <td class='border text-center'>".str_rot13(base64_decode($row['ObjetPlainte']))."</td>
                                    <td class='border text-center'>".$row['DatePlainte']."</td>
                                    <td class='border text-center'>".substr(str_rot13(base64_decode($row['DescriptionPlainte'])),0,20)."...</td>
                                    <td class='border text-center'>".$pj_plainte."</td>
                                    <td class='border text-center'>".$row['ModeEmission']."</td>
                                    <td class='border text-center'>
                                        <a class='btn btn-primary' href='receipt.php?id=".$row['NumPlainte']."'>Reçu</a>
                                        <a class='btn btn-danger' href='delete.php?id=".$row['NumPlainte']."'>x</a>
                                    </td>
                                </tr>
                            ";
                        }
                    }                
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $('#dataTable').dataTable({
                order: [[0, 'desc']],
            });
        });
    </script>

</body>
</html>