<?php 
    header('Content-Type: text/json');
    $db_host="localhost";
    $db_user="atomx";
    $db_password="bruh669";
    $db_name="gestion_plaintes";
    $conn=mysqli_connect($db_host, $db_user, $db_password) or die('db connexion error');
    $db=mysqli_select_db($conn, 'gestion_plaintes') or die(mysqli_errno($conn));
    $response=[];
    $response["found"]="false";
    if(isset($_GET["n"])){
        $plaignant_id=$_GET['n'];
        $sql = "SELECT * FROM Plaignant WHERE NumPlaignant='$plaignant_id' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $response["found"]="true";
                $response["nom_plaignant"]=$row["NomPlaignant"];
                $response["adresse_plaignant"]=$row["AdressePlaignant"];
                $response["email_plaignant"]=$row["EmailPlaignant"];
                $response["tel_plaignant"]=$row["TelPlaignant"];
            }
        }
    }
    echo json_encode($response);
?>