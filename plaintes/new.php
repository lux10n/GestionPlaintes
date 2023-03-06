<?php 
    session_start();
    if(!isset($_SESSION['NumPlaignant'])){
        header('Location: ../login.php');
    }
    $db_host="localhost";
    $db_user="root";
    $db_password="";
    $db_name="gestion_plaintes";
    $conn=mysqli_connect($db_host, $db_user, $db_password) or die('db connexion error');
    $db=mysqli_select_db($conn, 'gestion_plaintes') or die(mysqli_errno($conn));
    if(
        isset($_POST["anonymat"]) &&
        isset($_POST["date_plainte"]) &&
        isset($_POST["objet_plainte"]) &&
        isset($_POST["description_plainte"]) &&
        isset($_POST["mode_emission_plainte"])
    ){
        if($_POST["anonymat"]=="yes"){
            $sql1 = "INSERT INTO Plaignant (Anonyme) VALUES (1)";
            if (mysqli_query($conn, $sql1)) {
                $sql2 = "SELECT * FROM Plaignant WHERE Anonyme='1' ORDER BY NumPlaignant DESC LIMIT 1";
                $result = mysqli_query($conn, $sql2);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $numPlaignantToUse=$row['NumPlaignant'];
                    }
                }else{
                    $numPlaignantToUse=$_SESSION['NumPlaignant'];
                }
            } else {
                $numPlaignantToUse=$_SESSION['NumPlaignant'];
            }
        }else{
            $numPlaignantToUse=$_SESSION['NumPlaignant'];
        }
        $sql="INSERT INTO Plainte (NumPlaignant, DatePlainte, ObjetPlainte, DescriptionPlainte, ModeEmission) VALUES ('".$numPlaignantToUse."', '".htmlentities($_POST['date_plainte'])."', '".htmlentities($_POST['objet_plainte'])."', '".htmlentities($_POST['description_plainte'])."', '".htmlentities($_POST['mode_emission_plainte'])."')";
        if (mysqli_query($conn, $sql)) {
            echo('<script>alert("Plainte enregistrée avec succès.")</script>');
        } else {
            echo('<script>alert("Erreur lors de l\'enregistrement.")</script>');
            // echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" required>
    <title>Soumission Plainte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
</head>
<body>
    <h1 class="text-center mt-3">SOUMETTRE UNE PLAINTE</h1>
    <p class="text-center mb-5">
        <a href="/plaintes/list.php">Liste des plaintes &rarr;</a>
    </p>

    <form method="POST" action="" class="w-50 mx-auto px-3">

        <div class="anonymat">
            <div class="form-group row mb-3">
                <label class="col-sm-6 col-form-label">Souhaitez vous rester anonyme ?</label>
                <div class="col-sm-6">
                    <select name="anonymat" class="form-select" required>
                        <option value="no" selected>Non</option>
                        <option value="yes">Oui</option>
                    </select>
                </div>
            </div>
        </div>

        <fieldset class="plaignantId" disabled>
            <h3 class="pt-4 pb-2">Identification Plaignant</h3>
            <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Numéro</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="num_plaignant" value="PL-<?php echo $_SESSION['NumPlaignant'];?>"required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Nom</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="nom_plaignant" value="<?php echo $_SESSION['NomPlaignant'];?>"required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Adresse</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="adresse_plaignant" value="<?php echo $_SESSION['AdressePlaignant'];?>"required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Mail</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" name="email_plaignant" value="<?php echo $_SESSION['EmailPlaignant'];?>"required>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Téléphone</label>
                <div class="col-sm-9">
                    <input type="tel" class="form-control" name="tel_plaignant" value="<?php echo $_SESSION['TelPlaignant'];?>"required>
                </div>
            </div>        
        </fieldset>
        <div class="description">
            <h3 class="pt-4 pb-2">Description de la Plainte</h3>
                <!-- <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Plainte N°</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="num_plainte" required>
                    </div>
                </div> -->
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Date de la plainte</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="date_plainte" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Objet</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="objet_plainte" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Description (1500 caractères max)</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="description_plainte" rows="5"></textarea required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Mode d'émission</label>
                    <div class="col-sm-9">
                        <select name="mode_emission_plainte" class="form-select" required>
                            <option value="mail">E-Mail</option>
                            <option value="message">Message</option>
                            <option value="appel">Appel</option>
                            <option value="papier">Physique</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <div>
                        <button class="btn btn-primary">Soumettre</button>
                    </div>
                    <div>
                        <button class="btn btn-danger btn-cancel">Annuler</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $('input[name="date_plainte"]').val(new Date().toISOString().split('T')[0]);
            $('.btn-cancel').click(function(e){
                e.preventDefault();
                e.stopPropagation();
                $('form').trigger('reset');
            })
            anonymatSwitch=$('select[name="anonymat"]');
            anonymatSwitch.change(function(){
                switch(anonymatSwitch.val()){
                    case 'yes':
                        $('.plaignantId').hide();
                        break;
                    default:
                        $('.plaignantId').show();
                        break;
                }
            })
        });
    </script>

</body>
</html>