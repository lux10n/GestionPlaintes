<?php 
    if(isset($_GET['id'])){
        if(filter_var($_GET['id'], FILTER_VALIDATE_INT)){
            $db_host="localhost";
            $db_user="atomx";
            $db_password="bruh669";
            $db_name="gestion_plaintes";
            $conn=mysqli_connect($db_host, $db_user, $db_password) or die('db connexion error');
            $db=mysqli_select_db($conn, 'gestion_plaintes') or die(mysqli_errno($conn));
            $id=mysqli_real_escape_string($conn, $_GET['id']);
            $sql = "DELETE FROM Plainte WHERE NumPlainte=$id";
            mysqli_query($conn, $sql) or die(mysqli_errno($conn));
            header('Location: list.php');
        }
    }
?>
