<?php
    $db_host="localhost";
    $db_user="atomx";
    $db_password="bruh669";
    $db_name="gestion_plaintes";
    $conn=mysqli_connect($db_host, $db_user, $db_password) or die('db connexion error');
    $db=mysqli_select_db($conn, 'gestion_plaintes') or die(mysqli_errno($conn));

    if(
        isset($_POST["nom"]) &&
        isset($_POST["adresse"]) &&
        isset($_POST["tel"]) &&
        isset($_POST["email"]) &&
        isset($_POST["username"]) &&
        isset($_POST["password"]) &&
        isset($_POST["password_confirm"])
    ){
        $nom=$_POST["nom"];
        $adresse=$_POST["adresse"];
        $tel=$_POST["tel"];
        $email=$_POST["email"];
        $username=$_POST["username"];
        $password=$_POST["password"];
        $password_confirm=$_POST["password_confirm"];
        if($password!=$password_confirm){
            echo('<script>alert("Les deux mots de passe sont différents!")</script>');
        }else{
            // check for username
            $sql2 = "SELECT * FROM Plaignant WHERE UsernamePlaignant='$username' LIMIT 1";
            $result = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result) > 0) {
                echo('<script>alert("Nom d\'utilisateur déjà utilisé!")</script>');
            }else{
                $sql2 = "SELECT * FROM Plaignant WHERE EmailPlaignant='$email' LIMIT 1";
                $result = mysqli_query($conn, $sql2);
                if (mysqli_num_rows($result) > 0) {
                    echo('<script>alert("Adresse email déjà utilisée!")</script>');
                }else{
                    // hash password
                    $hash=password_hash($password, PASSWORD_DEFAULT);
                    //save user
                    if(password_verify($password,$hash)){
                        $sql="INSERT INTO Plaignant (
                            NomPlaignant,
                            AdressePlaignant,
                            EmailPlaignant,
                            TelPlaignant,
                            UsernamePlaignant,
                            PasswordPlaignant
                        ) VALUES (
                            '$nom',
                            '$adresse',
                            '$email',
                            '$tel',
                            '$username',
                            '$hash'
                        )";
                        if (mysqli_query($conn, $sql)) {
                            header('Location: login.php');
                        }else{
                            echo('<script>alert("Erreur lors de l\'enregistrement.")</script>');
                        }
                    }else{
                        echo('<script>alert("Erreur lors de l\'enregistrement.")</script>');
                    }
                }
            }
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" required>
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <style>
        html,body {
            height: 100%
        }
    </style>
</head>
<body>
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="col-5 mx-auto">
            <h1 class="text-center mt-2 mb-5">Inscription</h1>
            <form method="POST" action="">
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Nom &amp; Prénoms</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nom" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Adresse</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="adresse" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Téléphone</label>
                    <div class="col-sm-9">
                        <input type="tel" class="form-control" name="tel" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Adresse Mail</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" name="email" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Nom d&rsquo;utilisateur</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="username" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Mot de passe</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </div>
                <div class="form-group row mb-3 align-items-center">
                    <label class="col-sm-3 col-form-label">Confirmer le mot de passe</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password_confirm" required>
                    </div>
                </div>
                <div class="d-flex justify-content-center my-4">
                    <input type="submit" value="Envoyer" class="btn btn-primary px-5">
                </div>
            </form>
            <p class="text-center mb-5">
                Déjà inscrit? <a href="login.php">Connexion &rarr;</a>
            </p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>